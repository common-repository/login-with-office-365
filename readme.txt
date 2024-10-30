=== Login with Azure - SSO (Azure AD, Azure B2C) ===
Contributors: miniOrange
Donate link: http://miniorange.com
Tags: Azure, Azure AD, Azure B2C, Office 365, SSO, Azure AD SSO, o365 SSO, SAML, OAuth, Azure B2C SSO, Office 365 SSO, Azure login, Office 365 login, O365, Azure AD, Microsoft graph, Microsoft Apps SSO, Authentication, Auto User Provisioning, User Sync, Microsoft SSO, login, Employee Directory, Azure API, Graph API, microsoft groups
Requires at least: 3.7
Tested up to: 6.0
Requires PHP: 5.3
Stable tag: 1.0.4
License: MIT/Expat
License URI: https://docs.miniorange.com/mit-license

Login with Azure - SSO (Azure B2C, Azure AD, Office 365, Microsoft 365 etc.)allows you to login/SSO into WordPress. Setup guide, videos and 24/7 SUPPORT available.

== Description ==

**ONE LOGIN FOR MULTIPLE MICROSOFT ACCOUNTS (AZURE AD/B2C/O365)**

Azure AD, Azure B2C, Office 365, Microsoft 365 Login uses SAML / OAuth Single Sign On to allows users residing at Microsoft Azure to login into your WordPress site securely using their Azure AD, Azure B2C, O365, Microsoft 365 accounts.
Only after successful authentication with Azure AD / Azure B2C, Office 365 the plugin authorizes the users and grants them access to the WordPress site.

= List of Supported IdPs =
*	<a href="https://plugins.miniorange.com/saml-single-sign-on-sso-wordpress-using-azure-ad" target="_blank">**Azure AD**</a> (supports SAML / OAuth / OpenID Connect SSO for WordPress login)
*	<a href="https://plugins.miniorange.com/saml-single-sign-on-sso-wordpress-using-azure-b2c" target="_blank">**Azure AD B2C**</a> (supports SAML / OAuth / OpenID Connect SSO for WordPress login)
*	<a href="https://plugins.miniorange.com/saml-single-sign-on-sso-wordpress-using-azure-ad" target="_blank">**Office 365**</a> (supports SAML / OAuth / OpenID Connect SSO for WordPress login)
*	<a href="https://plugins.miniorange.com/saml-single-sign-on-sso-wordpress-using-azure-ad" target="_blank">**Microsoft 365**</a> (supports SAML / OAuth / OpenID Connect SSO for WordPress login)
*	<a href="https://plugins.miniorange.com/saml-single-sign-on-sso-wordpress-using-adfs" target="_blank">**ADFS**</a> (supports SAML SSO for WordPress login)
and practically any SAML compliant Identity Provider or OAuth / OpenID Connect Providers.

Azure AD SAML SSO Video Guide Links:
*  <a href="https://youtu.be/eHen4aiflFU" target="_blank">**App Registration Application**</a>
*  <a href="https://youtu.be/4-zyFUFiOXU" target="_blank">**Enterprise Application**</a>

miniOrange Azure AD, Azure B2C, Office 365 Login Plugin acts as a SAML 2.0 Service Provider or OAuth Client which can be configured to establish the trust between the plugin and Azure Active Directory / Azure B2C to securely authenticate the Azure AD, Azure B2C, O365 or Microsoft 365 users to the WordPress site.
WordPress Multi-Site Environment and the ability to configure Multiple IDPs/tenants/Azure Enterprise applications against wordpress as service provider is also supported in All-Inclusive/Enterprise version of Azure AD, Azure B2C, Office 365 Login plugin.

If you require any Single Sign On (SSO) application or need any help with installing this plugin, please feel free to email us at <a href="mailto:samlsupport@xecurify.com">samlsupport@xecurify.com</a> or <a href="http://miniorange.com/contact">Contact us</a>.

