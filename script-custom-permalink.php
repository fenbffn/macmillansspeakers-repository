<?php

/*
  get all speakers
  foreach speaker{
  get id, post_name

  if( not exists the record in mc_postmeta){
  insert into mc_postmeta(post_id, meta_key, meta_value) values ('125', 'custom_permalink', 'alec-baldwin')
  }
  }
 */


if (!($link = @mysql_connect("localhost", "macmillanspeaker", "yxm7jlOyQ48o2tr"))) {
    echo "Error conectando a la base de datos.";
    exit();
}
if (!mysql_select_db("macmillanspeaker", $link)) {
    echo "Error seleccionando la base de datos.";
    exit();
}

//get all speakers
$result = mysql_query("SELECT `ID`, `post_name` FROM  `macmillanspeaker`.`mc_posts` WHERE (post_type =  'speaker' and post_name <> '')", $link);
if ($result) {
    $i=1;
    while ($speaker = mysql_fetch_assoc($result)) { // siguiente
//ID, post_name
        $existe = mysql_query(sprintf("SELECT meta_id FROM  `mc_postmeta`  WHERE (post_id=%d and meta_key='custom_permalink' and meta_value='%s')", $speaker['ID'], str_replace("-", "",$speaker['post_name'])), $link);
        $existe = mysql_fetch_assoc($existe);
        if (!isset($existe['meta_id'])) {
            echo ($i++).". Insertando custom permalink para " . str_replace("-", "", $speaker['post_name']);
            if(mysql_query(sprintf("insert into mc_postmeta (post_id, meta_key, meta_value) values ('%d','custom_permalink', '%s')", $speaker['ID'], str_replace("-", "", $speaker['post_name'])), $link))
                    echo  " ... Ok <br />";
            else
                echo  " ... Failed <br />";
//                          echo  " <br />";
        }
    }
}

// cerramos la conexión a la base de datos (no importa si la abrimos en modo persistente)
mysql_close($link);
?>