<?php
function getStopwatchFormat($score_display) {
             $mins = floor($score_display / 6000);
             $secs = floor($score_display / 100) % 60;
             $hundredths = $score_display % 100;
             $score_display = $mins . ":" . str_pad($secs, 2, "0", STR_PAD_LEFT) . "." . str_pad($hundredths, 2, "0", STR_PAD_LEFT);

  return $score_display;
}
?>
