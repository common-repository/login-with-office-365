<?php
include_once 'Import-export.php';
include_once 'mo_saml_licensing_plans.php';
include 'mo_saml_addons.php';

function mo_o365_register_saml_sso() {

    if ( isset( $_GET['tab'] ) ) {
        $active_tab = $_GET['tab'];
    }else if ( mo_o365_saml_is_customer_registered_saml() ) {
        $active_tab = 'save';
    } else {
        $active_tab = 'login';
    }
    ?>
    <?php
    if ( ! mo_o365_saml_is_curl_installed() ) {
        ?>
        <p><font color="#FF0000">(Warning: <a href="http://php.net/manual/en/curl.installation.php" target="_blank">PHP
                    cURL extension</a> is not installed or disabled)</font></p>
        <?php
    }

    if ( ! mo_o365_saml_is_openssl_installed() ) {
        ?>
        <p><font color="#FF0000">(Warning: <a href="http://php.net/manual/en/openssl.installation.php" target="_blank">PHP
                    openssl extension</a> is not installed or disabled)</font></p>
        <?php
    }

	if ( ! mo_o365_saml_is_dom_installed() ) {
		?>
        <p><font color="#FF0000">(Warning: PHP
                    dom extension is not installed or disabled)</font></p>
		<?php
	}

    ?>
    <div id="mo_saml_settings" >
    <div class="notice is-dismissible"><p><b>Recommendation : </b> Please check out our
        <a href="<?php echo add_query_arg( array('tab' => 'integrations'), $_SERVER['REQUEST_URI'] );?>"><?php echo 'Azure integration page'; ?></a><?php echo ' for advanced functionality like User Sync, Microsoft Graph Integeration, etc.</p></div>';?>
        <form name="f" method="post" id="show_pointers">
            <?php wp_nonce_field("clear_pointers");?>
            <input type="hidden" name="option" value="clear_pointers"/>
        </form>

        <form name="f" method="post" id="mo-o365-restart-plugin-tour">
            <?php wp_nonce_field("restart_plugin_tour");?>
            <input type="hidden" name="option" value="restart_plugin_tour"/>
        </form>

        <form name="f" method="post" id="mo-o365-skip-plugin-tour">
            <?php wp_nonce_field("skip_plugin_tour");?>
            <input type="hidden" name="option" value="skip_plugin_tour"/>
        </form>


        <div class="wrap">
            <h1>

                <?php if($active_tab == 'licensing' || (isset($_REQUEST['page']) && $_REQUEST['page'] == 'mo_saml_licensing')){ ?>

                    <div style="text-align:center;">
                    WordPress SSO - Office 365 / Azure Login</div>
                    <div style="float:left;"><a  class="add-new-h2 add-new-hover" style="font-size: 16px; color: #000;" href="<?php echo mo_o365_saml_add_query_arg( array( 'tab' => 'save' ), htmlentities( $_SERVER['REQUEST_URI'] ) ); ?>"><span class="dashicons dashicons-arrow-left-alt" style="vertical-align: bottom;"></span> Back To Plugin Configuration</a></div>
            
                    <br />
                    <?php mo_azure_saml_display_sale_banner(); ?>
                    <div style="text-align:center; color: rgb(233, 125, 104);">You are currently on the Free version of the plugin<span style="font-size: 16px; margin-bottom: 0Px;"><li style="margin-bottom: 0px;margin-top: 0px;">Free version is recommended for setting up Proof of Concept (PoC)</li><li style="margin-bottom: 0px;margin-top: 0px;">Try it to test the SSO connection with your SAML 2.0 compliant IdP</li><li style="margin-bottom: 0px;margin-top: 0px;">Works with NameId Attribute which should contain Email Address</li>
                    <li style="color: dimgray; margin-top: 0px;list-style-type: none;">
                    <a tabindex="0"  style="cursor: pointer;color:dimgray;" id="popoverfree" data-toggle="popover" data-trigger="focus" title="<h3>Why should I upgrade to premium plugin?</h3>" data-placement="bottom" data-html="true"
                               data-content="<p>You should upgrade to seek the support of our SSO expert team.<br /><br />Free version does not support attribute mapping, role mapping, single logout features and Multisite Network Installation. <br /><br />Premium version support Signed SAML Request and Encrypted Assertion which are recommended from security point of view.<br /><br />Auto-Redirect to IdP which protect your site with IdP login is a part of premium version of the plugin.<br /><br />Check the features given in the Licensing Plans for more detail.</p>">
                    Why should I upgrade?</a>
                    </li></span></div>
                <?php }else{
                    update_option('mo_license_plan_from_feedback', '');
                    update_option('mo_saml_license_message', '');
                    ?>

                WordPress SSO - Office 365 / Azure Login&nbsp
                <a id="license_upgrade" class="add-new-h2 add-new-hover" style="background-color: orange !important; border-color: orange; font-size: 16px; color: #000;" href="<?php echo add_query_arg( array( 'tab' => 'licensing' ), htmlentities( $_SERVER['REQUEST_URI'] ) ); ?>">Upgrade Now</a>
                <a class="add-new-h2" href="https://faq.miniorange.com/kb/saml-single-sign-on/" target="_blank">FAQs</a>
                <a class="add-new-h2" href="https://forum.miniorange.com/" target="_blank">Ask questions on our forum</a>



                <span style="position: relative; float: right;background-color:white;border-radius:4px;" id="miniorange-plugin-restart-tour">
                     <button type="button"  class="button button-primary button-large" id="myBtn"><i class="fa fa-refresh"></i>  Restart Plugin Tour</button>
                </span>
                <?php mo_azure_saml_display_sale_banner();} ?>

            </h1>

        </div>

        <style>
            .add-new-hover:hover{
                color: white !important;
            }

        </style>




<input type="hidden" value="<?php echo get_option("mo_o365_is_new_user")?>" id="mo_modal_value">


<div id="mo_o365_modal" class="modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h2 class="modal-title" style="text-align: center; font-size: 40px; color: #2980b9">Let's get started!</h2>
            </div>

            <div class="modal-body">
                <p style="font-size: medium">Hey, Thank you for installing <b style="color: #E85700">WordPress SSO - Office 365 / Azure Login plugin</b>.</p>
                <p style="font-size: medium">We support all SAML 2.0 compliant Identity Providers. Please find some of the well-known IdP configuration guides below.</p>

                <div class="idp-guides-btns">
                    <button class="guide-btn" onclick="window.open('https://plugins.miniorange.com/saml-single-sign-on-sso-wordpress-using-azure-ad','_blank')">Office 365</button>
                    <button class="guide-btn" onclick="window.open('https://plugins.miniorange.com/saml-single-sign-on-sso-wordpress-using-azure-ad','_blank')">Azure AD</button>
                    <button class="guide-btn" onclick="window.open('https://plugins.miniorange.com/saml-single-sign-on-sso-wordpress-using-azure-b2c','_blank')">Azure B2C</button>
                </div>
                <p style="font-size: medium">Make sure to check out the list of supported add-ons to increase the functionality of your WordPress site.</p>
                <p style="font-size: medium">Would you like to watch a quick tour of setting up the plugin with Office 365?</p>
            </div>

            <div class="modal-footer">
                <button type="button" style="margin-right:5%;" class="button button-primary button-large" onclick="jQuery('#mo-o365-restart-plugin-tour').submit();">Start tour</button>
                <button type="button" style="margin-right:37.5%;" class="button button-primary button-large" onclick="jQuery('#mo-o365-skip-plugin-tour').submit();">Skip the tour</button>
            </div>

        </div>
    </div>
</div>


<script>

var modal = document.getElementById("mo_o365_modal");
var btn = document.getElementById("myBtn");
var span = document.getElementsByClassName("close1")[0];

btn.onclick = function() {
  modal.style.display = "block";
}

document.addEventListener("DOMContentLoaded", function() {
    var modal_value = document.getElementById("mo_modal_value");
    if(modal_value.value == 1) {
        modal.style.display = "block";
        <?php update_option('mo_o365_is_new_user',0)?>
    }
});

</script>



        <div class="miniorange_container" id="container">

                    <?php if($active_tab != 'licensing' && !(isset($_REQUEST['page']) && $_REQUEST['page'] == 'mo_saml_licensing')) { ?>
                <table style="width:100%;">
                <tr>
                    <h2 class="nav-tab-wrapper">
                        <form id="dismiss_pointers" method="post" action="">
                            <?php wp_nonce_field('dismiss_pointers');?>
                            <input type="hidden" name="option" value="dismiss_pointers"/>
                        </form>
                        <a id="sp-setup-tab" class="nav-tab <?php echo $active_tab == 'save' ? 'nav-tab-active' : ''; ?>"
                           href="<?php echo add_query_arg( array( 'tab' => 'save' ), htmlentities( $_SERVER['REQUEST_URI'] ) ); ?>">Service Provider Setup</a>
                        <a id="sp-meta-tab" class="nav-tab <?php echo $active_tab == 'config' ? 'nav-tab-active' : ''; ?>"
                           href="<?php echo add_query_arg( array( 'tab' => 'config' ), htmlentities( $_SERVER['REQUEST_URI'] ) ); ?>">Service Provider Metadata</a>
                        <a id="attr-role-tab" class="nav-tab <?php echo $active_tab == 'opt' ? 'nav-tab-active' : ''; ?>"
                           href="<?php echo add_query_arg( array( 'tab' => 'opt' ), htmlentities( $_SERVER['REQUEST_URI'] ) ); ?>">Attribute/Role Mapping</a>
                        <!-- <a class="nav-tab <?php echo $active_tab == 'licensing' ? 'nav-tab-active' : ''; ?>"
                           href="<?php echo add_query_arg( array( 'tab' => 'licensing' ), htmlentities( $_SERVER['REQUEST_URI'] ) ); ?>">Premium plans</a> -->
                           <a id="integration-tab" style="background:#0078d4;color:white;" class="nav-tab <?php echo $active_tab == 'integrations' ? 'nav-tab-active' : ''; ?>"
                           href="<?php echo add_query_arg( array( 'tab' => 'integrations' ), htmlentities( $_SERVER['REQUEST_URI'] ) ); ?>">Azure Integrations</a>
                        <a id="redir-sso-tab" class="nav-tab <?php echo $active_tab == 'general' ? 'nav-tab-active' : ''; ?>"
                           href="<?php echo add_query_arg( array( 'tab' => 'general' ), htmlentities( $_SERVER['REQUEST_URI'] ) ); ?>">Redirection & SSO Links</a>
                        <a id="addon-tab" class="nav-tab <?php echo $active_tab == 'addons' ? 'nav-tab-active' : ''; ?>"
                           href="<?php echo add_query_arg( array( 'tab' => 'addons' ), htmlentities( $_SERVER['REQUEST_URI'] ) ); ?>">Add-Ons</a>
                        <a class="nav-tab <?php echo $active_tab == 'support' ? 'nav-tab-active' : ''; ?>"
                           href="<?php echo add_query_arg( array( 'tab' => 'support' ), htmlentities( $_SERVER['REQUEST_URI'] ) ); ?>">Demo Request</a>
                        <a class="nav-tab <?php echo $active_tab == 'account-setup' ? 'nav-tab-active' : ''; ?>"
                           href="<?php echo add_query_arg( array( 'tab' => 'account-setup' ), htmlentities( $_SERVER['REQUEST_URI'] ) ); ?>">Account Setup</a>

                    </h2>
                    <td style="vertical-align:top;width:65%;">
                        <?php
                        if ( $active_tab == 'save' ) {
                            ?>
                            <div id="save_tab" style="display: block;">
                                 <?php mo_o365_saml_apps_config_saml();?>
                            </div>
                            <div id="config_tab" style="display:none">
                                <?php mo_o365_saml_configuration_steps();?>
                            </div>
                            <div id="opt_tab" style="display:none">
                                 <?php mo_o365_saml_save_optional_config();?>
                             </div>
                            <div id="addons_tab" style="display:none">
                                 <?php mo_o365_saml_show_addons_page();                               
                                 ?>
                             </div>
                             <div id="integrations_tab" style="display:none">
                                 <?php mo_o365_saml_show_integrations_page();                               
                                 ?>
                             </div>
                            <div id="redir_sso_tab" style="display:none">
                                 <?php mo_o365_saml_general_login_page();?>
                             </div>
                            <?php
                        }
                        else if ( $active_tab == 'opt' ) {
                            mo_o365_saml_save_optional_config();
                        }
                        else if ( $active_tab == 'config' ) {
                            mo_o365_saml_configuration_steps();
                        }
                        else if ( $active_tab == 'general' ) {
                            mo_o365_saml_general_login_page();
                        }
                        else if($active_tab == 'addons'){
                            mo_o365_saml_show_addons_page();
                        }
                        else if($active_tab == 'integrations'){
                            mo_o365_saml_show_integrations_page();
                            //echo '<style>#support-form{ display:none;}</style>';
                        }
                        else if($active_tab == 'support'){
                            mo_o365_demo_request_saml();
                            
                        }
                        else if($active_tab == 'account-setup'){
                            if(mo_o365_saml_is_customer_registered_saml(false)){
                                mo_o365_saml_show_customer_details();
                            }else{
                                if ( get_option( 'mo_saml_verify_customer' ) == 'true' ) {
                                    mo_o365_saml_show_verify_password_page_saml();
                                }else{
                                    mo_o365_saml_show_new_registration_page_saml();
                                }
                            }
                        }
                        else {
                                mo_o365_saml_apps_config_saml();
                        }
                        ?>
                    </td>
                    <td style="vertical-align:top;padding-left:1%;" id="support-form">
                        <?php 
                        if($active_tab !== 'opt' || !get_option('mo_saml_test_config_attrs')){
                        echo mo_o365_support_saml(); 
                        } else {
                            mo_o365_saml_display_attrs_list();
                        } ?>

                    </td>
                </tr>
                </table>
                    <?php }else if ( $active_tab == 'licensing' || 	(isset($_REQUEST['page']) && $_REQUEST['page'] == 'mo_saml_licensing')){ ?>

                            <?php
                            
                            mo_o365_saml_show_licensing_page();

                        }?>


        </div>
        <div class='overlay' id="overlay" hidden></div>
        <script>
            jQuery("#mo_saml_mo_idp").click(function () {
                jQuery("#mo_saml_mo_idp_form").submit();
            });

        </script>

        <?php
        }

