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
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">



		</main><!-- #main -->

<!-- Game Listing starts here -->

        <?php
        echo 'Game Index<br/><br/>';
        echo 'Order all by: ';
        echo '<a href="?orderby=name">Name</a> | ';
        echo '<a href="?orderby=newest">Newest</a> |';
        echo '<a href="?orderby=oldest">Oldest</a>';
        echo '<br/>';

        echo 'Game Jams: ';
        echo '<a href="?jam=ludumdare">Ludum Dare</a> | ';
        echo '<a href="?jam=gm48">GM48</a> | ';
        echo '<a href="?jam=minild">MiniLD</a> | ';
        echo '<a href="?jam=warmup">Warmup</a>';
        echo '<br/>';

        echo 'Videos: ';
        echo '<a href="?timelapse=true">Time lapse development</a>';
        echo '<br/>';

        echo 'Music: ';
        echo '<a href="?soundcloud=true">SoundCloud</a>';
        echo '<br/>';

        echo 'Engines: ';
        echo '<a href="?engine=unity">Unity</a> |';
        echo '<a href="?engine=gamemaker">GameMaker</a> |';
        echo '<a href="?engine=xna_monogame">XNA / MonoGame</a> |';
        echo '<a href="?engine=sdl">SDL</a> |';
        echo '<a href="?engine=stencyl">Stencyl</a> |';
        echo '<a href="?engine=6502">6502</a> |';
        echo '<a href="?engine=godot">Godot</a> |';
        echo '<a href="?engine=pico8">Pico-8</a> |';
        echo '<a href="?engine=construct">Construct</a> |';
        echo '<a href="?engine=unreal">Unreal Engine</a> |';
        echo '<a href="?engine=scratch">Scratch</a> |';
        echo '<br/>';

        echo 'Promotion: ';
        echo '<a href="?unityconnect=true">Unity Connect</a>';
        echo '<br/>';

        echo '<br/>';

        ?>

        <?php
        $args = array( 'posts_per_page' => 100, 'offset' => 0, 'order' => 'DESC');

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
          $args['orderby'] = 'title'; 
          $args['order'] = 'ASC'; 
        }
       
        $jam = $_GET['jam'];
        if ($jam != '') {
            $args['orderby'] = 'date'; 
            $args['order'] = 'ASC'; 
        }

        $args['post_type'] = 'games';

        $myposts = get_posts($args);
?>

        <table>

        <?php
        $iGameNumber = 0;
        foreach( $myposts as $post) : setup_postdata( $post); 

          $doIncrementNumber = display_game_row($post, $jam, $showDate, $iGameNumber);
          if ($doIncrementNumber) {
            $iGameNumber += 1;
          }
        ?>

        <?php endforeach;?>
        <?php wp_reset_postdata();?>
        </table>







