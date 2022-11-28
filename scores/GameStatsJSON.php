<?php
    include 'mysql_connect.php';
    include 'util_leaderboard.php';

    if (isset($_GET['sort'])) {
      $sort_type = $_GET['sort'];
    }
 
     //This query grabs the top $score_limit_value scores, sorting by score and timestamp.
    $query_game = "SELECT game.id id, game.name name, game.download_url url, MAX(ts) score_latest, DATE_FORMAT(MAX(ts), '%Y-%b-%d') score_latest_display, COUNT(*) score_count, MAX(score.score) score_max, MIN(score.score) score_min, FLOOR(AVG(score.score)) score_avg, game.score_format FROM game, score ";
    $query_game .= "WHERE game.id = score.game ";
    $query_game .= "GROUP BY score.game ";

    if (isset($sort_type)) {
      $sort_type = strtoupper($sort_type);
      if ($sort_type == "NAME") {
        $query_game .= "ORDER BY game.name ";

      } else if ($sort_type == "DATE") {
        $query_game .= "ORDER BY score_latest ";

      } else if ($sort_type == "COUNT") {
        $query_game .= "ORDER BY score_count ";

      } else {
        $query_game .= "ORDER BY game.name ";

      }

    }
  
    $result_game = mysqli_query($conn, $query_game) or die('Query failed: ' . mysqli_error());
 
    //We find our number of rows
    $result_length = mysqli_num_rows($result_game); 

    echo "{\n";
    echo "\t" . '"games": [' . "\n";
    
    //And now iterate through our results
    for($i = 0; $i < $result_length; $i++) {
         $row = mysqli_fetch_array($result_game);

         echo "\t\t" . '{' . "\n"; 
         echo "\t\t\t" . '"id": "' . $row['id'] .  '",' . "\n"; 
         echo "\t\t\t" . '"name": "' . $row['name'] .  '",' . "\n"; 
         echo "\t\t\t" . '"url": "' . $row['url'] .  '",' . "\n"; 
         echo "\t\t\t" . '"score_format": "' . $row['score_format'] .  '",' . "\n"; 
         $strScoreLatest = $row['score_latest'];
         echo "\t\t\t" . '"score_latest": "' . $strScoreLatest .  '",' . "\n"; 
         echo "\t\t\t" . '"score_latest_display": "' . $row['score_latest_display'] .  '",' . "\n"; 


         $strScoreFormat = $row['score_format'];
         $strScoreMax = $row['score_max'];
         $strScoreMin = $row['score_min'];
         $strScoreAvg = $row['score_avg'];
         if (isset($strScoreFormat)  && $strScoreFormat == 'stopwatch') {
           $strScoreMax = getStopwatchFormat($strScoreMax);
           $strScoreMin = getStopwatchFormat($strScoreMin);
           $strScoreAvg = getStopwatchFormat($strScoreAvg);
         }
         echo "\t\t\t" . '"score_max": "' . $strScoreMax .  '",' . "\n"; 
         echo "\t\t\t" . '"score_min": "' . $strScoreMin .  '",' . "\n"; 
         echo "\t\t\t" . '"score_avg": "' . $strScoreAvg .  '",' . "\n"; 

         echo "\t\t\t" . '"score_count": "' . $row['score_count'] .  '"'; 

         echo "\t\t" . '}'; 
         if ($i < $result_length - 1) {
           echo ',';
         }
         echo "\n"; 
    }
    echo "\t" . ']' . "\n";
    echo '}';
?>
