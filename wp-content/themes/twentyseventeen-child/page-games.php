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
        foreach( $myposts as $post) : setup_postdata( $post); ?>
        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a><br/>
        <?php endforeach;
        wp_reset_postdata();?>

<!-- Game Listing ends here -->
	</div><!-- #primary -->
</div><!-- .wrap -->

<?php get_footer();
