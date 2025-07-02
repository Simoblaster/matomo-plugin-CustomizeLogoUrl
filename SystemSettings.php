<?php
/**
 * Matomo - free/libre analytics platform
 */
namespace Piwik\Plugins\CustomizeLogoUrl;

use Piwik\Settings\Setting;
use Piwik\Settings\FieldConfig;
use Piwik\Settings\Plugin\SystemSetting;
use Piwik\Validators\NotEmpty;
use Piwik\Validators\UrlLike;

/**
 * Defines system settings for CustomizeLogoUrl
 */
class SystemSettings extends \Piwik\Settings\Plugin\SystemSettings
{
    /** @var SystemSetting */
    public $logoUrl;
    
    /** @var SystemSetting */
    public $openInNewTab;

    protected function init()
    {
        $this->logoUrl = $this->createLogoUrlSetting();
        $this->openInNewTab = $this->createOpenInNewTabSetting();
        $this->createInfoSetting();
    }

    /**
     * Creates the logo URL setting
     *
     * @return SystemSetting
     */
    private function createLogoUrlSetting(): SystemSetting
    {
        return $this->makeSetting('logoUrl', $default = \Piwik\SettingsPiwik::getPiwikUrl(), FieldConfig::TYPE_STRING, function (FieldConfig $field) {
            $field->title = 'Logo destination URL';
            $field->uiControl = FieldConfig::UI_CONTROL_TEXT;
            $field->description = 'URL to navigate to when clicking on the Matomo logo. Must be a valid URL (http:// or https://).';
            $field->validators[] = new NotEmpty();
            $field->validators[] = new UrlLike();
            $field->uiControlAttributes = array(
                'placeholder' => 'https://www.example.com',
                'size' => 50
            );
        });
    }

    /**
     * Creates the open in new tab setting
     *
     * @return SystemSetting
     */
    private function createOpenInNewTabSetting(): SystemSetting
    {
        return $this->makeSetting('openInNewTab', $default = false, FieldConfig::TYPE_BOOL, function (FieldConfig $field) {
            $field->title = 'Open in new window';
            $field->uiControl = FieldConfig::UI_CONTROL_CHECKBOX;
            $field->description = 'If enabled, the logo link will open in a new window/tab instead of the current window.';
        });
    }

    /**
     * Creates an informational field for the user
     *
     * @return SystemSetting
     */
    private function createInfoSetting(): SystemSetting
    {
        return $this->makeSetting('infoMessage', $default = '', FieldConfig::TYPE_STRING, function (FieldConfig $field) {
            $field->title = 'ℹ️ Important Information';
            $field->uiControl = FieldConfig::UI_CONTROL_TEXTAREA;
            $field->description = '⚠️ Important note: Logo link changes are active immediately after saving for all other users. However, to see the changes in the current session, you need to reload/refresh the page.';
            $field->uiControlAttributes = array(
                'readonly' => 'readonly',
                'style' => 'background-color: #f8f9fa; border: 1px solid #e9ecef; color: #6c757d; cursor: not-allowed;',
                'rows' => 3
            );
            // Hide this field from saved values
            $field->transform = function ($value) {
                return null;
            };
        });
    }
}