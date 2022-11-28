<?php

define('WEBGAME_WIDTH_DEFAULT', '1500');
define('WEBGAME_HEIGHT_DEFAULT', '760');

### START CUSTOM GAME TYPE ###
function create_posttype() {
  register_post_type('games', 
    array(
      'labels' => array(
        'name' => __('Games'),
        'singular_name' => __('Game'),
        'edit' => 'Edit'
      ),
      'description' => 'Games created by LD Smith',
      'taxonomies' => array('category', 'post_tag'),
      'public' => true,
      'has_archive' => true,
      'rewrite' => array('slug' => 'games'),
      'supports' => array('title', 'editor', 'custom-fields', 'publicize', 'comments', 'author', 'thumbnail' )
    )
  );


}
add_action('init', 'create_posttype');


add_action('load-post.php', 'game_post_meta_boxes_setup');
add_action('load-post-new.php', 'game_post_meta_boxes_setup');

  
function game_post_meta_boxes_setup() {
  add_action('add_meta_boxes', 'game_add_post_meta_boxes');
  add_action('save_post', 'game_save_post_class_meta', 10, 2);
}

function game_add_post_meta_boxes() {
  add_meta_box (
    'game-post-class',
    esc_html__('Game Data', 'example'),
    'game_post_class_meta_box',
    'games',
    'normal',
    'high'
  );
}

function game_save_post_class_meta($post_id, $post) {
  if (!isset( $_POST['game_post_class_nonce']) || !wp_verify_nonce( $_POST['game_post_class_nonce'], basename( __FILE__ ) ) ) {
    return $post_id;
  }

  $post_type = get_post_type_object( $post->post_type );

  if (!current_user_can( $post_type->cap->edit_post, $post_id) ) {
    return $post_id;
  }

## This could be done better with an array of keys and a loop -LDS ##

# Update Itch
  game_update_text_meta_value('_games_itchio', $post_id);

# Update GameJolt 
  game_update_text_meta_value('_games_gamejolt', $post_id);

# Update Microsoft Store 
  game_update_text_meta_value('_games_microsoftstore', $post_id);

# Update IndieDB 
  game_update_text_meta_value('_games_indiedb', $post_id);

# Update YouTube Playlist 
  game_update_text_meta_value('_games_youtube_playlist', $post_id);

# Update Google Play 
  game_update_text_meta_value('_games_googleplay', $post_id);

# Update Time Lapse 
  game_update_text_meta_value('_games_timelapse', $post_id);

# Update SoundCloud 
  game_update_text_meta_value('_games_soundcloud', $post_id);

# Update Unity Connect 
  game_update_text_meta_value('_games_unityconnect', $post_id);

# Update Ludum Dare 
  game_update_text_meta_value('_games_ludumdare', $post_id);

# Update MiniLD 
  game_update_text_meta_value('_games_minild', $post_id);

# Update Warmup 
  game_update_text_meta_value('_games_warmup', $post_id);

# Update GM48 
  game_update_text_meta_value('_games_gm48', $post_id);

# Update engine 
  game_update_text_meta_value('_games_engine', $post_id);

# Update thumbnail 
  game_update_text_meta_value('_games_thumbnail', $post_id);

# Update Kongregate 
  game_update_text_meta_value('_games_kongregate', $post_id);

# Update Display Web Game 
  game_update_checkbox_meta_value('_games_displaywebgame', $post_id);
  game_update_text_meta_value('_games_displaywebgame_width', $post_id);
  game_update_text_meta_value('_games_displaywebgame_height', $post_id);

# Update blurb 
  game_update_text_meta_value('_games_blurb', $post_id);

# Update Dream Build Play 
  game_update_text_meta_value('_games_dreambuildplay', $post_id);


# VideoGame Structured Data
# Update structured enabled 
  game_update_checkbox_meta_value('_games_structured_enabled', $post_id);

# Update structured descriptoin 
  game_update_text_meta_value('_games_structured_description', $post_id);

# Update structured genre 
  game_update_text_meta_value('_games_structured_genre', $post_id);

# Update structured image 
  game_update_text_meta_value('_games_structured_image', $post_id);

# Update structured screenshot 
  game_update_text_meta_value('_games_structured_screenshot', $post_id);

# Update structured platform 
  game_update_text_meta_value('_games_structured_platform', $post_id);

# Update structured operating system 
  game_update_text_meta_value('_games_structured_operatingsystem', $post_id);

# Update structured price 
  game_update_text_meta_value('_games_structured_price', $post_id);

# Update structured trailer url 
  game_update_text_meta_value('_games_structured_trailer_url', $post_id);

# Update structured trailer date 
  game_update_text_meta_value('_games_structured_trailer_date', $post_id);

# Update small capsule image
  game_update_text_meta_value('_games_img_small_capsule', $post_id);


}


