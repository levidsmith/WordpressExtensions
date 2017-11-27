Add a new meta key


*** In functions.php file

Add the following in game_save_post_class_meta($post_id, $post)
  game_update_meta_value('_games_mynewkey', $post_id);

Add the following in game_post_class_meta_box( $post )
Modify as necessary if not a text field
  echo 'MyNewKeyDisplay';
  $meta_key = '_games_mynewkey';
  echo '<input type="text" name="' . $meta_key . '" id="' . $meta_key . '" value="' . get_post_meta(get_the_ID(), $meta_key, true)  . '" size="64">';
  echo '<br/>';
  
Add the following in display_game_links( $content )
          $meta_key = '_games_mynewkey';
          $mynewkey_link = get_post_meta(get_the_ID(), $meta_key, true);

		  
            #Display MyNewKey link
            if ($mynewkey_link != "") {
              $strText .= "<a href=\"" . $mynewkey_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_mynewkey.jpg\" title=\"MyNewKey Tooltip\"></a> ";
            }

			
*** In page-game-list.php file
<?php
#Display MyNewKey link
        echo '<td width="40">';
        $meta_key = '_games_mynewkey';
        $mynewkey_link = get_post_meta(get_the_ID(), $meta_key, true);
        if ($mynewkey_link != "") {
          echo "<a href=\"" . $mynewkey_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_small_mynewkey.jpg\" title=\"Play " . get_the_title() . " on MyNewKey\"></a>";
        }
        echo '</td>';
?>

*** Create and put the following files in assets/images/icon_mynewkey	
	icon_mynewkey.jpg
	icon_small_mynewkey.jpg
