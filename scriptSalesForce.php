<?php

//include($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/salesforce-wordpress-to-lead/salesforce.php');

//$ruta = get_site_url()."/wp-content/plugins/salesforce-wordpress-to-lead/salesforce.php";
//include($ruta);

//require ABSPATH . DIRECTORY_SEPARATOR . 'wp-content' . DIRECTORY_SEPARATOR . 'plugins'. DIRECTORY_SEPARATOR . 'salesforce-wordpress-to-lead'. DIRECTORY_SEPARATOR . 'salesforce.php';

//$ruta2 = "/files/html/wp-content/plugins/salesforce-wordpress-to-lead/salesforce.php";
//include_path($ruta2);


//include('/wp-content/plugins/salesforce-wordpress-to-lead/salesforce.php');

require(dirname(__FILE__) . '/wp-load.php');
require_once('wp-content/plugins/salesforce-wordpress-to-lead/ov_plugin_tools.php');
require_once('wp-content/plugins/salesforce-wordpress-to-lead/salesforce.php');
require_once('wp-includes/plugin.php');


//include_php file="/wp-content/plugins/salesforce-wordpress-to-lead/salesforce.php";

//require_once('ov_plugin_tools.php');

echo"<br><br>METODO 1:<br><br>";

$first_name = "METODO 1";
$last_name = "METODO 1";
$company = "METODO 1";
$message = "METODO 1";
//
$post_items[] = '00Di0000000LANR';
$post_items[] = 'First_name=' . $first_name;
$post_items[] = 'Last_name=' . $last_name;
$post_items[] = 'Company= micompany';
$post_items[] = 'message=' . $message;




if (!empty($last_name) && !empty($message)) {
    $post_string = implode('&', $post_items);
    // Create a new cURL resource
    $ch = curl_init();

    echo"<br>crando nuevo recurso url<br>";
    var_dump($ch);


    if (curl_error($ch) != "") {
        // error handling

        echo "<script type='text/javascript'>alert('Error');</script>";
    }

    $con_url = 'https://www.salesforce.com/servlet/servlet.WebToLead?encoding=UTF-8';
    curl_setopt($ch, CURLOPT_URL, $con_url);
    // Set the method to POST
    curl_setopt($ch, CURLOPT_POST, 1);
    // Pass POST data
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);

    curl_exec($ch); // Post to Salesforce

    echo"<br>contenido de curl_exec($ch)<br>";
    var_dump(curl_exec($ch));

    curl_close($ch); // close cURL resource


    echo"<br>contenido de post string($ch)<br>";
    var_dump($post_string);


    echo "<script type='text/javascript'>alert('Enviado a salesforce de la forma 1');</script>";
}


echo"<br><br>METODO 2: del plugin<br><br>";



$args = array(
    "body" => array(
        "first_name" => "Juan Perez2",
        "title" => "Juan Perez2",
        "Organization" => "Juan Perez2",
        "Address" => "Juan Perez",
        "country" => "USA",
        "city" => "alaska",
        "state" => "Juan Perez",
        "zip" => "2343242",
        "phone" => "24341234124",
        "email" => "Prueba@h.com",
        "description" => "00Di0000000LANR00Di0000000LANR00Di0000000LANR",
        "oid" => "00Di0000000LANR",
        "lead_source" => "Lead form on macmillian speakers",
        "debug" => 0,
    ),
    "headers" => array(
        "user-agent" => "WordPress-to-Lead for Salesforce plugin - WordPress/3.5.1; http://localhost/MACMILLANFER",
    ),
    "sslverify" => false,
);



echo"<br>contenido de args<br>";
var_dump($args);


$result = wp_remote_post('https://www.salesforce.com/servlet/servlet.WebToLead?encoding=UTF-8', $args);

echo"<br>contenido de $results<br>";
var_dump($result);//Parece que se cuelga la coneccion porque no se imprime esto 

if (is_wp_error($result))
    return false;
else
    echo "<script type='text/javascript'>alert('Enviado a salesforce de la forma 2');</script>";
?>
