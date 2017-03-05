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
        ?>

        <?php
#       $args = array( 'posts_per_page' => 5, 'offset' => 1, 'category' => 'featured-games');
        $args = array( 'posts_per_page' => 100, 'offset' => 1, 'category_name' => 'featured-games', 'orderby' => 'title', 'order' => 'ASC');
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

          <td>
<?php 
        $itch_link = get_post_meta(get_the_ID(), 'itchio', true);
        if ($itch_link != "") {
          echo "<a href=\"" . $itch_link . "\">Itch.io</a>";
        } 
?>
        </td>

          <td>
<?php 
        $gamejolt_link = get_post_meta(get_the_ID(), 'gamejolt', true);
        if ($gamejolt_link != "") {
          echo "<a href=\"" . $gamejolt_link . "\">GameJolt</a>";
        } 
?>
        </td>

          <td>
<?php 
        $indiedb_link = get_post_meta(get_the_ID(), 'indiedb', true);
        if ($indiedb_link != "") {
          echo "<a href=\"" . $indiedb_link . "\">IndieDB</a>";
        } 
?>
        </td>

        </tr>   
        <?php $iGameNumber += 1;?>
        <?php endforeach;?>
        <?php wp_reset_postdata();?>
        </table>

<!-- Game Listing ends here -->
	</div><!-- #primary -->
</div><!-- .wrap -->

<?php get_footer();