<?php
### Display game list ###
function display_game_row($post, $jam, $showDate, $iGameNumber) {
?>



        <?php
#Filter by game jam


          if ($jam == 'ludumdare' && get_post_meta(get_the_ID(), '_games_ludumdare', true) == '') {
             return;
            
          } elseif ($jam == 'gm48' && get_post_meta(get_the_ID(), '_games_gm48', true) == '') {
             return;
          } elseif ($jam == 'minild' && get_post_meta(get_the_ID(), '_games_minild', true) == '') {
             return;
          } elseif ($jam == 'warmup' && get_post_meta(get_the_ID(), '_games_warmup', true) == '') {
             return;
          }



#Filter by engine 
          $engine = $_GET['engine'];
          $meta_key = '_games_engine';
          if ($engine == 'unity' && get_post_meta(get_the_ID(), $meta_key, true) != 'unity') {
             return;

          } elseif ($engine == 'gamemaker' && get_post_meta(get_the_ID(), $meta_key, true) != 'gamemaker') {
             return;

          } elseif ($engine == 'xna_monogame' && get_post_meta(get_the_ID(), $meta_key, true) != 'xna_monogame') {
             return;

          } elseif ($engine == 'sdl' && get_post_meta(get_the_ID(), $meta_key, true) != 'sdl') {
             return;

          } elseif ($engine == 'stencyl' && get_post_meta(get_the_ID(), $meta_key, true) != 'stencyl') {
             return;

          } elseif ($engine == '6502' && get_post_meta(get_the_ID(), $meta_key, true) != '6502') {
             return;

          } elseif ($engine == 'godot' && get_post_meta(get_the_ID(), $meta_key, true) != 'godot') {
             return;

          } elseif ($engine == 'construct' && get_post_meta(get_the_ID(), $meta_key, true) != 'construct') {
             return;

          } elseif ($engine == 'unreal' && get_post_meta(get_the_ID(), $meta_key, true) != 'unreal') {
             return;

          } elseif ($engine == 'scratch' && get_post_meta(get_the_ID(), $meta_key, true) != 'scratch') {
            return;

          } elseif ($engine == 'pico8' && get_post_meta(get_the_ID(), $meta_key, true) != 'pico8') {
             return;


         }
            


#Filter by time lapse
          $timelapse = $_GET['timelapse'];
          $meta_key = '_games_timelapse';
          if ($timelapse == 'true' && get_post_meta(get_the_ID(), $meta_key, true) == '') {
             return;
          }

#Filter by SoundCloud 
          $soundcloud = $_GET['soundcloud'];
          $meta_key = '_games_soundcloud';
          if ($soundcloud == 'true' && get_post_meta(get_the_ID(), $meta_key, true) == '') {
             return;
          }


#Filter by Unity Connect 
          $unityconnect = $_GET['unityconnect'];
          $meta_key = '_games_unityconnect';
          if ($unityconnect == 'true' && get_post_meta(get_the_ID(), $meta_key, true) == '') {
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
          <td><?php echo $iGameNumber + 1 ?></td>
          <td><strong><a href="<?php the_permalink();?>"><?php the_title();?></a></strong></td>




<?php
#Display post date
        if ($showDate) {
?>
        <td><?php the_date('M Y');?></td> 
<?php
        }
?>

<?php
#Display Ludum Dare icon
  if ($jam == 'ludumdare') {
    echo '<td width="40">';
    $meta_key = '_games_ludumdare';
    $ludumdare_link = get_post_meta(get_the_ID(), $meta_key, true);
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
    $gm48_link = get_post_meta(get_the_ID(), $meta_key, true);
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
    $minild_link = get_post_meta(get_the_ID(), $meta_key, true);
    if ($minild_link != "") {
      echo "<a href=\"" . $minild_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_small_minild.jpg\" title=\"View " . get_the_title() . " MiniLD entry\"></a>";
        } 
    echo '</td>';
  }

?>

<?php
#Display LD Warmup icon
  if ($jam == 'warmup') {
    echo '<td width="40">';
    $meta_key = '_games_warmup';
    $warmup_link = get_post_meta(get_the_ID(), $meta_key, true);
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
    $unityconnect_link = get_post_meta(get_the_ID(), $meta_key, true);
    if ($unityconnect_link != "") {
      echo "<a href=\"" . $unityconnect_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_small_unityconnect.jpg\" title=\"View " . get_the_title() . " on Unity Connect\"></a>";
        } 
    echo '</td>';
  }

?>



<?php 
#Display Itch.io link 
        echo '<td width="40">';
        $meta_key = '_games_itchio';
        $itch_link = get_post_meta(get_the_ID(), $meta_key, true);
        if ($itch_link != "") {
          echo "<a href=\"" . $itch_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_small_itchio.jpg\" title=\"Play " . get_the_title() . " on Itch.io\"></a>";
        } 
        echo '</td>';
?>


<?php 
#Display GameJolt link 
        echo '<td width="40">';
        $meta_key = '_games_gamejolt';
        $gamejolt_link = get_post_meta(get_the_ID(), $meta_key, true);
        if ($gamejolt_link != "") {
          echo "<a href=\"" . $gamejolt_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_small_gamejolt.jpg\" title=\"Play " . get_the_title() . " on GameJolt\"></a>";
        } 
        echo '</td>';
?>

<?php 
#Display Microsoft Store link 
        echo '<td width="40">';
        $meta_key = '_games_microsoftstore';
        $microsoftstore_link = get_post_meta(get_the_ID(), $meta_key, true);
        if ($microsoftstore_link != "") {
          echo "<a href=\"" . $microsoftstore_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_small_microsoftstore.jpg\" title=\"Play " . get_the_title() . " on Microsoft Store\"></a>";
        } 
        echo '</td>';
?>

<?php 
#Display Google Play link 
        echo '<td width="40">';
        $meta_key = '_games_googleplay';
        $googleplay_link = get_post_meta(get_the_ID(), $meta_key, true);
        if ($googleplay_link != "") {
          echo "<a href=\"" . $googleplay_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_small_googleplay.jpg\" title=\"Play " . get_the_title() . " on Google Play\"></a>";
        } 
        echo '</td>';
?>

<?php 
#Display Kongregate link 
        echo '<td width="40">';
        $meta_key = '_games_kongregate';
        $kongregate_link = get_post_meta(get_the_ID(), $meta_key, true);
        if ($kongregate_link != "") {
          echo "<a href=\"" . $kongregate_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_small_kongregate.jpg\" title=\"Play " . get_the_title() . " on Kongregate\"></a>";
        } 
        echo '</td>';
?>


<?php 
#Display IndieDB link 
        echo '<td width="40">';
        $meta_key = '_games_indiedb';
        $indiedb_link = get_post_meta(get_the_ID(), $meta_key, true);
        if ($indiedb_link != "") {
          #echo "<a href=\"" . $indiedb_link . "\">IndieDB</a>";
          echo "<a href=\"" . $indiedb_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_small_indiedb.jpg\" title=\"View " . get_the_title() . " on IndieDB\"></a>";
        } 
        echo '</td>';
?>


<?php
#Display time lapse icon
#  if ($timelapse == 'true') {
    echo '<td width="40">';
    $meta_key = '_games_timelapse';
    $timelapse_link = get_post_meta(get_the_ID(), $meta_key, true);
    if ($timelapse_link != "") {
      echo "<a href=\"" . $timelapse_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_small_timelapse.jpg\" title=\"Wathc " . get_the_title() . " time lapse development video\"></a>";
        } 
    echo '</td>';
#  }

?>

<?php
#Display SoundCloud icon
#  if ($soundcloud == 'true') {
    echo '<td width="40">';
    $meta_key = '_games_soundcloud';
    $soundcloud_link = get_post_meta(get_the_ID(), $meta_key, true);
    if ($soundcloud_link != "") {
      echo "<a href=\"" . $soundcloud_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_small_soundcloud.jpg\" title=\"Listen to " . get_the_title() . " music\"></a>";
        } 
    echo '</td>';
#  }

?>


<?php 
#Display YouTube Playlist link 
        echo '<td width="40">';
        $meta_key = '_games_youtube_playlist';
        $youtube_playlist_link = get_post_meta(get_the_ID(), $meta_key, true);
        if ($youtube_playlist_link != "") {
          #echo "<a href=\"" . $youtube_playlist_link . "\">Playlist</a>";
          echo "<a href=\"" . $youtube_playlist_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_small_youtube.jpg\" title=\"View " . get_the_title() . " playlist on YouTube\"></a>";
        } 
        echo '</td>';
?>


<?php 
#Display Edit link
        $edit_link = get_edit_post_link(get_the_ID());
        if ($edit_link != "") {
          echo "<td><a href=\"" . $edit_link . "\">Edit</a></td>";
        } 
?>

<?php
  #Missing engine value
  if (current_user_can("administrator")) {
    $meta_key = '_games_engine';
    if (get_post_meta(get_the_ID(), $meta_key, true) == '') {
          echo "<td>No engine</td>";
    } else {
      echo "<td></td>";
    }
#    echo "<td>Is admin</td>";
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
