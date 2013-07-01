<?php
/*
	Plugin Name: Hot Topic Widget
	Plugin URI: http://richtech.com
	Description: Plugin for displaying hot topic
	Author: R. Cruz
	Version: 1.0
	Author URI: http://hot-topic.com
*/

global $wp_version;
if((float)$wp_version >= 2.8){
class HotTopicWidget extends WP_Widget {

	/*
	* construct
	*/
	
	function HotTopicWidget() {
		parent::WP_Widget(
			'HotTopicWidget'
			, 'Hot Topic Widget'
			, array(
				'description' => 'Display Hot Topic'
			)
		);
	}

	
        //Aqui recuperamos los datos para mostrarlos en frontend
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		echo $before_widget;
        $title = $instance['title'];
		
        $title1 = $instance['title1'];		
        $title2 = $instance['title2'];
        $title3 = $instance['title3'];
        $title4 = $instance['title4'];
        
        $cortar1 = $instance['cortar1'];
        $cortar2 = $instance['cortar2'];
        $cortar3 = $instance['cortar3'];
        $cortar4 = $instance['cortar4'];        
        
        $permalink1 = get_permalink($instance['page_id_1']);
        $permalink2 = get_permalink($instance['page_id_2']);
        $permalink3 = get_permalink($instance['page_id_3']);
        $permalink4 = get_permalink($instance['page_id_4']);

        if ( !empty( $title ) ) {
            echo $before_title . '<span class="topic_header_bkg">'. $title . '</span>' . $after_title;
        }
        
        echo "<ul class='topics'>";
         //Aqui cortamos la cadena si es muy larga
        echo "<li><div style='display: table-cell; vertical-align: middle;'><a href='".$permalink1."'>".($cortar1==1?(strlen($title1)>50?substr($title1, 0, 48)."..":$title1):$title1)."</a></div></li>";
        echo "<li><div style='display: table-cell; vertical-align: middle;'><a href='".$permalink2."'>".($cortar2==1?(strlen($title2)>50?substr($title2, 0, 48)."..":$title2):$title2)."</a></div></li>";
        echo "<li><div style='display: table-cell; vertical-align: middle;'><a href='".$permalink3."'>".($cortar3==1?(strlen($title3)>50?substr($title3, 0, 48)."..":$title3):$title3)."</a></div></li>";
        echo "<li><div style='display: table-cell; vertical-align: middle;'><a href='".$permalink4."'>".($cortar4==1?(strlen($title4)>50?substr($title4, 0, 48)."..":$title4):$title4)."</a></div></li>";
        echo "</ul>";
//        echo "<div class='about-us-button'><a href='".esc_url( home_url( '/' ))."about-us/'>ABOUT US</a></div>";
		echo $after_widget;
        echo "<div class='clear'></div>";

		
	}
	
        
        //Aui guardamos los datos recabados en el backend
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['page_id_1'] = strip_tags($new_instance['page_id_1']);
                $instance['page_id_2'] = strip_tags($new_instance['page_id_2']);
                $instance['page_id_3'] = strip_tags($new_instance['page_id_3']);
                $instance['page_id_4'] = strip_tags($new_instance['page_id_4']);
                
                $instance['title'] = strip_tags($new_instance['title']);
		
                $instance['title1'] = strip_tags($new_instance['title1']);
		$instance['title2'] = strip_tags($new_instance['title2']);
                $instance['title3'] = strip_tags($new_instance['title3']);
                $instance['title4'] = strip_tags($new_instance['title4']);
                
                
                //Chequeamos el estado de los checksbox y guardamos el dato
                if($_POST["cortar1"])
                 {
                    $instance['cortar1'] = "1";
                 } 
                 else
                 {
                    $instance['cortar1'] = "0";
                 } 
               
                 if($_POST["cortar2"])
                 {
                    $instance['cortar2'] = "1";
                 } 
                 else
                 {
                    $instance['cortar2'] = "0";
                 } 
                 
                if($_POST["cortar3"])
                 {
                    $instance['cortar3'] = "1";
                 } 
                 else
                 {
                    $instance['cortar3'] = "0";
                 } 
                
                 if($_POST["cortar4"])
                 {
                    $instance['cortar4'] = "1";
                 } 
                 else
                 {
                    $instance['cortar4'] = "0";
                 } 
		
                
                
                return $instance;
	}

        //Esta funcion muestra el contenido en pantalla
	function form($instance) {
		$default = 	array(
			    'title'				=> 'HOT TOPICS'
			,   'title1'		=>      ''
            ,   'title2'        =>      ''
            ,   'title3'        =>      ''
            ,   'title4'        =>      ''
						 );
		$instance = wp_parse_args( (array) $instance, $default );

        $field_excerpt_length_id = $this->get_field_id('title');
        $field_excerpt_length = $this->get_field_name('title');
        echo "\r\n"
            .'<p><label for="'
            .$field_id
            .'">'
            .__('Title')
            .': </label><input type="text" id="'
            .$field_excerpt_length_id
            .'" name="'
            .$field_excerpt_length
            .'" value="'
            .esc_attr( $instance['title'] )
            .'" /></p>';
        
        echo " <hr />";
        echo "<center><h3>HOT TOPIC 1</h3></center>";
        /* topic 1*/
        $field_excerpt_length_id = $this->get_field_id('title1');
        $field_excerpt_length = $this->get_field_name('title1');
        
        $field_cortar1 = $this->get_field_name('cortar1');
     
        
        //echo  $instance['cortar1'] ;
       
    
        if($instance['cortar1']=="1")
         {
               echo "\r\n"
                .'<p>                
                <input type=checkbox name=cortar1 checked> Cut large titles<br>
                <label for="'
                .$field_id
                .'">'
                .__('Title Topic 1')
                .': </label><input type="text" id="'
                .$field_excerpt_length_id
                .'" name="'
                .$field_excerpt_length
                .'" value="'
                .esc_attr( $instance['title1'] )
                .'" /></p>';
         } 
         else
         {
                echo "\r\n"
                .'<p>                
                <input type=checkbox name=cortar1 > Cut large titles<br>
                <label for="'
                .$field_id
                .'">'
                .__('Title Topic 1')
                .': </label><input type="text" id="'
                .$field_excerpt_length_id
                .'" name="'
                .$field_excerpt_length
                .'" value="'
                .esc_attr( $instance['title1'] )
                .'" /></p>';
         } 
        
        
        
    


        $page_id_1 = $this->get_field_name('page_id_1');
		_e("Page to display: " );
			?>
			<select name="<?php echo $page_id_1; ?>">
				<?php
					$pages = get_pages();
					foreach ($pages as $page){
						if ($page->ID == $instance['page_id_1']){
							$selected = 'selected="selected"';
						}
						else {
							$selected='';
						}
						echo '<option value="'
							.$page->ID.'"'
							.$selected.'>'
							.$page->post_title
							.'</option>';
					};
				?>
			</select>


        <hr />
        <center> <h3>HOT TOPIC 2</h3></center>
		<?php

        /* topic 2*/
        $field_excerpt_length_id = $this->get_field_id('title2');
        $field_excerpt_length = $this->get_field_name('title2');
        
        $field_cortar2 = $this->get_field_name('cortar2');
        
        //echo  $instance['cortar2'] ;
        
        
        
         if($instance['cortar2']=="1")
         {
               echo "\r\n"
                .'<p>                
                <input type=checkbox name=cortar2 checked> Cut large titles<br>
                <label for="'
                .$field_id
                .'">'
                .__('Title Topic 2')
                .': </label><input type="text" id="'
                .$field_excerpt_length_id
                .'" name="'
                .$field_excerpt_length
                .'" value="'
                .esc_attr( $instance['title2'] )
                .'" /></p>';
         } 
         else
         {
                echo "\r\n"
                .'<p>                
                <input type=checkbox name=cortar2 > Cut large titles<br>
                <label for="'
                .$field_id
                .'">'
                .__('Title Topic 2')
                .': </label><input type="text" id="'
                .$field_excerpt_length_id
                .'" name="'
                .$field_excerpt_length
                .'" value="'
                .esc_attr( $instance['title2'] )
                .'" /></p>';
         } 


        $page_id_2 = $this->get_field_name('page_id_2');
        _e("Page to display: " );
        ?>
    <select name="<?php echo $page_id_2; ?>">
        <?php
        $pages = get_pages();
        foreach ($pages as $page){
            if ($page->ID == $instance['page_id_2']){
                $selected = 'selected="selected"';
            }
            else {
                $selected='';
            }
            echo '<option value="'
                .$page->ID.'"'
                .$selected.'>'
                .$page->post_title
                .'</option>';
        };
        ?>
    </select>

    <hr />
    <center> <h3>HOT TOPIC 3</h3></center>
    <?php
        /* topic 3*/
        $field_excerpt_length_id = $this->get_field_id('title3');
        $field_excerpt_length = $this->get_field_name('title3');
        
        $field_cortar3 = $this->get_field_name('cortar3');
        
        
        //echo  $instance['cortar3'] ;
          
        
        if($instance['cortar3']=="1")
         {
               echo "\r\n"
                .'<p>                
                <input type=checkbox name=cortar3 checked> Cut large titles<br>
                <label for="'
                .$field_id
                .'">'
                .__('Title Topic 3')
                .': </label><input type="text" id="'
                .$field_excerpt_length_id
                .'" name="'
                .$field_excerpt_length
                .'" value="'
                .esc_attr( $instance['title3'] )
                .'" /></p>';
         } 
         else
         {
                echo "\r\n"
                .'<p>                
                <input type=checkbox name=cortar3 > Cut large titles<br>
                <label for="'
                .$field_id
                .'">'
                .__('Title Topic 3')
                .': </label><input type="text" id="'
                .$field_excerpt_length_id
                .'" name="'
                .$field_excerpt_length
                .'" value="'
                .esc_attr( $instance['title3'] )
                .'" /></p>';
         } 


        $page_id_3 = $this->get_field_name('page_id_3');
        _e("Page to display: " );
        ?>
    <select name="<?php echo $page_id_3; ?>">
        <?php
        $pages = get_pages();
        foreach ($pages as $page){
            if ($page->ID == $instance['page_id_3']){
                $selected = 'selected="selected"';
            }
            else {
                $selected='';
            }
            echo '<option value="'
                .$page->ID.'"'
                .$selected.'>'
                .$page->post_title
                .'</option>';
        };
        ?>
    </select>
    <hr />
        <center> <h3>HOT TOPIC 4</h3></center>
        <?php

        /* topic 4*/
        $field_excerpt_length_id = $this->get_field_id('title4');
        $field_excerpt_length = $this->get_field_name('title4');
        
        $field_cortar4 = $this->get_field_name('cortar4');
        
        
        //echo  $instance['cortar4'] ;
        
        
         if($instance['cortar4']=="1")
         {
               echo "\r\n"
                .'<p>                
                <input type=checkbox name=cortar4 checked> Cut large titles<br>
                <label for="'
                .$field_id
                .'">'
                .__('Title Topic 4')
                .': </label><input type="text" id="'
                .$field_excerpt_length_id
                .'" name="'
                .$field_excerpt_length
                .'" value="'
                .esc_attr( $instance['title4'] )
                .'" /></p>';
         } 
         else
         {
                echo "\r\n"
                .'<p>                
                <input type=checkbox name=cortar4 > Cut large titles<br>
                <label for="'
                .$field_id
                .'">'
                .__('Title Topic 4')
                .': </label><input type="text" id="'
                .$field_excerpt_length_id
                .'" name="'
                .$field_excerpt_length
                .'" value="'
                .esc_attr( $instance['title4'] )
                .'" /></p>';
         } 



        $page_id_4 = $this->get_field_name('page_id_4');
        _e("Page to display: " );
        ?>
    <select name="<?php echo $page_id_4; ?>">
        <?php
        $pages = get_pages();
        foreach ($pages as $page){
            if ($page->ID == $instance['page_id_4']){
                $selected = 'selected="selected"';
            }
            else {
                $selected='';
            }
            echo '<option value="'
                .$page->ID.'"'
                .$selected.'>'
                .$page->post_title
                .'</option>';
        };
        ?>
    </select>
        <?php
	}
	
/* class end */
}
}

add_action('widgets_init', 'hot_topic_widgets');

function hot_topic_widgets(){
	register_widget('HotTopicWidget');
}

?>
