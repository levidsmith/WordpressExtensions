<?php 

        include 'mysql_connect.php';
        include 'update_key.php';

        function getRandomKey($iNumChars) {
          $strAlphaUppers = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
          $strAlphaLowers = 'abcdefghijklmnopqrstuvwxyz';
          $strNumbers = '0123456789';
          $strChars = '';
          for ($i = 0; $i < $iNumChars; $i++) {
            if ($i % 3 == 0) {
              $strChars .= $strAlphaUppers[random_int(0, strlen($strAlphaUppers))];
            } elseif  ($i % 3 == 1) {
              $strChars .= $strAlphaLowers[random_int(0, strlen($strAlphaLowers))];
            } elseif  ($i % 3 == 2) {
              $strChars .= $strNumbers[random_int(0, strlen($strNumbers))];
            }
          }
          return $strChars;
        }

        //These are our variables.

        $name = mysqli_real_escape_string($conn, $_GET['name']); 
        $id = mysqli_real_escape_string($conn, $_GET['id']); 
        $download_url = mysqli_real_escape_string($conn, $_GET['download_url']); 
        $hash = $_GET['hash']; 
        
        //Key ($secretKey) included from update_key.php.  
        //Create the file if it does not exist

        
        //We md5 hash our results.
        $str_date = date("Ymd");
        $expected_hash = md5(urlencode($name) . $id  . $str_date . $secretKey); 

      
        
        //If what we expect is what we have:
        if($expected_hash == $hash) { 
            $newKey = getRandomKey(16);
            // Here's our query to insert/update scores!
            $query = 'INSERT INTO game (id, name, order_method, score_format, metric, download_url, leaderboard_key) ' .
                     'VALUES (' . $id . ", '" . $name . "'," . 
                     "0, NULL, 'Points Scored', " .
                     "'" . $download_url . "', " .
                     "'" . $newKey . "')";

            //And finally we send our query.
            $result = mysqli_query($conn, $query) or die('Query failed: ' . mysqli_error() . $query); 
            echo "<html><head>";
            echo "</head><body>";
            echo "Game Added: " . $name . ", " . $id; 
            echo "</body></html>";
        }  else {
            echo "Invalid hash value<br/>";
        }



?>