function mo_o365_saml_is_curl_installed() {
    if ( in_array( 'curl', get_loaded_extensions() ) ) {
        return 1;
    } else {
        return 0;
    }
}

function mo_o365_saml_is_openssl_installed() {

    if ( in_array( 'openssl', get_loaded_extensions() ) ) {
        return 1;
    } else {
        return 0;
    }
}

function mo_o365_saml_is_dom_installed(){

    if ( in_array( 'dom', get_loaded_extensions() ) ) {
        return 1;
    } else {
        return 0;
    }
}

function mo_o365_saml_is_iconv_installed(){

    if ( in_array( 'iconv', get_loaded_extensions() ) ) {
        return 1;
    } else {
        return 0;
    }
}

function mo_o365_saml_get_attribute_mapping_url(){

    return add_query_arg( array('tab' => 'opt'), $_SERVER['REQUEST_URI'] );
}

function mo_o365_saml_show_customer_details(){
    ?>
    <div class="mo_saml_table_layout" >
        <h2>Thank you for registering with miniOrange.</h2>

        <table border="1"
           style="background-color:#FFFFFF; border:1px solid #CCCCCC; border-collapse: collapse; padding:0px 0px 0px 10px; margin:2px; width:85%">
        <tr>
            <td style="width:45%; padding: 10px;">miniOrange Account Email</td>
            <td style="width:55%; padding: 10px;"><?php echo get_option( 'mo_saml_admin_email' ); ?></td>
        </tr>
        <tr>
            <td style="width:45%; padding: 10px;">Customer ID</td>
            <td style="width:55%; padding: 10px;"><?php echo get_option( 'mo_saml_admin_customer_key' ) ?></td>
        </tr>
        </table>
        <br /><br />

    <table>
    <tr>
    <td>
    <form name="f1" method="post" action="" id="mo_saml_goto_login_form">
    <?php wp_nonce_field("change_miniorange");?>
        <input type="hidden" value="change_miniorange" name="option"/>
        <input type="submit" value="Change Email Address" class="button button-primary button-large"/>
    </form>
    </td><td>
    <a href="<?php echo add_query_arg( array( 'tab' => 'licensing' ), htmlentities( $_SERVER['REQUEST_URI'] ) ); ?>"><input type="button" class="button button-primary button-large" value="Check Licensing Plans"/></a>
    </td>
    </tr>
    </table>

                <br />
    </div>

    <?php
}

function mo_o365_saml_show_new_registration_page_saml() {
    update_option( 'mo_saml_new_registration', 'true' );
    $user = wp_get_current_user();

    ?>

    <form name="f" method="post" action="">
        <input type="hidden" name="option" value="mo_saml_register_customer"/>
        <?php wp_nonce_field("mo_saml_register_customer");?>
        <div class="mo_saml_table_layout">


            <h2>Register with miniOrange</h2>

            <div id="panel1">
                <p style="font-size:14px;"><b>Why should I register? </b></p>
                <div id="help_register_desc" style="background: aliceblue; padding: 10px 10px 10px 10px; border-radius: 10px;">
                    You should register so that in case you need help, we can help you with step by step
                    instructions. We support all known IdPs - Office 365, ADFS, Okta, Salesforce, Shibboleth,
                        SimpleSAMLphp, OpenAM, Centrify, Ping, RSA, IBM, Oracle, OneLogin, Bitium, WSO2 etc.
                        <b>You will also need a miniOrange account to upgrade to the premium version of the plugins.</b> We do not store any information except the email that you will use to register with us.
                </div>
                </p>
                <table class="mo_saml_settings_table">
                    <tr>
                        <td><b><font color="#FF0000">*</font>Email:</b></td>
                        <td><input class="mo_saml_table_textbox" type="email" name="email"
                                   required placeholder="person@example.com"
                                   value="<?php echo ( get_option( 'mo_saml_admin_email' ) == '' ) ? get_option( 'admin_email' ) : get_option( 'mo_saml_admin_email' ); ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td><b><font color="#FF0000">*</font>Password:</b></td>
                        <td><input class="mo_saml_table_textbox" required type="password"
                                   name="password" placeholder="Choose your password (Min. length 6)"
                                   minlength="6" pattern="^[(\w)*(!@#$.%^&*-_)*]+$"
                                   title="Minimum 6 characters should be present. Maximum 15 characters should be present. Only following symbols (!@#.$%^&*) should be present."
                                   /></td>
                    </tr>
                    <tr>
                        <td><b><font color="#FF0000">*</font>Confirm Password:</b></td>
                        <td><input class="mo_saml_table_textbox" required type="password"
                                   name="confirmPassword" placeholder="Confirm your password"
                                   minlength="6" pattern="^[(\w)*(!@#$.%^&*-_)*]+$"
                                   title="Minimum 6 characters should be present. Maximum 15 characters should be present. Only following symbols (!@#.$%^&*) should be present."

                                   /></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td><br><input type="submit" name="submit" value="Register"
                                       class="button button-primary button-large"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                       <input type="button" name="mo_saml_goto_login" id="mo_saml_goto_login"
                                   value="Already have an account?" class="button button-primary button-large"/>&nbsp;&nbsp;

                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </form>
    <form name="f1" method="post" action="" id="mo_saml_goto_login_form">
    <?php wp_nonce_field("mo_saml_goto_login");?>
        <input type="hidden" name="option" value="mo_saml_goto_login"/>
    </form>

    <script>
        jQuery('#mo_saml_goto_login').click(function () {
            jQuery('#mo_saml_goto_login_form').submit();
        });
    </script>
    <?php
}

function mo_o365_saml_show_verify_password_page_saml() {
            ?>
            
            <form name="f" method="post" action="">
            <?php wp_nonce_field("mo_saml_verify_customer");?>
                <input type="hidden" name="option" value="mo_saml_verify_customer"/>
                <div class="mo_saml_table_layout">
                    <div id="toggle1" class="panel_toggle">
                        <h3>Login with miniOrange</h3>
                    </div>
                    <div id="panel1">
                        <p><b>It seems you already have an account with miniOrange. Please enter your miniOrange email
                                and password.<br/> <a target="_blank"
                                                      href="https://login.xecurify.com/moas/idp/resetpassword">Click
                                    here if you forgot your password?</a></b></p>
                        <br/>
                        <table class="mo_saml_settings_table">
                            <tr>
                                <td><b><font color="#FF0000">*</font>Email:</b></td>
                                <td><input class="mo_saml_table_textbox" type="email" name="email"
                                           required placeholder="person@example.com"
                                           value="<?php echo get_option( 'mo_saml_admin_email' ); ?>"/></td>
                            </tr>
                            <tr>
                                <td><b><font color="#FF0000">*</font>Password:</b></td>
                                <td><input class="mo_saml_table_textbox" required type="password"
                                           name="password" placeholder="Enter your password"
                                           minlength="6" pattern="^[(\w)*(!@#$.%^&*-_)*]+$"
                                           title="Minimum 6 characters should be present. Maximum 15 characters should be present. Only following symbols (!@#.$%^&*) should be present."

                                           /></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>
                                    <input type="submit" name="submit" value="Login"
                                           class="button button-primary button-large"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="button" name="mo_saml_goback" id="mo_saml_goback" value="Back"
                                           class="button button-primary button-large"/>
                            </tr>
                        </table>
                    </div>
                </div>
            </form>
            <form name="f" method="post" action="" id="mo_saml_goback_form">
                <?php wp_nonce_field("mo_saml_go_back")?>
                <input type="hidden" name="option" value="mo_saml_go_back"/>
            </form>
            <form name="f" method="post" action="" id="mo_saml_forgotpassword_form">
            <?php wp_nonce_field("mo_saml_forgot_password_form_option");?>
                <input type="hidden" name="option" value="mo_saml_forgot_password_form_option"/>
            </form>
            <script>
                jQuery('#mo_saml_goback').click(function () {
                    jQuery('#mo_saml_goback_form').submit();
                });
                jQuery("a[href=\"#mo_saml_forgot_password_link\"]").click(function () {
                    jQuery('#mo_saml_forgotpassword_form').submit();
                });
            </script>
            <?php
        }

