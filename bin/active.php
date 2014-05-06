<?php

  require_once dirname(__FILE__) . "/../include/config.php";

  date_default_timezone_set($local_timezone); 
 
  $db = mysql_connect($db_host, $db_user, $db_password);
  if (!$db) die('Error connecting to db');

  mysql_select_db($db_db);
  $result = mysql_query("select distinct(user), auxuser from stats_shares where foundtime >= date_sub(now(), interval 5 minute) group by user;");
  $rows = mysql_num_rows($result);

  $hashrate_total = 0;

  $now = date("Y-m-d\TH:i:s");

  $output = '';

  if ($rows == 0) {
    $output .= "Nothing to display";
  } else {
    $output .= "<h3>Last 5 minutes stats</h3><table class='table table-bordered table-striped'><th>VTC</th><th>MON</th><th>Hashrate (khs)</th>";
    $output .=  "<p>This table is updated every one minute. Last update " . $now;
    while ( $row = mysql_fetch_array($result) ): {
      $query_hash = "select count(user), avg(sharediff) from stats_shares where user='" . $row[0] . "' and foundtime >= date_sub(now(), interval 5 minute);";
      $hashes = mysql_query($query_hash);
      $num_rows = mysql_num_rows($hashes);
      if ($num_rows == 0) {
        $hashrate = "n/a";
      } else {
        $h_row = mysql_fetch_array($hashes);
        $hashrate = ($h_row[1] * pow(2, 32)) / (300 / $h_row[0])/1000;
        $hashrate_total += $hashrate;
      };
      $hyperlink = "?vtc=" . $row[0] . "&mon=" . $row[1];
      $output .= "<tr><td><a href=\"" . $hyperlink . "\">" . $row[0] . "</a></td><td><a href=\"" . $hyperlink . "\">" . $row[1] . "</a></td><td class='numbers'>" . sprintf("%.02f", $hashrate) .  "</td></tr>";
    } endwhile;
    $output .= "<tr><td colspan=\"2\"><td class='numbers'>" . sprintf("%.02f", $hashrate_total) . "</td></table>";
  };

  mysql_close($db);

  $file = dirname(__FILE__) . "/../include/gen-active.html";
  file_put_contents($file, $output);  

?>
