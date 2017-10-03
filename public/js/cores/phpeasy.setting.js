PHPEasy.Setting = PHPEasy.Setting || {};


PHPEasy.Setting.Https = 0; // Use HTTPS: 1 - Use, 0 - No (Default)

// Plugins Setting
PHPEasy.Setting.Plugins = PHPEasy.Setting.Plugins || {};
// Facebook Setting
PHPEasy.Setting.Plugins.Facebook = PHPEasy.Setting.Plugins.Facebook || {};

// User config
PHPEasy.Setting.Plugins.Facebook.appId = '';
// Dev config
PHPEasy.Setting.Plugins.Facebook.scope = 'public_profile, email, user_birthday, user_location';
PHPEasy.Setting.Plugins.Facebook.fields = 'id, first_name, last_name, name, gender, email, birthday, location';

// Google Setting
PHPEasy.Setting.Plugins.Google = PHPEasy.Setting.Plugins.Google || {};
// V1
PHPEasy.Setting.Plugins.Google.V1 = PHPEasy.Setting.Plugins.Google.V1 || {};
PHPEasy.Setting.Plugins.Google.V1.Width = 800;
PHPEasy.Setting.Plugins.Google.V1.Height = 600;
// V2
PHPEasy.Setting.Plugins.Google.V2 = PHPEasy.Setting.Plugins.Google.V2 || {};
// User config
PHPEasy.Setting.Plugins.Google.V2.ApiKey = '';
PHPEasy.Setting.Plugins.Google.V2.ClientId = '';
// Dev config
PHPEasy.Setting.Plugins.Google.V2.Scope = 'https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/plus.profile.emails.read';
// Page Setting
PHPEasy.Setting.Page = PHPEasy.Setting.Page || {};

PHPEasy.Setting.Page.activeNavbarElement = '#nav ul li a'; // Navbar auto active when page in