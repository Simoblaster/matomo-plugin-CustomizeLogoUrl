<?php
/**
 * Matomo - free/libre analytics platform
 */
namespace Piwik\Plugins\CustomizeLogoUrl;

use Piwik\Piwik;

class Controller extends \Piwik\Plugin\Controller
{
    /**
     * Endpoint to get plugin configuration
     */
    public function getConfig()
    {
        // Verify that user is authenticated
        Piwik::checkUserHasSomeViewAccess();
        
        try {
            $settings = new SystemSettings();
            $config = array(
                'logoUrl' => $settings->logoUrl->getValue(),
                'openInNewTab' => $settings->openInNewTab->getValue()
            );
            
            // Return configuration as JSON
            return json_encode($config);
            
        } catch (\Exception $e) {
            // In case of error, return default configuration
            return json_encode(array(
                'logoUrl' => 'https://www.matomo.org',
                'openInNewTab' => false
            ));
        }
    }
}