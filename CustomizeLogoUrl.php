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
            
            // Prepare configuration array
            $config = array(
                'logoUrl' => $logoUrl,
                'openInNewTab' => $openInNewTab
            );
            
            // Use json_encode to safely encode the configuration
            $jsConfig = 'window.CustomizeLogoUrlConfig = ' . json_encode($config) . ';';
            
            $out .= $jsConfig;
            
        } catch (\Exception $e) {
            // Log error only when it occurs
            error_log('CustomizeLogoUrl Error: ' . $e->getMessage());
        }
    }
}