= Feature Highlights = 
* Unlimited Authentications
* Single Sign-on Using SAML / OAuth / OpenID Connect Support
* Auto-create New Users / Allow only existing users to login / Restrict site access to users based on Azure AD Security groups.
* Intranet SSO / Internet SSO / WP-LOGIN + SSO mode / Customizable SSO Button / Shortcode Embedding
* Attribute Mapping / Azure AD security groups mapping with Wordpress Roles
* Real-time User synchronization / provisioning from Azure AD to WordPress using SCIM Protocol / Microsoft Graph API.
* Multi-tenant / Extranet / Microsoft Applications integration support
* Embed sharepoint / one drive/ delve folders in wordpress page
* Create and manage Azure AD Employee Directory in the WordPress site with real-time user synchronization.
* Microsoft Graph API integration with WordPress to send emails.
* Adding a WordPress tab to Microsoft Teams for viewing the WordPress content.
* Embed Microsoft Power BI content in the Wordpress site.
* Protect Wordpress REST API endpoints.
* Connect with Multiple IDPs and compatible with Multisite Environment
* In-built x509 certificate for Securely Signing SAML Requests and Encrypting the user attributes.
* Seamless Integration with BuddyPress / WooCommerce / Learndash / Groups / Memberpress / Paid Membership Pro etc.
* SSO Login Audit / Session Manager / Media Files Management 


= WordPress Single Sign On (SSO) =

Single Sign-On (SSO) is an authentication process in which a user can login to multiple applications and/or websites by using only a single set of login credentials (such as username and password). This prevents the need for the user to login separately into the different applications. Single Sign-On addresses the challenge of maintaining the credentials for each application separately, streamlining the process of signing-on without need to re-enter the password.

Azure / O365 Single Sign On supports all kinds of SSO use cases such as Azure login, Azure AD login, Office 365 login, ADFS login, Okta login, OneLogin SSO, Salesforce login, Google Apps login, Keycloak login, Auth0 login, Shibboleth login, PingFederate login, etc. allowing your users to securely login to the WordPress site.

Login with Azure - SSO (Azure B2C, Azure AD) supports SSO with any 3rd party SAML supported Identity Providers like Azure AD, Azure B2C, Office 365, Microsoft 365, ADFS, Okta, Salesforce, Shibboleth, SimpleSAMLphp, OpenAM, Centrify, Ping, RSA, IBM, Oracle, OneLogin, Bitium, WSO2, NetIQ etc.  

= Free Version Features =
*   **Single Sign-On Support** - Supports SSO authentication based on SAML 2.0 / OAuth / OpenID Connect.	
*   **Auto Create Users** - Users will be auto-created in WordPress after SSO 
*   **Login Widgets** - Use Widgets to easily integrate the login link with your Wordpress site.
*   **Attribute Mapping** - Map attributes like Email and Username with the claims received from your provider.
*   **Role Mapping** - Select default role to assign to users on auto registration.

