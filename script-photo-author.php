<?php

/* Código que lee un archivo .csv con datos, para luego insertarse en una base de datos, vía MySQL
 *  http://gualinx.wordpress.com
 */



if (!($link = @mysql_connect("localhost", "macmillanspeaker", "yxm7jlOyQ48o2tr"))) {
    echo "Error conectando a la base de datos.";
    exit();
}
if (!mysql_select_db("macmillanspeaker", $link)) {
    echo "Error seleccionando la base de datos.";
    exit();
}


$row = 0;
$i = 0;
$handle = fopen("autores.csv", "r"); //Coloca el nombre de tu archivo .csv que contiene los datos

$lines = file("autores.csv");

foreach ($lines as $line_num => $line) {
    ++$row;
    if ($row == 1)
        continue;
    $record = explode(";", $line);
    $photocredit = $record[1];

    if ($photocredit == '')
        continue;
    $keynote = strtolower(trim(strip_tags($record[3])));

    $post_id = "";


    //seleccionamos los post que tienen el tag
    $sql = sprintf("SELECT `post_id` FROM  `macmillanspeaker`.`mc_postmeta` WHERE lower(meta_value)='%s'", mysql_real_escape_string($keynote));
    $result = mysql_query($sql, $link) or die(mysql_error() . " sql: " . $sql);

    $result = mysql_fetch_assoc($result);

    echo "$row. photo credit: ***" . $photocredit . "***  keynote: " . $keynote . "  post_id: ";


    if ($result != null) {
        ++$i;
        echo $result['post_id'] . " ... processing ... ";
        $meta_value = mysql_real_escape_string(trim($photocredit));
        $sql2 = sprintf("insert into mc_postmeta(post_id, meta_key, meta_value) VALUES(%d, 'photo_credit', '%s')", $result['post_id'], $meta_value);
        $ans1 = mysql_query($sql2, $link);
        $record_id = mysql_insert_id($link);
        
        $sql3 = sprintf("insert into mc_mf_post_meta(meta_id, field_name, field_count, group_count, post_id) VALUES(%d, 'photo_credit', 1, 1, %d)", $record_id, $result['post_id']);
        $ans2 = mysql_query($sql3, $link);
        
        if ($ans1 and $ans2)
            echo "OK";
        else {
            echo "FAIL";
        }

    } else {
        ++$j;
        echo "<span style='color:red'>No post_id, please fix manually.</span>";
    }
    echo "<br>";
    
    //exit;
}


//echo "Total results: " . $i;
echo "Pending: " . $j;

mysql_close($link);

//get_post_meta($post->ID, 'photo_credit', true);
?>