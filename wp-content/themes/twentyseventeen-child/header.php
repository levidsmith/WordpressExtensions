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

<!-- Start Google Analytics -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-62497279-1', 'auto');
  ga('send', 'pageview');

</script>
<!-- End Google Analytics -->


<!-- Start YouTube embed -->
<script>

    /* Light YouTube Embeds by @labnol */
    /* Web: http://labnol.org/?p=27941 */

    document.addEventListener("DOMContentLoaded",
        function() {
            var div, n,
                v = document.getElementsByClassName("youtube-player");
            for (n = 0; n < v.length; n++) {
                div = document.createElement("div");
                div.setAttribute("data-id", v[n].dataset.id);
                div.innerHTML = labnolThumb(v[n].dataset.id);
                div.onclick = labnolIframe;
                v[n].appendChild(div);
            }
        });

    function labnolThumb(id) {
/*
        var thumb = '<img src="https://levidsmith.com/blog/wp-content/uploads/2019/08/hqdefault.jpg">',
            play = '<div class="play"></div>';
*/
            var strThumb = '<img class="youtube_thumb" width="800" src="https://i.ytimg.com/vi/ID/hqdefault.jpg">'.replace("ID", id);
            var strArrow = '<img class="youtube_arrow" width="256" height="256" src="https://levidsmith.com/blog/wp-content/uploads/2019/08/play_arrow.png">';
            var strPlayer = '<div class="youtube_player">' + strThumb + strArrow + '</div>';
          return strPlayer;
/*        return thumb.replace("ID", id) + play; */
    }

    function labnolIframe() {
        var iframe = document.createElement("iframe");
        var embed = "https://www.youtube.com/embed/ID?autoplay=1";
        iframe.setAttribute("src", embed.replace("ID", this.dataset.id));
        iframe.setAttribute("frameborder", "0");
        iframe.setAttribute("width", "800px");
        iframe.setAttribute("height", "450px");  
        iframe.setAttribute("allowfullscreen", "1");
        this.parentNode.replaceChild(iframe, this);
    }

</script>

<!-- End YouTube embed -->
	
	<!-- Start Google Font -->
	<link href="https://fonts.googleapis.com/css?family=Share+Tech" rel="stylesheet"> 
	<!-- End Google Font -->

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

