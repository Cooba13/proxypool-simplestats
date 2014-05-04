<?php
  
  require_once dirname(__FILE__) . "/../include/config.php";
  
  $db = mysql_connect($db_host, $db_user, $db_password);
  if (!$db) die('Error connecting to db');

  mysql_select_db($db_db);
  $result = mysql_query("select distinct(user), auxuser, sum(monvalue), sum(vtcvalue) from stats_shares where foundtime >= date_sub(now(), interval 5 minute) group by user");
  $rows = mysql_num_rows($result);

  $sum_mon = 0;
  $sum_vtc = 0;
  $hashrate_total = 0;

  $now = date("c");

  $output = '';

  if ($rows == 0) {
    $output .= "Nothing to display";
  } else {
    $output .= "<h3>Last 5 minutes stats</h3><table class='table table-bordered table-striped'><th>VTC</th><th>MON</th><th>MON value</th><th>VTC value</th><th>Hashrate (khs)</th>";
    $output .=  "<p>This table is updated every one minute. Last update " . $now;
    while ( $row = mysql_fetch_array($result) ): {
      $sum_mon += $row[2];
      $sum_vtc += $row[3];
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
      $output .= "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td><td>" . $row[3] . "</td><td>" . $hashrate .  "</td></tr>";
    } endwhile;
    $output .= "<tr><td colspan=\"2\"><td>" . $sum_mon . "</td><td>" . $sum_vtc . "</td><td>" . $hashrate_total . "</td></table>";
  };

  mysql_close($db);

  $file = getcwd() . "/../include/gen-active.html";
  file_put_contents($file, $output);  

?>
