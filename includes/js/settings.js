jQuery(document).ready(function () {	
	
    jQuery("#toggle_am_content").click(function () {
        jQuery("#show_am_content").toggle();
    });
	jQuery("#dont_allow_unlisted_user_role").change(function() {
		if(jQuery(this).is(":checked")) {
			jQuery("#saml_am_default_user_role").attr('disabled', true);
		} else {
			jQuery("#saml_am_default_user_role").attr('disabled', false);
		}
	});
    if(jQuery("#dont_allow_unlisted_user_role").is(":checked")) {
			jQuery("#saml_am_default_user_role").attr('disabled', true);
		} else if(!jQuery("#dont_allow_unlisted_user_role").is(":disabled")){
			jQuery("#saml_am_default_user_role").attr('disabled', false);
		}
	
	jQuery("#help_curl_enable_title").click(function () {
        jQuery("#help_curl_enable_desc").slideToggle(400);
    });
	
	
	jQuery("#help_openssl_enable_title").click(function () {
        jQuery("#help_openssl_enable_desc").slideToggle(400);
    });
	
	
	jQuery("#attribute_mapping").click(function () {
        jQuery("#attribute_mapping_desc").slideToggle(400);
    });
	
	
	jQuery("#role_mapping").click(function (e) {
		e.preventDefault();
        jQuery("#role_mapping_desc").slideToggle(400);
    });
	
	
	jQuery("#idp_details_link").click(function (e) {
		e.preventDefault();
        jQuery("#idp_details_desc").slideToggle(400);
    });
	
	
	jQuery("#mo_saml_add_widget").change(function () {
        jQuery("#mo_saml_add_widget_steps").slideToggle(400);
    });
	
	
	jQuery("#mo_saml_add_shortcode").change(function () {
        jQuery("#mo_saml_add_shortcode_steps").slideToggle(400);
    });
	
	
	jQuery("#help_register_link").click(function (e) {
		e.preventDefault();
        jQuery("#help_register_desc").slideToggle(400);
    });
	
	
	
	jQuery("#help_widget_steps_title").click(function () {
        jQuery("#help_widget_steps_desc").slideToggle(400);
    });
	
	
	jQuery("#redirect_to_idp").click(function (e) {
		e.preventDefault;
        jQuery("#redirect_to_idp_desc").slideToggle(400);
    });
	
	
	jQuery("#registered_only_access").click(function (e) {
		e.preventDefault;
        jQuery("#registered_only_access_desc").slideToggle(400);
    });
	
	
	jQuery("#force_authentication_with_idp").click(function (e) {
		e.preventDefault;
        jQuery("#force_authentication_with_idp_desc").slideToggle(400);
    });
	 
	 
	 jQuery("#help_steps_title").click(function () {
        jQuery("#help_steps_desc").slideToggle(400);
    });
	
	
	 jQuery("#help_working_title1").click(function () {
		 jQuery("#help_working_desc2").hide();
		 jQuery("#help_working_desc3").hide();
        jQuery("#help_working_desc1").slideToggle(400);
    });
	 
	 jQuery("#help_working_title2").click(function () {
		   jQuery("#help_working_desc1").hide();
		    jQuery("#help_working_desc3").hide();
	        jQuery("#help_working_desc2").slideToggle(400);
	    });
		
	  jQuery("#help_working_title3").click(function () {
		   jQuery("#help_working_desc1").hide();
		   jQuery("#help_working_desc2").hide();
	        jQuery("#help_working_desc3").slideToggle(400);
	    });
	
	
	 jQuery("#help_saml_title").click(function () {
        jQuery("#help_saml_desc").slideToggle(400);
    });
	
	
	 jQuery("#help_saml_flow_title").click(function () {
        jQuery("#help_saml_flow_desc").slideToggle(400);
    });
	
	
	 jQuery("#help_faq_cert_title").click(function () {
        jQuery("#help_faq_cert_desc").slideToggle(400);
    });
	
	
	 jQuery("#help_faq_404_title").click(function () {
        jQuery("#help_faq_404_desc").slideToggle(400);
    });
	
	
	 jQuery("#help_faq_idp_config_title").click(function () {
        jQuery("#help_faq_idp_config_desc").slideToggle(400);
    });
	
	
	 jQuery("#help_faq_idp_redirect_title").click(function () {
        jQuery("#help_faq_idp_redirect_desc").slideToggle(400);
    });
	var countDownDate = new Date("Dec 31 2021 23:59:59")    
    var now = new Date()
    var distance = countDownDate - now;
    if (distance < 0) {
        clearInterval(x);
    } else {
        document.getElementById("mo_saml_sale_banner").style.display = "block";
    }
});