function mo_o365_saml_general_login_page() {

    ?>
    <?php if ( mo_o365_saml_is_customer_registered_saml() ) { ?>
        <div style="background-color:#FFFFFF; border:1px solid #CCCCCC; padding:0px 2% 0px 2%;position: relative" id="minorange-use-widget">

            <h3><b>Option 1: Use a Widget</b><sup style="font-size: 12px;">[Available in current version of the plugin]</sup>
            <span style="position: relative; float: right;padding-left: 13px;padding-right:13px;background-color:white;border-radius:4px;" id="miniorange-redirection-sso-restart-tour">
             <button type="button"  class="button button-primary button-large" onclick="jQuery('#show_pointers').submit();"><i class="fa fa-refresh"></i>  Restart Tour</button>

            </span>

            </h3>
            <div style="margin:2% 0 2% 17px;">
                <p>Add the SSO Widget by following the instructions below. This will add the SSO link on your site.</p>
                <div id="mo_saml_add_widget_steps">
                    <ol>
                        <li>Go to Appearances > <a href="<?php echo get_admin_url().'widgets.php';?>">Widgets.</a></li>
                        <li>Select "Login with <?php echo get_option( 'saml_identity_name' ); ?>". Drag and drop to your
                            favourite location and save.
                        </li>
                    </ol>
                </div>
            </div>
        </div>
        <br/>
        <div style="background-color:#FFFFFF; border:1px solid #CCCCCC; padding:0px 2% 0px 2%;position: relative" id="miniorange-auto-redirect">
            <h3>Option 2: Auto-Redirection from site<sup style="font-size: 12px;">[Available in <a
                        href="<?php echo admin_url( 'admin.php?page=mo_o365_saml_settings&tab=licensing' ); ?>">Standard, Premium and Enterprise</a> plans]</sup></h3>
            <span>1. Select this option if you want to restrict your site to only logged in users. Selecting this option will redirect the users to your IdP if logged in session is not found.</span>
            <br /><br/>
            <label class="switch">
            <input type="checkbox" style="background: #DCDAD1;" disabled/>
            <span class="slider round"></span>
            </label><span style="padding-left:5px"><b><span style="color: red;">*</span>Redirect to
            IdP if user not logged in</b></span>
            <br/>
            <br />
            <span>2. It will force user to provide credentials on your IdP on each login attempt even if the user is already logged in to IdP. This option may require some additional setting in your IdP to force it depending on your Identity Provider.</span>
            <br /><br />
            <label class="switch">
            <input type="checkbox" style="background: #DCDAD1;" disabled>
            <span class="slider round"></span>
            </label><span style="padding-left:5px"><b><span style="color: red;">*</span>Force authentication with your IdP on each login attempt</b></span>
           <br />
            <br/>
        </div>
        <div style="background-color:#FFFFFF; border:1px solid #CCCCCC; padding:0px 2% 0px 2%;position: relative" id="miniorange-auto-redirect-login-page">
             <h3>Option 3: Auto-Redirection from WordPress Login<sup style="font-size: 12px;">[Available in <a
                        href="<?php echo admin_url( 'admin.php?page=mo_o365_saml_settings&tab=licensing' ); ?>">Standard, Premium and Enterprise</a> plans]</sup></h3>
            <span>1. Select this option if you want the users visiting any of the following URLs to get redirected to your configured IdP for authentication:</span>
                <br/><code><b><?php echo wp_login_url(); ?></b></code> or
                <code><b><?php echo admin_url(); ?></b></code><br /><br/>
            <label class="switch">
            <input type="checkbox" style="background: #DCDAD1;" disabled>
            <span class="slider round"></span>
					</label><span style="padding-left:5px"><b><span style="color: red;">*</span> Redirect to IdP from WordPress Login Page</b></span>
            <br /><br/>

            <span>2. Select this option to enable backdoor login if auto-redirect from WordPress Login is enabled.</span>
            <br/><br/>
            <label class="switch">
            <input type="checkbox" style="background: #DCDAD1;" disabled>
            <span class="slider round"></span>
					</label><span style="padding-left:5px"><b>
                        <span style="color: red;">*</span> Checking
                        this option creates a backdoor to login to your Website using WordPress credentials incase you
                        get locked out of your IdP</b></span><br/>
                        <br/><i>(Note down this URL: <code><b><?php echo site_url(); ?>/wp-login.php?saml_sso=false</b></code> )</i>
            <br /><br />
        </div>
        <div style="background-color:#FFFFFF; border:1px solid #CCCCCC; padding:0px 2% 0px 2%;" >
            <div style="background-color:#FFFFFF;position: relative" id="miniorange-short-code">
            <h3>Option 4: Use a ShortCode<sup style="font-size: 12px;">[Available in <a
                        href="<?php echo admin_url( 'admin.php?page=mo_o365_saml_settings&tab=licensing' ); ?>">Standard, Premium and Enterprise</a> plans]</sup></h3>
                        <label class="switch">
                        <input type="checkbox" style="background: #DCDAD1;"
                           disabled <?php if ( ! mo_o365_saml_is_sp_configured() )
                        echo 'disabled title="Disabled. Configure your Service Provider"' ?> value="true">
                         <span class="slider round"></span>
					</label><span style="padding-left:5px"><b><span
                            style="color: red">*</span>Check this option if you want to add a shortcode to your page</b></span>
                    <br/>
            </div>
            <div style="display:block;text-align:center;margin:2%;">
                <input type="button"
                       onclick="window.location.href='<?php echo wp_logout_url( site_url() ); ?>'" <?php if ( ! mo_o365_saml_is_sp_configured() )
                    echo 'disabled title="Disabled. Configure your Service Provider"' ?>
                       class="button button-primary button-large" value="Log Out and Test">
            </div>
            <?php if ( get_option( 'mo_saml_free_version' ) ) { ?>
                <span style="color:red;">*</span>These options are configurable in the <a
                        href="<?php echo admin_url( 'admin.php?page=mo_o365_saml_settings&tab=licensing' ); ?>"><b>standard,
                        premium and enterprise</b></a> version of the plugin.</h3>
                <br/><br/>
            <?php } ?>
        </div>
        <br/>
    <?php }
}

function mo_o365_saml_configuration_steps() {
    $sp_base_url = site_url();
    
    $sp_entity_id = get_option('mo_saml_sp_entity_id')?:$sp_base_url.'/wp-content/plugins/miniorange-saml-20-single-sign-on/';
    ?>
    
    <input type="hidden" name="option" value="mo_saml_idp_config"/>
    <div id="instructions_idp"></div>
    <table width="98%" border="0" style="background-color:#FFFFFF; border:1px solid #CCCCCC; padding:2%;padding-top: 0px">
        <tr>
                    <td colspan="2" style="padding: 13px;padding-top: 0px;padding-bottom: 0px">
                        <h3>Gather Metadata for IDP &nbsp &nbsp
             <span style="padding-left:13px;padding-right:13px; background-color: white;position: relative; float: right;border-radius:2px;" id="identity-provider-restart-tour"><button type="button"  class="button button-primary button-large" onclick="jQuery('#show_pointers').submit();" ><i class="fa fa-refresh"></i>  Restart Tour</button>
</span>
                </h3></td>
                </tr>

                <tr>
                    <td colspan="4">
                        <hr>
                    </td>
                </tr>
                <tr>
                <td colspan="4">
                <h3>Service Provider Endpoints</h3>
                <form width="98%" border="0" style="position:relative;background: white;border-radius:5px;padding-left: 13px;" method="post" id="mo_saml_update_idp_settings_form" action="">
		<?php wp_nonce_field('mo_saml_update_idp_settings_option');?>
			<input type="hidden" name="option" value="mo_saml_update_idp_settings_option" />
				<table width="98%">
                <tr>
                <td>SP EntityID / Issuer:</td>
						<td><input type="text" name="mo_saml_sp_entity_id" placeholder="Enter Service Provider Entity ID" style="width: 95%;" value="<?php echo $sp_entity_id; ?>" required /></td>
                </tr>


                




                <tr>
                    <td>
                    </td>
                    <td>
                    <i><b>Note:</b> If you have already shared the below URLs or Metadata with your IdP, do <b>NOT</b> change SP EntityID. It might break your existing login flow.</i>
                    <br>
                    <i><b>Note:</b> For configuring through <b>App Registrations</b> remove the trailing slash<b>("/")</b> and then click Update.</i>
                    </td>
                </tr>
                <tr>		
                    <td colspan="2" style="text-align: center"><br><input type="submit" name="submit" style="width:100px;" value="Update" class="button button-primary button-large"/></td>
                </tr>
                </table></form>

        <tr>
            <?php if ( ! mo_o365_saml_is_customer_registered_saml() ) { ?>
                <td colspan="2">
                    <div style="display:block;margin-top:10px;color:red;background-color:rgba(251, 232, 0, 0.15);padding:4px;border:solid 1px rgba(255, 0, 9, 0.36);">
                        Please <a
                                href="<?php echo add_query_arg( array( 'tab' => 'login' ), htmlentities( $_SERVER['REQUEST_URI'] ) ); ?>">Register
                            or Login with miniOrange</a> to configure the miniOrange SAML Plugin.
                    </div>
                </td>
            <?php } ?>
        </tr>

        <tr>
            <td colspan="2">

                <h3>
                <?php
                echo '
                <div id="metadata_url" style="position:relative;background: white;border-radius:5px;padding-left: 13px;">';
                 echo '<p><b>Provide this metadata URL to your Identity Provider or download the .xml file to upload it in your idp:</b></p>
            <p>Metadata URL:   <code style="margin-right:20px"><b><a id="sp_metadata_url" target="_blank" href="'.$sp_base_url.'/?option=mosaml_metadata">'. $sp_base_url.'/?option=mosaml_metadata</a></b>
            </code>
            <i class="fa fa-fw fa-lg fa-copy mo_copy copytooltip" onclick="copyToClipboard(this, \'#sp_metadata_url\', \'#metadata_url_copy\');"><span id="metadata_url_copy" class="copytooltiptext">Copy to Clipboard</span></i>
            </p>
            <p>Metadata XML:  <a href="#" onclick="document.forms[\'mo_saml_download_metadata\'].submit();" >Download</a></p></div>';

            echo '<p style="text-align: center;font-size: 13pt;font-weight: bold;">OR</p>';?>

                <div style="font-size: 13px;position: relative;background-color: white;border-radius: 5px;padding-left: 13px;padding-right:13px;padding-bottom:13px;" id="metadata_manual">
                    <h3>Link to Configure the Plug in:
                        <a href="https://www.miniorange.com/step-by-step-guide-to-set-up-azure-ad-as-idp-for-wordpress" target='_blank'>Click Here to
                            see the Guide for Configuring the plugin</b></a></h3><h4>You will need the following
                            information to configure your IdP. Copy it and keep it handy:</h4>
                        <table border="1"
                               style="background-color:#FFFFFF; border:1px solid #CCCCCC; padding:0px 0px 0px 10px; margin:2px; border-collapse: collapse; width:98%">

                            <tr>
                                <td style="width:40%; padding: 15px;"><b>SP-EntityID / Issuer</b></td>

                                    <td style="width:60%; padding: 15px;font-weight: 400"><table width="100%"><tr><td><span id="entity_id"><?php echo $sp_entity_id; ?></span></td>
                                    <td><i class="fa fa-fw fa-lg fa-pull-right fa-copy mo_copy copytooltip" onclick="copyToClipboard(this, '#entity_id', '#entity_id_copy');"><span id="entity_id_copy" class="copytooltiptext">Copy to Clipboard</span></i></td></tr></table>
                                    </td>

                            </tr>


                            <tr>
                                <td style="width:40%; padding: 15px;"><b>ACS (AssertionConsumerService) URL</b></td>

                                    
                                 <td style="width:60%;  padding: 15px;font-weight: 400"><table width="100%"><tr><td><span id="base_url"><?php echo site_url(). '/' ?></span></td> 
                                    <td><i class="fa fa-fw fa-pull-right fa-lg fa-copy mo_copy copytooltip" onclick="copyToClipboard(this, '#base_url', '#base_url_copy');"><span id="base_url_copy" class="copytooltiptext">Copy to Clipboard</span></i></td></tr></table>
                                    </td>

                            </tr>


                            <tr>
                                <td style="width:40%; padding: 15px;"><b>Audience URI</b></td>

                                    <td style="width:60%; padding: 15px;font-weight: 400"><table width="100%"><tr><td><span id="audience"><?php echo $sp_entity_id; ?></span></td>
                                    <td><i class="fa fa-fw fa-pull-right fa-lg fa-copy mo_copy copytooltip" onclick="copyToClipboard(this, '#audience','#audience_copy');"><span id="audience_copy" class="copytooltiptext">Copy to Clipboard</span></i></td></tr></table>
                                    </td>

                            </tr>


                            <tr>
                                <td style="width:40%; padding: 15px;"><b>NameID format</b></td>

                                    <td style="width:60%; padding: 15px;font-weight: 400"><table width="100%"><tr><td><span id="nameid">
                                        urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress
                                    </span></td>
                                    <td><i class="fa fa-fw fa-pull-right fa-lg fa-copy mo_copy copytooltip" onclick="copyToClipboard(this, '#nameid', '#nameid_copy');"><span id="nameid_copy" class="copytooltiptext">Copy to Clipboard</span></i></td></tr></table>
                                    </td>

                            </tr>


                            <tr>
                                <td style="width:40%; padding: 15px;"><b>Recipient URL</b></td>

                                    <td style="width:60%;  padding: 15px;font-weight: 400"><table width="100%"><tr><td><span id="recipient"><?php echo site_url() . '/' ?></span></td>
                                    <td><i class="fa fa-fw fa-pull-right fa-lg fa-copy mo_copy copytooltip" onclick="copyToClipboard(this, '#recipient','#recipient_copy');"><span id="recipient_copy" class="copytooltiptext">Copy to Clipboard</span></i></td></tr></table>
                                    </td>

                            </tr>


                            <tr>
                                <td style="width:40%; padding: 15px;font-weight: 400"><b>Destination URL</b></td>

                                    <td style="width:60%;  padding: 15px;font-weight: 400"><table width="100%"><tr><td><span id="destination"><?php echo site_url() . '/' ?></span></td>
                                    <td><i class="fa fa-fw fa-pull-right fa-lg fa-copy mo_copy copytooltip" onclick="copyToClipboard(this, '#destination','#destination_copy');"><span id="destination_copy" class="copytooltiptext">Copy to Clipboard</span></i></td></tr></table>
                                    </td>

                            </tr>


                            <?php if ( ! get_option( 'mo_saml_free_version' ) ) { ?>
                                <tr>
                                    <td style="width:40%; padding: 15px;"><b>Default Relay State (Optional)</b></td>

                                        <td style="width:60%;  padding: 15px;font-weight: 400"><table width="100%"><tr><td><span id="relaystate"><?php echo site_url() . '/' ?></span></td>
                                        <td><i class="fa fa-fw fa-pull-right fa-lg fa-copy mo_copy copytooltip" onclick="copyToClipboard(this, '#relaystate', '#relaystate_copy');"><span id="relaystate_copy" class="copytooltiptext">Copy to Clipboard</span></i></td></tr></table>
                                        </td>

                                </tr>

                                    <tr>
                                        <td style="width:40%; padding: 15px;font-weight: 400"><b>Certificate (Optional)</b></td>
                                        <?php if ( ! mo_o365_saml_is_customer_registered_saml() ) { ?>
                                            <td style="width:60%;  padding: 15px;">Download <i>(Register to download the
                                                    certificate)</i></td>
                                        <?php } else { ?>
                                            <td style="width:60%;  padding: 15px;font-weight: 400"><a
                                                        href="<?php echo plugins_url( 'resources/sp-certificate.crt', __FILE__ ); ?>">Download</a>
                                            </td>
                                        <?php } ?>
                                    </tr>

                            <?php } else { ?>
                                <tr>
                                    <td style="width:40%; padding: 15px;"><b>Default Relay State (Optional)</b></td>
                                    <td style="width:60%;  padding: 15px;font-weight: 400">Available in the <a
                                                href="<?php echo admin_url( 'admin.php?page=mo_o365_saml_settings&tab=licensing' ); ?>"><b>standard,
                                                premium and enterprise</b></a> plans of the plugin.
                                    </td>
                                </tr>

                                    <tr>
                                        <td style="width:40%; padding: 15px;"><b>Certificate (Optional)</b></td>
                                        <td style="width:60%;  padding: 15px;font-weight: 400">Available in the <a
                                                    href="<?php echo admin_url( 'admin.php?page=mo_o365_saml_settings&tab=licensing' ); ?>"><b>standard,
                                                    premium and enterprise</b></a> plans of the plugin.
                                        </td>
                                    </tr>

                            <?php } ?>
                        </table>
                    </div>



            </td>
        </tr>

       



    </table>
    <script>
    function copyToClipboard(copyButton, element, copyelement) {
        var temp = jQuery("<input>");
        jQuery("body").append(temp);
        temp.val(jQuery(element).text()).select();
        document.execCommand("copy");
        temp.remove();
        jQuery(copyelement).text("Copied");

        jQuery(copyButton).mouseout(function(){
            jQuery(copyelement).text("Copy to Clipboard");
        });
    }
    </script>
    <form name="mo_saml_download_metadata" method="post" action="">
    <?php wp_nonce_field("mosaml_metadata_download");?>
            <input type="hidden" name="option" value="mosaml_metadata_download"/>

</form>
    <?php
}

