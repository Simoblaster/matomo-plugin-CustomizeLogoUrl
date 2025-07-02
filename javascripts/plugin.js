/**
 * Plugin CustomizeLogoUrl - Modifies the Matomo logo link
 */
var CustomizeLogoUrl = (function () {
  "use strict";

  var self = {};
  var config = {
    logoUrl: window.location.origin + "/", // Default fallback to current Matomo instance
    openInNewTab: false, // Default fallback
  };

  /**
   * Configures the plugin with user settings
   */
  self.configure = function (userConfig) {
    config = Object.assign(config, userConfig);
    console.log("CustomizeLogoUrl: Configuration updated", config);
  };

  /**
   * Loads configuration from server via AJAX
   */
  self.loadConfiguration = function () {
    // First try to load from window.CustomizeLogoUrlConfig
    if (typeof window.CustomizeLogoUrlConfig !== "undefined") {
      self.configure(window.CustomizeLogoUrlConfig);
      console.log(
        "CustomizeLogoUrl: Configuration loaded from window.CustomizeLogoUrlConfig"
      );
      return;
    }

    // If not available, load via AJAX
    console.log("CustomizeLogoUrl: Loading configuration from server...");

    // Use jQuery if available, otherwise fetch
    if (typeof $ !== "undefined") {
      $.ajax({
        url: "index.php?module=CustomizeLogoUrl&action=getConfig",
        method: "GET",
        dataType: "json",
        success: function (data) {
          console.log(
            "CustomizeLogoUrl: Configuration received from server:",
            data
          );
          self.configure(data);
          // Apply configuration immediately if DOM is already ready
          if (document.readyState === "complete") {
            setTimeout(self.modifyLogoLink, 100);
          }
        },
        error: function (xhr, status, error) {
          console.log("CustomizeLogoUrl: Error loading configuration:", error);
          console.log("CustomizeLogoUrl: Using default configuration");
        },
      });
    } else {
      // Fallback with fetch
      fetch("index.php?module=CustomizeLogoUrl&action=getConfig")
        .then((response) => response.json())
        .then((data) => {
          console.log(
            "CustomizeLogoUrl: Configuration received from server:",
            data
          );
          self.configure(data);
          if (document.readyState === "complete") {
            setTimeout(self.modifyLogoLink, 100);
          }
        })
        .catch((error) => {
          console.log("CustomizeLogoUrl: Error loading configuration:", error);
          console.log("CustomizeLogoUrl: Using default configuration");
        });
    }
  };

  /**
   * Plugin initialization
   */
  self.init = function () {
    console.log("CustomizeLogoUrl: Initializing...");

    // Load configuration first
    self.loadConfiguration();

    // Wait for DOM to be fully loaded
    if (document.readyState === "loading") {
      document.addEventListener("DOMContentLoaded", self.onDOMReady);
    } else {
      self.onDOMReady();
    }
  };

  /**
   * Function called when DOM is ready
   */
  self.onDOMReady = function () {
    console.log("CustomizeLogoUrl: DOM ready, configuration:", config);

    // Wait a bit to ensure Matomo has loaded everything
    setTimeout(function () {
      self.modifyLogoLink();
    }, 500);
  };

  /**
   * Modifies the Matomo logo link to point to a custom URL
   */
  self.modifyLogoLink = function () {
    // Try different selectors to find the logo
    var selectors = [
      "#logo a",
      ".navbar-brand",
      'a[href*="matomo.org"]',
      ".logo a",
      "#header .logo a",
    ];

    var logoElement = null;

    for (var i = 0; i < selectors.length; i++) {
      logoElement = document.querySelector(selectors[i]);
      if (logoElement) {
        console.log(
          "CustomizeLogoUrl: Logo found with selector:",
          selectors[i]
        );
        break;
      }
    }

    if (logoElement) {
      // Use the URL configured by the user
      var newUrl = config.logoUrl;

      // Save the original URL for reference
      if (!logoElement.hasAttribute("data-original-href")) {
        logoElement.setAttribute("data-original-href", logoElement.href);
      }

      // Change the destination URL
      logoElement.href = newUrl;

      // Configure target if requested
      if (config.openInNewTab) {
        logoElement.target = "_blank";
        logoElement.rel = "noopener noreferrer";
      } else {
        logoElement.removeAttribute("target");
        logoElement.removeAttribute("rel");
      }

      // Add an attribute to identify that it has been modified
      logoElement.setAttribute("data-domaccessplugin-modified", "true");

      console.log(
        'CustomizeLogoUrl: Logo link modified from "' +
          logoElement.getAttribute("data-original-href") +
          '" to "' +
          newUrl +
          '"' +
          (config.openInNewTab ? " (new window)" : "")
      );
    } else {
      console.log(
        "CustomizeLogoUrl: Logo not found with any selector, retrying in 1 second..."
      );
      // Retry after 1 second if the logo is not yet loaded
      setTimeout(self.modifyLogoLink, 1000);
    }
  };

  /**
   * Function to restore the original link (useful for debugging)
   */
  self.restoreOriginalLink = function () {
    var logoElement = document.querySelector(
      '[data-domaccessplugin-modified="true"]'
    );
    if (logoElement && logoElement.hasAttribute("data-original-href")) {
      logoElement.href = logoElement.getAttribute("data-original-href");
      logoElement.removeAttribute("data-domaccessplugin-modified");
      console.log("CustomizeLogoUrl: Original link restored");
    }
  };

  /**
   * Function to get information about the current logo
   */
  self.getLogoInfo = function () {
    var logoElement =
      document.querySelector('[data-domaccessplugin-modified="true"]') ||
      document.querySelector("#logo a");
    if (logoElement) {
      return {
        currentHref: logoElement.href,
        originalHref: logoElement.getAttribute("data-original-href"),
        target: logoElement.target,
        title: logoElement.title,
        configuredUrl: config.logoUrl,
        openInNewTab: config.openInNewTab,
        isModified: logoElement.hasAttribute("data-domaccessplugin-modified"),
      };
    }
    return null;
  };

  /**
   * Function to get the current configuration
   */
  self.getConfig = function () {
    return config;
  };

  /**
   * Debug function - forces reapplication of modifications
   */
  self.forceReapply = function () {
    console.log("CustomizeLogoUrl: Forcing reapplication...");
    self.loadConfiguration();
    // Wait a bit to allow AJAX loading to complete
    setTimeout(self.modifyLogoLink, 1000);
  };

  return self;
})();

// Initialize automatically when DOM is ready
if (document.readyState === "loading") {
  document.addEventListener("DOMContentLoaded", function () {
    CustomizeLogoUrl.init();
  });
} else {
  CustomizeLogoUrl.init();
}

// Expose the plugin globally for debugging
window.CustomizeLogoUrl = CustomizeLogoUrl;
