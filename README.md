# CustomizeLogoUrl

A Matomo plugin that allows administrators to customize the destination URL of the Matomo logo through the Admin Dashboard.

## Description

By default, clicking on the Matomo logo in the top-left corner navigates to the Matomo homepage. This plugin provides the flexibility to redirect users to any custom URL when they click on the logo, directly configurable from the Matomo administration panel.

## Features

- **Custom Logo URL**: Configure any URL as the destination for the Matomo logo click
- **New Tab Option**: Choose whether the link opens in the current window or a new tab
- **Admin Interface**: Easy-to-use configuration panel in the Matomo admin dashboard
- **Real-time Updates**: Changes are applied immediately for all users
- **URL Validation**: Built-in validation ensures only valid URLs are accepted

## Requirements

- Matomo >= 5.0.0
- Administrator access to configure the plugin

## Installation

1. Download the plugin files
2. Extract the plugin to your Matomo `plugins/` directory
3. The plugin folder should be named `CustomizeLogoUrl`
4. Activate the plugin through the Matomo admin interface

## Configuration

1. Navigate to **Administration → System → General Settings**
2. Scroll down to the **CustomizeLogoUrl** section
3. Configure the following options:
   - **Logo Destination URL**: Enter the URL where users should be redirected when clicking the logo
   - **Open in New Tab**: Check this option if you want the link to open in a new window/tab

### Configuration Options

| Setting | Description | Default |
|---------|-------------|---------|
| Logo Destination URL | The URL to navigate to when clicking the Matomo logo | `https://www.matomo.org` |
| Open in New Tab | Whether to open the link in a new window/tab | `false` |

## Important Notes

⚠️ **Page Refresh Required**: Changes are active immediately for all users, but to see the modifications in your current session, you need to refresh/reload the page after saving the settings.

## Technical Details

The plugin works by:
1. Loading user configuration from the Matomo settings system
2. Injecting JavaScript that modifies the logo link behavior
3. Preserving the original link for reference
4. Applying the new URL and target attributes as configured

## Browser Compatibility

This plugin is compatible with all modern web browsers that support:
- JavaScript ES5+
- DOM manipulation
- AJAX requests

## Support

For support, please contact:
- **Email**: simone.saturno@innovaway.it
- **Author**: Simone Saturno
- **Company**: Innovaway S.p.A.
- **Website**: https://innovaway.it

## Version History

### 1.0.0
- Initial release
- Basic logo URL customization
- New tab/window option
- Admin panel integration
- URL validation

## License

This plugin is licensed under GPL v3+. See the [GPL License](http://www.gnu.org/licenses/gpl.html) for more details.

## Keywords

`logo`, `navigation`, `configuration`, `admin`, `settings`

---

**Note**: This plugin modifies the client-side behavior of the Matomo interface and does not affect any analytics data or reporting functionality.
