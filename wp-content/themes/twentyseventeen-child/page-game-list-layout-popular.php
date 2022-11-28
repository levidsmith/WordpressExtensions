<?php


#  echo "Display popular list";


### Display games by views ###
function get_rank_json($myposts) {
  $json = '';
  $ranked_games_array = array();
  
  $game_ids = '';
  $game_count = 0;



  $json .= '{' . "\n"; 
  $json .= '  "games": [' . "\n"; 




  foreach( $myposts as $thepost) : setup_postdata( $thepost); 


    if ($game_ids != '') {
    $game_ids .= ',';
    }
    $game_ids .= $thepost->ID;
    $game_count += 1; 

    $ranked_games_array[$thepost->ID]['post_title'] = $thepost->post_title;
    $ranked_games_array[$thepost->ID]['post_permalink'] = get_permalink($thepost);
  endforeach;

    if (function_exists('stats_get_csv')) {

      #All Time Views
      $current_rank = 1;
      $current_views = -1;

      $response = stats_get_csv('postviews', array('post_id' => $game_ids, 'days' => -1, 'limit' => $game_count));
      foreach ($response as &$response_entry) {
        $ranked_games_array[$response_entry['post_id']]['alltime'] = $response_entry['views'];
        if ($current_views == -1) {
          $current_views = $response_entry['views'];
        } elseif  ($response_entry['views'] < $current_views) {
          $current_views = $response_entry['views'];
          $current_rank += 1;
        }
        $ranked_games_array[$response_entry['post_id']]['alltime_rank'] = $current_rank;
        
      }
      #Set the rank for games wilth null (zero) views
      foreach (explode(',', $game_ids) as $id) {
        if (is_null($ranked_games_array[$id]['alltime_rank'])) {
          $ranked_games_array[$id]['alltime_rank'] = $current_rank + 1;
        }
      }



      #Year Views
      $current_rank = 1;
      $current_views = -1;


      $response = stats_get_csv('postviews', array('post_id' => $game_ids, 'days' => 365, 'limit' => $game_count));
      foreach ($response as &$response_entry) {
        $ranked_games_array[$response_entry['post_id']]['year'] = $response_entry['views'];
        if ($current_views == -1) {
          $current_views = $response_entry['views'];
        } elseif  ($response_entry['views'] < $current_views) {
          $current_views = $response_entry['views'];
          $current_rank += 1;
        }
        $ranked_games_array[$response_entry['post_id']]['year_rank'] = $current_rank;
        
      }
      #Set the rank for games with null (zero) views
      foreach (explode(',', $game_ids) as $id) {
        if (is_null($ranked_games_array[$id]['year_rank'])) {
          $ranked_games_array[$id]['year_rank'] = $current_rank + 1;
        }
      }



      #Month Views
      $current_rank = 1;
      $current_views = -1;

      $response = stats_get_csv('postviews', array('post_id' => $game_ids, 'days' => 30, 'limit' => $game_count));
      foreach ($response as &$response_entry) {
        $ranked_games_array[$response_entry['post_id']]['month'] = $response_entry['views'];
        if ($current_views == -1) {
          $current_views = $response_entry['views'];
        } elseif  ($response_entry['views'] < $current_views) {
          $current_views = $response_entry['views'];
          $current_rank += 1;
        }
        $ranked_games_array[$response_entry['post_id']]['month_rank'] = $current_rank;
        
      }
      #Set the rank for games wilth null (zero) views
      foreach (explode(',', $game_ids) as $id) {
        if (is_null($ranked_games_array[$id]['month_rank'])) {
          $ranked_games_array[$id]['month_rank'] = $current_rank + 1;
        }
      }



      #Week Views
      $current_rank = 1;
      $current_views = -1;

      $response = stats_get_csv('postviews', array('post_id' => $game_ids, 'days' => 7, 'limit' => $game_count));
      foreach ($response as &$response_entry) {
        $ranked_games_array[$response_entry['post_id']]['week'] = $response_entry['views'];
        if ($current_views == -1) {
          $current_views = $response_entry['views'];
        } elseif  ($response_entry['views'] < $current_views) {
          $current_views = $response_entry['views'];
          $current_rank += 1;
        }
        $ranked_games_array[$response_entry['post_id']]['week_rank'] = $current_rank;
      }
      #Set the rank for games wilth null (zero) views
      foreach (explode(',', $game_ids) as $id) {
        if (is_null($ranked_games_array[$id]['week_rank'])) {
          $ranked_games_array[$id]['week_rank'] = $current_rank + 1;
        }
      }


  }

  foreach ($ranked_games_array as $game) {

    $json .= '    {' . "\n"; 
    $json .= '      "name": "' . $game['post_title'] . '",' . "\n"; 
    $json .= '      "link": "' . $game['post_permalink'] . '",' . "\n";  
    $json .= '      "7days_rank": ' . $game['week_rank'] . ',' . "\n";  
    $json .= '      "30days_rank": ' . $game['month_rank'] . ',' . "\n";  
    $json .= '      "365days_rank": ' . $game['year_rank'] . ',' . "\n";  
    $json .= '      "alltime_rank": ' . $game['alltime_rank'] . '' . "\n";  
    $json .= '    }' . "\n"; 
    if ($game != end($ranked_games_array)) {
      $json .= ','; 
    }
  }


  $json .= '  ]' . "\n"; 
  $json .= '}' . "\n"; 

  return $json;

}