function game_update_text_meta_value($meta_key, $post_id) {
  $new_meta_value = ( isset( $_POST[$meta_key] ) ? sanitize_text_field( $_POST[$meta_key]) : '');
  game_update_meta_value($meta_key, $post_id, $new_meta_value);
}

function game_update_checkbox_meta_value($meta_key, $post_id) {
  $new_meta_value = 'false';
  if (isset($_POST[$meta_key])) {
    $new_meta_value = 'true';
  }
  game_update_meta_value($meta_key, $post_id, $new_meta_value);

}

function game_update_meta_value($meta_key, $post_id, $new_meta_value) {


  $meta_value = get_post_meta($post_id, $meta_key, true);

  if ($new_meta_value && '' == $meta_value) {
    add_post_meta($post_id, $meta_key, $new_meta_value, true);
  } elseif ($new_meta_value && $new_meta_value != $meta_value) {
    update_post_meta($post_id, $meta_key, $new_meta_value);

  } elseif ('' == $new_meta_value && $meta_value) {
    delete_post_meta($post_id, $meta_key, $meta_value);
  } 


}

function game_post_class_meta_box( $post ) {
  wp_nonce_field( basename( __FILE__ ), 'game_post_class_nonce' );

  create_text_meta_field('Itch.io', '_games_itchio');
  create_text_meta_field('GameJolt', '_games_gamejolt');
  create_text_meta_field('Microsoft', '_games_microsoftstore');
  create_text_meta_field('Kongregate', '_games_kongregate');
  create_text_meta_field('IndieDB', '_games_indiedb');
  create_text_meta_field('YouTube Playlist', '_games_youtube_playlist');
  create_text_meta_field('Google Play', '_games_googleplay');
  create_text_meta_field('Time Lapse Video', '_games_timelapse');
  create_text_meta_field('SoundCloud', '_games_soundcloud');
  create_text_meta_field('Unity Connect', '_games_unityconnect');
  create_text_meta_field('Ludum Dare Entry', '_games_ludumdare');
  create_text_meta_field('MiniLD', '_games_minild');
  create_text_meta_field('Warmup', '_games_warmup');
  create_text_meta_field('GM48 Entry', '_games_gm48');

  $meta_key = '_games_engine';
  echo 'Engine';
  $engine = get_post_meta(get_the_ID(), $meta_key, true);
  echo '<select name="' . $meta_key . '" id="' . $meta_key . '">';
  echo '  <option></option>';
  $engines = get_engines();

  foreach ($engines as $key => $value) {
    display_option($value, $key, $engine);

  }

  echo '</select>';
  echo '<br/>';

  create_text_meta_field('Thumbnail (256x144 pixels)', '_games_thumbnail');


  create_checkbox_meta_field('Display Web Game (game files must be in /web-games/' . $post->post_name . ') ', '_games_displaywebgame');

  create_text_meta_field('Web Game width (default ' . constant('WEBGAME_WIDTH_DEFAULT') . ')', '_games_displaywebgame_width');
  create_text_meta_field('Web Game height (default ' . constant('WEBGAME_HEIGHT_DEFAULT') . ')', '_games_displaywebgame_height');

  create_text_meta_field('Blurb', '_games_blurb');
  create_text_meta_field('Dream Build Play', '_games_dreambuildplay');


  echo '&nbsp;<br/>&nbsp;<br/>';
  echo '<strong>VideoGame Structured Data (https://schema.org/VideoGame)</strong><br/>';
  echo '<strong>Product Structured Data (http://schema.org/Product)</strong><br/>';

  create_checkbox_meta_field('Structured Data - enabled', '_games_structured_enabled');

  create_text_meta_field('Structured Data - description (500 characters or less)', '_games_structured_description');

  create_text_meta_field('Structured Data - genre', '_games_structured_genre');

  create_text_meta_field('Structured Data - image (cover image?)', '_games_structured_image');

  create_text_meta_field('Structured Data - screenshot', '_games_structured_screenshot');
  create_text_meta_field('Structured Data - platform', '_games_structured_platform');
  create_text_meta_field('Structured Data - operating system', '_games_structured_operatingsystem');
  create_text_meta_field('Structured Data - price (USD)', '_games_structured_price');
  create_text_meta_field('Structured Data - trailer url', '_games_structured_trailer_url');
  create_text_meta_field('Structured Data - trailer date', '_games_structured_trailer_date');

  echo '&nbsp;<br/>&nbsp;<br/>';
  echo '<strong>Steam Style Images</strong><br/>';

  create_text_meta_field('Image Small Capsule (231x87)', '_games_img_small_capsule');
  display_img_meta_field('_games_img_small_capsule');

}

