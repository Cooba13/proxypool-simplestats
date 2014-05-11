<?php

  require_once dirname(__FILE__) . "/../include/config.php";

  date_default_timezone_set($local_timezone);
  $now = date("Y-m-d\TH:i:s");

  $db = mysql_connect($db_host, $db_user, $db_password);

  if (!$db) die('Error connecting to db');

  mysql_select_db($db_db);

  $output = '';
  $tbody = '<tbody>';
  $thead = '';
  $tfoot = '';

  $output .= "<h3>List of VTC transactions</h3>";
  $output .= "<p>This table is updated every 5 minutes. Last update " . $now;
  $thead .= "<table class='table table-bordered table-striped";
  if ( $table_consolas ) $output .= " table-consolas";
  $thead .= "' id='vtc'><thead><tr><th>Date</th><th>TX Hash</th><th>Amount</th></tr></thead>";

  $query = "select date_sent, txhash, amount from stats_transactions where coin='vtc' order by date_sent desc;"; 
  $result = mysql_query($query);
  $sum_amount = 0;
  while ( $row = mysql_fetch_array($result) ): {
    $tbody .= "<tr><td>" . date("Y-m-d H:i:s", strtotime($row[0].' UTC')) ."</td><td><a href=\"http://cryptexplorer.com/tx/" . $row[1] . "\">" . $row[1] . "</a></td>";
    $tbody .= "<td class='numbers'>". sprintf("%.08f", $row[2]) . "</td></tr>";
    $sum_amount += $row[2];
  } endwhile;
  $tfoot .= "<tfoot><tr><td colspan=2><td class='numbers'>". sprintf("%.08f", $sum_amount) . "</td></tr></tfoot>";
  $tbody .= "</tbody></table>";
  $output .= $thead . $tfoot . $tbody;
  
  $tbody = '<tbody>';
  $thead = '';
  $tfoot = '';
  
  $output .= "<h3>List of MON transactions</h3>";
  $output .= "<p>This table is updated every 5 minutes. Last update " . $now;
  $thead .= "<table class='table table-bordered table-striped ";
  if ( $table_consolas ) $output .= "table-consolas";
  $thead .= "' id='mon'><thead><tr><th>Date</th><th>TX Hash</th><th>Amount</th></tr></thead>";

  $query = "select date_sent, txhash, amount from stats_transactions where coin='mon' order by date_sent desc;";
  $result = mysql_query($query);
  $sum_amount = 0;
  while ( $row = mysql_fetch_array($result) ): {
    $tbody .= "<tr><td>" . date("Y-m-d H:i:s", strtotime($row[0].' UTC')) ."</td><td><a href=\"http://cryptexplorer.com/tx/" . $row[1] . "\">" . $row[1] . "</a></td>";
    $tbody .= "<td class='numbers'>". sprintf("%.08f", $row[2]) . "</td></tr>";
    $sum_amount += $row[2];
  } endwhile;
  $tfoot .= "<tfoot><tr><td colspan=2><td class='numbers'>". sprintf("%.08f", $sum_amount) . "</td></tr></tfoot>";
  $tbody .= "</tbody></table>";
  $output .= $thead . $tfoot . $tbody;

  $file = dirname(__FILE__) . "/../include/gen-tx.html";
  file_put_contents($file, $output);


?>
