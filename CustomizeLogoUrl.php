<?php
/**
 * Matomo - free/libre analytics platform
 */
namespace Piwik\Plugins\CustomizeLogoUrl;

use Piwik\Plugin;

class CustomizeLogoUrl extends Plugin
{
    /**
     * List of events the plugin registers to
     */
    public function registerEvents()
    {
        return array(
            'AssetManager.getStylesheetFiles' => 'getStylesheetFiles',
            'AssetManager.getJavaScriptFiles' => 'getJavaScriptFiles',
            'Template.jsGlobalVariables' => 'addJavaScriptConfiguration'
        );
    }

    /**
     * Adds the plugin's CSS files
     */
    public function getStylesheetFiles(&$stylesheets)
    {
        $stylesheets[] = "plugins/CustomizeLogoUrl/stylesheets/plugin.css";
    }

    /**
     * Adds the plugin's JavaScript files
     */
    public function getJavaScriptFiles(&$jsFiles)
    {
        $jsFiles[] = "plugins/CustomizeLogoUrl/javascripts/plugin.js";
    }

    /**
     * Adds JavaScript configuration to global variables
     */
    public function addJavaScriptConfiguration(&$out)
    {
        try {
            // Get user settings
            $settings = new SystemSettings();
            $logoUrl = $settings->logoUrl->getValue();
            $openInNewTab = $settings->openInNewTab->getValue();
            
            // Debug: Log obtained values
            error_log('CustomizeLogoUrl Debug - logoUrl: ' . $logoUrl);
            error_log('CustomizeLogoUrl Debug - openInNewTab: ' . ($openInNewTab ? 'true' : 'false'));
            
            // Add configuration to JavaScript global variables
            $jsConfig = 'window.CustomizeLogoUrlConfig = {
    logoUrl: "' . addslashes($logoUrl) . '",
    openInNewTab: ' . ($openInNewTab ? 'true' : 'false') . '
};
console.log("CustomizeLogoUrl: Configuration loaded from server", window.CustomizeLogoUrlConfig);';
            
            $out .= $jsConfig;
            
        } catch (\Exception $e) {
            // Log error without interrupting execution
            error_log('CustomizeLogoUrl Error: ' . $e->getMessage());
            error_log('CustomizeLogoUrl Error Stack: ' . $e->getTraceAsString());
        }
    }
}