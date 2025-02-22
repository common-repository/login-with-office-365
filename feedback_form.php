<?php
require_once dirname( __FILE__ ) . '/includes/lib/mo-options-enum.php';

function mo_o365_display_saml_feedback_form() {
	if ( 'plugins.php' != basename( $_SERVER['PHP_SELF'] ) ) {
		return;
	}
	$deactivate_reasons = Mo_o365_options_feedback::getConstants();

	wp_enqueue_style( 'wp-pointer' );
	wp_enqueue_script( 'wp-pointer' );
	wp_enqueue_script( 'utils' );
	wp_enqueue_style( 'mo_saml_admin_plugins_page_style', plugins_url( '/includes/css/style_settings.css?ver=4.8.60', __FILE__ ) );
	?>

    </head>
    <body>


    
    <div id="feedback_modal" class="mo_modal" style="width:80%;">

        
        <div class="mo_modal-content">
            <h3 style="margin: 2%; text-align:center;"><b>Your feedback</b><span class="mo_close" style="cursor: pointer">&times;</span>
            </h3>
			<hr style="width:75%;">
			
            <form name="f" method="post" action="" id="mo_feedback">
                <?php wp_nonce_field("mo_feedback");?>
                <input type="hidden" name="option" value="mo_feedback"/>
                <div>
                    <p style="margin:2%">
					<h4 style="margin: 2%; text-align:center;">Please help us to improve our plugin by giving your opinion.<br></h4>
					
					<div id="smi_rate" style="text-align:center">
					<input type="radio" name="rate" id="angry" value="1"/>
						<label for="angry"><img class="sm" src="<?php echo plugin_dir_url( __FILE__ ) . 'images/angry.png'; ?>" />
						</label>
						
					<input type="radio" name="rate" id="sad" value="2"/>
						<label for="sad"><img class="sm" src="<?php echo plugin_dir_url( __FILE__ ) . 'images/sad.png'; ?>" />
						</label>
					
					
					<input type="radio" name="rate" id="neutral" value="3"/>
						<label for="neutral"><img class="sm" src="<?php echo plugin_dir_url( __FILE__ ) . 'images/normal.png'; ?>" />
						</label>
						
					<input type="radio" name="rate" id="smile" value="4"/>
						<label for="smile">
						<img class="sm" src="<?php echo plugin_dir_url( __FILE__ ) . 'images/smile.png'; ?>" />
						</label>
						
					<input type="radio" name="rate" id="happy" value="5" checked/>
						<label for="happy"><img class="sm" src="<?php echo plugin_dir_url( __FILE__ ) . 'images/happy.png'; ?>" />
						</label>
						
					<div id="outer" style="visibility:visible"><span id="result">Thank you for appreciating our work</span></div>
					</div><br>
					<hr style="width:75%;">
					<?php $email = get_option("mo_saml_admin_email");
						if(empty($email)){
							$user = wp_get_current_user();
							$email = $user->user_email;
						}
						?>
					<div style="text-align:center;">
						
						<div style="display:inline-block; width:60%;">
						<input type="email" id="query_mail" name="query_mail" style="text-align:center; border:0px solid black; border-style:solid; background:#f0f3f7; width:20vw;border-radius: 6px;"
                              placeholder="your email address" required value="<?php echo $email; ?>" readonly="readonly"/>
						
						<input type="radio" name="edit" id="edit" onclick="editName()" value=""/>
						<label for="edit"><img class="editable" src="<?php echo plugin_dir_url( __FILE__ ) . 'images/61456.png'; ?>" />
						</label>
						
						</div>
						<br><br>
						<textarea id="query_feedback" name="query_feedback" rows="4" style="width: 60%"
                              placeholder="Tell us what happened!"></textarea>
						<br><br>
						  <input type="checkbox" name="get_reply" value="reply" checked>miniOrange representative will reach out to you at the email-address entered above.</input>
					</div>
					<br>
                   
                    <div class="mo-modal-footer" style="text-align: center;margin-bottom: 2%">
                        <input type="submit" name="miniorange_feedback_submit"
                               class="button button-primary button-large" value="Send"/>
						<span width="30%">&nbsp;&nbsp;</span>
                        <input type="button" name="miniorange_skip_feedback"
                               class="button button-primary button-large" value="Skip" onclick="document.getElementById('mo_feedback_form_close').submit();"/>
                    </div>
                </div>
				
									<script>
									
						
						
						
						const INPUTS = document.querySelectorAll('#smi_rate input');
						INPUTS.forEach(el => el.addEventListener('click', (e) => updateValue(e)));
						
						
						function editName(){
							
							document.querySelector('#query_mail').removeAttribute('readonly');
							
							document.querySelector('#query_mail').focus();
							return false;
							
						}
						function updateValue(e) {
							document.querySelector('#outer').style.visibility="visible";
							
							var result = 'Thank you for appreciating our work';
							switch(e.target.value){
								case '1':	result = 'Not happy with our plugin ? Let us know what went wrong';
											break;
								case '2':	result = 'Found any issues? Let us know and we\'ll fix it ASAP';
											break;
								case '3':	result = 'Let us know if you need any help';
											break;
								case '4':	result = 'We\'re glad that you are happy with our plugin';
											break;
								case '5':	result = 'Thank you for appreciating our work';
											break;
							}
							document.querySelector('#result').innerHTML = result;
							
						}
					</script>
					<style>
					.editable{
						text-align:center;
						width:1em;
						height:1em;
					}
					.sm {
						text-align:center;
					  width: 2vw;
					  height: 2vw;
					  padding: 1vw;
					}

					input[type=radio] {
					  display: none;
					}

					.sm:hover {
					  opacity:0.6;
					  cursor: pointer;
					}

					.sm:active {
					  opacity:0.4;
					  cursor: pointer;
					}

					input[type=radio]:checked + label > .sm {
					  border: 2px solid #21ecdc;
					}



					</style>
            </form>
            <form name="f" method="post" action="" id="mo_feedback_form_close">
                <?php wp_nonce_field("mo_skip_feedback");?>
                <input type="hidden" name="option" value="mo_skip_feedback"/>
            </form>

        </div>

    </div>

    <script>
        jQuery('a[aria-label="Deactivate Login with Office 365"]').click(function () {

            var mo_modal = document.getElementById('feedback_modal');

            var span = document.getElementsByClassName("mo_close")[0];


										
            mo_modal.style.display = "block";
			document.querySelector("#query_feedback").focus();
            span.onclick = function () {
                mo_modal.style.display = "none";
                jQuery('#mo_feedback_form_close').submit();
            }

            
            window.onclick = function (event) {
                if (event.target == mo_modal) {
                    mo_modal.style.display = "none";
                }
            }
            return false;

        });
    </script><?php
}

?>