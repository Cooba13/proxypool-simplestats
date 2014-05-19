<?php

  // call for update.php
  include dirname(__FILE__) . "/update.php";

  require_once dirname(__FILE__) . "/../include/config.php";

  date_default_timezone_set($local_timezone);
  
  $db = mysql_connect($db_host, $db_user, $db_password);
  if (!$db) die('Error connecting to db');

  mysql_select_db($db_db);

  $now = date("Y-m-d\TH:i:s");

  $sum_mon = 0;
  $sum_vtc = 0;

  $output = '';
  $tbody = '<tbody>';
  $thead = '';
  $tfoot = '';
  
  $result = mysql_query("select user, sum(if(vtcpaid=0, vtcvalue, 0)), auxuser, sum(if(monpaid=0, monvalue, 0)) from stats_shares group by user order by user asc;");
  $rows = mysql_num_rows($result);
  if ( $rows == 0 ) {
     $output = "Nothing to display";
  } else {
    $output .= "<h3>All times, good times</h3><p>This is table of not yet paid submitted shares.";
    $thead .= "<table class='table table-bordered table-striped' id='unpaid'>";
    $thead .= "<thead><tr><th>VTC</th><th class='numbers'>VTC value</th><th>MON</th><th class='numbers'>MON value</th></tr></thead>";
    $thead .= "<p>This table is updated every 5 minutes. Last update " . $now;
    while ( True ): {
      $row = mysql_fetch_array($result);
      if ( $row === False ) break;
      $sum_vtc += $row[1];
      $sum_mon += $row[3];
      if ( $row[1] == 0 && $row[3] == 0 ) continue;
      $tbody .= "<tr><td";
      if ( $row[1] == 0 ) $tbody .= " class='grayed'";
      $tbody .= ">" . $row[0] . "</td><td class='numbers";
      if ( $row[1] == 0 ) $tbody .= " grayed";
      $tbody .= "'>" . sprintf("%.08f", $row[1]) . "</td><td";
      if ( $row[3] == 0 ) $tbody .= " class='grayed'";
      $tbody .= ">" . $row[2] . "</td><td class='numbers";
      if ( $row[3] == 0 ) $tbody .= " grayed";
      $tbody .= "'>" . sprintf("%.08f", $row[3]) . "</td></tr>";
    } endwhile;
    $tfoot .= "<tfoot><tr><td></td><td class='numbers'>" . sprintf("%.08f", $sum_vtc) . "</td><td></td><td class='numbers'>" . sprintf("%.08f", $sum_mon) . "</td></tfoot>";
  };
  $tbody .= '</tbody></table>';
  $output .= $thead . $tfoot . $tbody;

  mysql_close($db);

  $file = dirname(__FILE__) . "/../include/gen-unpaid.html";
  file_put_contents($file, $output);

?>
