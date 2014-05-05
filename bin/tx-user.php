<?php

#  $safeVtc = "VngdNPuaysaUFUKNWguoD7CFsLkm9fJpy7";
#  $safeMon = "MVp1RzpFRbv3oHE1Ed98C96uSpN4YYvTL1";

  echo "<h3>Personal stats<h3>";

  date_default_timezone_set($local_timezone);

  if ( isset($safeVtc) && isset($safeVtc) ) {

    $file = "./include/gen-" . $safeVtc . "-" . $safeMon . ".html";

    if ( file_exists($file) ) {
      $file_modified = filemtime($file) + 300;
    } else {
      $file_modified = 0;
    };

    if ( $file_modified > date("Y-m-d\TH:i:s") ) {
      include $file;
    } else {
      $htmlbody = '';
      $htmlbody .= "<h4>Shares to be paid</h4>";
      $htmlbody .= "<p>This table must be 5 minutes old to update. Last update at " . date("Y-m-d\TH:i:s") . "<br />";
      $htmlbody .= "PLEASE keep in mind that theese numbers are predictions and estimates!";
      $htmlbody .= "<table class='table table-bordered table-striped'><tr><th>Address</th><th>Amount</th></tr>";      

      require_once dirname(__FILE__) . "/../include/config.php";

      $db = mysql_connect($db_host, $db_user, $db_password);
      if (!$db) die ('Error connectiong to db');
      mysql_select_db($db_db);

      $query = "select user, sum(vtcvalue) from stats_shares where vtcpaid=0 and user='" . $safeVtc . "';";
      $result = mysql_query($query);
      if ( !$result ) {
        $htmlbody .= "<td colspan=2>No VTC shares to be paid yet</td>";
      } else {
        $row = mysql_fetch_array($result);
        $htmlbody .= "<tr><td>" . $row[0] . "</td><td>" . round($row[1], 8) . "</td></tr>";
      };

      $query = "select auxuser, sum(monvalue) from stats_shares where monpaid=0 and auxuser='" . $safeMon . "';";
      $result = mysql_query($query);
      if ( !$result ) {
        $htmlbody .= "<td colspan=2>No MON shares to be paid yet</td>";
      } else {
        $row = mysql_fetch_array($result);
        $htmlbody .= "<tr><td>" . $row[0] . "</td><td>" . round($row[1], 8) . "</td></tr>";
      };

      $htmlbody .= "</table>";

      file_put_contents($file, $htmlbody);

      mysql_close($db);

      include $file;
    }

  }


  if ( isset($safeVtc) ) {
    $vtc_file = "./include/gen-" . $safeVtc . ".html";

    if ( file_exists($vtc_file) ) {
      $vtc_modified = filemtime($vtc_file) + 300; // move time 5 minutes into the future of file
    } else {
      $vtc_modified = 0;
    }; 

    if ( $vtc_modified > date("Y-m-d\TH:i:s") ) {
      include $vtc_file;
    } else {
      $htmlbody = '';
      $htmlbody .= "<h4>Vertcoin Transactions</h4>";
      $htmlbody .= "<p>This table must be 5 minutes old to update. Last update at " . date("Y-m-d\TH:i:s");

      require_once dirname(__FILE__) . "/../include/config.php";

      $db = mysql_connect($db_host, $db_user, $db_password);
      if (!$db) die('Error connecting to db');
      mysql_select_db($db_db);

      $query = "select stats_transactions.date_sent, stats_transactions.txhash, stats_usertransactions.amount from stats_transactions inner join stats_usertransactions on stats_transactions.id = stats_usertransactions.tx_id and stats_usertransactions.coin = 'vtc' and stats_usertransactions.user = '" . $safeVtc  . "' order by stats_transactions.date_sent desc;";
      $result = mysql_query($query);
      if ( !$result ) {
         $htmlbody .= "<p>No VertCoin transactions yet!";
      } else {
        $htmlbody .= "<table class='table table-bordered table-striped'><tr><th>Date</th><th>Transaction</th><th>Amount</th></tr>";
        $sum_amount = 0;
        while ( $row = mysql_fetch_array($result) ): {
          $htmlbody .= "<tr><td>" . $row[0] . "</td><td><a href=\"http://cryptexplorer.com/tx/" . $row[1] . "\">" . $row[1] . "</a></td><td>" . round($row[2], 8) . "</td></tr>";
          $sum_amount += $row[2];
        } endwhile;
        $htmlbody .= "<td colspan=2></td><td>" . round($sum_amount, 8) . "</td></table>";
      };

      file_put_contents($vtc_file, $htmlbody);

      mysql_close($db);

      include $vtc_file;
    };

  };

  if ( isset($safeMon) ) {
    $mon_file = "./include/gen-" . $safeMon . ".html";

    if ( file_exists($mon_file) ) {
      $mon_modified = filemtime($mon_file) + 300;
    } else {
      $mon_modified = 0;
    };

    if ( $mon_modified > date("Y-m-d\TH:i:s") ) {
      include $mon_file;
    } else {
      $htmlbody = '';
      $htmlbody .= "<h4>Monocle Transactions</h4>";
      $htmlbody .= "<p>This table must be 5 minutes old to update. Last update at " . date("Y-m-d\TH:i:s");

      require_once dirname(__FILE__) . "/../include/config.php";

      $db = mysql_connect($db_host, $db_user, $db_password);
      if (!$db) die('Error connecting to db');
      mysql_select_db($db_db);

      $query = "select stats_transactions.date_sent, stats_transactions.txhash, stats_usertransactions.amount from stats_transactions inner join stats_usertransactions on stats_transactions.id = stats_usertransactions.tx_id and stats_usertransactions.coin = 'mon' and stats_usertransactions.user = '" . $safeMon  . "' order by stats_transactions.date_sent desc;";
      $result = mysql_query($query);
      if ( !$result ) {
        $htmlbody .= "<p>No Monocle transactions yet!"; 
      } else {
        $htmlbody .= "<table class='table table-bordered table-striped'><tr><th>Date</th><th>Transaction</th><th>Amount</th></tr>";
        $sum_amount = 0;
        while ( $row = mysql_fetch_array($result) ): {
          $htmlbody .= "<tr><td>" . $row[0] . "</td><td><a href=\"http://cryptexplorer.com/tx/" . $row[1] . "\">" . $row[1] . "</a></td><td>" . round($row[2], 8) . "</td></tr>";
          $sum_amount += $row[2];
        } endwhile;
        $htmlbody .= "<td colspan=2></td><td>" . round($sum_amount, 8) . "</td></table>";
      };

      file_put_contents($mon_file, $htmlbody);

      mysql_close($db);

      include $mon_file;
    };
  };
?>
