# DomAccessPlugin for Matomo

A Matomo plugin that allows you to customize the destination URL of the Matomo logo link in the top-left corner of the interface. By default, clicking the Matomo logo navigates to the Matomo homepage, but this plugin enables you to redirect users to any external website.

## Features

- **Custom Logo URL**: Configure any external URL as the destination for the Matomo logo click
- **New Tab Option**: Choose whether the link opens in the current window or a new tab
- **Debug Mode**: Enable/disable console logging for troubleshooting
- **Real-time Configuration**: Settings are applied immediately for all users
- **User-friendly Interface**: Easy configuration through Matomo's admin panel

## Installation

### Manual Installation

1. Download the plugin files
2. Extract the contents to your Matomo installation directory:
   ```
   /path/to/matomo/plugins/DomAccessPlugin/
   ```
3. The plugin directory should contain:
   ```
   DomAccessPlugin/
   ├── Controller.php
   ├── DomAccessPlugin.php
   ├── SystemSettings.php
   ├── javascripts/
   │   └── plugin.js
   ├── stylesheets/
   │   └── plugin.css
   └── README.md
   ```

### Activation

1. Log in to your Matomo admin panel
2. Navigate to **Administration** → **System** → **Plugins**
3. Find "DomAccessPlugin" in the list
4. Click **Activate**

## Configuration

1. Go to **Administration** → **System** → **General Settings**
2. Scroll down to find the **DomAccessPlugin** section
3. Configure the following settings:

### Settings

- **Logo Destination URL**: Enter the URL where users should be redirected when clicking the Matomo logo
  - Must be a valid URL (http:// or https://)
  - Example: `https://www.yourcompany.com`

- **Open in New Window**: Check this option if you want the link to open in a new tab/window instead of the current window

- **Debug Mode**: Enable this option to show debug messages in the browser console for troubleshooting

4. Click **Save** to apply the changes

⚠️ **Important**: Changes are active immediately for all users, but to see the changes in your current session, you need to refresh the page.

## Usage

Once configured and activated:

1. The Matomo logo in the top-left corner will now link to your specified URL
2. Clicking the logo will navigate to your custom destination
3. If "Open in New Window" is enabled, the link will open in a new tab

## Troubleshooting

### Debug Mode

Enable **Debug Mode** in the plugin settings to see detailed console logs:

1. Open your browser's Developer Tools (F12)
2. Go to the **Console** tab
3. Refresh the page
4. Look for messages starting with "DomAccessPlugin:"

### Common Issues

**Settings not saving**: 
- Ensure you have administrator privileges
- Check that the plugin is properly activated
- Verify file permissions on the plugin directory

**Logo link not changing**:
- Enable Debug Mode to see console logs
- Try refreshing the page after saving settings
- Check browser console for JavaScript errors

**Configuration not loading**:
- Verify the plugin files are in the correct directory
- Check Matomo error logs for PHP errors
- Ensure proper file permissions

### Manual Testing

You can test the plugin functionality in the browser console:

```javascript
// Get current configuration
DomAccessPlugin.getConfig();

// Get logo information
DomAccessPlugin.getLogoInfo();

// Force reapply settings
DomAccessPlugin.forceReapply();
```

## Technical Details

### Files Structure

- **DomAccessPlugin.php**: Main plugin class and event handlers
- **SystemSettings.php**: Plugin configuration settings
- **Controller.php**: AJAX endpoint for configuration retrieval
- **javascripts/plugin.js**: Frontend JavaScript for logo modification
- **stylesheets/plugin.css**: Optional CSS styles

### How It Works

1. The plugin registers system settings that are configurable through the admin panel
2. Settings are loaded via PHP and passed to JavaScript
3. JavaScript modifies the DOM to update the logo link destination
4. Changes are applied in real-time without requiring page reload (except for the current session)

### Compatibility

- **Matomo Version**: 3.x and 4.x
- **PHP Version**: 7.2 or higher
- **Browser Support**: All modern browsers (Chrome, Firefox, Safari, Edge)

## Development

### API Endpoints

The plugin exposes the following endpoint:
- `GET /index.php?module=DomAccessPlugin&action=getConfig` - Returns current plugin configuration as JSON

### Events

The plugin hooks into these Matomo events:
- `AssetManager.getStylesheetFiles` - For CSS inclusion
- `AssetManager.getJavaScriptFiles` - For JavaScript inclusion  
- `Template.jsGlobalVariables` - For configuration injection

## Security Considerations

- All URLs are validated using Matomo's built-in URL validators
- Input is properly sanitized before being output to JavaScript
- The plugin requires user authentication to access configuration
- XSS protection is implemented through proper escaping

## License

This plugin is licensed under the same license as Matomo (GPL v3 or later).

## Support

For issues, feature requests, or contributions:

1. Check the troubleshooting section above
2. Enable Debug Mode to gather detailed logs
3. Check Matomo and PHP error logs
4. Ensure you're using a supported Matomo version

## Changelog

### Version 1.0.0
- Initial release
- Basic URL customization
- New tab option
- Debug mode functionality
- Real-time configuration updates