#function display_layout_popular($json_rank_stats) {
function display_layout_popular($myposts) {
  
#  echo "Display Popular Layout";


  $json_rank_stats = get_rank_json($myposts);
  $json = json_decode($json_rank_stats, true);

  $ranked_games_array = $json['games'];

    if ($_GET['order'] == '7days') {
      usort($ranked_games_array, function($a, $b) {
          return $a['7days_rank'] - $b['7days_rank'];
      });
    }

    if ($_GET['order'] == '30days') {
      usort($ranked_games_array, function($a, $b) {
        return $a['30days_rank'] - $b['30days_rank'];
      });
    }

    if ($_GET['order'] == '365days') {
      usort($ranked_games_array, function($a, $b) {
        return $a['365days_rank'] - $b['365days_rank'];
      });
    }

    if ($_GET['order'] == 'alltime') {
      usort($ranked_games_array, function($a, $b) {
        return $a['alltime_rank'] - $b['alltime_rank'];
      });
    }

  echo '<table class="popularity_table">';

    #Table Headers
    echo '<tr class="popularity_row">';
    echo '<td class="popularity_title">&nbsp;</td>';
    echo '<td class="popularity_rank"><a href="?layout=popular&order=7days">7 Days</a></td>';
    echo '<td class="popularity_rank"><a href="?layout=popular&order=30days">30 Days</a></td>';
    echo '<td class="popularity_rank"><a href="?layout=popular&order=365days">365 Days</a></td>';
    echo '<td class="popularity_rank"><a href="?layout=popular&order=alltime">All Time</a></td>';
    echo '</tr>';
  
    #Table data
    $num_row = 0;
    foreach ($ranked_games_array as $key => $value) {
        if ($num_row % 2 == 0) {
          $row_style = 'odd_row';
        } else {
          $row_style = 'even_row';
        }

        echo '<tr class="popularity_row">';
        echo '<td class="popularity_title"><span class="game_list"><a href="' . $value['link'] . '">' . $value['name'] . '</a></span></td>';
        echo '<td class="popularity_rank">' . $value['7days_rank'] . '</td>';
        echo '<td class="popularity_rank">' . $value['30days_rank'] . '</td>';
        echo '<td class="popularity_rank">' . $value['365days_rank'] . '</td>';
        echo '<td class="popularity_rank">' . $value['alltime_rank'] . '</td>';


        echo '</tr>';

        $num_row += 1;
   
    }


  echo '</table>';



    echo "<br/>";
}



?>



