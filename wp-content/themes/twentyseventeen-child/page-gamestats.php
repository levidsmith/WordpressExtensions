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

<!-- My Code Starts Here -->

<?php

/*
  $i = 0;
  while ($i < 5) {
    print "This is a test<br>";
    $i++;
  }
*/

  $html_itchio = "";
  $html_gamejolt = "";
  $html_kongregate = "";

#  $html_gamejolt = file_get_contents('http://gamejolt.com/profile/levi-d-smith/49381/');
  $html_gamejolt = file_get_contents('http://gamejolt.com/@GaTechGrad/games');
  $html_kongregate = file_get_contents('http://www.kongregate.com/games/GaTechGrad');
  $html_itchio = file_get_contents('http://gatechgrad.itch.io/');




#  print $html

#  $xml = simplexml_load_string($html_gamejolt);
#  $result = $xml->xpath("<h4>");

#  $html_gamejolt = "jasdklf jadfslkja sdflkjal <h4>hello</h4> kasdjf k ljajsdf k<h4>world</h4> ajdksf jj dfsj kas djfklj";

#  preg_match_all("a(.*)f", $html_gamejolt, $results);
#preg_match_all("/(<([\w]+)[^>]*>)(.*?)(<\/\\2>)/", $html_gamejolt, $matches, PREG_SET_ORDER);
#preg_match_all("/(<h4>)(.*?)(<\/h4>)/", $html_gamejolt, $matches, PREG_SET_ORDER);
preg_match_all('/<a href="(.*)" title="View Game.*">(.*?)<\/a>/', $html_gamejolt, $matches, PREG_SET_ORDER);
  print "<strong>Game Jolt</strong><br/>\n";
foreach ($matches as $val) {
    echo '<a href="http://www.gamejolt.com' . $val[1] . '">' . $val[2] . '</a><br/>' . "\n";
}



preg_match_all('/<a class="truncate_one_line play_link .* href="(.*)" itemprop="name".*>(.*)<\/a>/', $html_kongregate, $matches, PREG_SET_ORDER);
  print "<strong>Kongregate</strong><br/>\n";
foreach ($matches as $val) {
    echo '<a href="' . $val[1] . '">' . $val[2] . '</a><br/>' . "\n";
}

preg_match_all('/class="game_title"><a href="(.*?)".*?data-action="game_grid">(.*?)<\/a>/', $html_itchio, $matches, PREG_SET_ORDER);
  print "<strong>Itch.io</strong><br/>\n";
foreach ($matches as $val) {
    print '<a href="' . $val[1] . '">' . $val[2] . '</a><br/>' . "\n";
#   print "val[1]: " . $val[1] . "<br/>\n";
#   print "val[2]: " . $val[2] . "<br/>\n";
}

 
?>


<!-- My Code Ends Here -->



	</div><!-- #primary -->
</div><!-- .wrap -->

<?php get_footer();





