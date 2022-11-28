<!DOCTYPE html>
<!-- 2017 Levi D. Smith -->
<?php
  $param_unique = "1";
  $param_latest = "0";
  if (isset($_GET["unique"])) {
    $param_unique = $_GET["unique"];
  }
  if (isset($_GET["latest"])) {
    $param_latest = $_GET["latest"];
  }
?>
<html>
<head>

        <!-- Start Custom Font -->
        <link href="static/ldsmith_style.css" rel="stylesheet">
        <!-- End Custom Font -->

<?php
  $site_name = "LD Smith Games";
  $site_url = "https://levidsmith.com";
?>

 
  <meta http-equiv="pragma" content="no-cache">
  <meta http-equiv="expires" content="-1">

  <link rel="stylesheet" href="static/leaderboard_style.css">


</head>
<body class="winter">

<h2>Leaderboards</h2>
<?php
    echo '<a href="' . $site_url . '/scores/DisplayScores?unique=1">Top Scores by Name</a> - ';
    echo '<a href="' . $site_url . '/scores/DisplayScores?unique=0">All Top Scores</a> - ';
    echo '<a href="' . $site_url . '/scores/DisplayScores?latest=1">Latest Scores</a> - ';
    echo '<a href="' . $site_url . '/scores/GameStats.php">Score Stats by Game</a><br/>';
?>

<p id="game_display"></p>
<div class="back">
<?php
    echo '<a href="' . $site_url . '">Back to ' . $site_name . '</a>';
?>
</div>


<script>

var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
  if (this.readyState == 4 && this.status == 200) {
    var myObj = JSON.parse(this.responseText);
    var strGame = "";
    
    for ( var i = 0; i < myObj.games.length; i++) {
      strGame += '<div class="game">';
      strGame += '<div class="game_name">';
      strGame += '<a href="' + myObj.games[i].download_url + '">';
      strGame += myObj.games[i].name; 
      strGame += '</a>';
      strGame += '</div>' + "\n";
      strGame += '<div class="game_metric">' + myObj.games[i].metric + '</div>' + "\n";

      if (myObj.games[i].scores) {

        for ( var j = 0; j < myObj.games[i].scores.length; j++) {
<?php
  if ($param_latest == "1") {
?>
            strGame += '<div class="score_other">';
<?php
  } else {
?>
          if (j == 0) {
            strGame += '<div class="score_first_place">';
          } else if (j == 1) {
            strGame += '<div class="score_second_place">';
          } else if (j == 2) {
            strGame += '<div class="score_third_place">';
          } else {
            strGame += '<div class="score_other">';
          }
<?php
  }
?>
          strGame += '<div class="score_name">';
          if (myObj.games[i].scores[j].name != "") {
            strGame += myObj.games[i].scores[j].name + "\n";
          } else {
            strGame += "&nbsp;" + "\n";
          }
          strGame += '</div>';
          strGame += '<div class="score_score">';
          strGame += myObj.games[i].scores[j].score + "\n";
          strGame += '</div>';
          strGame += '</div>';

        }
      } else {
        strGame += "<div>No Scores</div>";
      }

      strGame += '</div>';
    } 

	document.getElementById("game_display").innerHTML = strGame;
  }
};

	document.getElementById("game_display").innerHTML = "Loading";

<?php
  $params = "?";
  if ($param_unique == "1") {
      $params .= 'unique=1';
  } else {
      $params .= 'unique=0';
  }
  $params .= "&";
  if ($param_latest == "1") {
      $params .= 'latest=1';
  } else {
      $params .= 'latest=0';
  }
  echo 'xmlhttp.open("GET", "' . $site_url . '/scores/leaderboard.json' . $params . '", true);';
?>
xmlhttp.send();

</script>

</body>
</html>