function mo_o365_saml_apps_config_saml() {
    $sync_interval                   = get_option( 'saml_metadata_sync_interval' );
    $sync_url                        = get_option( 'saml_metadata_url_for_sync' );
    $sync_selected                   = ! empty( $sync_url ) ? 'checked' : '';
    $hidden                          = empty( $sync_url ) ? 'hidden' : '';
    $saml_identity_metadata_provider = '';
    if ( isset( $_GET['action'] ) && $_GET['action'] == 'upload_metadata' ) {
        echo '<div border="0" style="background-color:#FFFFFF; border:1px solid #CCCCCC; padding:0px 0px 0px 10px;">
        <table style="width:100%;">
            <tr>
                <td colspan="3">
                    <h3>Upload IDP Metadata
                        <span style="float:right;margin-right:25px;">
                            <a href="' . admin_url() . 'admin.php?page=mo_o365_saml_settings&tab=save' . '"><input type="button" class="button" value="Cancel"/></a>
                        </span>
                    </h3>
                </td>
            </tr>
            <tr><td colspan="4"><hr></td></tr>
            <tr>';

        echo '
            <form name="saml_form" method="post" action="' . admin_url() . 'admin.php?page=mo_o365_saml_settings&tab=save' . '" enctype="multipart/form-data">


        <tr>
                <td width="30%"><strong>Identity Provider Name<span style="color:red;">*</span>:</strong></td>
                <td><input type="text" name="saml_identity_metadata_provider" placeholder="Identity Provider name like Office 365,ADFS, SimpleSAML" style="width: 100%;" value="" required /></td>
                </tr>

                <tr>';

        echo '
                <input type="hidden" name="option" value="saml_upload_metadata" />';
                wp_nonce_field("saml_upload_metadata");
               echo' <input type="hidden" name="action" value="upload_metadata" />

                    <td>Upload Metadata  :</td>
                    <td colspan="2"><input type="file" name="metadata_file" />
                    <input type="submit" class="button button-primary button-large" value="Upload"/></td>
                    </tr>';
        echo '<tr>
                <td colspan="2"><p style="font-size:13pt;text-align:center;"><b>OR</b></p></td>
            </tr>';
        echo '

            <tr>
                <input type="hidden" name="option" value="saml_upload_metadata" />
                <input type="hidden" name="action" value="fetch_metadata" />
                <td width="20%">Enter metadata URL:</td>
                <td><input type="url" name="metadata_url" placeholder="Enter metadata URL of your IdP." style="width:100%" value="' . $sync_url . '"/></td>
                <td width="20%">&nbsp;&nbsp;<input type="submit" class="button button-primary button-large" value="Fetch Metadata"/></td>
            </tr>
            </form>';
        echo '</table><br /></div>';


    }
    else {
        global $wpdb;
        $entity_id = get_option( 'entity_id' );
        if ( ! $entity_id ) {
            $entity_id = 'https://login.xecurify.com/moas';
        }
        $sso_url = get_option( 'sso_url' );
        $cert_fp = get_option( 'cert_fp' );

        $saml_identity_name    = get_option( 'saml_identity_name' );
        $saml_login_url        = get_option( 'saml_login_url' );
        $saml_issuer           = get_option( 'saml_issuer' );
        $saml_x509_certificate = maybe_unserialize( get_option( 'saml_x509_certificate' ) );
        $saml_x509_certificate = ! is_array( $saml_x509_certificate ) ? array( 0 => $saml_x509_certificate ) : $saml_x509_certificate;
        $saml_response_signed  = get_option( 'saml_response_signed' );
        $saml_identity_provider_guide_name = get_option('saml_identity_provider_guide_name')?get_option('saml_identity_provider_guide_name'):Mo_o365_options_plugin_idp::$IDP_GUIDES['Office 365'];

        $saml_is_encoding_enabled = get_option('mo_saml_encoding_enabled')!==false?get_option('mo_saml_encoding_enabled'):'checked';
        if( $saml_identity_provider_guide_name && $saml_identity_provider_guide_name!='Other')
            $action = "https://www.miniorange.com/step-by-step-guide-to-set-up-".$saml_identity_provider_guide_name."-as-idp-for-wordpress";

        if ( $saml_response_signed == null ) {
            $saml_response_signed = 'checked';
        }
        $saml_assertion_signed = get_option( 'saml_assertion_signed' );
        if ( $saml_assertion_signed == null ) {
            $saml_assertion_signed = 'Yes';
        }

        $idp_config = get_option( 'mo_saml_idp_config_complete' );
        ?>

        <form width="98%" border="0" style="background-color:#FFFFFF; border:1px solid #CCCCCC; padding:0px 0px 0px 10px;" name="saml_form" method="post" action="">
        <?php
            if ( function_exists('wp_nonce_field') )
                wp_nonce_field('login_widget_saml_save_settings');
        ?>
        <input type="hidden" name="option" value="login_widget_saml_save_settings"/>
        <table style="width:100%;">
            <tr><td colspan="2">
                <h3> Configure Service Provider &nbsp; &nbsp;
                    <span style="position: relative;padding-bottom: 14px;padding-top:14px;background: white;border-radius: 10px; float:right;" id="upload-metadata">
                        <a href="<?php echo admin_url(); ?>admin.php?page=mo_o365_saml_settings&tab=save&action=upload_metadata" style="margin-left: 15px">
                            <input type="button" class="button button-primary button-large" value="Upload IDP Metadata"
                            <?php
                                if ( ! mo_o365_saml_is_customer_registered_saml() ) {
                                    echo "disabled";
                                }
                                ?>
                            />
                        </a>&nbsp; &nbsp;
                    </span>
                    <span id="configure-service-restart-tour" style="position: relative; float:right; padding-bottom: 14px;padding-top:14px;background: white;border-radius: 10px;">
                        <button type="button"  class="button button-primary button-large"  onclick="jQuery('#show_pointers').submit();"><i class="fa fa-refresh"></i>  Restart Tour</button>
                    </span>
                </h3>
            </td></tr>
            <tr><td colspan="4"><hr></td></tr>
            <?php if ( !mo_o365_saml_is_customer_registered_saml() ) { ?>
            <tr>
                <td colspan="2">
                    <div style="display:block;color:red;background-color:rgba(251, 232, 0, 0.15);padding:5px;border:solid 1px rgba(255, 0, 9, 0.36);">
                        Please <a href="<?php echo add_query_arg( array( 'tab' => 'login' ), htmlentities( $_SERVER['REQUEST_URI'] ) ); ?>">
                        Register or Login with miniOrange</a> to configure the miniOrange SAML Plugin.
                    </div>
                </td>
            </tr>
            <?php } ?>
            <tr>
                <td colspan="2">
                    Select your Identity Provider from the list below, and you can find the link to the guide for setting up SAML below.
                    Please contact us if you don't find your IDP in the list.
                    <br/><br/>
                </td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <tr>
                <td style="width:200px;"><strong>Select your Identity Provider :</strong></td>
                <td>
                    <div style="line-height: 5;background: white;position: relative;" id="select_your_idp">
                        <select onchange="getguidelink()" id="idpguide" name="saml_identity_provider_guide_name" style="width: 50%;" value="<?php echo $saml_identity_provider_guide_name;?>">
                        <?php
                            foreach(Mo_o365_options_plugin_idp::$IDP_GUIDES as $key=>$value) {
                                $selected="";
                                if($value===$saml_identity_provider_guide_name)
                                    $selected ="selected";
                                ?>
                                <option value="<?php echo $value;?>" <?php echo $selected;?>><?php echo $key;?></option>
                                <?php
                            }?>

                        </select>

                        <?php
                            if($saml_identity_provider_guide_name=='Azure B2C') {
                                $action = "https://plugins.miniorange.com/saml-single-sign-on-sso-wordpress-using-azure-b2c";
                             }
                            else {
                                $action = "https://plugins.miniorange.com/saml-single-sign-on-sso-wordpress-using-azure-ad";
                            }    ?>
                                <a style="margin-left: 2%" target="_blank" <?php if(!$saml_identity_provider_guide_name) echo "hidden"; ?> id="idplink" href="<?php echo $action;?>">Link to guide</a>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td style="width:200px;"><strong>Identity Provider Name <span style="color:red;">*</span>:</strong>
                    </td>
                    <td><input type="text" name="saml_identity_name"
                               placeholder="Identity Provider name like Office365, AzureAD, AzureB2C"
                               style="width: 95%;" value="<?php echo $saml_identity_name; ?>"
                               required <?php if ( ! mo_o365_saml_is_customer_registered_saml() )
                            echo 'disabled' ?> title="Only alphabets, numbers and underscore is allowed"/></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>


                <tr>
                    <td><strong>IdP Entity ID or Issuer <span style="color:red;">*</span>:</strong></td>
                    <td><input type="text" name="saml_issuer" placeholder="Identity Provider Entity ID or Issuer"
                               style="width: 95%;" value="<?php echo $saml_issuer; ?>"
                               required <?php if ( ! mo_o365_saml_is_customer_registered_saml() )
                            echo 'disabled' ?>/></td>
                </tr>

                <tr>
                    <td></td>
                    <td><b>Note</b> : You can find the <b>EntityID</b> in Your IdP-Metadata XML file enclosed in <code>EntityDescriptor</code>
                        tag having attribute as <code>entityID</code></td>

                </tr>

                <tr>
                    <td>&nbsp;</td>
                </tr>

                <tr>
                    <td><strong>SAML Login URL <span style="color:red;">*</span>:</strong></td>
                    <td><input type="url" name="saml_login_url"
                               placeholder="Single Sign On Service URL (HTTP-Redirect binding) of your IdP"
                               style="width: 95%;" value="<?php echo $saml_login_url; ?>"
                               required <?php if ( ! mo_o365_saml_is_customer_registered_saml() )
                            echo 'disabled' ?>/></td>
                </tr>

                <tr>
                    <td></td>

                    <td><b>Note</b> : You can find the <b>SAML Login URL</b> in Your IdP-Metadata XML file enclosed in
                        <code>SingleSignOnService</code> tag (Binding type: HTTP-Redirect)


                </tr>

                <tr>
                    <td>&nbsp;</td>
                </tr>
                <?php
                foreach ( $saml_x509_certificate as $key => $value ) {
                    echo '<tr>
                <td><strong>X.509 Certificate <span style="color:red;">*</span>:</strong></td>
                <td><textarea rows="6" cols="5" name="saml_x509_certificate[' . $key . ']" placeholder="Copy and Paste the content from the downloaded certificate or copy the content enclosed in X509Certificate tag (has parent tag KeyDescriptor use=signing) in IdP-Metadata XML file" style="width: 95%;"';
                    echo ' >' . $value . '</textarea></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td><b>NOTE:</b> Format of the certificate:<br/><b>-----BEGIN CERTIFICATE-----<br/>XXXXXXXXXXXXXXXXXXXXXXXXXXX<br/>-----END CERTIFICATE-----</b></i><br/>
                </tr>';
                }


                ?>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td><strong><label for="enable_iconv">Character encoding :</label></strong></td>
                    <td>
                    <label class="switch">
                        <input type="checkbox" name="enable_iconv" id="enable_iconv"  <?php echo $saml_is_encoding_enabled;?>/>
                        <span class="slider round"></span>
					</label>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td><b>NOTE: </b>Uses iconv encoding to convert X509 certificate into correct encoding. </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td><br/><input type="submit" name="submit" style="width:150px;margin-right: 3%;" value="Save"
                                    class="button button-primary button-large"<?php if ( ! mo_o365_saml_is_customer_registered_saml() )
                            echo 'disabled' ?>/>
                        <input type="button" id="test_config"
                               title= "<?php if(!mo_o365_saml_is_openssl_installed()){
                                echo 'Enable openssl extension to test your configuration.';
                               }
                                else{
                               echo 'You can only test your Configuration after saving your Service Provider Settings.'; }?>"
                            onclick="showTestWindow();" <?php if ( ! mo_o365_saml_is_sp_configured() || ! get_option( 'saml_x509_certificate' ) || !mo_o365_saml_is_openssl_installed() )
                            echo 'disabled' ?> value="Test configuration" class="button button-primary button-large"
                               style="margin-right: 3%;width: 150px;position: absolute"/>
                    </td>
                </tr>

                <tr>
                    <td></td>
                    <td><br /><input type="button" name="saml_request" id="export-import-config"
                               title="Export Plugin Configuration"
                        <?php if ( ! mo_o365_saml_is_sp_configured() || ! get_option( 'saml_x509_certificate' ) ) {
                            echo 'disabled';
                        } ?> value="Export Plugin Configuration" class="button button-primary button-large" style="width:320px;position: relative"
                        onclick="jQuery('#mo_export').submit();"/></td>
                </tr>
            </table>
            <br/>
        </form>
        <form method="get" target="_blank" action="" id="getIDPguides"></form>
        <form method="post" action="" name="mo_export" id="mo_export">
        <?php
           wp_nonce_field('mo_saml_export');?>
		<input type="hidden" name="option" value="mo_saml_export" /></form>

        <script>
            function showTestWindow() {
                var myWindow = window.open("<?php echo mo_o365_saml_get_test_url(); ?>", "TEST SAML IDP", "scrollbars=1 width=800, height=600");
            }

            function showSAMLRequest() {
                var myWindow = window.open("<?php echo mo_o365_saml_get_saml_request_url();?>", "VIEW SAML REQUEST", "scrollbars=1 width=800, height=600");
            }

            function showSAMLResponse() {
                var myWindow = window.open("<?php echo mo_o365_saml_get_saml_response_url();?>", "VIEW SAML RESPONSE", "scrollbars=1 width=800, height=600");
            }

            function getguidelink(){
                var dropdown = document.getElementById('idpguide');
                if(dropdown.value==='office-365' || dropdown.value==='azure-ad'){
                    var action='https://plugins.miniorange.com/saml-single-sign-on-sso-wordpress-using-azure-ad';
                }
                else{
                    var action = 'https://plugins.miniorange.com/saml-single-sign-on-sso-wordpress-using-azure-b2c';
                }

            }

            function redirect_to_attribute_mapping(){
				window.location.href= "<?php echo mo_o365_saml_get_attribute_mapping_url(); ?>";
			}
        </script>
        <?php
    }
}

