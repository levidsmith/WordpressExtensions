<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

<div class="wrap">
	<div id="primary-game-list" class="content-area">
		<main id="main" class="site-main" role="main">



		</main><!-- #main -->

<!-- Game Listing starts here -->
<?php
include('page-game-list-layout-popular.php');
?>

        <?php
        echo '<a href="?web=true&layout=thumbnail">Web Games</a> | ';
        echo '<a href="?download=true">Downloads</a> | ';
        echo '<a href="?soundcloud=true">Soundtracks</a>';
        echo '<br/>';
        echo 'Order all by: ';
        echo '<a href="?orderby=name">Name</a> | ';
        echo '<a href="?orderby=newest">Newest</a> | ';
        echo '<a href="?orderby=oldest">Oldest</a>';
        echo '<br/>';

/*
        echo 'Game Jams: ';
        echo '<a href="?jam=ludumdare">48 hour</a> | ';
        echo '<a href="?jam=gm48">GM48</a> | ';
        echo '<a href="?jam=minild">Mini</a> | ';
        echo '<a href="?jam=dreambuildplay">Dream Build Play</a> | ';
        echo '<a href="?jam=warmup">Warmup</a>';
        echo '<br/>';
*/
/*
        echo 'Videos: ';
        echo '<a href="?layout=videos&video_type=timelapse">Time lapse development</a>';
        echo '<br/>';

        echo 'Music: ';
        echo '<a href="?soundcloud=true">Soundtracks</a>';
        echo '<br/>';
*/
/*
        echo 'Engines: ';

        $strFileContents = file_get_contents("json/engines.json", TRUE);
        $objJSON = json_decode($strFileContents);
        foreach ($objJSON->engine as $engine) {
          echo '<a href="?engine=' . $engine->key . '">' . $engine->description . '</a> | ';
          
        }

        echo '<br/>';
*/

/*
        echo 'Promotion: ';
#        echo '<a href="?unityconnect=true">Unity Connect </a> | ';
        echo '<a href="?indiedb=true">IndieDB</a>';
        echo '<br/>';
*/
        echo 'Most viewed: ';
        echo '<a href="?layout=popular&order=7days">7 Days</a> | ';
        echo '<a href="?layout=popular&order=30days">30 Days</a> | ';
        echo '<a href="?layout=popular&order=365days">365 Days</a> | ';
        echo '<a href="?layout=popular&order=alltime">All Time</a>';
        echo '<br/>';

        echo '<br/>';

        ?>

        <?php