function create_text_meta_field($label, $meta_key) {
  echo $label; 

  echo '<input type="text" name="' . $meta_key . '" id="' . $meta_key . '" value="' . get_post_meta(get_the_ID(), $meta_key, true)  . '" size="64">';
  echo '<br/>';


}

function display_img_meta_field($meta_key) {
  $img_url = get_post_meta(get_the_ID(), $meta_key, true);
  if ($img_url != '') {
  echo '<img src="' . $img_url . '"/>';
  } else {
    echo 'No image';
  }
  echo '<br/>';



}


function create_checkbox_meta_field($label, $meta_key) {
  echo $label; 

  echo '<input type="checkbox" name="' . $meta_key . '" id="' . $meta_key . '"';
  if (get_post_meta(get_the_ID(), $meta_key, true) == 'true') {
    echo ' checked';
  }  
  echo '>';
  echo '<br/>';
}

function display_option($strDisplay, $strValue, $strCurrent) {
  echo '  <option value="' . $strValue . '"'; 
  if ($strCurrent == $strValue) {
    echo ' selected';
  }
  echo '>' . $strDisplay . '</option>';

}

function get_engines() {
  $array = [];
  $strFileContents = file_get_contents("json/engines.json", TRUE);
  $objJSON = json_decode($strFileContents);

#  var_dump($objJSON);

#  echo "Key";
#  echo $objJSON->engine[0]->key;
#  echo "Description";
#  echo $objJSON->engine[0]->description;
  
  $array["foo"] = "bar";
#  $array[$objJSON["engine"]["key"]] = $objJSON["engine"]["description"];

#  foreach ($objJSON["engine"] as $engine) {
  foreach ($objJSON->engine as $engine) {
#    echo "foo";
#    echo $engine["key"] . ": " . $engine["description"];
#    $array[$engine["key"]] = $engine["description"];
#    echo $engine->key . " | " . $engine->description;
    $array[$engine->key] = $engine->description;
  }
  

  return $array;
#  return array ( 
#    "6502" => "6502",
#    "construct" => "Construct",
#    "gamemaker" => "GameMaker",
#    "godot" => "Godot",
#    "pico8" => "Pico-8",
#    "projectspark" => "Project Spark",
#    "scratch" => "Scratch",
#    "sdl" => "SDL",
#    "stencyl" => "Stencyl",
#    "unity" => "Unity",
#    "unreal" => "Unreal Engine",
#    "xna_monogame" => "XNA / MonoGame"
#  );
}

### END CUSTOM GAME TYPE ###