function mo_o365_saml_save_optional_config() {
    global $wpdb;
    $entity_id = get_option( 'entity_id' );
    if ( ! $entity_id ) {
        $entity_id = 'https://login.xecurify.com/moas';
    }
    $sso_url = get_option( 'sso_url' );
    $cert_fp = get_option( 'cert_fp' );

    $saml_identity_name = get_option( 'saml_identity_name' );

    
    $saml_am_username = get_option( 'saml_am_username' );
    if ( $saml_am_username == null ) {
        $saml_am_username = 'NameID';
    }
    $saml_am_email = get_option( 'saml_am_email' );
    if ( $saml_am_email == null ) {
        $saml_am_email = 'NameID';
    }
    $saml_am_first_name = get_option( 'saml_am_first_name' );
    $saml_am_last_name  = get_option( 'saml_am_last_name' );
    $saml_am_group_name = get_option( 'saml_am_group_name' );
    ?>
    <form name="saml_form_am" method="post" action="">
        <input type="hidden" name="option" value="login_widget_saml_attribute_mapping"/>
        <?php wp_nonce_field("login_widget_saml_attribute_mapping");?>
        <table width="98%" border="0"
               style="background-color:#FFFFFF; border:1px solid #CCCCCC; padding:0px 0px 0px 10px;position: relative;" id="miniorange-attribute-mapping">
            <tr>
                <td colspan="2">
                    <h3>Attribute Mapping (Optional)
            <span style="float: right; padding-left:13px;padding-right:13px; border-radius:4px; background-color: white;position: relative" id="attribute-mapping-restart-tour" >
            <button type="button" class="button button-primary button-large"  onclick="jQuery('#show_pointers').submit();"><i class="fa fa-refresh"></i>  Restart Tour</button>
            </span>
</h3>
                </td>

            </tr>
            <?php if ( ! mo_o365_saml_is_customer_registered_saml() ) { ?>
                <tr>
                    <td colspan="2">
                        <div style="display:block;color:red;background-color:rgba(251, 232, 0, 0.15);padding:5px;border:solid 1px rgba(255, 0, 9, 0.36);">
                            Please <a
                                    href="<?php echo add_query_arg( array( 'tab' => 'login' ), htmlentities( $_SERVER['REQUEST_URI'] ) ); ?>">Register
                                or Login with miniOrange</a> to configure the miniOrange SAML Plugin.
                        </div>
                    </td>
                </tr>
            <?php } ?>
            <tr>
                <td colspan="2">[ <a href="https://docs.miniorange.com/documentation/saml-handbook/attribute-role-mapping" id="attribute_mapping" target="_blank    ">Click Here</a> to know how this is useful. ]

                </td>
            </tr>
            <tr>
                <td colspan="2"><br/><b>NOTE: </b>Use attribute name <code>NameID</code> if Identity is in the <i>NameIdentifier</i>
                    element of the subject statement in SAML Response.<br/><br/></td>
            </tr>

                <tr>
                    <td style="width:150px;"><span style="color:red;">*</span><strong>Username (required):</strong></td>
                    <td><b>NameID</b></td>
                </tr>
                <tr>
                    <td><span style="color:red;">*</span><strong>Email (required):</strong></td>
                    <td><b>NameID</b></td>
                </tr>

            <tr>
                <td><span style="color:red;">*</span><strong>First Name:</strong></td>
                <td><input type="text" disabled name="saml_am_first_name" placeholder="Enter attribute name for First Name"
                           style="width: 350px;background: #DCDAD1;"
                           value="<?php echo $saml_am_first_name; ?>" <?php if ( ! mo_o365_saml_is_customer_registered_saml() )
                        echo 'disabled' ?>/></td>
            </tr>
            <tr>
                <td><span style="color:red;">*</span><strong>Last Name:</strong></td>
                <td><input type="text" disabled name="saml_am_last_name" placeholder="Enter attribute name for Last Name"
                           style="width: 350px;background: #DCDAD1;"
                           value="<?php echo $saml_am_last_name; ?>" <?php if ( ! mo_o365_saml_is_customer_registered_saml() )
                        echo 'disabled' ?>/></td>
            </tr>

                <tr>
                    <td><span style="color:red;">*</span><strong>Group/Role:</strong></td>
                    <td><input type="text" disabled placeholder="Enter attribute name for Group/Role"
                               style="width: 350px;background: #DCDAD1;"/></td>
                </tr>
                <tr>
                    <td colspan="2">
                    <br/><span style="color:red;">*</span> These attributes are configurable in <a
                                href="<?php echo admin_url( 'admin.php?page=mo_o365_saml_settings&tab=licensing' ); ?>"><b>standard,
                                premium and enterprise</b></a> versions of the plugin.<br/>
                                <h3>Map Custom Attributes</h3>
                                Customized Attribute Mapping means you
                        can map any attribute of the IDP to the <b>usermeta</b> table of your database.<br/>
                    Customized Attribute Mapping is
                        configurable in the <a
                                href="<?php echo admin_url( 'admin.php?page=mo_o365_saml_settings&tab=licensing' ); ?>"><b>premium
                                and enterprise</b></a> versions of the plugin.<br/><br/>
                    </td>
                </tr>

        </table>
    </form>
    <br/>
    <form name="saml_form_am_role_mapping" method="post" action="">
        <?php
                wp_nonce_field('login_widget_saml_role_mapping');?>
        <input type="hidden" name="option" value="login_widget_saml_role_mapping"/>
        <table width="98%" border="0" id="miniorange-role-mapping"
               style="background-color:#FFFFFF; border:1px solid #CCCCCC; padding:0px 0px 0px 10px;position: relative">
            <tr>
                <td colspan="2">
                    <h3>Role Mapping (Optional)</h3>
                </td>
            </tr>
            <tr>
                <td colspan="2">[ <a href="https://docs.miniorange.com/documentation/saml-handbook/attribute-role-mapping/role-mapping" target="_blank">Click Here</a> to know how this is useful. ]

                </td>
            </tr>
            <tr>
                <td colspan="2"><br/><b>NOTE: </b>Role will be assigned only to new users. Existing Wordpress users'
                    role remains same.<br/><br/></td>
            </tr>
            <tr>
                <td colspan="2">
                <label class="switch">
                <input type="checkbox" disabled style="background: #DCDAD1;"/>
                <span class="slider round"></span>
					</label><span style="padding-left:5px"><b><span
                            style="color:red;">*</span>Do not auto create users if roles are not mapped here</b></span><br/></td>
            </tr>

                <tr>
                    <td colspan="2">
                    <label class="switch">
                    <input type="checkbox" style="background: #DCDAD1;" disabled/>
                    <span class="slider round"></span>
					</label><span style="padding-left:5px"><b><span
                                style="color:red;">*</span>Do not assign role to unlisted users</b></span><br/><br/></td>
                </tr>

            <tr>
                <td><strong>Default Role:</strong></td>
                <td>
                    <?php
                    $disabled = '';
                    if ( ! mo_o365_saml_is_customer_registered_saml() ) {
                        $disabled = 'disabled';
                    }
                    ?>
                    <select id="saml_am_default_user_role" name="saml_am_default_user_role" <?php echo $disabled ?>
                            style="width:150px;">
                        <?php
                        $default_role = get_option( 'saml_am_default_user_role' );
                        if ( empty( $default_role ) ) {
                            $default_role = get_option( 'default_role' );
                        }
                        echo wp_dropdown_roles( $default_role );
                        ?>
                    </select>
                    &nbsp;&nbsp;&nbsp;&nbsp;<i>Select the default role to assign to Users.</i>
                </td>
            </tr>
            <?php
            $is_disabled = "";
            if ( ! mo_o365_saml_is_customer_registered_saml() ) {
                $is_disabled = "disabled";
            }
            $wp_roles         = new WP_Roles();
            $roles            = $wp_roles->get_names();
            $roles_configured = get_option( 'saml_am_role_mapping' );
            foreach ( $roles as $role_value => $role_name ) {
                if ( ! get_option( 'mo_saml_free_version' ) ) {
                    echo '<tr><td><b>' . $role_name . '</b></td><td><input type="text" name="saml_am_group_attr_values_' . $role_value . '" value="' . $roles_configured[ $role_value ] . '" placeholder="Semi-colon(;) separated Group/Role value for ' . $role_name . '" style="width: 400px;"' . $is_disabled . ' /></td></tr>';
                } else {
                    echo '<tr><td><span style="color:red;">*</span><b>' . $role_name . '</b></td><td><input type="text" placeholder="Semi-colon(;) separated Group/Role value for ' . $role_name . '" style="width: 400px;background: #DCDAD1" disabled /></td></tr>';
                }
            }
            ?>
            <?php if ( get_option( 'mo_saml_free_version' ) ) { ?>
                <tr>
                    <td colspan="2"><br/><span style="color:red;">*</span>Customized Role Mapping options are
                        configurable in the <a
                                href="<?php echo admin_url( 'admin.php?page=mo_o365_saml_settings&tab=licensing' ); ?>"><b>premium
                                and enterprise</b></a> versions of the plugin. In the <a
                                href="<?php echo admin_url( 'admin.php?page=mo_o365_saml_settings&tab=licensing' ); ?>"><b>standard</b></a>
                        version, you can only assign the default role to the user.
                    </td>
                </tr>
            <?php } ?>
            <tr>
                <td>&nbsp;</td>
                <td><br/><input type="submit" style="width:100px;" name="submit" value="Save"
                                class="button button-primary button-large" <?php if ( ! mo_o365_saml_is_customer_registered_saml() )
                        echo 'disabled' ?>/> &nbsp;
                    <br/><br/>
                </td>
            </tr>
        </table>
    </form>
    <?php
}