#Note - The following line will need to be increased if the number of posted games exceeds 200
        $args = array( 'posts_per_page' => 200, 'offset' => 0, 'order' => 'DESC');

        $showDate = false;
        if ($orderby == 'name') {
          $args['orderby'] = 'title'; 
          $args['order'] = 'ASC'; 
        } else if ($orderby == 'newest') {
          $args['orderby'] = 'date'; 
          $args['order'] = 'DESC'; 
          $showDate = true;
        } else if ($orderby == 'oldest') {
          $args['orderby'] = 'date'; 
          $args['order'] = 'ASC'; 
          $showDate = true;
        } else {
          $args['orderby'] = 'date'; 
          $args['order'] = 'DESC'; 
        }
       
        $jam = $_GET['jam'];
        if ($jam != '') {
            $args['orderby'] = 'date'; 
            $args['order'] = 'ASC'; 
        }

        $args['post_type'] = 'games';
        $myposts = get_posts($args);


        $layout = $_GET['layout'];

        $download = $_GET['download'];
        $soundcloud = $_GET['soundcloud'];
        $indiedb = $_GET['indiedb'];
        $unityconnect = $_GET['unityconnect'];

        if ($layout == 'thumbnail') {
          display_layout_thumbnail($myposts, true);

        } elseif ($download == 'true' ||
                  $soundcloud == 'true' ||
                  $indiedb == 'true' ||
                  $unityconnect == 'true'
                 ) {
          display_layout_list($myposts, $jam, $showDate);

        } elseif ($layout == 'list') {
          display_layout_list($myposts, $jam, $showDate);
        } elseif ($layout == 'videos') {
          display_layout_videos($myposts, $args['video_type']);
        } elseif ($layout == 'popular') {
          display_layout_popular($myposts);
        } elseif ($layout == 'capsule') {
          display_layout_capsule($myposts);
        } elseif ($layout == 'list') {
          display_layout_list($myposts, $jam, $showDate);
        } else {
          display_layout_capsule($myposts);
        }





  function display_layout_thumbnail($myposts, $webgame_only) {
    echo '<div class="thumbnail_games">';
        foreach( $myposts as $thepost) : setup_postdata( $thepost); 

        if (!$thepost->_games_displaywebgame || $thepost->_games_displaywebgame == 'false') {
          continue;
        }


    $game_name = get_the_title($thepost->ID); 
    $game_url = get_the_permalink($thepost->ID);
    $game_img = $thepost->_games_thumbnail;
    $game_blurb = $thepost->_games_blurb;
    echo '<div class="featured_game"><a href="' . $game_url . '">';
    if ($game_img != '') {
      echo '<img src="' . $game_img . '">';
    } else {
      echo '<img src="' . 'https://levidsmith.com/blog/wp-content/uploads/2018/09/game_thumbnail_missing_256x144.jpg' . '">';
    }
    echo '</a>';
    if ($game_blurb != '') {
      echo '<div class="featured_game_blurb">' . $game_blurb . '</div>';
    }


      echo  '<div class="featured_game_name"><a href="' . $game_url . '">' . $game_name . '</a></div>' . '</div>';



        endforeach;
        wp_reset_postdata();
    echo '</div>';
 
  }

  function display_layout_capsule($myposts) {
    $jam = $_GET['jam'];
    $engine = $_GET['engine'];
    echo '<div class="capsule_games">';
        foreach( $myposts as $thepost) : setup_postdata( $thepost); 



          if ($jam == 'ludumdare' && $thepost->_games_ludumdare == '') {
            continue;
          }

          if ($jam == 'gm48' && $thepost->_games_gm48 == '') {
            continue;
          }

          if ($jam == 'minild' && $thepost->_games_minild == '') {
            continue;
          }

          if ($jam == 'dreambuildplay' && $thepost->_games_dreambuildplay == '') {
            continue;
          }

          if ($jam == 'warmup' && $thepost->_games_warmup == '') {
            continue;
          }

          if ($engine != '' && $engine != $thepost->_games_engine) {
            continue;
          }






    $game_name = get_the_title($thepost->ID); 
    $game_url = get_the_permalink($thepost->ID);
    $game_img_capsule = $thepost->_games_img_small_capsule;

    echo '<div class="capsule_game"><a href="' . $game_url . '">';
    if ($game_img_capsule != '') {
      echo '<img src="' . $game_img_capsule . '" alt="' . $game_name . '" title="' . $game_name . '">';
    } else {
      echo $game_name;
    }
    echo '</a></div>';


        endforeach;
        wp_reset_postdata();
    echo '</div>';
 
  }


  function display_layout_videos($myposts, $video_type) {
        foreach( $myposts as $thepost) : setup_postdata( $thepost); 

        if (!$thepost->_games_timelapse) {
          continue;
        }
    echo '<div class="game_list_video">';


    $game_name = get_the_title($thepost->ID); 
    $game_url = get_the_permalink($thepost->ID);
    $meta_key = '_games_timelapse';
    $timelapse_youtube_id = get_post_meta($thepost->ID, $meta_key, true);
    $timelapse_youtube_id = substr($timelapse_youtube_id, strpos($timelapse_youtube_id, "=") + 1);
    echo '<div class="game_list_video_name"><a href="' . $game_url . '">' . $game_name . '</a>';
    echo '</div>';

    echo '<div class="game_list_video_embed">';
    echo '<iframe width="256" height="144" src="https://www.youtube.com/embed/' . $timelapse_youtube_id . '" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>';
    echo '</div>';

    echo '</div>';


        endforeach;
        wp_reset_postdata();
 
  }




  function display_layout_list($myposts, $jam, $showDate) {
    echo '<table>';

        $iGameNumber = 0;
        foreach( $myposts as $thepost) : setup_postdata( $thepost); 

          $doIncrementNumber = display_game_row($thepost, $jam, $showDate, $iGameNumber);
          if ($doIncrementNumber) {
            $iGameNumber += 1;
          }

        endforeach;
        wp_reset_postdata();
        echo '</table>';

  }