= Standard Version Features =
*   **Unlimited Authentications** - Unlimited authentication with Azure AD, Azure B2C, Office 365, Microsoft 365, ADFS. <a href="https://plugins.miniorange.com/wordpress-single-sign-on-sso" target="_blank">**Click here**</a> for more information. 
*   **Advanced Attribute Mapping** - Azure AD, Azure B2C, Office 365 Login provides the feature to map your IDP attributes to your WordPress site attributes like Username, Email, First Name, Last Name, Group/Role, Display Name. <a href="https://docs.miniorange.com/documentation/saml-handbook/attribute-role-mapping/attribute-mapping" target="_blank">**Click here**</a> for more information. 
*   **Login Widgets and Short Code** - Use Widgets to easily integrate the login link with your Wordpress site. Use Short Code (PHP or HTML) generated by Login with Azure - SSO (Azure B2C, Azure AD) to place the login link wherever you want on the site.<a href="https://docs.miniorange.com/documentation/saml-handbook/redirection-sso-links-settings" target="_blank">**Click here**</a> for more information. 
*   **Step-by-step Guides** - Use step-by-step guide to configure Azure AD, Azure B2C, Office 365, Microsoft 365, ADFS.<a href="https://plugins.miniorange.com/wordpress-saml-guides" target="_blank">**Click here**</a> for more information. 
*   **Intranet / Auto-redirect to IDP [Protect Complete Site]** - Users trying to access Wordpress site will be redirected to the Identity Provider for SSO.<a href="https://docs.miniorange.com/documentation/saml-handbook/redirection-sso-links-settings" target="_blank">**Click here**</a> for more information. 
*   **Internet / Protect WordPress login page** - Users trying to access Wordpress login page will be redirected to the Identity Provider for SSO.<a href="https://docs.miniorange.com/documentation/saml-handbook/redirection-sso-links-settings" target="_blank">**Click here**</a> for more information. 
*	**Customize SP Configuration** - Change SP base URL and SP Entity ID.<a href="https://docs.miniorange.com/documentation/saml-handbook/service-provider-metadata" target="_blank">**Click here**</a> for more information. 
*   **Select Binding Type** - Select HTTP-Post or HTTP-Redirect binding type to use for sending SAML Requests.<a href="https://docs.miniorange.com/documentation/saml-handbook/service-provider-setup" target="_blank">**Click here**</a> for more information. 
*   **Integrated Windows Authentication** - Support for Integrated Windows Authentication (IWA) in Azure AD, Azure B2C, Office 365 Login Premium plugin.<a href="https://docs.miniorange.com/documentation/saml-handbook/redirection-sso-links-settings" target="_blank">**Click here**</a> for more information. 