function mo_o365_saml_get_test_url() {

        $url = site_url() . '/?option=testConfig';


    return $url;
}

function mo_o365_saml_is_customer_registered_saml($check_guest=true) {

    $email       = get_option( 'mo_saml_admin_email' );
    $customerKey = get_option( 'mo_saml_admin_customer_key' );

    if(mo_o365_saml_is_guest_enabled() && $check_guest)
        return 1;
    if ( ! $email || ! $customerKey || ! is_numeric( trim( $customerKey ) ) ) {
        return 0;
    } else {
        return 1;
    }
}

function mo_o365_saml_is_guest_enabled(){
    $guest_enabled = get_option('mo_saml_guest_enabled');

    return $guest_enabled;
}

function mo_o365_Multisite_enabled(){
    if( is_multisite()){
        return "<b><font color='green'> enabled </font></b>";
    }
    return "<b><font color='red'> disabled </font></b>";
}

function mo_o365_saml_is_sp_configured() {
    $saml_login_url = get_option( 'saml_login_url' );

    
    if ( empty( $saml_login_url ) ) {
        return 0;
    } else {
        return 1;
    }
}

function mo_o365_saml_download_logs($error_msg,$cause_msg) {

    echo '<div style="font-family:Calibri;padding:0 3%;">';
    echo '<hr class="header"/>';
    echo '          <p style="font-size: larger       ">Please try the solution given above.If the problem persists,download the plugin configuration by clicking on Export Plugin Configuration and mail us at <a href="mailto:info@xecurify.com">info@xecurify.com</a>.</p>
                    <p>We will get back to you soon!<p>
                    </div>
                    <div style="margin:3%;display:block;text-align:center;">
                    <div style="margin:3%;display:block;text-align:center;">
                    <form method="get" action="" name="mo_export" id="mo_export">';
                    wp_nonce_field('mo_saml_export');
				echo '<input type="hidden" name="option" value="export_configuration" />
				<input type="submit" class="miniorange-button" value="Export Plugin Configuration">
				<input class="miniorange-button" type="button" value="Close" onclick="self.close()"></form>
               ';
    echo '&nbsp;&nbsp;';

    $samlResponse = htmlspecialchars($_POST['SAMLResponse']);
    update_option('MO_SAML_RESPONSE',$samlResponse);
    $error_array  = array("Error"=>$error_msg,"Cause"=>$cause_msg);
    update_option('MO_SAML_TEST',$error_array);
    update_option('MO_SAML_TEST_STATUS',0);
    ?>
    <style>
    .miniorange-button {
    padding:1%;
    background: #0091CD none repeat scroll 0% 0%;
    cursor: pointer;font-size:15px;
    border-width: 1px;border-style: solid;
    border-radius: 3px;white-space: nowrap;
    box-sizing: border-box;border-color: #0073AA;
    box-shadow: 0px 1px 0px rgba(120, 200, 230, 0.6) inset;color: #FFF;
    margin: 22px;
    }
</style>
    <?php

    exit();


}

function mo_o365_document_xml( $saml ) {
    $doc = new DOMDocument();
    $doc->preserveWhiteSpace = false;
    $doc->formatOutput = true;
    $doc->loadXML($saml);
    $out   = $doc->saveXML();
    $xml   = simplexml_load_string( $out );
    $json  = json_encode( $xml );
    $array = json_decode( $json );

    return $array;

}

function mo_o365_support_saml() {
    ?>
        <div class="mo_saml_support_layout" id="mo_saml_support_layout" style="position: relative;">
        <div>
            <h3>Feature Request/Contact Us</h3>
            <p>Need any help? We can help you with configuring your Identity Provider. Just send us a query and we will
                get back to you soon.<br /><br />
                <i>If you have any query related to the Licensing Plans or add-ons, please let us know, we will assist you in choosing the right plan as per your requirement.</i></p>
            <form method="post" action="">
            <?php wp_nonce_field("mo_saml_contact_us_query_option");?>
                <input type="hidden" name="option" value="mo_saml_contact_us_query_option"/>
                <table class="mo_saml_settings_table">
                    <tr>
                        <td><input style="width:95%" type="email" class="mo_saml_table_textbox" required
                                   name="mo_saml_contact_us_email"
                                   value="<?php echo get_option( "mo_saml_admin_email" ); ?>"
                                   placeholder="Enter your email"></td>
                    </tr>
                    <tr>
                        <td><input type="tel" style="width:95%" id="contact_us_phone"
                                   pattern="[\+]?[0-9]{1,4}[\s]?[0-9]{4,12}" class="mo_saml_table_textbox"
                                   name="mo_saml_contact_us_phone"
                                   value="<?php echo get_option( 'mo_saml_admin_phone' ); ?>"
                                   placeholder="Enter your phone"></td>
                    </tr>
                    <tr>
                        <td><textarea class="mo_saml_table_textbox" style="width:95%"
                                      onkeypress="mo_o365_saml_valid_query(this)" onkeyup="mo_o365_saml_valid_query(this)"
                                      onblur="mo_o365_saml_valid_query(this)" required name="mo_saml_contact_us_query"
                                      rows="4" style="resize: vertical;" placeholder="Write your query here"></textarea>
                        </td>
                    </tr>
                    <tr>
                    <td>
                    <label class="switch">
                    <input type="checkbox" name="send_plugin_config" id="send_plugin_config" <?php checked(get_option('send_plugin_config'),false,true);?> />
                    <span class="slider round"></span>
					</label><span style="padding-left:5px"><b>
                    <label for="send_plugin_config">Send plugin configuration with the query</label></b></span>
</td>
</tr>
                </table>
                <div style="text-align:center;">
                    <input type="submit" name="submit" style="margin:15px; width:120px;"
                           class="button button-primary button-large"/>
                </div>
            </form>
        </div>

    </div>
    <br />

    <?php mo_o365_keep_configuration_saml(); ?>

    <script>
        jQuery("#contact_us_phone").intlTelInput();
        jQuery("#phone_contact").intlTelInput();

        function mo_o365_saml_valid_query(f) {
            !(/^[a-zA-Z?,.\(\)\/@ 0-9]*$/).test(f.value) ? f.value = f.value.replace(
                /[^a-zA-Z?,.\(\)\/@ 0-9]/, '') : null;
        }


    </script>
<?php }

function mo_o365_saml_display_attrs_list(){
    $idp_attrs = get_option('mo_saml_test_config_attrs');
    $idp_attrs = maybe_unserialize($idp_attrs);
    if(!empty($idp_attrs)){ ?>
        <div class="mo_saml_support_layout" style="padding-bottom:20px; padding-right:5px;">
        <h3>Attributes sent by the Identity Provider:</h3>
                <div>
                    <table style="border-collapse:collapse;border-spacing:0;table-layout: fixed; width: 96%;background-color:#ffffff;">
                    <tr style="text-align:center;"><td style="font-weight:bold;border:0px solid #949090;padding:2%; width:65%;background-color:#0085ba;color:white;">ATTRIBUTE NAME</td><td style="font-weight:bold;padding:2%;border-left:1px solid #ffffff; border-right:1px solid #0085ba; word-wrap:break-word; width:35%;background-color:#0085ba;color:white;">ATTRIBUTE VALUE</td></tr>

                            <?php foreach($idp_attrs as $attr_name => $values){ ?>
                                <tr style="text-align:center;"><td style="font-weight:bold;border:1px solid #949090;padding:2%; word-wrap:break-word;"> <?php echo $attr_name; ?></td>
                                <td style="padding:2%;border:1px solid #949090; word-wrap:break-word;"> <?php echo implode("<hr/>",$values); ?> </td>
                                </tr>
                            <?php } ?>
                        
                        </table>
                        <br/>
                        <p style="text-align:center;"><input type="button" class="button-primary" value="Clear Attributes List" onclick="document.forms['attrs_list_form'].submit();"></p>
                        <div style="padding-right:8px;">
                        <p><b>NOTE :</b> Please clear this list after configuring the plugin to hide your confidential attributes.<br/>
                        Click on <b>Test configuration</b> in <b>Service Provider Setup</b> tab to populate the list again.</p>
                        </div>
                        <form method="post" action="" id="attrs_list_form">
                        <?php wp_nonce_field('clear_attrs_list'); ?>
                        <input type="hidden" name="option" value="clear_attrs_list">
                        </form>
                        </div>
        </div>
        <?php
    }
}