### START GAME STRUCTURED DATA ###
function get_game_structured_data() {
  $strText = '';


  $structured_title = get_the_title();

  $meta_key = '_games_structured_enabled';
  $structured_enabled = get_post_meta(get_the_ID(), $meta_key, true);

  $meta_key = '_games_structured_description';
  $structured_description = get_post_meta(get_the_ID(), $meta_key, true);

  $meta_key = '_games_structured_genre';
  $structured_genre = get_post_meta(get_the_ID(), $meta_key, true);

  $meta_key = '_games_structured_image';
  $structured_image = get_post_meta(get_the_ID(), $meta_key, true);

  $meta_key = '_games_structured_screenshot';
  $structured_screenshot = get_post_meta(get_the_ID(), $meta_key, true);

  $structured_org_name = 'LD Smith Games';
  $structured_org_url = 'https://levidsmith.com';

  $meta_key = '_games_indiedb';
  $indiedb_link = get_post_meta(get_the_ID(), $meta_key, true);

  $meta_key = '_games_structured_platform';
  $structured_platform = get_post_meta(get_the_ID(), $meta_key, true);

  $meta_key = '_games_structured_operatingsystem';
  $structured_operatingsystem = get_post_meta(get_the_ID(), $meta_key, true);

  $meta_key = '_games_structured_price';
  $structured_price = get_post_meta(get_the_ID(), $meta_key, true);


  $structured_rating_count = 1;
  $structured_rating_value = 5;
  $structured_rating_best = 5;
  $structured_rating_worst = 1;


  $structured_releasedate = get_the_date('Y-m-d', get_the_ID()); 

  $structured_contentrating = 'Not Rated';

  $meta_key = '_games_structured_trailer_url';
  $structured_trailer_url = get_post_meta(get_the_ID(), $meta_key, true);

  $meta_key = '_games_structured_trailer_date';
  $structured_trailer_date = get_post_meta(get_the_ID(), $meta_key, true);


  if ($structured_enabled == 'true') {

  $strText .= '<script type="application/ld+json">';
  $strText .= '{  ';
  $strText .= '  "@context": "http://schema.org",';
  $strText .= '  "@type":"VideoGame",';
  $strText .= '  "name":[';
  $strText .= '    {';
  $strText .= '      "@language":"en",';
  $strText .= '      "@value":"' . $structured_title . '"';
  $strText .= '    }';
  $strText .= '  ],';
  $strText .= '  "description":[';
  $strText .= '    {';
  $strText .= '      "@language":"en",';
  $strText .= '      "@value":"' . $structured_description . '"';
  $strText .= '    }';
  $strText .= '  ],';
  $strText .= '  "genre":[';
  $strText .= '    "' . $structured_genre . '"';
  $strText .= '  ],';
  $strText .= '  "url":"' . get_permalink() . '",';
  $strText .= '  "image":"' . $structured_image . '",';
  $strText .= '  "screenshot":"' . $structured_screenshot . '",';
  $strText .= '  "author":{';
  $strText .= '    "@type":"Organization",';
  $strText .= '    "name":"' . $structured_org_name . '",';
  $strText .= '    "url":"' . $structured_org_url . '"';
  $strText .= '  },';
  $strText .= '  "sameAs": [';
  if ($indiedb_link != '') {
    $strText .= '    "' . $indiedb_link . '"';
  }
  $strText .= '  ],';
  $strText .= '  "trailer":{';
  $strText .= '    "@type":"VideoObject",';
  $strText .= '    "name":"' . $structured_title . ' Trailer",';
  $strText .= '    "url":"' . $structured_trailer_url . '",';
  $strText .= '    "description":"' . $structured_title . ' Trailer",';
  $strText .= '    "uploadDate":"' . $structured_trailer_date . '",';
  $strText .= '    "thumbnailUrl":"' . $structured_image . '",';
  $strText .= '    "inLanguage":"en"';
  $strText .= '  },';
  $strText .= '  "exampleOfWork":[';
  $strText .= '    {';
  $strText .= '      "@type":"VideoGame",';
  $strText .= '      "name":"' . $structured_title . '",';
  $strText .= '      "gamePlatform":"' . $structured_platform . '",';
  $strText .= '      "operatingSystem":"' . $structured_operatingsystem . '",';
  $strText .= '      "contentRating":"' . $structured_contentrating . '",';
  $strText .= '      "aggregateRating": {';
  $strText .= '        "@type":"AggregateRating",';
  $strText .= '        "name":"rating",';
  $strText .= '        "ratingValue":"' . $structured_rating_value . '",';
  $strText .= '        "reviewCount":"' . $structured_rating_count . '"';
  $strText .= '      },';
  $strText .= '      "applicationCategory":"game",';
  $strText .= '      "offers": {';
  $strText .= '        "@type":"Offer",';
  $strText .= '        "price":"' . $structured_price . '",';
  $strText .= '        "priceCurrency":"USD"';
  $strText .= '      },';
  $strText .= '      "releasedEvent":{';
  $strText .= '        "@type":"PublicationEvent",';
  $strText .= '        "startDate":"' . $structured_releasedate . '",';
  $strText .= '        "location":{';
  $strText .= '          "@type":"Place",';
  $strText .= '          "name":"NA"';
  $strText .= '        }';
  $strText .= '      }';
  $strText .= '    }';
  $strText .= '  ],';
  $strText .= '  "aggregateRating": {';
  $strText .= '        "@type":"AggregateRating",';
  $strText .= '        "name":"rating",';
  $strText .= '        "ratingValue":"' . $structured_rating_value . '",';
  $strText .= '        "reviewCount":"' . $structured_rating_count . '"';
  $strText .= '  },';
  $strText .= '   "operatingSystem":"' . $structured_operatingsystem . '"';
  $strText .= '}';
  $strText .= '</script>';



# Start product type
  $strText .= '<script type="application/ld+json">';
  $strText .= '{  ';
  $strText .= '  "@context": "http://schema.org",';
  $strText .= '  "@type":"Product",';
  $strText .= '  "name":"' . $structured_title . '",';
  $strText .= '  "url":"' . get_permalink() . '",';
  $strText .= '  "description":"' . $structured_description . '",';
  $strText .= '  "image":"' . $structured_image . '",';
  $strText .= '  "aggregateRating": {';
  $strText .= '        "@type":"AggregateRating",';
  $strText .= '        "ratingValue":"' . $structured_rating_value . '",';
  $strText .= '        "ratingCount":"' . $structured_rating_count . '",';
  $strText .= '        "bestRating":"' . $structured_rating_best . '",';
  $strText .= '        "worstRating":"' . $structured_rating_worst . '"';
  $strText .= '  }';
  $strText .= '}';
  $strText .= '</script>';

  }


  return $strText;

}
### END GAME STRUCTURED DATA ###

