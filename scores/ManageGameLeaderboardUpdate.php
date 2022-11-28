<?php 

        include 'mysql_connect.php';
        include 'update_key.php';

        //These are our variables.

        $id = $_POST['id']; 
        
        echo 'Game id: ' . $id . "</br>";
        $strOrderMethod = $_POST['order_method'];
        $strScoreFormat = $_POST['score_format'];
        $strMetric = $_POST['metric'];
        $strDownloadURL = $_POST['download_url'];


        $strQuery = 'UPDATE game SET order_method = ' . $strOrderMethod . ', ' .
                    'score_format = \'' . $strScoreFormat . '\', ' .
                    'metric = \'' . $strMetric . '\', ' .
                    'download_url = \'' . $strDownloadURL . '\' ' .
                    'WHERE id = ' . $id;

         echo 'query: ' . $strQuery;

        $result = mysqli_query($conn, $strQuery) or die('Query failed: ' . mysqli_error());
?>
</br></br></br>

Submitted Values</br>
Order Method: <?php echo $strOrderMethod; ?></br>
Score Format: <?php echo $strScoreFormat; ?> </br>
Metric: <?php echo $strMetric; ?> </br>
Download URL: <?php echo $strDownloadURL; ?> </br>

<a href="https://levidsmith.com/leaderboard-management/">Back to Leaderboard Management</a>