function mo_o365_demo_request_saml(){?>
    <div style="background-color: #FFFFFF; border: 1px solid #CCCCCC; padding: 10px 10px 10px 10px;">
    <h3>Request for Demo</h3><hr>
    Want to try out the paid features before purchasing the license? Just let us know which plan you're interested in and we will setup a demo for you.
    <br/><br/>
    <div class="mo_demo_layout" style="padding-bottom:20px; padding-right:5px;">
    
    <form method="post" action="">
    <?php wp_nonce_field("mo_saml_demo_request_option");?>
        <input type="hidden" name="option" value="mo_saml_demo_request_option"/>
        <table cellpadding="4" cellspacing="4">
        <tr>
        <td><strong>Email :</strong></td>
        <td><input type="text" name="mo_saml_demo_email" placeholder="We will use this email to setup the demo for you" required style="width:350px" value="<?php echo !empty(get_option('mo_saml_admin_email')) ? get_option('mo_saml_admin_email') : ''; ?>"></td>
        </tr>

        <?php
        $license_plans = array(
            'standard'                  => 'WP SAML SSO Standard Plan',
            'premium'                   => 'WP SAML SSO Premium Plan',
            'premium-multisite'         => 'WP SAML SSO Premium Multisite Plan',
            'enterprise'                => 'WP SAML SSO Enterprise Plan',
            'enterprise-multisite'      => 'WP SAML SSO Enterprise Multisite Plan',
            'enterprise-multiple-idp'   => 'WP SAML SSO Enterprise Multiple-IDP Plan',
            'help'                      => 'Not Sure'
        );
        ?>
        <tr>
        <td><strong>Request a demo for :</strong></td>
        <td><select name="mo_saml_demo_plan" id="mo_saml_demo_plan" style="width:350px" required onchange="mo_o365_saml_show_description();">
        <option hidden disabled selected value="">--Select a license plan--</option>
        <?php
        foreach($license_plans as $key => $value){
            ?>
            <option value="<?php echo $key;?>"><?php echo $value;?>
            <?php
        }
        ?>
        </select></td>
        </tr>
        <tr id="demo_description" style="display:none">
        <td><strong>Description</strong></td>
        <td><textarea type="text" name="mo_saml_demo_description" style="resize: vertical; width:350px; height:100px;" rows="4" placeholder="Need assistance? Write us about your requirement and we will suggest the best plan for you."></textarea></td>
        </tr>
        <tr id="add-on-list" style="display:none">
        <?php 
        $addons = array(
            'page-restriction'          => 'Page Restriction',
            'buddypress-integration'    => 'BuddyPress Integration',
            'learndash-integration'     => 'LearnDash Integration',
            'sso-login-audit'           => 'SSO Login Audit',
            'attribute-based-redirect'  => 'Attribute Based Redirect'
        );
        ?>
        <td colspan="2">
        <p><strong>Select the Add-ons you are interested in (Optional)</strong></p>
        <div style="padding-left:20px;">
        <?php
        foreach($addons as $key => $value){?>
            <input type="checkbox" name="<?php echo $key; ?>" value="true"> <?php echo $value ?><br/>
            <?php
        }
        ?>
        </div></td>
        </tr>
        <tr><td><br/></td></tr>
        <tr style="text-align:center;"><td colspan="2" ><input type="submit" value="Send Request" class="button button-primary button-large"/></td></tr>
        </table>
    </form>
    </div>
    </div>
    <script type="text/javascript">
        function mo_o365_saml_show_description() {
            var element = document.getElementById("mo_saml_demo_plan").selectedIndex;
            var allOptions = document.getElementById("mo_saml_demo_plan").options;
            if (allOptions[element].index == 7){
                document.getElementById("demo_description").style.display = "";
            } else {
                document.getElementById("demo_description").style.display = "none";
            }
            if (allOptions[element].index == 4 || allOptions[element].index == 5 || allOptions[element].index == 6){
                document.getElementById("add-on-list").style.display = "";
            } else {
                document.getElementById("add-on-list").style.display = "none";
            }
        }
    </script>
<?php
}

