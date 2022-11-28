<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>

<!-- Start Site Verification -->
<meta name="p:domain_verify" content="f6572e5e5e31c15808105ecbb7169245"/>
<!-- End Site Verification -->


	
	<!-- Start Custom Font -->
	<link href="https://levidsmith.com/style/ldsmith_style.css" rel="stylesheet"> 
	<!-- End Custom Font -->

<!-- Start Leaderboard CSS -->
<link rel="stylesheet" type="text/css" href="https://levidsmith.com/scores/leaderboard.css">

<!-- End Leaderboard CSS -->



<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php
#<link rel="profile" href="http://gmpg.org/xfn/11">
?>


<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'twentyseventeen' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
<!-- Before get_template_part -->

		<?php  get_template_part( 'template-parts/header/header', 'image' ); ?>
<!-- After get_template_part -->

		<?php if ( has_nav_menu( 'top' ) ) : ?>
			<div class="navigation-top">
				<div class="wrap">
					<?php get_template_part( 'template-parts/navigation/navigation', 'top' ); ?>
				</div>
			</div>
		<?php endif; ?>

	</header>





	<?php
	// If a regular post or page, and not the front page, show the featured image.

/*
	if ( has_post_thumbnail() && ( is_single() || ( is_page() && ! twentyseventeen_is_frontpage() ) ) ) :
		echo '<div class="single-featured-image-header">';
		the_post_thumbnail( 'twentyseventeen-featured-image' );
		echo '</div><!-- .single-featured-image-header -->';
	endif;
*/


	?>

	<div class="site-content-contain">
		<div id="content" class="site-content">

<?php  get_featured_game_blurbs(); ?>