### DISPLAY GAME LINKS ###
  function display_game_links() {
#       $strText .= '<div>';

       if (get_post_type(get_the_ID()) == 'games') {

          $meta_key = '_games_itchio';
          $itch_link = get_post_meta(get_the_ID(), $meta_key, true);

          $meta_key = '_games_gamejolt';
          $gamejolt_link = get_post_meta(get_the_ID(), $meta_key, true);

          $meta_key = '_games_microsoftstore';
          $microsoftstore_link = get_post_meta(get_the_ID(), $meta_key, true);

          $meta_key = '_games_googleplay';
          $googleplay_link = get_post_meta(get_the_ID(), $meta_key, true);

          $meta_key = '_games_indiedb';
          $indiedb_link = get_post_meta(get_the_ID(), $meta_key, true);

          $meta_key = '_games_youtube_playlist';
          $youtube_playlist_link = get_post_meta(get_the_ID(), $meta_key, true);

          $meta_key = '_games_ludumdare';
          $ludumdare_link = get_post_meta(get_the_ID(), $meta_key, true);

          $meta_key = '_games_minild';
          $minild_link = get_post_meta(get_the_ID(), $meta_key, true);

          $meta_key = '_games_warmup';
          $warmup_link = get_post_meta(get_the_ID(), $meta_key, true);

          $meta_key = '_games_gm48';
          $gm48_link = get_post_meta(get_the_ID(), $meta_key, true);

          $meta_key = '_games_timelapse';
          $timelapse_link = get_post_meta(get_the_ID(), $meta_key, true);

          $meta_key = '_games_soundcloud';
          $soundcloud_link = get_post_meta(get_the_ID(), $meta_key, true);

          $meta_key = '_games_unityconnect';
          $unityconnect_link = get_post_meta(get_the_ID(), $meta_key, true);


          $meta_key = '_games_thumbnail';
          $thumbnail_value = get_post_meta(get_the_ID(), $meta_key, true);

          $meta_key = '_games_kongregate';
          $kongregate_link = get_post_meta(get_the_ID(), $meta_key, true);

          $meta_key = '_games_dreambuildplay';
          $dreambuildplay_link = get_post_meta(get_the_ID(), $meta_key, true);


            $strText = "&nbsp;<br/>";

            #Display Itch.io link 
            if ($itch_link != "") {
              $strText .= "<a href=\"" . $itch_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_download_64x64.png\" title=\"Download on Itch.io\"></a> ";
            }

            #Display GameJolt link 
            if ($gamejolt_link != "") {
              $strText .= "<a href=\"" . $gamejolt_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_download_64x64.png\" title=\"Download on GameJolt\"></a> ";
            }

            #Display Microsoft Store link 
            if ($microsoftstore_link != "") {
              $strText .= "<a href=\"" . $microsoftstore_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_download_64x64.png\" title=\"Download on Microsoft Store\"></a> ";
            }

            #Display Google Play link 
            if ($googleplay_link != "") {
              $strText .= "<a href=\"" . $googleplay_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_mobile_64x64.png\" title=\"Download on mobile\"></a> ";
            }

            #Display Kongregate link 
            if ($kongregate_link != "") {
              $strText .= "<a href=\"" . $kongregate_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_online_64x64.png\" title=\"Play on Kongregate\"></a> ";
            }


            #Display IndieDB link 
            if ($indiedb_link != "") {
              $strText .= "<a href=\"" . $indiedb_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_promotion_64x64.png\" title=\"Promotion\"></a> ";
            }

            #Display YouTube playlist
            if ($youtube_playlist_link != "") {
              $strText .= "<a href=\"" . $youtube_playlist_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_video_64x64.png\" title=\"View video playlist\"></a> ";
            }

            #Display Time Lapse link 
            if ($timelapse_link != "") {
              $strText .= "<a href=\"" . $timelapse_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_timelapse_64x64.png\" title=\"Time lapse video\"></a> ";
            }

            #Display SoundCloud link 
            if ($soundcloud_link != "") {
              $strText .= "<a href=\"" . $soundcloud_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_music_64x64.png\" title=\"Music soundtrack\"></a> ";
            }

/*
            #Display Unity Connect link 
            if ($unityconnect_link != "") {
              $strText .= "<a href=\"" . $unityconnect_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_promotion_64x64.png\" title=\"Unity Connect Page\"></a> ";
            }
*/
/*

            #Display Ludum Dare link 
            if ($ludumdare_link != "") {
              $strText .= "<a href=\"" . $ludumdare_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_jam_64x64.png\" title=\"Game jam entry\"></a> ";
            }

            #Display MiniLD link 
            if ($minild_link != "") {
              $strText .= "<a href=\"" . $minild_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_jam_64x64.png\" title=\"Game jam entry\"></a> ";
            }

            #Display MiniLD link 
            if ($warmup_link != "") {
              $strText .= "<a href=\"" . $warmup_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_jam_64x64.png\" title=\"Game jam entry\"></a> ";
            }


            #Display GM48 link 
            if ($gm48_link != "") {
              $strText .= "<a href=\"" . $gm48_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_jam_64x64.png\" title=\"Game jam Entry\"></a> ";
            }
*/

            #Display Dream Build Play link 
/*
            if ($dreambuildplay_link != "") {
              $strText .= "<a href=\"" . $dreambuildplay_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_jam_64x64.png\" title=\"Dream Build Play Page\"></a> ";
            }

*/
    }

    return $strText;
  }



