<?php
// if uninstall.php is not called by WordPress, die
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    die;
}
// Get options created by the plugin
$option_nlc_phonenumber =   'nlc_phonenumber';
$option_nlc_email =         'nlc_email';
$option_nlc_formid =        'nlc_formid';
$option_nlc_title =         'nlc_title';
$option_nlc_message =       'nlc_message';

// Delete options from single site WP installs
delete_option( $option_nlc_phonenumber );
delete_option( $option_nlc_email );
delete_option( $option_nlc_formid );
delete_option( $option_nlc_title );
delete_option( $option_nlc_message );
 
// Delete options from multisite WP installs
delete_site_option( $option_nlc_phonenumber );
delete_site_option( $option_nlc_email );
delete_site_option( $option_nlc_formid );
delete_site_option( $option_nlc_title );
delete_site_option( $option_nlc_message );
