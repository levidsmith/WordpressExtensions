<html>
<head>
  <meta http-equiv="pragma" content="no-cache">
  <meta http-equiv="expires" content="-1">

<?php
  $site_name = "LD Smith Games";
  $site_url = "https://levidsmith.com";
?>
  <link rel="stylesheet" href="static/gamestats_style.css">

</head>
<body class="winter">
  Game Score Stats<br/>

  <p id="stats_display"></p>

  <script>
var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {

  if (this.readyState == 4 && this.status == 200) {
    var myObj = JSON.parse(this.responseText);
    var strOutput = ""; 

    //header row
    strOutput += '<div class="stats_row">';
    strOutput += '<div class="stats_name"><b>Game</b></div>';
    strOutput += '<div class="stats_column"><b>Count</b></div>';
    strOutput += '<div class="stats_column"><b>Min</b></div>';
    strOutput += '<div class="stats_column"><b>Max</b></div>';
    strOutput += '<div class="stats_column"><b>Avg</b></div>';
    strOutput += '<div class="stats_latest"><b>Latest</b></div>';
    strOutput += '</div>';

    var i;
    for ( i = 0; i < myObj.games.length; i++) {
      if (i % 2 == 0) {
        strOutput += '<div class="stats_row even_row">';
      } else {
        strOutput += '<div class="stats_row odd_row">';
      }

      strOutput += '<div class="stats_name"><a href="' + myObj.games[i].url + '">' + myObj.games[i].name + '</a></div>';

        strOutput += '<div class="stats_column">' + myObj.games[i].score_count + '</div>';
        strOutput += '<div class="stats_column">' + myObj.games[i].score_min + '</div>';
        strOutput += '<div class="stats_column">' + myObj.games[i].score_max + '</div>';
        strOutput += '<div class="stats_column">' + myObj.games[i].score_avg + '</div>';


      strOutput += '<div class="stats_latest">' + myObj.games[i].score_latest_display + '</div>';

      strOutput += '</div>';
    } 
  }

   document.getElementById("stats_display").innerHTML = strOutput;
}
<?php
  $params = "";
  if (isset($_SERVER['QUERY_STRING'])) {
    $params = "?" . $_SERVER['QUERY_STRING']; 
  }
  echo 'xmlhttp.open("GET", "' . $site_url . '/scores/GameStatsJSON.php' .
        $params . '", true);'; 
?>

  xmlhttp.send();
  </script>

Order by:
<a href="GameStats.php?sort=name">Name</a>
<a href="GameStats.php?sort=count">Count</a>
<a href="GameStats.php?sort=date">Latest</a>

<p>Back to
<?php
echo '<a href="' . $site_url . '">' . $site_name . '</a>';
?>
</p> 


</body>
</html>
