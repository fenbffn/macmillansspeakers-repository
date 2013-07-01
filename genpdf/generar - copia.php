<?php

require "../wp-config.php";
global $wpdb;


$output .= '<div>';
$parametro = $_GET['id'];


//echo $parametro;
$array = explode(",", $parametro);


query_posts(array(
    'post_type' => 'speaker',
    'p' => $parametro)
);

while (have_posts()) : the_post();

    require_once "genpdf.php";
    $pdf = new genPDF();
    $html = 'You can now easily print text mixing different styles: <b>bold</b>, <i>italic</i>,
<u>underlined</u>, or <b><i><u>all at once</u></i></b>!<br><br>You can also insert links on
text, such as <a href="http://www.fpdf.org">www.fpdf.org</a>, or on an image: click on the logo.';


    $pdf->SetFont('Arial', '', 20);

    $pdf->AddPage();
//$pdf->SetLink($link);
//$pdf->Write(0, "To find out what's new in this tutorial, click ");
    
       remove_filter('the_title', 'wptitle2_the_title', 999);
    $output .= "<h3><a href='" . get_permalink() . "'>" . get_the_title() . "</a></h3>";
   
  

    $pdf->Ln(2);
     $pdf->SetFontSize(20);
    $pdf->WriteHTML("$output");
    $pdf->Ln(20);
   


    

    $output .= '<div class="speakert">';
    if (has_post_thumbnail()) {
        //$output .="<a href='" . get_permalink() . "'>" . get_the_post_thumbnail(get_the_ID(), "medium") . "</a>";
        $rutaImage = wp_get_attachment_image_src(get_post_thumbnail_id($parametro), 'single-post-thumbnail');

        $pdf->Image($rutaImage[0], 10, 20, 30, 0, '', '');
    } else {
        $output .= '<img style="border:1px solid #adadad;padding:2px" width="100" height="100" alt="7337178" class="attachment-100x250 wp-post-image" src="' . esc_url(home_url('/')) . 'wp-content/uploads/2013/02/no-image.png">';
    }
    
    
     $pdf->Ln(40);
  
    
    
    
     add_filter('the_title', 'wptitle2_the_title', 999);
    

     /*
    $pdf->SetFontSize(20);
    $pdf->WriteHTML("<p>TAGLINE</p>");
    $pdf->Ln();
    */

    $output = "<p>" . (get_the_title()) . "</p>";
    $pdf->SetFontSize(14);
    $pdf->WriteHTML($output);
    $pdf->Ln();
    $pdf->Ln();
//$pdf->Image('logo.png', 10, 12, 30, 0, '', 'http://www.fpdf.org');
    //topics



    $pdf->SetTextColor(255,0,0);
    $pdf->SetFontSize(20);
    $pdf->WriteHTML("<p>BIO</p>");
    $pdf->Ln();


    $output = "<p>" . (get_the_content()) . "</p>";

    $pdf->SetFontSize(14);    
    $pdf->SetTextColor(128); // Text color in gray
    $pdf->WriteHTML($output);
    $pdf->Ln();
     $pdf->Ln();






    $comma = "";
    $post_categories = wp_get_post_terms(get_the_ID(), 'topics', array("fields" => "all"));


    if (!empty($post_categories)) {

        $pdf->SetTextColor(255,0,0);
        $pdf->SetFontSize(20);
        $pdf->WriteHTML("<p>TOPICS</p>");
        $pdf->Ln();
        
        $output = "";


        foreach ($post_categories as $term) {
            $output .= $comma . "<a href='" . get_term_link($term->slug, 'topics') . "'>" . $term->name . "</a>";
            $comma = ", ";
        }

        $pdf->SetFontSize(14);
        $pdf->SetTextColor(128); // Text color in gray
        $pdf->WriteHTML($output);
        $pdf->Ln();
         $pdf->Ln();
    }





    $speeches = get_group('speeches');
    if (!empty($speeches)) {

        $pdf->SetTextColor(255,0,0);
        $pdf->SetFontSize(20);
        $pdf->WriteHTML("<p>SPEECHES</p>");
        $pdf->Ln();

        $output = "";

        foreach ($speeches[1]['speeches_speech'] as $speech) {
            $output .= $speech . "<br /><br/>";
        }
        $output .= "</p>";


        $pdf->SetFontSize(14);
        $pdf->SetTextColor(128); // Text color in gray
        $pdf->WriteHTML($output);
        $pdf->Ln();
         $pdf->Ln();
    }




    $works = get_group('works', $valor);
    if (!empty($works)) {

        $pdf->SetTextColor(255,0,0);
        $pdf->SetFontSize(20);
        $pdf->WriteHTML("<p>BOOKS:</p>");
        $pdf->Ln();



        $output = "";
        foreach ($works[1]['works_product'] as $work) {
            $output .= $work . "<br /><br/>";
        }
        $output .= "</p>";

        $pdf->SetFontSize(14);
        $pdf->SetTextColor(128); // Text color in gray
        $pdf->WriteHTML($output);
        $pdf->Ln();
        $pdf->Ln();
    }



    $output .= '</div>';
    $pdf->Output();


endwhile;



$output .= '</div>';
require_once "genpdf.php";
$pdf = new genPDF();
$html = 'You can now easily print text mixing different styles: <b>bold</b>, <i>italic</i>,
<u>underlined</u>, or <b><i><u>all at once</u></i></b>!<br><br>You can also insert links on
text, such as <a href="http://www.fpdf.org">www.fpdf.org</a>, or on an image: click on the logo.';

/*

  // First page
  $pdf->AddPage();
  $rutaImage = wp_get_attachment_image_src( get_post_thumbnail_id( $parametro ), 'single-post-thumbnail' );
  echo $rutaImage[0];
  $pdf->Image($rutaImage[0], 10, 12, 30, 0, '','');
  $pdf->WriteHTML("Hola esto es una prueba");

  //$pdf->Output();

 */





    
    
    
    




//$pdf->SetLeftMargin(45);
//$pdf->WriteHTML($output);

