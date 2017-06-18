<?php

### DISPLAY GAME LINKS ###
  function display_game_links() {
        if (in_category('featured-games')) {
          $itch_link = get_post_meta(get_the_ID(), 'itchio', true);
          $gamejolt_link = get_post_meta(get_the_ID(), 'gamejolt', true);
          $indiedb_link = get_post_meta(get_the_ID(), 'indiedb', true);
          $youtube_playlist_link = get_post_meta(get_the_ID(), 'youtube_playlist', true);

          if ($itch_link != "" || $gamejolt_link != "") {
            $strText .= "";
            #Display Itch.io link 
            if ($itch_link != "") {
#              $strText .= "<a href=\"" . $itch_link . "\">Itch.io</a> ";
              $strText .= "<a href=\"" . $itch_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_itchio.jpg\" title=\"Download on Itch.io\"></a> ";
            }

            #Display GameJolt link 
            if ($gamejolt_link != "") {
#              $strText .= "<a href=\"" . $gamejolt_link . "\">GameJolt</a> ";
              $strText .= "<a href=\"" . $gamejolt_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_gamejolt.jpg\" title=\"Download on GameJolt\"></a> ";
            }

            #Display IndieDB link 
            if ($indiedb_link != "") {
              $strText .= "<a href=\"" . $indiedb_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_indiedb.jpg\" title=\"View on IndieDB\"></a> ";
            }

            #Display YouTube playlist
            if ($youtube_playlist_link != "") {
              $strText .= "<a href=\"" . $youtube_playlist_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_youtube.jpg\" title=\"View YouTube Playlist\"></a> ";
            }



          }
        }
        return $strText;
  }

### END DISPLAY GAME LINKS ###

### DISPLAY GAME METADATA ###
  function display_game_metadata() {
    $strText = "\n";
    $display_metadata = get_post_meta(get_the_ID(), 'vg_display_metadata', true);
    if (in_category('featured-games') && $display_metadata == "true") {
      $strText .= "<script type=\"application/ld+json\">{";
      $strText .= '"@context": "http://schema.org",';
      $strText .= '"@type":"VideoGame",';
      $strText .= '"name":[ { "@language":"en", "@value":"' . get_the_title() . '" }],';
      $strText .= '"description":[ { "@language":"en", "@value":"' . get_post_meta(get_the_ID(), 'vg_description', true) . '" }],';
  
      $strText .= '"genre":"' . get_post_meta(get_the_ID(), 'vg_genre', true) . '",';
      $strText .= '"url":"' . get_permalink() . '",';
      $strText .= '"image":"' . get_post_meta(get_the_ID(), 'vg_image', true) . '",';
      $strText .= '"screenshot":"' . get_post_meta(get_the_ID(), 'vg_screenshot', true) . '",';
      $strText .= '"sameAs":"' . 'https://www.youtube.com/levidsmith' . '",';
      $strText .= '"exampleOfWork": {';
      $strText .= '"@type":"' . 'VideoGame' . '",';
      $strText .= '"name":"' . get_the_title() . '",';
      $strText .= '"gamePlatform":"' . 'https://en.wikipedia.org/wiki/Microsoft_Windows' . '",';
      $strText .= '"operatingSystem":[';
      $strText .= '"https://en.wikipedia.org/wiki/Microsoft_Windows",';
      $strText .= '"https://en.wikipedia.org/wiki/MacOS",';
      $strText .= '"https://en.wikipedia.org/wiki/Linux"';
      $strText .= '],';
      $strText .= '"applicationCategory":"' . 'game' . '",';
      $strText .= '"contentRating":"' . 'ESRB Not Rated' . '",';
      $strText .= '"releasedEvent": {';
      $strText .= '"@type":"' . 'PublicationEvent' . '",';
      $strText .= '"startDate":"' . get_the_date('Y-m-d', get_the_ID()) . '",';
      $strText .= '"location": {';
      $strText .= '"@type":"' . 'Place' . '",';
      $strText .= '"name":"' . 'WW' . '"';
      $strText .= '}';
      $strText .= '}';
      $strText .= '},';
      $strText .= '"applicationCategory":"game",';
      $strText .= '"operatingSystem":"' . 'https://en.wikipedia.org/wiki/Microsoft_Windows' . '"';
      $strText .= '}</script>';
    }
    return $strText;
  }
### END DISPLAY GAME METADATA ###
?>