?>




<?php
### Display game text ###
function display_game_text($post, $jam, $showDate, $iGameNumber) {
  echo "Game: " . get_the_title($post->ID) . "<br/>";
}
?>

<?php
### Display game list ###
function display_game_row($post, $jam, $showDate, $iGameNumber) {

#Filter by game jam

          if ($jam == 'ludumdare' && get_post_meta($post->ID, '_games_ludumdare', true) == '') {
             return;
            
          } elseif ($jam == 'gm48' && get_post_meta($post->ID, '_games_gm48', true) == '') {
             return;
          } elseif ($jam == 'minild' && get_post_meta($post->ID, '_games_minild', true) == '') {
             return;
          } elseif ($jam == 'warmup' && get_post_meta($post->ID, '_games_warmup', true) == '') {
             return;
          } elseif ($jam == 'dreambuildplay' && get_post_meta($post->ID, '_games_dreambuildplay', true) == '') {
             return;
          }



#Filter by engine 
          $engine = $_GET['engine'];
          $meta_key = '_games_engine';
          if ($engine == 'unity' && get_post_meta($post->ID, $meta_key, true) != 'unity') {
             return;

          } elseif ($engine == 'gamemaker' && get_post_meta($post->ID, $meta_key, true) != 'gamemaker') {
             return;

          } elseif ($engine == 'xna_monogame' && get_post_meta($post->ID, $meta_key, true) != 'xna_monogame') {
             return;

          } elseif ($engine == 'sdl' && get_post_meta($post->ID, $meta_key, true) != 'sdl') {
             return;

          } elseif ($engine == 'stencyl' && get_post_meta($post->ID, $meta_key, true) != 'stencyl') {
             return;

          } elseif ($engine == '6502' && get_post_meta($post->ID, $meta_key, true) != '6502') {
             return;

          } elseif ($engine == 'godot' && get_post_meta($post->ID, $meta_key, true) != 'godot') {
             return;

          } elseif ($engine == 'construct' && get_post_meta($post->ID, $meta_key, true) != 'construct') {
             return;

          } elseif ($engine == 'unreal' && get_post_meta($post->ID, $meta_key, true) != 'unreal') {
             return;

          } elseif ($engine == 'scratch' && get_post_meta($post->ID, $meta_key, true) != 'scratch') {
            return;

          } elseif ($engine == 'pico8' && get_post_meta($post->ID, $meta_key, true) != 'pico8') {
             return;


         }
            

#Filter by SoundCloud 
          $soundcloud = $_GET['soundcloud'];
          $meta_key = '_games_soundcloud';
          if ($soundcloud == 'true' && get_post_meta($post->ID, $meta_key, true) == '') {
             return;
          }


#Filter by Unity Connect 
          $unityconnect = $_GET['unityconnect'];
          $meta_key = '_games_unityconnect';
          if ($unityconnect == 'true' && get_post_meta($post->ID, $meta_key, true) == '') {
             return;
          }

#Filter by IndieDB 
          $indiedb = $_GET['indiedb'];
          $meta_key = '_games_indiedb';
          if ($indiedb == 'true' && get_post_meta($post->ID, $meta_key, true) == '') {
             return;
          }

        ?>



        <?php
### Display Game List ###

          if ($iGameNumber % 2 == 0) {
            echo "<tr class=\"even_row\">";
          } else {
            echo "<tr class=\"odd_row\">";
          }
        ?>
          <td class="game_row_number"><?php echo $iGameNumber + 1 ?></td>
        
<?php
          echo '<td><span class="game_list"><a href="' . get_the_permalink($post->ID) . '">' . get_the_title($post->ID) . '</a></span></td>';

?>



<?php
#Display post date
        if ($showDate) {
          echo '<td>' . get_the_date('M Y', $post->ID) . '</td>'; 
        }

#Display Ludum Dare icon
  if ($jam == 'ludumdare') {
    echo '<td width="40">';
    $meta_key = '_games_ludumdare';
    $ludumdare_link = get_post_meta($post->ID, $meta_key, true);
    if ($ludumdare_link != "") {
      echo "<a href=\"" . $ludumdare_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_small_ludumdare.jpg\" title=\"View " . get_the_title() . " Ludum Dare entry\"></a>";
        } 
    echo '</td>';
  }

?>

<?php
#Display GM48 icon
  if ($jam == 'gm48') {
    echo '<td width="40">';
    $meta_key = '_games_gm48';
    $gm48_link = get_post_meta($post->ID, $meta_key, true);
    if ($gm48_link != "") {
      echo "<a href=\"" . $gm48_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_small_gm48.jpg\" title=\"View " . get_the_title() . " GM48 entry\"></a>";
        } 
    echo '</td>';
  }

?>

<?php
#Display MiniLD icon
  if ($jam == 'minild') {
    echo '<td width="40">';
    $meta_key = '_games_minild';
    $minild_link = get_post_meta($post->ID, $meta_key, true);
    if ($minild_link != "") {
      echo "<a href=\"" . $minild_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_small_minild.jpg\" title=\"View " . get_the_title() . " MiniLD entry\"></a>";
        } 
    echo '</td>';
  }

?>

<?php
#Display Dream Build Play icon
  if ($jam == 'dreambuildplay') {
    echo '<td width="40">';
    $meta_key = '_games_dreambuildplay';
    $dreambuildplay_link = get_post_meta($post->ID, $meta_key, true);
    if ($dreambuildplay_link != "") {
      echo "<a href=\"" . $dreambuildplay_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_small_dreambuildplay.jpg\" title=\"View " . get_the_title() . " Dream Build Play entry\"></a>";
        } 
    echo '</td>';
  }

?>

<?php
#Display LD Warmup icon
  if ($jam == 'warmup') {
    echo '<td width="40">';
    $meta_key = '_games_warmup';
    $warmup_link = get_post_meta($post->ID, $meta_key, true);
    if ($warmup_link != "") {
      echo "<a href=\"" . $warmup_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_small_warmup.jpg\" title=\"View " . get_the_title() . " warmup entry\"></a>";
        } 
    echo '</td>';
  }

?>

<?php
#Display Unity Connect icon
  if ($unityconnect == 'true') {
    echo '<td width="40">';
    $meta_key = '_games_unityconnect';
    $unityconnect_link = get_post_meta($post->ID, $meta_key, true);
    if ($unityconnect_link != "") {
      echo "<a href=\"" . $unityconnect_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_small_unityconnect.jpg\" title=\"View " . get_the_title() . " on Unity Connect\"></a>";
        } 
    echo '</td>';
  }

?>

<?php 
#Display IndieDB link 
  if ($indiedb == 'true') {
        echo '<td width="40">';
        $meta_key = '_games_indiedb';
        $indiedb_link = get_post_meta($post->ID, $meta_key, true);
        if ($indiedb_link != "") {
          #echo "<a href=\"" . $indiedb_link . "\">IndieDB</a>";
          echo "<a href=\"" . $indiedb_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_small_indiedb.jpg\" title=\"View " . get_the_title() . " on IndieDB\"></a>";
        } 
        echo '</td>';
  }
?>

<?php
#Display Dream Build Play icon
  if ($dreambuildplay == 'true') {
    echo '<td width="40">';
    $meta_key = '_games_dreambuildplay';
    $dreambuildplay_link = get_post_meta($post->ID, $meta_key, true);
    if ($dreambuildplay_link != "") {
      echo "<a href=\"" . $dreambuildplay_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_small_dreambuildplay.jpg\" title=\"View " . get_the_title() . " on Dream Build Play\"></a>";
        } 
    echo '</td>';
  }

?>



<?php
#Display SoundCloud icon
  if ($soundcloud == 'true') {
    echo '<td width="40">';
    $meta_key = '_games_soundcloud';
    $soundcloud_link = get_post_meta($post->ID, $meta_key, true);
    if ($soundcloud_link != "") {
      echo "<a href=\"" . $soundcloud_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_small_soundcloud.jpg\" title=\"Listen to " . get_the_title() . " music\"></a>";
        } 
    echo '</td>';
  }
?>


<?php
# Start Download links
  $download = $_GET['download'];
  if ($download == 'true' && !isset($soundcloud) && $jam != 'ludumdare' && 
       $jam != 'gm48' && $jam != 'minild' &&
       $jam != 'warmup' && $jam != 'dreambuildplay' &&
       !isset($unityconnect) && !isset($indiedb) ) {
?>


<?php 
#Display Itch.io link 
        echo '<td width="40">';
        $meta_key = '_games_itchio';
        $itch_link = get_post_meta($post->ID, $meta_key, true);
        if ($itch_link != "") {
          echo "<a href=\"" . $itch_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_small_itchio.jpg\" title=\"Play " . $post->post_title . " on Itch.io\"></a>";
        } 
        echo '</td>';
?>


<?php 
#Display GameJolt link 
        echo '<td width="40">';
        $meta_key = '_games_gamejolt';
        $gamejolt_link = get_post_meta($post->ID, $meta_key, true);
        if ($gamejolt_link != "") {
          echo "<a href=\"" . $gamejolt_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_small_gamejolt.jpg\" title=\"Play " . $post->post_title . " on GameJolt\"></a>";
        } 
        echo '</td>';
?>

<?php 
#Display Microsoft Store link 
        echo '<td width="40">';
        $meta_key = '_games_microsoftstore';
        $microsoftstore_link = get_post_meta($post->ID, $meta_key, true);
        if ($microsoftstore_link != "") {
          echo "<a href=\"" . $microsoftstore_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_small_microsoftstore.jpg\" title=\"Play " . $post->post_title . " on Microsoft Store\"></a>";
        } 
        echo '</td>';
?>

<?php 
#Display Google Play link 
        echo '<td width="40">';
        $meta_key = '_games_googleplay';
        $googleplay_link = get_post_meta($post->ID, $meta_key, true);
        if ($googleplay_link != "") {
          echo "<a href=\"" . $googleplay_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_small_googleplay.jpg\" title=\"Play " . $post->post_title . " on Google Play\"></a>";
        } 
        echo '</td>';
?>

<?php 
#Display Kongregate link 
        echo '<td width="40">';
        $meta_key = '_games_kongregate';
        $kongregate_link = get_post_meta($post->ID, $meta_key, true);
        if ($kongregate_link != "") {
          echo "<a href=\"" . $kongregate_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_small_kongregate.jpg\" title=\"Play " . $post->post_title . " on Kongregate\"></a>";
        } 
        echo '</td>';
?>



<?php
#Display time lapse icon
    echo '<td width="40">';
    $meta_key = '_games_timelapse';
    $timelapse_link = get_post_meta($post->ID, $meta_key, true);
    if ($timelapse_link != "") {
      echo "<a href=\"" . $timelapse_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_small_timelapse.jpg\" title=\"Watch " . $post->post_title . " time lapse development video\"></a>";
        } 
    echo '</td>';

?>


<?php 
#Display YouTube Playlist link 
        echo '<td width="40">';
        $meta_key = '_games_youtube_playlist';
        $youtube_playlist_link = get_post_meta($post->ID, $meta_key, true);
        if ($youtube_playlist_link != "") {
          echo "<a href=\"" . $youtube_playlist_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_small_youtube.jpg\" title=\"View " . $post->post_title . " playlist on YouTube\"></a>";
        } 
        echo '</td>';
?>

<?php
### End Download Links
  }
?>



<?php 
#Display Edit link
        $edit_link = get_edit_post_link($post->ID);
        if ($edit_link != "") {
          echo "<td><a href=\"" . $edit_link . "\">Edit</a></td>";
        } 
?>

<?php
  #Missing engine value
  if (current_user_can("administrator")) {
    $meta_key = '_games_engine';
    if (get_post_meta($post->ID, $meta_key, true) == '') {
          echo "<td>No engine</td>";
    } else {
      echo "<td></td>";
    }
#    echo "<td>Is admin</td>";
  }
?>


<?php
  #Structured Data disabled
  if (current_user_can("administrator")) {
    $meta_key = '_games_structured_enabled';
    $meta_value = get_post_meta($post->ID, $meta_key, true);
    if ($meta_value == '' || $meta_value == 'false') {
          echo "<td>Structured Data Disabled</td>";
    } else {
      echo "<td></td>";
    }
  }
?>



        </tr>   



<?php
  return true;
}
?>

<!-- Game Listing ends here -->
	</div><!-- #primary -->
</div><!-- .wrap -->

<?php get_footer();
