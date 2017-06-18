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
        echo 'Order by: ';
        echo '<a href="?orderby=name">Name</a> | ';
        echo '<a href="?orderby=newest">Newest</a> |';
        echo '<a href="?orderby=oldest">Oldest</a>';
        echo '<br/><br/>';

/*
        echo 'Ordering by: ';
        $orderby = $_GET['orderby'];
        if ($orderby == 'name') {
          echo 'Name';
        } else if ($orderby == 'newest') {
          echo 'Newest';
        } else if ($orderby == 'oldest') {
          echo 'oldest';
        } else {
          echo 'Not set';
        }
*/
        ?>

        <?php
#       $args = array( 'posts_per_page' => 5, 'offset' => 1, 'category' => 'featured-games');
        #$args = array( 'posts_per_page' => 100, 'offset' => 1, 'category_name' => 'featured-games', 'orderby' => 'title', 'order' => 'ASC');
        $args = array( 'posts_per_page' => 100, 'offset' => 0, 'category_name' => 'featured-games', 'order' => 'DESC');

        if ($orderby == 'name') {
          $args['orderby'] = 'title'; 
          $args['order'] = 'ASC'; 
        } else if ($orderby == 'newest') {
          $args['orderby'] = 'date'; 
          $args['order'] = 'DESC'; 
        } else if ($orderby == 'oldest') {
          $args['orderby'] = 'date'; 
          $args['order'] = 'ASC'; 
        } else {
          $args['orderby'] = 'title'; 
          $args['order'] = 'ASC'; 
        }

        $myposts = get_posts($args);
        ?>
        <table>
        <?php
        $iGameNumber = 0;
        foreach( $myposts as $post) : setup_postdata( $post); ?>
      
        <?php
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
        if ($orderby == 'newest' || $orderby == 'oldest') {
?>
        <td><?php the_date('M Y');?></td> 
<?php
        }
?>


<?php 
#Display Itch.io link 
        echo '<td width="40">';
        $itch_link = get_post_meta(get_the_ID(), 'itchio', true);
        if ($itch_link != "") {
#          echo "<a href=\"" . $itch_link . "\">Itch.io</a>";
          echo "<a href=\"" . $itch_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_small_itchio.jpg\" title=\"Play " . get_the_title() . " on Itch.io\"></a>";
        } 
        echo '</td>';
?>


<?php 
#Display GameJolt link 
        echo '<td width="40">';
        $gamejolt_link = get_post_meta(get_the_ID(), 'gamejolt', true);
        if ($gamejolt_link != "") {
          #echo "<a href=\"" . $gamejolt_link . "\">GameJolt</a>";
          echo "<a href=\"" . $gamejolt_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_small_gamejolt.jpg\" title=\"Play " . get_the_title() . " on GameJolt\"></a>";
        } 
        echo '</td>';
?>


<?php 
#Display IndieDB link 
        echo '<td width="40">';
        $indiedb_link = get_post_meta(get_the_ID(), 'indiedb', true);
        if ($indiedb_link != "") {
          #echo "<a href=\"" . $indiedb_link . "\">IndieDB</a>";
          echo "<a href=\"" . $indiedb_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_small_indiedb.jpg\" title=\"View " . get_the_title() . " on IndieDB\"></a>";
        } 
        echo '</td>';
?>

<?php 
#Display YouTube Playlist link 
        echo '<td width="40">';
        $youtube_playlist_link = get_post_meta(get_the_ID(), 'youtube_playlist', true);
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





        </tr>   
        <?php $iGameNumber += 1;?>
        <?php endforeach;?>
        <?php wp_reset_postdata();?>
        </table>

<!-- Game Listing ends here -->
	</div><!-- #primary -->
</div><!-- .wrap -->

<?php get_footer();
