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

    $output .= '<div class="speakert">';
    if (has_post_thumbnail()) {
        //$output .="<a href='" . get_permalink() . "'>" . get_the_post_thumbnail(get_the_ID(), "medium") . "</a>";
        $output .="" . get_the_post_thumbnail(get_the_ID(), "medium"). "";
   
        
        
    } else {
        $output .= '<img style="border:1px solid #adadad;padding:2px" width="100" height="100" alt="7337178" class="attachment-100x250 wp-post-image" src="' . esc_url(home_url('/')) . 'wp-content/uploads/2013/02/no-image.png">';
    }
    remove_filter('the_title', 'wptitle2_the_title', 999);
    //$output .= "<h3><a href='" . get_permalink() . "'>" . get_the_title() . "</a></h3>";
    $output .= "<h3>" . get_the_title() . "</h3>";
    add_filter('the_title', 'wptitle2_the_title', 999);
    $output .= "<p>" . (get_the_title()) . "</p>";
    $output .= '</div>';


    //topics

    $output .= "<h4>Topics</h4><p>";

    $comma = "";
    $post_categories = wp_get_post_terms(get_the_ID(), 'topics', array("fields" => "all"));
    foreach ($post_categories as $term) {
        //$output .= $comma . "<a href='" . get_term_link($term->slug, 'topics') . "'>" . $term->name . "</a>";
        $output .= $comma . $term->name;
        $comma = ", ";
    }
    $output .= "</p>";
    
    
    $output .= "<h4>Travels From</h4><p>";
   
    
    $comma = "";
    $post_travels = wp_get_post_terms( get_the_ID(), 'travels',array("fields" => "all"));
    foreach($post_travels as $term) {
        //$output .= $comma."<a href='".get_term_link($term->slug, 'travels')."'>".$term->name."</a>";
        $output .= $comma.$term->name;
        $comma = ", ";
    }
                 
    $output .= "</p>";
    


    $output .= "<h4>Bio</h4><p>" . (get_the_content()) . "</p>";


    $speeches = get_group('speeches');
    if (!empty($speeches)) {
        $output .= "<h4>SPEECHES</h4><p>"; 
        foreach ($speeches[1]['speeches_speech'] as $speech) {
            $output .= $speech . "<br /><br/>";
        }
        $output .= "</p>";
    }


    $works = get_group('works', $parametro);


    //        print_r($works[1]['works_product']);
    if (!empty($works)) {
        $output .= "<h4>BOOKS</h4><p>"; 

        foreach ($works[1]['works_product'] as $work) {
            $work = str_replace("<br>", '', $work);
            $output .= $work ;
        }
        $output .= "</p>";
    }

    
     $reviews = get_group('reviews');
    if (!empty($reviews)) {
        $output .= "<p> REVIEWS: </br>";

        foreach ($reviews[1]['reviews_review'] as $review) {
            $output .= $review . "<br /><br/>";
        }
        $output .= "</p>";
    }


    $output .= '</div>';


endwhile;



$output .= '</div>';
//include('bbcode1.php');// para convertir los tags bbcode a html
ob_end_clean();
//include_once("../inc/fpdf.php");

require_once('tcpdf/config/lang/eng.php');
require_once('tcpdf/tcpdf.php');
ini_set("display_errors", "off");
error_reporting(0);

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

	//Page header
	public function Header() {
            
           // public function Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false, $alt=false, $altimgs=array()) {
	
		// Logo
		$image_file = K_PATH_IMAGES.'macmillan_logo.jpg';
		$this->Image($image_file, 5, 0, 60, 40, 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		// Set font
		$this->SetFont('helvetica', 'B', 8);
                // 
                // 
                //
                //public function Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M') {
	
		// Title
                $this->Cell(0, 10, '', 0,1, 'R', 0, '', 0, false, 'M', 'M');
                $this->Cell(0, 10, '', 0,2, 'R', 0, '', 0, false, 'M', 'M');
                $this->Cell(0, 10, 'For more information contact us on:', 0, 3, 'R', 0, '', 0, false, 'M', 'M');
		$this->Cell(0, 10, 'North America 855.414.1034', 0, 4, 'R', 0, '', 0, false, 'M', 'M');
		$this->Cell(0, 10, 'International +1 646.307.5567', 0, 5, 'R', 0, '', 0, false, 'M', 'M');
                $this->Cell(0, 10, 'speakers@macmillan.com', 0, 6, 'R', 0, '', 0, false, 'M', 'M');
                
                $this->header_line_color = array(0,64,128);
//                $this->SetLineStyle(array('width' => 0.85 / $this->k, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => $headerdata['line_color']));
//			
                
                // print an ending header line
			$this->SetLineStyle(array('width' => 0.85 / $this->k, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0,64,128)));
			//$this->SetY((2.835 / $this->k) + max($imgy, $this->y));
                        $this->SetY(33);
			if ($this->rtl) {
				$this->SetX($this->original_rMargin);
			} else {
				$this->SetX($this->original_lMargin);
			}
			$this->Cell(($this->w - $this->original_lMargin - $this->original_rMargin), 0, '', 'T', 0, 'C');
			
	}	
        
     
}


// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('');
$pdf->SetTitle('');
$pdf->SetSubject('');
$pdf->SetKeywords('');

// set default header data
$pdf->SetHeaderData('macmillan_logo.jpg',40, '', '', array(0,64,255), array(0,64,128));
$pdf->setFooterData($tc=array(0,64,0), $lc=array(0,64,128));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 35, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('dejavusans', '', 14, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

// set text shadow effect
//$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

// set font
$pdf->SetFont('times', '', 12);


// Print text using writeHTMLCell()
file_put_contents("dataspeakers.txt", $output);
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $output, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('macmillan_speaker.pdf', 'I');