### END DISPLAY GAME LINKS ###


### START DISPLAY GAME APPENDIX ###
  function display_game_appendix() {
       $strText = "";
       $game_id = get_the_ID();

       if (isset($game_id) && get_post_type(get_the_ID()) == 'games') {

/*
          $strText .= 'Created by <span class="author vcard"><a class="url fn n" href="https://levidsmith.com/author/levidsmith/">LD Smith</a></span><br/>';
*/
          $strText .= 'Released <time class="entry-date published" datetime="' . get_the_time('c', $game_id) . '">' . get_the_time('F j, Y', $game_id) . '</time>';
          $strText .= '<time class="updated" datetime="' . get_the_time('c', $game_id) . '">' . get_the_time('F j, Y', $game_id) . '</time>';


          $meta_key = '_games_engine';
          $engine_value = get_post_meta(get_the_ID(), $meta_key, true);

            #Display Engine value 
/*
            if ($engine_value != "") {
              $engines = get_engines();
              $strText .= "<br/>Built with: " . $engines[$engine_value] . "<br/>";
            }
*/

       }



       return $strText;
  }


### END DISPLAY GAME APPENDIX ###


### START FIX HENTRY ###
function fix_hentry() {

}
### END FIX HENTRY ###


add_action('pre_get_posts', 'games_pre_posts');
function games_pre_posts($q) {
  if (is_admin() || !$q->is_main_query() || !is_home()) {
    return;
  }
  $q->set('post_type', array('post', 'games'));

  exclude_tag($q); #remove wrestling podcast posts
#  add_custom_types_to_tax($q);
}

#add_filter('pre_get_posts', 'exclude_tag');
function exclude_tag($q) {
  if (is_admin() || !$q->is_main_query() || !$q->is_home()) {
    return;
  }
    $query_args = array('tag__not_in' => array(1));
    $q->set('tag__not_in', array(99));  #remove wrestling podcasts from main query, without completely deleting them


}

#Add games to the listing of posts by tag
function add_custom_types_to_tax($q) {
  if (is_category() || is_tag() ) {
    $q->set('post_type', array('post', 'games'));
    return $q;
  }
}
add_filter('pre_get_posts', 'add_custom_types_to_tax');