function mo_o365_saml_show_pricing_page() {?>
    <div class="mo_saml_table_layout">
        <h2>Licensing Plans
            <span style="float:right;margin-right:15px;"><input type="button" name="ok_btn"
                                                                class="button button-primary button-large"
                                                                value="OK, Got It"
                                                                onclick="window.location.href='admin.php?page=mo_o365_saml_settings'"/></span>
        </h2>
        <hr>

        <h3>
            What is a MultiSite?
        </h3>
        <p>WordPress Multisite is a feature which allows users to create a “Network” of subsites within a single install of WordPress. This allows you to use subdomains (or subdirectories) of the same root domain (site1.domain.com as a subsite of domain.com for example), within the same Network.
            <b style="font-size: 16px">Currently you have Multisite <?php echo mo_o365_Multisite_enabled()?> on this instance.</b><p>

        <h3>
            What is Multiple IDP?
        </h3>
        <p>
            miniOrange SAML plugin provides support for more than one Identity Providers simultaneously.Choose Enterprise version if you have multiple Identity Providers.
        </p>
        <table class="table mo_table-bordered mo_table-striped">

            <thead>
            <tr style="background-color:#0085ba;">
                <th width="25%"><br><br><br><br>
                    <h3>Features \ Plans</h3></th>
                <th class="text-center" width="25%"><h3>Standard <br><br><br></h3><p class="mo_plan-desc"></p><h3><b class="tooltip">$249 *<span class="tooltiptext">Cost applicable for one instance only.</span></b><br><br><br><span>
                <input type="hidden" value="<?php echo mo_o365_saml_is_customer_registered_saml(false);?>" id="mo_customer_registered">
                <input type="button" name="upgrade_btn" class="button button-default button-large" value="Upgrade Now for Single Site Environment"
                       onclick="upgradeform('wp_saml_sso_standard_plan')"/>
                </span></h3></th>
                <th class="text-center" width="25%"><h3>Premium <br><br><br></h3><p class="mo_plan-desc"></p><h3><b class="tooltip">$449 *<span class="tooltiptext">Cost applicable for one instance only.</span></b><br><br><br><span>

                <input type="button" name="upgrade_btn" class="button button-default button-large" value="Upgrade Now for Single Site Environment"
                       onclick="upgradeform('wp_saml_sso_basic_plan')"/><br /><br />
                <input type="button" name="upgrade_btn" class="button button-default button-large" value="Upgrade Now for Multsite Network Environment"
                       onclick="upgradeform('wp_saml_sso_multisite_basic_plan')" title="Use it if you have subdomain or sub-directory of WordPress site."/>


                </span></h3></th>

                <th class="text-center" width="25%"><h3>Enterprise <br></h3><p>(Multiple IDP and MultiNetwork Support)</p><p class="mo_plan-desc"></p><h3><b class="tooltip">$499 *<span class="tooltiptext">Cost applicable for one instance only.</span></b><br><br><br><span>
                <input type="button" name="upgrade_btn" class="button button-default button-large" value="Upgrade Now for Single Site Environment"
                       onclick="upgradeform('wp_saml_sso_enterprise_plan')"/><br /><br />
                <input type="button" name="upgrade_btn" class="button button-default button-large" value="Upgrade Now for Multisite Network Environment"
                       onclick="upgradeform('wp_saml_sso_multisite_enterprise_plan')"/ title="Use it if you have subdomain or sub-directory of WordPress site."><br /><br />
                <input type="button" name="upgrade_btn" class="button button-default button-large" value="Upgrade Now for Single Site Environment And Multiple IdP"
                       onclick="upgradeform('wp_saml_sso_multiple_idp_plan')" title="Use it if you want the users of more than 1 IDP to login into single WordPress site."/>

                </span></h3></th>

            </tr>
            </thead>
            <tbody class="mo_align-center mo-fa-icon">
            <tr>
                <td>Unlimited Authentications</td>
                <td><i class="fa fa-check"></i></td>
                <td><i class="fa fa-check"></i></td>
                <td><i class="fa fa-check"></i></td>
            </tr>
            <tr>
                <td>Basic Attribute Mapping (Username, Email, First Name, Last Name,Display Name)</td>
                <td><i class="fa fa-check"></i></td>
                <td><i class="fa fa-check"></i></td>
                <td><i class="fa fa-check"></i></td>
            </tr>
            <tr>
                <td>Widget,Shortcode to add IDP Login Link on your site</td>
                <td><i class="fa fa-check"></i></td>
                <td><i class="fa fa-check"></i></td>
                <td><i class="fa fa-check"></i></td>
            </tr>
            <tr>
                <td>Step-by-step guide to setup IDP</td>
                <td><i class="fa fa-check"></i></td>
                <td><i class="fa fa-check"></i></td>
                <td><i class="fa fa-check"></i></td>
            </tr>
            <tr>
                <td>Auto-Redirect to IDP from login page</td>
                <td><i class="fa fa-check"></i></td>
                <td><i class="fa fa-check"></i></td>
                <td><i class="fa fa-check"></i></td>
            </tr>
            <tr>
                <td>Protect your complete site (Auto-Redirect to IDP from any page)</td>
                <td><i class="fa fa-check"></i></td>
                <td><i class="fa fa-check"></i></td>
                <td><i class="fa fa-check"></i></td>
            </tr>
            <tr>
                <td>Change SP base Url and SP Entity ID</td>
                <td><i class="fa fa-check"></i></td>
                <td><i class="fa fa-check"></i></td>
                <td><i class="fa fa-check"></i></td>
            </tr>
            <tr>
                <td>Options to select SAML Request binding type</td>
                <td><i class="fa fa-check"></i></td>
                <td><i class="fa fa-check"></i></td>
                <td><i class="fa fa-check"></i></td>
            </tr>
            <tr>
                <td>SAML Single Logout</td>
                <td><i class="fa fa-check"></i></td>
                <td><i class="fa fa-check"></i></td>
                <td><i class="fa fa-check"></i></td>
            </tr>
            <tr>
                <td>Integrated Windows Authentication (supported with AD FS)</td>
                <td><i class="fa fa-check"></i></td>
                <td><i class="fa fa-check"></i></td>
                <td><i class="fa fa-check"></i></td>
            </tr>
            <tr>
                <td>Customized Role Mapping</td>
                <td></td>
                <td><i class="fa fa-check"></i></td>
                <td><i class="fa fa-check"></i></td>
            </tr>
            <tr>
                <td>Auto-sync IdP Configuration from metadata</td>
                <td></td>
                <td><i class="fa fa-check"></i></td>
                <td><i class="fa fa-check"></i></td>
            </tr>
            <tr>
                <td>Custom Attribute Mapping (Any attribute which is stored in user-meta table)</td>
                <td></td>
                <td><i class="fa fa-check"></i></td>
                <td><i class="fa fa-check"></i></td>
            </tr>
            <tr>
                <td>Store Multiple IdP Certificates</td>
                <td></td>
                <td><i class="fa fa-check"></i></td>
                <td><i class="fa fa-check"></i></td>
            </tr>
            <tr>
                <td>Custom SP Certificate</td>
                <td></td>
                <td><i class="fa fa-check"></i></td>
                <td><i class="fa fa-check"></i></td>
            </tr>
            <tr>
                <td>Multi-Site Support **</td>
                <td></td>
                <td><i class="fa fa-check"></i></td>
                <td><i class="fa fa-check"></i></td>
            </tr>
            <tr>
                <td>Sub-site specific SSO for Multisite</td>
                <td></td>
                <td><i class="fa fa-check"></i></td>
                <td><i class="fa fa-check"></i></td>
            </tr>
            <tr>
                <td>Multiple IDP's Supported ***</td>
                <td></td>
                <td></td>
                <td><i class="fa fa-check"></i></td>
            </tr>
            <tr>
                <td>Multi-Network SSO Support ***</td>
                <td></td>
                <td></td>
                <td><i class="fa fa-check"></i></td>
            </tr>
            <tr>
                <td><b>Add-Ons</b></td>
                <td>Purchase Separately</td>
                <td>Purchase Separately</td>
                <td>Included</td>
            </tr>
            <tr>
                <td>Buddypress Attribute Mapping Add-On</td>
                <td><a target="_blank" href="https://www.miniorange.com/contact">Contact Us</a></td>
                <td><a target="_blank" href="https://www.miniorange.com/contact">Contact Us</a></td>
                <td><i class="fa fa-check"></i></td>
            </tr>
            <tr>
                <td>Page Restriction Add-On</td>
                <td><a target="_blank" href="https://www.miniorange.com/contact">Contact Us</a></td>
                <td><a target="_blank" href="https://www.miniorange.com/contact">Contact Us</a></td>
                <td><i class="fa fa-check"></i></td>

        </table>


        <form style="display:none;" id="loginform"
              action="<?php echo Mo_o365_options_plugin_constants::HOSTNAME . '/moas/login'; ?>"
              target="_blank" method="post">
              <?php wp_nonce_field("mo_loginform");?>
            <input type="email" name="username" value="<?php echo get_option( 'mo_saml_admin_email' ); ?>"/>
            <input type="text" name="redirectUrl"
                   value="<?php echo Mo_o365_options_plugin_constants::HOSTNAME . '/moas/initializepayment'; ?>"/>
            <input type="text" name="requestOrigin" id="requestOrigin"/>
        </form>



        <script>
            var container  = document.getElementById('container');
            function upgradeform(planType) {
                jQuery('#requestOrigin').val(planType);
                if(jQuery('#mo_customer_registered').val()==1)
                    jQuery('#loginform').submit();
                else{

                   jQuery('#container').css('filter','blur(2px)');
                    jQuery('#overlay').show();
                    jQuery('#request_registeration').show();
                    jQuery('#requestOriginstate').val(planType);
                }

            }
            jQuery('#register_submit').click(function () {
                jQuery('#loginform').submit();
            })

            jQuery('#mo_close').click(function () {
                jQuery('#request_registeration').hide();
            });

        </script>
        <br>
        <h3>Steps to Upgrade to Premium Plugin -</h3>
        <p>1. You will be redirected to miniOrange Login Console. Enter your password with which you created an account
            with us. After that you will be redirected to payment page.</p>
        <p>2. Enter you card details and complete the payment. On successful payment completion, you will see the link
            to download the premium plugin.</p>
        <p>3. When you download the premium plugin, just unzip it and replace the folder with existing plugin. Do not
            delete and upload again from wordpress admin panel as your already saved settings will get lost.<br><br>
            <b>Note: If you are downloading the Multi-Site Plugin, then first delete existing plugin and then re-install
                the Multi-Site plugin.</b></p>
        <p>4. From this point on, do not update the premium plugin from the Wordpress store.</p>

        <h3>* Cost applicable for one instance only. Licenses are subscriptional and the purchase price includes 12 months of maintenance (support and version updates). You can renew maintenance after 12 months at 50% of the current purchase price.</h3>
        <p>You can Upgrade the number of instances by clicking on Upgrade now.</p>
        <h3>** Multi-Site Support - </h3>
        <p>This feature has a separate premium plugin and licensing is also based on number of subsites. Please select the Multisite option on the payment page while upgrading.</p>

        <h3>*** Multiple IDP\'s Supported - </h3>
        <p>This feature has a separate premium plugin and licensing is also based on number of IDPs. Contact us at <b>info@xecurify.com</b> to get quote for these.</p>

        <h3>*** Multi-Network Supported - </h3>
        <p>This feature has a separate premium plugin and licensing is also based on number of networks and subsites. Contact us at <b>info@xecurify.com</b> to get quote for these.</p>

        
        <h3>10 Days Return Policy -</h3>
        At miniOrange, we want to ensure you are 100% happy with your purchase. If the premium plugin you purchased is
        not working as advertised and you've attempted to resolve any issues with our support team, which couldn't get
        resolved. We will refund the whole amount within 10 days of the purchase. Please email us at info@xecurify.com
        for any queries regarding the return policy.

        Please email us at <b>info@xecurify.com</b> for any queries regarding the return policy.
        <h2>Licensing Plans (Cloud Service)</h2>
        <hr>
        <p>If you want to use miniOrange Cloud Single Sign on service. <a style="cursor:pointer;"
                                                                          id="help_working_title1">Click Here</a> to
            know how the plugin works for this case. Contact us at <b>info@xecurify.com</b> to get its licensing plans
            info.</p>
        <br>

        <div hidden id="help_working_desc1" class="mo_saml_help_desc">
            <h3>Using miniOrange Single Sign On service:</h3>
            <div style="display:block;text-align:center;">
                <img src="<?php echo plugin_dir_url( __FILE__ ) . 'images/saml_working.png' ?>"
                     alt="Working of miniOrange SAML plugin" style="width: 85%;"/>
            </div>
            <ol>
                <li>miniOrange SAML SSO plugin sends a login request to miniOrange SSO Service.</li>
                <li>miniOrange SSO Service creates a SAML Request and redirects the user to your Identity Provider for
                    authentication.
                </li>
                <li>Upon successful authentication, your Identity Provider sends a SAML Response back to miniOrange SSO
                    Service.
                </li>
                <li>miniOrange SSO Service verifies the SAML Response and sends a response status (along with the logged
                    in user's information) back to miniOrange SAML SSO plugin. Plugin then reads the response and logins
                    the user.
                </li>
            </ol>
            <div>
                <b>Advantages:</b>
                <ol>
                    <li>If you are an enterprise or business user then on using this service you will be able to take
                        full advantage of all of miniOrange SSO features. ( For a complete list of these features <a
                                href="http://miniorange.com/single-sign-on-sso" target="_blank">Click Here</a>)
                    </li>
                    <li>You can use Non-SAML Identity Providers for Single Sign On.</li>
                    <li>If you have multiple websites then you can use the same IdP configuration for all of them. You
                        don't have to make seperate configurations in your IdP.
                    </li>
                    <li>Some Identity Providers like ADFS do not support HTTP endpoints ( i.e. your wordpress site needs
                        to be on HTTPS ). So, if your wordpress site is not on HTTPS then you can use this service for
                        such IdPs.
                    </li>
                </ol>
            </div>
        </div>
        If you have any doubts regarding the licensing plans, you can mail us at <a
                href="mailto:info@xecurify.com"><i>info@xecurify.com</i></a> or submit a query using the <b>support
            form</b> on right.
        <br>

        <br>

    </div>
<?php }

function mo_o365_saml_get_saml_request_url() {


        $url = home_url() . '/?option=getsamlrequest';


    return $url;
}

function mo_o365_saml_get_saml_response_url() {

        $url = home_url() . '/?option=getsamlresponse';


    return $url;
}

function mo_o365_saml_add_query_arg($query_arg, $url){
    if(strpos($url, 'mo_saml_licensing') !== false){
        $url = str_replace('mo_saml_licensing', 'mo_o365_saml_settings', $url);
    }
    $url = add_query_arg($query_arg, $url);
    return $url;
}

function mo_o365_generate_metadata($download=false) {

    $sp_base_url = get_option( 'mo_saml_sp_base_url' );
    if ( empty( $sp_base_url ) ) {
        $sp_base_url = site_url();
    }
    if ( substr( $sp_base_url, - 1 ) == '/' ) {
        $sp_base_url = substr( $sp_base_url, 0, - 1 );
    }
    $sp_entity_id = get_option( 'mo_saml_sp_entity_id' );
    if ( empty( $sp_entity_id ) ) {
        $sp_entity_id = $sp_base_url . '/wp-content/plugins/miniorange-saml-20-single-sign-on/';
    }

    $entity_id   = $sp_entity_id;
    $acs_url     = $sp_base_url . '/';
    $certificate = file_get_contents( plugin_dir_path( __FILE__ ) . 'resources' . DIRECTORY_SEPARATOR . 'sp-certificate.crt' );
    $certificate = Mo_o365_Utilities::desanitize_certificate( $certificate );
    if(ob_get_contents())
        ob_clean();
    header( 'Content-Type: text/xml' );
    if($download)
            header('Content-Disposition: attachment; filename="Metadata.xml"');
    echo '<?xml version="1.0"?>
<md:EntityDescriptor xmlns:md="urn:oasis:names:tc:SAML:2.0:metadata" validUntil="2020-10-28T23:59:59Z" cacheDuration="PT1446808792S" entityID="' . $entity_id . '">
  <md:SPSSODescriptor AuthnRequestsSigned="false" WantAssertionsSigned="true" protocolSupportEnumeration="urn:oasis:names:tc:SAML:2.0:protocol">
    <md:NameIDFormat>urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress</md:NameIDFormat>
    <md:AssertionConsumerService Binding="urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST" Location="' . $acs_url . '" index="1"/>
  </md:SPSSODescriptor>
  <md:Organization>
    <md:OrganizationName xml:lang="en-US">miniOrange</md:OrganizationName>
    <md:OrganizationDisplayName xml:lang="en-US">miniOrange</md:OrganizationDisplayName>
    <md:OrganizationURL xml:lang="en-US">http://miniorange.com</md:OrganizationURL>
  </md:Organization>
  <md:ContactPerson contactType="technical">
    <md:GivenName>miniOrange</md:GivenName>
    <md:EmailAddress>info@xecurify.com</md:EmailAddress>
  </md:ContactPerson>
  <md:ContactPerson contactType="support">
    <md:GivenName>miniOrange</md:GivenName>
    <md:EmailAddress>info@xecurify.com</md:EmailAddress>
  </md:ContactPerson>
</md:EntityDescriptor>';
    exit;

}
function mo_azure_saml_display_sale_banner(){
       ?>
<div class="container-fluid sale-bg-banner" id="mo_saml_sale_banner" style="display:none">
    <div class="">
        <div class="banner-sale">
            <h1 class="h1 head-title blink" style="font-size: 50px;">END OF YEAR SALE

            </h1>
            <h2 class="hr-line"><span class="text-white"> LIMITED PERIOD OFFER</span></h2>
            <h3 class="sub-banner">Upto <b style="color: red;">95% Discount</b> on WordPress SAML SSO Plugins</h3>


        </div>
        <div class="banner-contact"
            style="display:flex; justify-content:center; align-items:center;flex-direction:column;">
            <p class="table-text">DISCOUNTS STARTING FROM <b class="instance-text">1<sup>st</sup> INSTANCE</b></p>
            <div class="sale-btn" style="display:flex;flex-direction:row">
                <a href="https://plugins.miniorange.com/wordpress-sso-end-of-year-sale" class="btn banner-btn-sale" target="_blank">View Sale Prices</a>
                <a target="_blank" href="https://mail.google.com/mail/u/0/?fs=1&amp;tf=cm&amp;source=mailto&amp;su=End+of+Year+Sale+-+WP+SAML+SSO+Plugin+.&amp;to=samlsupport@xecurify.com&amp;body=I+want+to+enquire+about+End+of+Year+Sale+-+WP+SAML+SSO+plugin+.+" class="btn banner-btn-sale">Contact Us</a>
            </div>
        </div>
    </div>
</div>
    
    <?php

}


?>