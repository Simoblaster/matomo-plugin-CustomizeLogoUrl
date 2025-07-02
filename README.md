# CustomizeLogoUrl

A Matomo plugin that allows administrators to customize the destination URL of the Matomo logo through the Admin Dashboard.

## Description

By default, clicking on the Matomo logo in the top-left corner navigates to the current Matomo installation homepage. This plugin provides the flexibility to redirect users to any custom URL when they click on the logo, directly configurable from the Matomo administration panel.

## Features

- **Custom Logo URL**: Configure any URL as the destination for the Matomo logo click
- **New Tab Option**: Choose whether the link opens in the current window or a new tab
- **Admin Interface**: Easy-to-use configuration panel in the Matomo admin dashboard
- **Real-time Updates**: Changes are applied immediately for all users
- **URL Validation**: Built-in validation ensures only valid URLs are accepted
- **Secure Implementation**: Uses JSON encoding and proper XSS prevention measures

## Requirements

- Matomo >= 5.0.0
- PHP >= 7.3.5
- Administrator access to configure the plugin

## Installation

### From Matomo Marketplace

1. Go to **Administration → Marketplace**
2. Search for "CustomizeLogoUrl"
3. Click **Install** and follow the instructions
4. Activate the plugin

### Manual Installation

1. Download the plugin files
2. Extract the plugin to your Matomo `plugins/` directory
3. The plugin folder should be named `CustomizeLogoUrl`
4. Activate the plugin through **Administration → Plugins**

## Configuration

1. Navigate to **Administration → System → General Settings**
2. Scroll down to the **CustomizeLogoUrl** section
3. Configure the following options:
   - **Logo Destination URL**: Enter the URL where users should be redirected when clicking the logo
   - **Open in New Tab**: Check this option if you want the link to open in a new window/tab
4. Click **Save** to apply changes

### Configuration Options

| Setting              | Description                                          | Default                         |
| -------------------- | ---------------------------------------------------- | ------------------------------- |
| Logo Destination URL | The URL to navigate to when clicking the Matomo logo | Current Matomo installation URL |
| Open in New Tab      | Whether to open the link in a new window/tab         | `false`                         |

## Important Notes

⚠️ **Page Refresh Required**: Changes are active immediately for all users, but to see the modifications in your current session, you need to refresh/reload the page after saving the settings.

🔒 **Security**: This plugin implements proper security measures including XSS prevention and input validation to ensure safe operation.

## Technical Details

The plugin works by:

1. Loading user configuration from the Matomo settings system using `SystemSettings`
2. Safely injecting JavaScript configuration using `json_encode()` to prevent XSS
3. Modifying the logo link behavior through DOM manipulation
4. Preserving the original link for reference
5. Applying the new URL and target attributes as configured

### Architecture

- **SystemSettings.php**: Manages plugin configuration with validation
- **Controller.php**: Provides API endpoint for configuration retrieval
- **CustomizeLogoUrl.php**: Main plugin class handling events and JavaScript injection
- **plugin.js**: Client-side JavaScript for logo link modification

## Browser Compatibility

This plugin is compatible with all modern web browsers that support:

- JavaScript ES5+
- DOM manipulation
- AJAX requests (jQuery or Fetch API)

## Debugging

For troubleshooting, you can use the browser console to access debugging functions:

```javascript
// Get current configuration
console.log(CustomizeLogoUrl.getConfig());

// Get logo information
console.log(CustomizeLogoUrl.getLogoInfo());

// Force reapply settings
CustomizeLogoUrl.forceReapply();
```

## Support

For support, please contact:

- **Email**: simone.saturno@innovaway.it
- **Issues**: [GitHub Issues](https://github.com/Simoblaster/matomo-plugin-CustomizeLogoUrl/issues)
- **Source Code**: [GitHub Repository](https://github.com/Simoblaster/matomo-plugin-CustomizeLogoUrl)
- **Author**: Simone Saturno
- **Company**: Innovaway S.p.A.
- **Website**: https://innovaway.it

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request on GitHub.

## Version History

### 1.0.6 (Current)

- **Security Enhancement**: Implemented `json_encode()` for JavaScript configuration injection
- **Performance**: Removed unnecessary debug logging in production
- **Improved Defaults**: Now uses current Matomo installation URL as default instead of hardcoded URL
- **XSS Prevention**: Enhanced security measures against cross-site scripting

### 1.0.0

- Initial release
- Basic logo URL customization
- New tab/window option
- Admin panel integration
- URL validation

## License

This plugin is licensed under GPL v3+. See the [GPL License](http://www.gnu.org/licenses/gpl.html) for more details.

## Keywords

`logo`, `navigation`, `configuration`, `admin`, `settings`, `customization`, `url`, `redirect`

---

**Note**: This plugin modifies the client-side behavior of the Matomo interface and does not affect any analytics data or reporting functionality. All modifications are applied safely with proper security measures.