= Premium Features of Login with Azure - SSO (Azure B2C, Azure AD, Office 365, Microsoft 365) =
*   Includes all the STANDARD version features.
*   **Role Mapping** - Helps you to assign specific wordpress roles to users of a certain group(Self Service Group Management) in your IdP like Azure AD as IdP, Azure B2C as IdP or Office 365 as IdP or Microsoft 365 as IDP. <a href="https://docs.miniorange.com/documentation/saml-handbook/attribute-role-mapping/role-mapping" target="_blank">**Click here**</a> for more information.
*   **Auto-sync IdP Configuration from metadata** - Keep your Azure AD, Azure B2C, Microsoft 365 or O365 IDP SAML Configuration and Certificates updated and in sync. <a href="https://docs.miniorange.com/documentation/saml-handbook/service-provider-metadata" target="_blank">**Click here**</a> for more information.
*   **WordPress Multi-site Support** - Multi-Site environment is one which allows multiple subdomains / subdirectories to share a single installation. With multisite premium plugin, you can configure SSO with Azure AD, Azure B2C, Office 365, Microsoft 365, ADFS in minutes for all your sites in a network. While, if you have basic premium plugin, you have to do plugin configuration on each site individually as well as multiple Azure AD tenants for your WordPress site.<a href="https://www.miniorange.com/wordpress-single-sign-on-(sso)-for-multisite" target="_blank">**Click here**</a> for more information.
*   **Redirect URL after Login** - You can configure the WordPress logins initiated from the Web Console to automatically redirect users to the IdP(Azure AD, Azure B2C, Office 365, Microsoft 365). If multiple IdPs (Azure AD SSO, Azure B2C SSO, Office 365,Microsoft 365 SSO) are available, users choose which Microsoft application IdP validates their credentials.<a href="https://www.miniorange.com/wordpress-single-sign-on-(sso)-for-multisite" target="_blank">**Click here**</a> for more information.
*   **Widget to add IDP Login** - We customize Add a link or button anywhere on your WordPress site to allow users to authenticate via their Identity Provider.<a href="https://docs.miniorange.com/documentation/saml-handbook/redirection-sso-links-settings" target="_blank">**Click here**</a> for more information.
*   **Auto Create Users** – Users will be auto-created in WordPress after SSO which benefits you in maintaining stream lined account management with Improved Productivity and enhanced security.<a href="https://plugins.miniorange.com/wordpress-single-sign-on-sso" target="_blank">**Click here**</a> for more information.
*   **SAML Single Logout** - Support for SAML Single Logout (Works only if your IDP supports SLO).<a href="https://docs.miniorange.com/documentation/saml-handbook/service-provider-setup" target="_blank">**Click here**</a> for more information.
*   **Intranet / Auto-redirect to IDP [Protect Complete Site]** - Users trying to access Wordpress site will be redirected to the Identity Provider for SSO.<a href="https://docs.miniorange.com/documentation/saml-handbook/redirection-sso-links-settings" target="_blank">**Click here**</a> for more information. 
*   **Internet / Protect WordPress login page** - Users trying to access Wordpress login page will be redirected to the Identity Provider for SSO.<a href="https://docs.miniorange.com/documentation/saml-handbook/redirection-sso-links-settings" target="_blank">**Click here**</a> for more information.
*   **Advanced Role Mapping** - Provides the feature to assign WordPress roles to your users based on the security group/role sent by Azure AD, Azure B2C, Office 365.<a href="https://docs.miniorange.com/documentation/saml-handbook/attribute-role-mapping/role-mapping" target="_blank">**Click here**</a> for more information.
*   **Reverse-proxy Support** - Support for sites behind a reverse-proxy in WordPress SSO - Office 365 / Azure Login.<a href="https://docs.miniorange.com/documentation/saml-handbook/redirection-sso-links-settings" target="_blank">**Click here**</a> for more information.
* 	**Multiple Certificates** - Store Multiple IdP Certificates.<a href="https://docs.miniorange.com/documentation/saml-handbook/attribute-role-mapping/role-mapping" target="_blank">**Click here**</a> for more information.
*	**Custom Certificate** - Have your own custom SAML-compliant SP X-509 Certificate.<a href="https://docs.miniorange.com/documentation/saml-handbook/custom-certificate" target="_blank">**Click here**</a> for more information.
*   **Multi-Network Support** - Allow multiple Subdomains / subdirectories by sharing a single installation. Configure microsoft applications (Azure AD, Azure B2C, Office 365) for all your sites in a Network.https://www.miniorange.com/wordpress-single-sign-on-(sso)-for-multinetwork
*   **Single Sign-On (SSO)** - Easy and seamless access to all resources. WordPress Single Sign On (SSO) via any existing Microsoft applications SAML 2.0 Identity Provider / OAuth / OpenID Connect provider.<a href="https://plugins.miniorange.com/wordpress-single-sign-on-sso" target="_blank">**Click here**</a> for more information.
  
= Enterprise Features of Login with Azure - SSO (Azure B2C, Azure AD, Office 365, Microsoft 365) =
*   Includes all the STANDARD version features.
*   **Multiple SAML IDPs Support** - We now support configuration of Multiple SAML-compliant IDPs in the plugin to authenticate the different group of users with different IDP's. You can give access to users by users to IDP mapping (which SAML-compliant IDP to use to authenticate a user) is done based on the domain name in the user's email. (This is a **Enterprise** feature with separate licensing. Contact us at <a href="mailto:info@xecurify.com">info@xecurify.com</a> to get licensing plans for this feature.)
*   **Easy migration from dev to prod** - Compatible with multiple environments in a hosting provider like Pantheon, WP-Engine, Wordpress VIP. In general, if you make copy of your site then all the configuration will also get copied resulting in interuption of SSO. Using this feature you can easy migrate without breaking the SSO on test/stag/prod site.<a href="https://plugins.miniorange.com/wordpress-single-sign-on-sso" target="_blank">**Click here**</a> for more information.
*   **Mu Domain Mapping Support** - If you are using WordPress Multisite installation with each subsite using different domain host (Multiple Domain Installation) then SSO can be performed in all the subsites regardless of their domain.<a href="https://plugins.miniorange.com/wordpress-single-sign-on-sso" target="_blank">**Click here**</a> for more information.
*   **SAML Single Logout** - Support for SAML Single Logout (Works only if your IDP supports SLO).<a href="https://docs.miniorange.com/documentation/saml-handbook/service-provider-setup" target="_blank">**Click here**</a> for more information.
*   **Intranet / Auto-redirect to IDP [Protect Complete Site]** - Users trying to access Wordpress site will be redirected to the Identity Provider for SSO.<a href="https://docs.miniorange.com/documentation/saml-handbook/redirection-sso-links-settings" target="_blank">**Click here**</a> for more information. 
*   **Internet / Protect WordPress login page** - Users trying to access Wordpress login page will be redirected to the Identity Provider for SSO.<a href="https://docs.miniorange.com/documentation/saml-handbook/redirection-sso-links-settings" target="_blank">**Click here**</a> for more information.
 **Advanced Role Mapping** - Provides the feature to assign WordPress roles to your users based on the security group/role sent by Azure AD, Azure B2C, Office 365.<a href="https://docs.miniorange.com/documentation/saml-handbook/attribute-role-mapping/role-mapping" target="_blank">**Click here**</a> for more information.