function get_featured_game_blurbs() {

  if (!is_home()) {
    return;
  }

  echo '<div class="featured_games">';
  echo 'Random Web Games<br/>';

  global $wpdb;
  $result = $wpdb->get_results("SELECT DISTINCT post_id FROM wp_postmeta, wp_posts WHERE wp_postmeta.post_id = wp_posts.id AND post_status = 'publish' AND meta_key = '_games_displaywebgame' and meta_value = 'true' AND post_id NOT IN (3435, 5391) ORDER BY RAND() LIMIT 3");
#  $result = $wpdb->get_results("SELECT DISTINCT post_id FROM wp_postmeta WHERE meta_key = '_games_displaywebgame' and meta_value = 'true' and post_id NOT IN (3435, 5391) ORDER BY RAND() LIMIT 3");
#  $result = $wpdb->get_results("SELECT DISTINCT post_id FROM wp_postmeta WHERE meta_key = '_games_displaywebgame' and meta_value = 'true' ORDER BY post_id");
  foreach ( $result as $row) {
#   echo $row->post_id . ", ";
    display_game_thumbnail($row->post_id);
  }
//  echo '<h2>Recently Updated</h2>';

//#  echo 'Recently Updated<br/>';

//  display_game_thumbnail(4252);
//  display_game_thumbnail(2827);
//  display_game_thumbnail(6313);
  echo '</div>';

//  echo '<h2>XBox One Games</h2>';
  echo '<div class="featured_games">';
  echo 'Featured Games<br/>';
  display_game_thumbnail(3435);
  display_game_thumbnail(5391);
  echo '</div>';


}


function display_embed_game() {
  if (in_the_loop()) {
    $meta_key = '_games_displaywebgame';
    $displaywebgame = get_post_meta(get_the_ID(), $meta_key, true);
    $webgame_width =  get_post_meta(get_the_ID(), "_games_displaywebgame_width", true);
    if ($webgame_width == null) {
      $webgame_width = constant('WEBGAME_WIDTH_DEFAULT');
    }
    $webgame_height =  get_post_meta(get_the_ID(), "_games_displaywebgame_height", true);
    if ($webgame_height == null) {
      $webgame_height = constant('WEBGAME_HEIGHT_DEFAULT');
    }

#      echo 'wp_is_mobile(): ' . (int) wp_is_mobile();

    if (!wp_is_mobile() && !is_home() && !is_feed() && $displaywebgame == 'true') {
      $game_identifier = get_post(get_the_ID())->post_name;


      echo '<!-- LDS - START - Embed Unity WebGL game using iframe -->' . "\n";
      echo '<div>';
      echo '<iframe src="https://levidsmith.com/web-games/' . $game_identifier . '" width="' . $webgame_width . '" height="' . $webgame_height . '" frameborder="0" allowfullscreen="allowfullscreen">';
      echo '</iframe>';
      echo '</div>';
      echo '<!-- LDS - END - Embed Unity WebGL game using iframe -->' . "\n";
    }
  }

/*
  $strText = '' . "\n";

  $meta_key = '_games_displaywebgame';
  $displaywebgame = get_post_meta(get_the_ID(), $meta_key, true);
  $webgame_width =  get_post_meta(get_the_ID(), "_games_displaywebgame_width", true);
  if ($webgame_width == null) {
    $webgame_width = constant('WEBGAME_WIDTH_DEFAULT');
  }
  $webgame_height =  get_post_meta(get_the_ID(), "_games_displaywebgame_height", true);
  if ($webgame_height == null) {
    $webgame_height = constant('WEBGAME_HEIGHT_DEFAULT');
  }

  if (!wp_is_mobile() && !is_home() && $displaywebgame == 'true') {
  $game_identifier = get_post(get_the_ID())->post_name;

  $strText .= '<!-- LDS - START - Embed Unity WebGL game using iframe -->' . "\n";
  $strText .= '<div>';
  $strText .= '<iframe src="https://levidsmith.com/web-games/' . $game_identifier . '" width="' . $webgame_width . '" height="' . $webgame_height . '" frameborder="0" allowfullscreen="allowfullscreen">';
  $strText .= '</iframe>';
  $strText .= '</div>';
  $strText .= '<!-- LDS - END - Embed Unity WebGL game using iframe -->' . "\n";


  } else {
#    $strText .= 'Do not display web game';
  }
  
  return $strText;
*/

}

