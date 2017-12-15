<?php


### START CUSTOM GAME TYPE ###
function create_posttype() {
  register_post_type('games', 
    array(
      'labels' => array(
        'name' => __('Games'),
        'singular_name' => __('Game'),
        'edit' => 'Edit'
      ),
      'description' => 'Games created by Levi D. Smith',
      'taxonomies' => array('post_tag'),
      'public' => true,
      'has_archive' => true,
      'rewrite' => array('slug' => 'games'),
      'supports' => array('title', 'editor', 'custom-fields', 'publicize')
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
  game_update_meta_value('_games_itchio', $post_id);

# Update GameJolt 
  game_update_meta_value('_games_gamejolt', $post_id);

# Update Microsoft Store 
  game_update_meta_value('_games_microsoftstore', $post_id);

# Update IndieDB 
  game_update_meta_value('_games_indiedb', $post_id);

# Update YouTube Playlist 
  game_update_meta_value('_games_youtube_playlist', $post_id);

# Update Google Play 
  game_update_meta_value('_games_googleplay', $post_id);

# Update Time Lapse 
  game_update_meta_value('_games_timelapse', $post_id);

# Update SoundCloud 
  game_update_meta_value('_games_soundcloud', $post_id);

# Update Unity Connect 
  game_update_meta_value('_games_unityconnect', $post_id);

# Update Ludum Dare 
  game_update_meta_value('_games_ludumdare', $post_id);

# Update MiniLD 
  game_update_meta_value('_games_minild', $post_id);

# Update Warmup 
  game_update_meta_value('_games_warmup', $post_id);

# Update GM48 
  game_update_meta_value('_games_gm48', $post_id);

# Update engine 
  game_update_meta_value('_games_engine', $post_id);

# Update thumbnail 
  game_update_meta_value('_games_thumbnail', $post_id);

# Update Kongregate 
  game_update_meta_value('_games_kongregate', $post_id);


}

function game_update_meta_value($meta_key, $post_id) {
  $new_meta_value = ( isset( $_POST[$meta_key] ) ? sanitize_text_field( $_POST[$meta_key]) : '');


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

  echo 'Itch.io';
  $meta_key = '_games_itchio';
  echo '<input type="text" name="' . $meta_key . '" id="' . $meta_key . '" value="' . get_post_meta(get_the_ID(), $meta_key, true)  . '" size="64">';
  echo '<br/>';

  echo 'GameJolt';
  $meta_key = '_games_gamejolt';
  echo '<input type="text" name="' . $meta_key . '" id="' . $meta_key . '" value="' . get_post_meta(get_the_ID(), $meta_key, true)  . '" size="64">';
  echo '<br/>';

  echo 'Microsoft';
  $meta_key = '_games_microsoftstore';
  echo '<input type="text" name="' . $meta_key . '" id="' . $meta_key . '" value="' . get_post_meta(get_the_ID(), $meta_key, true)  . '" size="64">';
  echo '<br/>';

  echo 'Kongregate';
  $meta_key = '_games_kongregate';
  echo '<input type="text" name="' . $meta_key . '" id="' . $meta_key . '" value="' . get_post_meta(get_the_ID(), $meta_key, true)  . '" size="64">';
  echo '<br/>';

  echo 'IndieDB';
  $meta_key = '_games_indiedb';
  echo '<input type="text" name="' . $meta_key . '" id="' . $meta_key . '" value="' . get_post_meta(get_the_ID(), $meta_key, true)  . '" size="64">';
  echo '<br/>';

  echo 'YouTube Playlist';
  $meta_key = '_games_youtube_playlist';
  echo '<input type="text" name="' . $meta_key . '" id="' . $meta_key . '" value="' . get_post_meta(get_the_ID(), $meta_key, true)  . '" size="64">';
  echo '<br/>';

  echo 'Google Play';
  $meta_key = '_games_googleplay';
  echo '<input type="text" name="' . $meta_key . '" id="' . $meta_key . '" value="' . get_post_meta(get_the_ID(), $meta_key, true)  . '" size="64">';
  echo '<br/>';

  echo 'Time Lapse Video';
  $meta_key = '_games_timelapse';
  echo '<input type="text" name="' . $meta_key . '" id="' . $meta_key . '" value="' . get_post_meta(get_the_ID(), $meta_key, true)  . '" size="64">';
  echo '<br/>';

  echo 'SoundCloud';
  $meta_key = '_games_soundcloud';
  echo '<input type="text" name="' . $meta_key . '" id="' . $meta_key . '" value="' . get_post_meta(get_the_ID(), $meta_key, true)  . '" size="64">';
  echo '<br/>';

  echo 'Unity Connect';
  $meta_key = '_games_unityconnect';
  echo '<input type="text" name="' . $meta_key . '" id="' . $meta_key . '" value="' . get_post_meta(get_the_ID(), $meta_key, true)  . '" size="64">';
  echo '<br/>';

  echo 'Ludum Dare Entry';
  $meta_key = '_games_ludumdare';
  echo '<input type="text" name="' . $meta_key . '" id="' . $meta_key . '" value="' . get_post_meta(get_the_ID(), $meta_key, true)  . '" size="64">';
  echo '<br/>';

  echo 'MiniLD';
  $meta_key = '_games_minild';
  echo '<input type="text" name="' . $meta_key . '" id="' . $meta_key . '" value="' . get_post_meta(get_the_ID(), $meta_key, true)  . '" size="64">';
  echo '<br/>';

  echo 'Warmup';
  $meta_key = '_games_warmup';
  echo '<input type="text" name="' . $meta_key . '" id="' . $meta_key . '" value="' . get_post_meta(get_the_ID(), $meta_key, true)  . '" size="64">';
  echo '<br/>';

  echo 'GM48 Entry';
  $meta_key = '_games_gm48';
  echo '<input type="text" name="' . $meta_key . '" id="' . $meta_key . '" value="' . get_post_meta(get_the_ID(), $meta_key, true)  . '" size="64">';
  echo '<br/>';

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

  echo 'Thumbnail ';
  $meta_key = '_games_thumbnail';
  echo '<input type="text" name="' . $meta_key . '" id="' . $meta_key . '" value="' . get_post_meta(get_the_ID(), $meta_key, true)  . '" size="64">';
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
  return array ( 
    "6502" => "6502",
    "construct" => "Construct",
    "gamemaker" => "GameMaker",
    "godot" => "Godot",
    "pico8" => "Pico-8",
    "scratch" => "Scratch",
    "sdl" => "SDL",
    "stencyl" => "Stencyl",
    "unity" => "Unity",
    "unreal" => "Unreal Engine",
    "xna_monogame" => "XNA / MonoGame"
  );
}

### END CUSTOM GAME TYPE ###


### DISPLAY GAME LINKS ###
  function display_game_links( $content ) {

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

          $meta_key = '_games_engine';
          $engine_value = get_post_meta(get_the_ID(), $meta_key, true);

          $meta_key = '_games_thumbnail';
          $engine_value = get_post_meta(get_the_ID(), $meta_key, true);

          $meta_key = '_games_kongregate';
          $kongregate_link = get_post_meta(get_the_ID(), $meta_key, true);


            $strText = "";

            #Display Itch.io link 
            if ($itch_link != "") {
              $strText .= "<a href=\"" . $itch_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_itchio.jpg\" title=\"Download on Itch.io\"></a> ";
            }

            #Display GameJolt link 
            if ($gamejolt_link != "") {
              $strText .= "<a href=\"" . $gamejolt_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_gamejolt.jpg\" title=\"Download on GameJolt\"></a> ";
            }

            #Display Microsoft Store link 
            if ($microsoftstore_link != "") {
              $strText .= "<a href=\"" . $microsoftstore_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_microsoftstore.jpg\" title=\"Download on Microsoft Store\"></a> ";
            }

            #Display Google Play link 
            if ($googleplay_link != "") {
              $strText .= "<a href=\"" . $googleplay_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_googleplay.jpg\" title=\"Download on Google Play\"></a> ";
            }

            #Display Kongregate link 
            if ($kongregate_link != "") {
              $strText .= "<a href=\"" . $kongregate_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_kongregate.jpg\" title=\"Play on Kongregate\"></a> ";
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

            #Display Time Lapse link 
            if ($timelapse_link != "") {
              $strText .= "<a href=\"" . $timelapse_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_timelapse.jpg\" title=\"Time lapse video\"></a> ";
            }

            #Display SoundCloud link 
            if ($soundcloud_link != "") {
              $strText .= "<a href=\"" . $soundcloud_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_soundcloud.jpg\" title=\"Music on SoundCloud\"></a> ";
            }

            #Display Unity Connect link 
            if ($unityconnect_link != "") {
              $strText .= "<a href=\"" . $unityconnect_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_unityconnect.jpg\" title=\"Unity Connect Page\"></a> ";
            }

            #Display Ludum Dare link 
            if ($ludumdare_link != "") {
              $strText .= "<a href=\"" . $ludumdare_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_ludumdare.jpg\" title=\"Ludum Dare Entry\"></a> ";
            }

            #Display MiniLD link 
            if ($minild_link != "") {
              $strText .= "<a href=\"" . $minild_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_minild.jpg\" title=\"Ludum Dare Entry\"></a> ";
            }

            #Display MiniLD link 
            if ($warmup_link != "") {
              $strText .= "<a href=\"" . $warmup_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_warmup.jpg\" title=\"Ludum Dare Entry\"></a> ";
            }


            #Display GM48 link 
            if ($gm48_link != "") {
              $strText .= "<a href=\"" . $gm48_link . "\"><img src=\"" .
                          get_stylesheet_directory_uri() .
                          "/assets/images/icon_gm48.jpg\" title=\"GM48 Entry\"></a> ";
            }

            #Display Engine value 
            if ($engine_value != "") {
              $engines = get_engines();
              $strText .= "<br/>Engine: " . $engines[$engine_value] . "<br/>";
            }




#        if (get_post_type(get_the_ID()) == 'games') {
#          return "game content";
          $strText .= '<div class="entry-meta"><time class="entry-date published" datetime="' . get_the_date('c') . '">' . get_the_date() . '</time></div><br/>';

          $content = $strText . '<br/>' . $content;
        }

        return $content;
  }

add_action('the_content', 'display_game_links');


### END DISPLAY GAME LINKS ###

### DISPLAY GAME TITLE ###
#  function display_game_title( $title ) {
#       if (get_post_type(get_the_ID()) == 'games') {
#         $title = "Hello: " . $title;
#       }
#    return $title;
#  }
#  add_action('the_title', 'display_game_title');

### END DISPLAY GAME TITLE ###


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

/*
function custom_game_feed($query) {
  if ($query->is_feed()) {
    $query->set('post_type', array('post', 'games'));
  }
  return $query;
}
add_filter('pre_get_posts', 'custom_game_feed');
*/

add_action('pre_get_posts', 'games_pre_posts');
function games_pre_posts($q) {
  if (is_admin() || !$q->is_main_query() || !is_home()) {
    return;
  }
  $q->set('post_type', array('post', 'games'));
#  $q->set('year', '2015');

}

#Add games to the listing of posts by tag
add_action('parse_tax_query', 'games_tax_query');
function games_tax_query($q) {
  $q->set('post_type', array('post', 'games'));
}


?>
