<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
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

<?php

  $secretKey="****************";



  if (current_user_can("administrator")) {
    echo "Leaderboard Management<br>";
  } else {
    echo "Login to manage leaderboards<br/>";
  }

  $args = array( 'posts_per_page' => 100, 'offset' => 0, 'order' => 'ASC');
  $args['orderby'] = 'title';
  $args['post_type'] = 'games';
  $myposts = get_posts($args);

  foreach( $myposts as $thepost) : setup_postdata( $thepost);

    $game_name = get_the_title($thepost->ID);
    $game_url = get_the_permalink($thepost->ID);
    $game_id = $thepost->ID;
//    $download_url = get_post_meta($thepost->ID, '_games_itchio', true);
    $download_url = $thepost->_games_itchio;

//    echo urlencode($game_name) . $game_id . $secretKey; 

    echo '<div style="width: 1000px; color: #000000; background-color: #A0FFA0; margin: 2px 2px 2px 2px; float: left">';
    echo '<div style="width: 400px; float: left; background-color: #FFA0A0;">' . $game_name . '</div>';
    echo '<div style="width: 200px; background-color: #A0A0FF; float: left;">' . $thepost->ID . '</div>';

    if (current_user_can("administrator")) {
      $str_date = date("Ymd");
      $hash = md5(urlencode($game_name) . $game_id . $str_date . $secretKey);
      echo '<div style="width: 200px; background-color: #A0FFFF; float: left;">' .      '<a href="/scores/AddGame.php?name=' . urlencode($game_name) . '&id=' . $thepost->ID . '&download_url=' . urlencode($download_url) . '&hash=' . $hash . '">Add Game</a></div>';

      $hash = md5($game_id . $str_date . $secretKey);
      echo '<div style="width: 200px; background-color: #A0FFFF; float: left;">' .      '<a href="/scores/ClearScores.php?id=' . $thepost->ID . '&hash=' . $hash . '">Clear Scores</a></div>';

    }

    echo '</div>';
  endforeach 


?>





			<?php
/*
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/page/content', 'page' );











				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
*/
			?>

		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .wrap -->

<?php
get_footer();
