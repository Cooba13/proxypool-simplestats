<?php

  # call check for last blocks (just because this script is already called every minute using scheduler)
  include dirname(__FILE__) . "/wallet.php";

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
  $tbody = '<tbody>';
  $thead = '';
  $tfoot = '';

  if ($rows == 0) {
    $tbody .= "<tr><td colspan=3>Nothing to display</td></td>";
  } else {
    $output .= "<h3>Last 5 minutes stats</h3>";
    $output .= "<p>This table is updated every one minute. Last update " . $now;
    $thead .= "<table class='table table-bordered table-striped";
    if ( $table_consolas ) $thead .= " table-consolas";
    $thead .= "'><th>VTC</th><th>MON</th><th class='numbers'>Hashrate (khs)</th>";
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
      $tbody .= "<tr><td><a href=\"" . $hyperlink . "\">" . $row[0] . "</a></td><td><a href=\"" . $hyperlink . "\">" . $row[1] . "</a></td><td class='numbers'>" . sprintf("%.02f", $hashrate) .  "</td></tr>";
    } endwhile;
    $tfoot .= "</tbody><tfoot><tr><td colspan=\"2\"><td class='numbers'>" . sprintf("%.02f", $hashrate_total) . "</td></tfoot>";
    $tbody .= "</table>";
  };

  mysql_close($db);

  $output .= $thead . $tfoot . $tbody;
  
  $file = dirname(__FILE__) . "/../include/gen-active.html";
  file_put_contents($file, $output);  

?>
