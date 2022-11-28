<html>
  <head>
<script>
  function showClearScores() {
    alert('Are you sure?');
    document.getElementById('clear_scores').style.display = 'block';
  }
</script>
  </head>
  <body>
<?php 

//Include the following two lines to use Wordpress functions, 
//such as getting the user's logged in status and privileges
define('WP_USE_THEMES', false);
require('../blog/wp-blog-header.php');


        include 'mysql_connect.php';
        include 'update_key.php';


  if (current_user_can("administrator")) {
    echo "Leaderboard Management<br>";
    manage_game($conn, $secretKey);
  } else {
    echo "Access to leaderboards denied<br/>";
  }

  function manage_game($conn, $secretKey) {

        //These are our variables.
        $id = mysqli_real_escape_string($conn, $_GET['id']); 
        echo 'Game id: ' . $id . "</br>";

        $strQuery = 'SELECT name, order_method, score_format, metric, download_url, leaderboard_key FROM game WHERE id = ' . $id;

        $result = mysqli_query($conn, $strQuery) or die('Query failed: ' . mysqli_error());

        $row = mysqli_fetch_array($result);
        echo 'Name: ' . $row['name'] . '</br>'; 
        echo 'Order Method: ' . $row['order_method'] . '</br>'; 
        echo 'Score Format: ' . $row['score_format'] . '</br>'; 
        echo 'Metric: ' . $row['metric'] . '</br>'; 
        echo 'Download URL: ' . $row['download_url'] . '</br>'; 

        $strName = $row['name'];
        $strOrderMethod = $row['order_method'];
        $strScoreFormat = $row['score_format'];
        $strMetric = $row['metric'];
        $strDownloadURL = $row['download_url'];
        $strLeaderboardKey = $row['leaderboard_key'];

        echo 'Leaderboard key: ' . $strLeaderboardKey . '</br>'; 
?>

</br></br></br>

  <form action="ManageGameLeaderboardUpdate.php" method="post">
    <input type="hidden" name="id" value="<?php echo $id; ?>"></br>
    Name: <?php echo $strName; ?></br>
<!--
    Order Method: <input type="text" name="order_method" value="<?php echo $strOrderMethod; ?>"></br>
-->

    Order Method: <select id="order_method" name ="order_method">
                    <option value="0"
                    <?php if ($strOrderMethod == "0") { echo " selected"; }  ?>
                    >High to Low</option>
                    <option value="1"
                    <?php if ($strOrderMethod == "1") { echo " selected"; }  ?>
                    >Low to High</option>
                  </select>
<br/>

<!--
    Score Format: <input type="text" name="score_format" value="<?php echo $strScoreFormat; ?>"></br>
-->
    Score Format: <select id="score_format" name ="score_format">
                    <option value="normal"
                    <?php if ($strScoreFormat == "") { echo " selected"; }  ?>
                    >Normal</option>
                    <option value="stopwatch"
                    <?php if ($strScoreFormat == "stopwatch") { echo " selected"; }  ?>
                    >Stopwatch</option>
                  </select>
<br/>

    Metric: <input type="text" name="metric" value="<?php echo $strMetric; ?>"></br>
    Download URL: <input type="text" name="download_url" value="<?php echo $strDownloadURL; ?>"></br>
    <input type="submit">

  </form>

<br/><br/><br/>
<br/><br/><br/>

<a href="https://levidsmith.com/leaderboard-management/">Back to Leaderboard Management</a>

<br/><br/><br/>
<br/><br/><br/>

<input type="button" value="Clear Scores" onClick="showClearScores()"/>

<?php
      $str_date = date("Ymd");
      $hash = md5($id . $str_date . $secretKey);
      echo '<div id="clear_scores" style="width: 200px; background-color: #A0FFFF; float: left; display: none;">' .      '<a href="/scores/ClearScores.php?id=' . $id . '&hash=' . $hash . '">Clear Scores</a></div>';
  }



?>
  </body>
</html>