function display_leaderboard() {
  if (in_the_loop()) {
    if (!wp_is_mobile() && !is_home() && !is_feed() && (get_post_type(get_the_ID()) == 'games')) {
      $game_id = get_the_ID();

  echo '<!-- Start Game Leaderboard -->';
  echo '<p id="leaderboard_display"></p>';
    $leaderboard_script = file_get_contents('blog/wp-content/themes/twentyseventeen-child/leaderboard_script.html');
//    $leaderboard_script = file_get_contents('leaderboard_script.html');
  $leaderboard_script = str_replace('<LEADERBOARD_JSON>', 'https://levidsmith.com/scores/TopScoresAllJSON.php?game=' . $game_id, $leaderboard_script);
  echo $leaderboard_script;
//   echo getcwd();
  echo '<!-- End Game Leaderboard -->';

/*
      echo '<!-- LDS - START - leaderboard embed iframe -->' . "\n";
      echo '<div>';
      echo 'leaderboard ' . $game_identifier . '<br/>';
      echo '<iframe src="https://levidsmith.com/scores/TopScoresAllJSON.php?game=' . $game_id . '" width="600" height="400" frameborder="1">';
      echo '</iframe>';
      echo '</div>';
      echo '<!-- LDS - END - leaderboard embed iframe -->' . "\n";
*/

    }
  }
}


function display_content_pane() {
  $strContent = '';

  if (in_the_loop() && !wp_is_mobile() && !is_home() && (get_post_type(get_the_ID()) == 'games')) {
    require 'game_content.php';

    echo '<a id="music">Music</a>';
    echo  '<div id="game_content">Game Content</div>';
  }

  return $strContent;
}




function add_custom_game_content($content) {

#For some reason this messes up oembed links on the first or last line, so you just have to put those in the [embed][/embed] tags

  if ( is_main_query()) {

    display_play_online_link();
    display_embed_game();
    display_leaderboard();
/*    display_content_pane(); */

//    $content = get_game_structured_data() . '<br/>' . display_embed_game() . '<br/>' . $content . '<div style="clear: both;"></div>' . display_game_links() . '<br/>' . display_game_appendix(); 
    $content = get_game_structured_data() . '<br/>' . $content . '<div style="clear: both;"></div>' . display_game_links() . '<br/>' . display_game_appendix(); 
#    $content .= "Post ID: " . get_the_ID() . "end";
  } 

  display_game_links();
  return $content;
}
add_filter('the_content', 'add_custom_game_content', 5);

function display_play_online_link() {
    if (is_front_page() && get_post_type(get_the_ID()) == 'games') {
      $meta_key = '_games_displaywebgame';
      $displaywebgame = get_post_meta(get_the_ID(), $meta_key, true);
      if ($displaywebgame == 'true') {
        echo '<a href="' . get_the_permalink() . '">Play online</a>' . '<br/>';
      }
    }


}

function display_game_thumbnail($game_id) {

    $post = get_post($game_id);

    $game_name = get_the_title($game_id);
    $game_url = get_the_permalink($game_id);
    $game_img = $post->_games_thumbnail;
    $game_blurb = $post->_games_blurb;
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


  }


function my_post_image_html($html, $post_id, $post_image_id) {
  if (is_category() || is_tag() || is_single()) {
    return '';
  } else {
    return $html;
  }
}
add_filter('post_thumbnail_html', 'my_post_image_html', 10, 3);

function myfeed_request($qv) {
  if ( isset( $qv['feed'] ) ) {
    $qv['post_type'] = get_post_types();
  }
  return $qv;
/*
  if(isset($qv['feed']) && !isset($qv['post_type'])) {
    $qv['post_type'] = array('post', 'games');
    return $qv;
  }
*/
}
add_filter('request', 'myfeed_request');

// remove the SVG icon garbage from the parent theme
add_action('init', function() {
  remove_action( 'wp_footer', 'twentyseventeen_include_svg_icons', 9999 );
  add_action('wp_footer', 'twentyseventeen_include_svg_icons_child', 9999 );
  }
);


function twentyseventeen_include_svg_icons_child() {
  require 'assets/images/svg-icons_child.svg';
}



//Add games content type to Jetpack
function jeherve_add_cpt_sitemaps( $post_types ) {
    $post_types[] = 'games';
    return $post_types;
}
add_filter( 'jetpack_sitemap_post_types', 'jeherve_add_cpt_sitemaps' );

add_filter( 'jetpack_sitemap_post_types', 'games_jetpack_sitemap_post_types' ); 
 
function games_jetpack_sitemap_post_types( $post_types ) {
    $post_types[] = 'games';
    return $post_types; 
}



?>
