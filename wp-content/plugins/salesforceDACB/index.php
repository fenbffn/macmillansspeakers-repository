<?php


ini_set("display_errors", "off");
ini_set("display_startup_errors", "off");
error_reporting(0);

/*
  Plugin Name: salesforceDACB
  Description: Different widgets for salesforce
  Author: Daniel Cosio
  Version: 0.1
  Author URI: 
 */

/*
 * Creating Newsletter widget
 */
 
 global $wp_version;
if((float)$wp_version >= 2.8){




//salesforce para contact form 7
function my_salesForce( $cf7 )
{ 
  $name  = $cf7->posted_data["your-name"];
  $organization  = $cf7->posted_data["organization"];
  $email = $cf7->posted_data["your-email"];
  $telephone = $cf7->posted_data["your-telephone"];
  $country = $cf7->posted_data["country"];
  $state = $cf7->posted_data["state"];
  $city = $cf7->posted_data["city"];
  $message  = $cf7->posted_data["your-message"];
  $lead_source = $cf7->title;
  
  
  
$args = array(
    "body" => array(
        "first_name" => $name,
        "title" => $lead_source,
        "company" => $organization,
        "Address" => "",
        "country" => $country,
        "city" => $city,
        "state" => $state,
        "zip" => "",
        "phone" => $telephone,
        "email" => $email,
        "description" => $message,
        "oid" => "00D40000000ITe7",
        "lead_source" => "Lead form on macmillian speakers",
        "debug" => 0,
    ),
    "headers" => array(
        "user-agent" => "WordPress-to-Lead for Salesforce plugin - WordPress/3.5.1; http://localhost/MACMILLANFER",
    ),
    "sslverify" => false,
);



$result = wp_remote_post('https://www.salesforce.com/servlet/servlet.WebToLead?encoding=UTF-8', $args);
    
}
  
add_action( 'wpcf7_before_send_mail', 'my_salesForce' );


}