*   **Reverse-proxy Support** - Support for sites behind a reverse-proxy in WordPress SSO - Office 365 / Azure Login Premium plugin.<a href="https://plugins.miniorange.com/wordpress-single-sign-on-sso" target="_blank">**Click here**</a> for more information.
* 	**Multiple Certificates** - Store Multiple IdP Certificates.<a href="https://docs.miniorange.com/documentation/saml-handbook/service-provider-setup" target="_blank">**Click here**</a> for more information.
*	**Custom Certificate** - Have your own custom SAML-compliant SP X-509 Certificate.<a href="https://docs.miniorange.com/documentation/saml-handbook/custom-certificate" target="_blank">**Click here**</a> for more information.
*   **WordPress Multi-site Support** - Multi-Site environment is one which allows multiple subdomains / subdirectories to share a single installation. With multisite premium plugin, you can configure SSO with Azure AD, Azure B2C, Office 365, Microsoft 365, ADFS in minutes for all your sites in a network. While, if you have basic premium plugin, you have to do plugin configuration on each site individually as well as multiple Azure AD tenants for your WordPress site.<a href="https://www.miniorange.com/wordpress-single-sign-on-(sso)-for-multisite" target="_blank">**Click here**</a> for more information.

= All-Inclusive Features of Login with Azure - SSO (Azure B2C, Azure AD, Office 365, Microsoft 365) =
*  Includes all the Enterprise version features.
*  **Customize Metadata Contact Information** - You can now customize Organization profile as well as technical details in Service Provider Metadata. 
*  **Configuring Plugin using APIs** - You can configure the plugin using API calls as well as WP-CLI. It helps you to manage configuration for large number of sites and easily automate the process.
*  **Add-Ons included** - You will get the following addons in the license cost itself for extended functionality. It provides functionality ranging from Automatic user provisioning, login audit, session manager, LMS mapper, Page/Post/Media restriction, etc. 

= Add-ons =
We have a variety of add-ons that can be integrated with the WordPress SSO - Office 365 / Azure Login plugin to improve the functionality of your WordPress site.

