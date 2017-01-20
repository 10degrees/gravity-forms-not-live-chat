<?php
/*
Plugin Name: 10° Not Live chat
Plugin URI: https://www.10degrees.uk
Description: Looks like a live chat, smells like a live chat, is not live chat.
Version: 1.1.0
Author: Tom Kay, Matt Radford
Author URI: https://www.10degrees.uk
License: MIT
Text Domain: nlc
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


add_action( 'admin_init', 'child_plugin_has_parent_plugin' );
function child_plugin_has_parent_plugin() {
    if ( is_admin() && current_user_can( 'activate_plugins' ) &&  ! class_exists( 'GFForms' ) ) {
        add_action( 'admin_notices', 'child_plugin_notice' );

        deactivate_plugins( plugin_basename( __FILE__ ) ); 

        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }
    }
}

function child_plugin_notice(){
    ?><div class="error"><p>Sorry, but 10° Not Live Chat requires <a href="http://www.gravityforms.com/">Gravity Forms</a> to be installed and active.</p></div><?php
}

// Add NLC Options page
add_action('admin_menu', 'tend_not_live_chat');

function tend_not_live_chat(){
  add_options_page( 'Not Live Chat', 'Not Live Chat', 'manage_options', '10d-not-live-chat', 'tend_not_live_chat_page') ;
  //call register settings function
	add_action( 'admin_init', 'register_tend_nlc_settings' );
}

// Register NLC settings
function register_tend_nlc_settings() {
	register_setting( 'tend-nlc-settings-group', 'nlc_phonenumber' );
	register_setting( 'tend-nlc-settings-group', 'nlc_email' );
	register_setting( 'tend-nlc-settings-group', 'nlc_gformid' );
  register_setting( 'tend-nlc-settings-group', 'nlc_title' );
  register_setting( 'tend-nlc-settings-group', 'nlc_message' );
}


function tend_not_live_chat_page() {

  // Restrict to Administrator
  if ( ! current_user_can( 'manage_options' ) )  {
    wp_die( __( 'You do not have permission to access this page.' )    );
  }

  // Build the Options page
  echo '<div class="wrap">';
  echo '<h2>10° Not Live Chat</h2>';

  // Check whether the button has been pressed AND also check the nonce
  if (isset($_POST['nlc']) && check_admin_referer('update_button_clicked')) {
    // the button has been pressed AND we've passed the security check
    // update_the_stylesheet();
    save_nlc_options();
  }

  echo '<form action="options-general.php?page=10d-not-live-chat" method="post">';

  settings_fields( 'tend-nlc-settings-group' );
  do_settings_sections( 'tend-nlc-settings-group' );

  // This is a WordPress security feature - see: https://codex.wordpress.org/WordPress_Nonces
  wp_nonce_field('update_button_clicked');

  echo '<b>Contact Phone Number:</b><br /><input type="text" name="nlc_phonenumber" value="' . esc_attr( get_option('nlc_phonenumber') ) . '" /> <br />';
  echo '<b>Contact Email:</b><br /><input type="text" name="nlc_email" value="' . esc_attr( get_option('nlc_email') ) . '" /> <br />';
  echo '<b>Graviy Form ID:</b><br /><input type="text" name="nlc_gformid" value="' . esc_attr( get_option('nlc_gformid') ) . '" /> <br />';
  echo '<b>Message Box Title (keep short, e.g "Talk to Us")</b><br /><input type="text" name="nlc_title" value="' . esc_attr( get_option('nlc_title') ) . '" /><br />';
  echo '<b>Holding Message:</b><br /><input style="width:400px;" type="text" name="nlc_message" value="' . esc_attr( get_option('nlc_message') ) . '" />';
  echo '<hr />';
  echo '<input type="hidden" value="true" name="nlc" />';
  submit_button('Update Settings');
  echo '</form>';

  echo '</div>';

}




   function save_nlc_options() {

     $phone = $_POST["nlc_phonenumber"];
     $email = $_POST["nlc_email"];
     $gform = $_POST["nlc_gformid"];
     $title = $_POST["nlc_title"];
     $message = $_POST["nlc_message"];


     update_option( 'nlc_phonenumber', $phone );
     update_option( 'nlc_email', $email );
     update_option( 'nlc_gformid', $gform );
     update_option( 'nlc_title', $title );
     update_option( 'nlc_message', $message );


   }



   function tend_load_floaty_tab() {


     ?>

     <div class="tend_nlc_chat">
       <div class="tend_nlc_chat_icon">
       <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="36" height="32" viewBox="0 0 36 32">
       <path d="M15 0v0c8.284 0 15 5.435 15 12.139s-6.716 12.139-15 12.139c-0.796 0-1.576-0.051-2.339-0.147-3.222 3.209-6.943 3.785-10.661 3.869v-0.785c2.008-0.98 3.625-2.765 3.625-4.804 0-0.285-0.022-0.564-0.063-0.837-3.392-2.225-5.562-5.625-5.562-9.434 0-6.704 6.716-12.139 15-12.139zM31.125 27.209c0 1.748 1.135 3.278 2.875 4.118v0.673c-3.223-0.072-6.181-0.566-8.973-3.316-0.661 0.083-1.337 0.126-2.027 0.126-2.983 0-5.732-0.805-7.925-2.157 4.521-0.016 8.789-1.464 12.026-4.084 1.631-1.32 2.919-2.87 3.825-4.605 0.961-1.84 1.449-3.799 1.449-5.825 0-0.326-0.014-0.651-0.039-0.974 2.268 1.873 3.664 4.426 3.664 7.24 0 3.265-1.88 6.179-4.82 8.086-0.036 0.234-0.055 0.474-0.055 0.718z"></path>
       </svg>
      </div>

        <div class="tend_nlc_chat_content">
            <div class="tend_nlc_chat_banner">
              <h2><?php echo get_option('nlc_title'); ?></h2>
              <div class="tend_nlc_chat_close">
                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32" viewBox="0 0 32 32">
                <path d="M16 0c-8.837 0-16 7.163-16 16s7.163 16 16 16 16-7.163 16-16-7.163-16-16-16zM16 29c-7.18 0-13-5.82-13-13s5.82-13 13-13 13 5.82 13 13-5.82 13-13 13z"></path>
                <path d="M21 8l-5 5-5-5-3 3 5 5-5 5 3 3 5-5 5 5 3-3-5-5 5-5z"></path>
                </svg>

              </div>
            </div>

            <div class="tend_nlc_chat_content_inner">

            <?php if( get_option('nlc_message') ) { ?>  <p class="tend_nlc_chat_content_inner_message"><?php echo get_option('nlc_message'); ?></p><hr /> <?php } ?>
            <?php if( get_option('nlc_phonenumber') ) { ?>  <p><b>Telephone:</b>  <a class="tend_nlc_chat_content_call" href="tel:<?php echo get_option('nlc_phonenumber'); ?>"><?php echo get_option('nlc_phonenumber'); ?></a></p> <?php } ?>
            <?php if( get_option('nlc_email') ) { ?>  <p><b>Email:</b> <a href="mailto:<?php echo get_option('nlc_email'); ?>"><?php echo get_option('nlc_email'); ?></a></p> <?php } ?>
              <hr />
              <?php $formid = get_option('nlc_gformid'); ?>
              <?php echo do_shortcode('[gravityform id='.$formid.' title=false description=false ajax=true tabindex=49]'); ?>

            </div>
        </div>



     </div>


     <script>
     jQuery(document).ready(function($){


     if ($(window).width() < 480) {

       $( ".tend_nlc_chat").on('click', function() {
          $('a.tend_nlc_chat_content_call')[0].click();

       var what = $( "a.tend_nlc_chat_content_call").attr('href');
       console.log(what);
        });

     } else {

       $('.tend_nlc_chat_icon').click(function(){

         $(this).hide();

       $('.tend_nlc_chat_content').slideToggle( "slow", function() {

       })

       $( ".tend_nlc_chat").addClass('open');

     });

   }



     $('.tend_nlc_chat_close').click(function(){

       $('.tend_nlc_chat_content').slideToggle( "slow", function() {

         $('.tend_nlc_chat_icon').show();
       })

       $( ".tend_nlc_chat").removeClass('open');

     });

     });

     </script>

     <?php

   }
   add_action( 'wp_footer', 'tend_load_floaty_tab' , 200);


   function tend_load_nlc_styles() {
   $stylesheeruri = plugins_url( 'tend-not-live-chat/tend_nlc.css', dirname(__FILE__) );
   ?>
   <link rel="stylesheet" id="tend-nlc-styles-css" href="<?php echo $stylesheeruri;?>" type="text/css" media="all">
   <?php

}
add_action( 'wp_head', 'tend_load_nlc_styles' , 200);
