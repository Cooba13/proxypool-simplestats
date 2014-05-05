<?php

  require_once dirname(__FILE__) . "/../include/config.php";

  date_default_timezone_set($local_timezone);
  $now = date("Y-m-d\TH:i:s");

  $db = mysql_connect($db_host, $db_user, $db_password);

  if (!$db) die('Error connecting to db');

  mysql_select_db($db_db);

  $output = '';

  $output .= "<h3>List of VTC transactions</h3>";
  $output .= "<p>This table is updated every 5 minutes. Last update " . $now;
  $output .= "<table class='table table-bordered table-striped'><tr><th>Date</th><th>TX Hash</th><th>Amount</th></tr>";

  $query = "select date_sent, txhash, amount from stats_transactions where coin='vtc' order by date_sent desc;"; 
  $result = mysql_query($query);
  $sum_amount = 0;
  while ( $row = mysql_fetch_array($result) ): {
    $output .= "<tr><td>" . $row[0] ."</td><td><a href=\"http://cryptexplorer.com/tx/" . $row[1] . "\">" . $row[1] . "</a></td>";
    $output .= "<td>". round($row[2], 8) . "</td></tr>";
    $sum_amount += $row[2];
  } endwhile;
  $output .= "<tr><td colspan=2><td>". round($sum_amount, 8) . "</td></tr>";
  $output .= "</table>";

  $output .= "<h3>List of MON transactions</h3>";
  $output .= "<p>This table is updated every 5 minutes. Last update " . $now;
  $output .= "<table class='table table-bordered table-striped'><tr><th>Date</th><th>TX Hash</th><th>Amount</th></tr>";

  $query = "select date_sent, txhash, amount from stats_transactions where coin='mon' order by date_sent desc;";
  $result = mysql_query($query);
  $sum_amount = 0;
  while ( $row = mysql_fetch_array($result) ): {
    $output .= "<tr><td>" . $row[0] ."</td><td><a href=\"http://cryptexplorer.com/tx/" . $row[1] . "\">" . $row[1] . "</a></td>";
    $output .= "<td>". round($row[2], 8) . "</td></tr>";
    $sum_amount += $row[2];
  } endwhile;
  $output .= "<tr><td colspan=2><td>". round($sum_amount, 8) . "</td></tr>";
  $output .= "</table>";


  $file = dirname(__FILE__) . "/../include/gen-tx.html";
  file_put_contents($file, $output);


?>