*	<a href="https://plugins.miniorange.com/wordpress-page-restriction" target="_blank">**Page Restriction**</a> -  	This add-on is basically used to protect the pages/posts of your site with SAML-compliant IDP login page and also, restrict the access to pages/posts of the site based on the user roles.
*	<a href="https://plugins.miniorange.com/wordpress-buddypress-integrator" target="_blank">**BuddyPress Integration**</a> - This add-on maps the attributes fetched from the SAML-compliant IdP with BuddyPress attributes.
*	<a href="https://plugins.miniorange.com/wordpress-learndash-integrator" target="_blank">**LearnDash Integration**</a> - This add-on will map the SAML-compliant IdP attributes to the LearnDash attributes.
*	<a href="https://plugins.miniorange.com/wordpress-media-restriction" target="_blank">**Media Restriction**</a> - This add-on restricts unauthorized users from accessing the media files on your WordPress site.
*	<a href="https://plugins.miniorange.com/wordpress-attribute-based-redirection-restriction" target="_blank">**Attribute based Redirection (ABAC)**</a> - This plugin can be used to restrict and redirect users to different URLs based on Azure AD / Azure B2C / Office 365 IDP attributes.
*	<a href="https://plugins.miniorange.com/wordpress-user-provisioning" target="_blank">**SCIM-User Provisioning**</a> - SCIM Auto User Provisioning allows users to sync, Create, Update, delete users from Azure AD or all SCIM capable Identity providers(IdPs) to WordPress sites.
*	<a href="https://plugins.miniorange.com/wordpress-sso-login-audit" target="_blank">**SSO Login Audit**</a> - SSO Login Audit captures all the SSO users and will generate the reports.
*	<a href="https://plugins.miniorange.com/sso-session-management" target="_blank">**SSO Session Management** </a>- SSO session management add-on manages the login session time of your users based on their WordPress roles.

If you are looking for an SAML-compliant Identity Provider,you can try out <a href="https://idp.miniorange.com">miniOrange On-Premise IdP</a>.

You might be interested to know that if you’re a current Office 365, Azure or you’re already using Azure AD – and can use this tenant to manage access to any of the other cloud services with which Azure AD integrates.

Contact us at <a href="mailto:info@xecurify.com">info@xecurify.com</a> to get add-ons. 

= Website - =
Check out our website for other plugins <a href="http://miniorange.com/plugins" >http://miniorange.com/plugins</a> or <a href="https://wordpress.org/plugins/search.php?q=miniorange" >click here</a> to see all our listed WordPress plugins.
For more support or info email us at <a href="mailto:info@xecurify.com">info@xecurify.com</a> or <a href="http://miniorange.com/contact" >Contact us</a>. You can also submit your query from plugin's configuration page.

== Installation ==

= From your WordPress dashboard =
1. Visit `Plugins > Add New`.
2. Search for `Azure AD, Azure B2C, Office 365 Login`. Find and Install `Azure AD, Azure B2C, Office 365 Login`.
3. Activate the plugin from your Plugins page.

= From WordPress.org =
1. Download WordPress SSO - Office 365 / Azure Login plugin.
2. Unzip and upload the `login-with-office-365` directory to your `/wp-content/plugins/` directory.
3. Activate WordPress SSO - Office 365 / Azure Login from your Plugins page.

== Frequently Asked Questions ==

= I am not able to configure the Identity Provider with the provided settings =
Please email us at <a href="mailto:info@xecurify.com">info@xecurify.com</a> or <a href="http://miniorange.com/contact" >Contact us</a>. You can also submit your app request from plugin's configuration page.

= For any query/problem/request =
Visit Help & FAQ section in the plugin OR email us at <a href="mailto:info@xecurify.com">info@xecurify.com</a> or <a href="http://miniorange.com/contact">Contact us</a>. You can also submit your query from plugin's configuration page.

== Screenshots ==

1. Configure your Wordpress as Service Provider.
2. Gather Metadata for your Identity Provider.
3. Configure Attribute/Role Mapping for Users in Wordpress.
4. Add widget to enable Single Sign-on.
5. Plugin-tour which guides you through entire plugin setup.
6. Addons which extend plugin functionality.

== Changelog ==

= 1.0.4 =
* Compatibility with WordPress 6.0
* Some UI improvements

= 1.0.3 =
* Compatibility with WordPress 5.8
* Added Banner for year end sale

= 1.0.2 =
* Compatibility with WordPress 5.5 and PHP 7.4+
* Sanitization fixes

= 1.0 =
Initial public release

== Upgrade Notice ==

= 1.0.4 =
* Compatibility with WordPress 6.0
* Some UI improvements

= 1.0 =
Initial public release