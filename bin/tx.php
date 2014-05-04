<?php


  $now = date("c");

  require_once dirname(__FILE__) . "/../include/config.php";
  
  $db = mysql_connect($db_host, $db_user, $db_password);

  if (!$db) die('Error connecting to db');

  mysql_select_db($db_db);

  $output = '';

  $output .= "<h3>List of VTC transactions</h3>";
  $output .= "<p>This table is updated every 5 minutes. Last update " . $now;
  $output .= "<table class='table table-bordered table-striped'><tr><th>Date</th><th>TX Hash</th><th>user</th><th>Amount</th></tr>";

  $query = "select stats_transactions.date_sent, stats_transactions.txhash, stats_usertransactions.user, stats_usertransactions.amount from stats_transactions inner join stats_usertransactions on stats_transactions.id = stats_usertransactions.tx_id and stats_usertransactions.coin = 'vtc' order by stats_transactions.date_sent desc;";
  $result = mysql_query($query);
  while ( $row = mysql_fetch_array($result) ): {
    $output .= "<tr><td>" . $row[0] ."</td><td><a href=\"http://cryptexplorer.com/tx/" . $row[1] . "\">" . $row[1] . "</a></td>";
    $output .= "<td><a href=\"http://cryptexplorer.com/address/" . $row[2] . "\">". $row[2] . "</td><td>". $row[3] . "</td></tr>";
  } endwhile;
  $output .= "</table>";

  $output .= "<h3>List of MON transactions</h3>";
  $output .= "<p>This table is updated every 5 minutes. Last update " . $now;
  $output .= "<table><tr><th>Date</th><th>TX Hash</th><th>user</th><th>Amount</th></tr>";

  $query = "select stats_transactions.date_sent, stats_transactions.txhash, stats_usertransactions.user, stats_usertransactions.amount from stats_transactions inner join stats_usertransactions on stats_transactions.id = stats_usertransactions.tx_id and stats_usertransactions.coin = 'mon' order by stats_transactions.date_sent desc;";
  $result = mysql_query($query);
  while ( $row = mysql_fetch_array($result) ): {
    $output .= "<tr><td>" . $row[0] ."</td><td><a href=\"http://cryptexplorer.com/tx/" . $row[1] . "\">" . $row[1] . "</a></td>";
    $output .= "<td><a href=\"http://cryptexplorer.com/address/" . $row[2] . "\">". $row[2] . "</td><td>". $row[3] . "</td></tr>";
  } endwhile;
  $output .= "</table>";

  mysql_close($db);

  $file = getcwd() . "/../include/gen-tx.html";
  file_put_contents($file, $output);


?>
