<?php
  require_once dirname(__FILE__) . "/include/config.php";
  if ( file_exists(dirname(__FILE__) . "/include/gen-lastblock.php") ) 
    require_once dirname(__FILE__) . "/include/gen-lastblock.php";
  if ( !file_exists(dirname(__FILE__) . "/include/gen-update.php") )
    include dirname(__FILE__) . "/bin/update.php";
  require_once dirname(__FILE__) . "/include/gen-update.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
<link href="./theme/basic.css" rel="stylesheet">
<?php if ( $show_email ) print '<script type="text/JavaScript" src="./js/email.js"></script>' . PHP_EOL; ?>
<script type="text/javascript" charset="utf8" src="//code.jquery.com/jquery-2.1.1.min.js"></script>
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.0/js/jquery.dataTables.js"></script>
<link href="//cdn.datatables.net/plug-ins/e9421181788/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/plug-ins/e9421181788/integration/bootstrap/3/dataTables.bootstrap.js"></script>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Simple ProxyPool stats</title>
<script type="text/javascript">
  $.extend( $.fn.dataTable.defaults, {
    searching: false,
    ordering: false,
    pageLength: 10,
    lengthChange: false
  } );
  
  <?php if ( $table_consolas ) print '$.fn.dataTableExt.oStdClasses.sTable = "table-consolas"' . PHP_EOL; ?>

  $(document).ready( function () {
    $('#vtc').dataTable();
    $('#mon').dataTable();
    $('#unpaid').dataTable();
  } );
</script>
</head>
<body>
<div class="container">
<h2>VTC/MON Merged Mining</h2>
<table>
<tr style="vertical-align: top;">
<td style="width:474px;">
<img alt="vertcoin icon" src="./img/vertcoin.png" style="height:80px;width:80px;" />
<img alt="vertcoin icon" src="./img/monocle.png" style="height:80px;width:80px;" />
<br>
Mining VTC on the
<?php if ( $p2pool_port == '9171' ) {
    echo 'first';
  } elseif ( $p2pool_port == '9172' ) {
    echo 'second';  
  } elseif ( $p2pool_port == '9174' ) {
    echo 'third';
  } else { echo 'not specified'; };
?>
 P2Pool Network<br />

<?php echo '<a href="http://' . $p2pool_address . ':' . $p2pool_port . '/static/">http://' . $p2pool_address . ':' . $p2pool_port . '/static/</a><br />'; ?>
All times are in <?php echo $local_timezone; ?> time<br />
<b>Click on your VTC/MON address to get detailed stats.</b><br />
</td>

<td>
  <table>
    <tr>
      <td style="width:160px">
        <h4>Getting started</h4>
      </td>
      <td>
      </td>
    </tr>
      <td><b>URL</b> </td>
      <td><p><code>stratum+tcp://<?php echo $p2pool_address; ?>:9555</p></code></td>
    </tr>
    <tr>
      <td><b>Username:</b></td>
      <td>Your Vertcoin Wallet Address</td>
    </tr>
    <tr>
      <td><b>Password</b></td>
      <td>Your Monocle Wallet Address</td>
    </tr>
    <tr>
      <td><b>Fee</b></td>
      <td><?php echo $p2pool_fee; ?>%</td>
    </tr>
    <tr>
      <td><b>Node Location</b></td>
      <td><?php echo $node_location; ?></td>
    </tr>
    <?php if ( $show_email ) {
      print "<tr><td><b>Contact</b></td>" . PHP_EOL;
      print "<td><script language=\"JavaScript\" type=\"text/javascript\"><!--" . PHP_EOL;
      print "gen_mail_to_link('$lhs','$rhs','$subject')" . PHP_EOL;
      print "// --> </script>" . PHP_EOL;
      print "<noscript><em>Email address protected by JavaScript. Activate javascript to see the email.</em></noscript>" . PHP_EOL;
      print "</td></tr>" . PHP_EOL;
    } ?>
    <tr>
      <td><b>Auto Payout</b></td>
      <td><span class="label label-success"><?php echo $vtc_autopayout; ?> VTC</span> / <span class="label label-default"><?php echo $mon_autopayout; ?> MON</span></td>
    </tr>
    <tr>
      <td><b>Last VTC block</b></td>
      <td><?php if ( isset($vtc_block_found) ) { echo $vtc_block_found . " ("; echo $vtc_block_since . ")"; } ?></td>
    </tr>
    <tr>
      <td><b>Last MON block</b></td>
      <td><?php if ( isset($mon_block_found) ) { echo $mon_block_found . " ("; echo $mon_block_since . ")"; } ?></td>
    </tr>
    <?php if ( $show_balance ) { ?>
    <tr>
      <td><b>VTC balance</b></td>
      <td><?php if ( isset($vtc_balance) ) { echo $vtc_balance . " ("; echo $vtc_immature . ")"; } ?></td>
    </tr>
    <tr>
      <td><b>MON balance</b></td>
      <td><?php if ( isset($mon_balance) ) { echo $mon_balance . " ("; echo $mon_immature . ")"; } ?></td>
    </tr>
    <?php } ?>
</td>
</tr>
</table>
</table>
<br />
<?php if ( $announcement && file_exists(dirname(__FILE__) . "/include/announcement.html") ) { ?>
<div class = "alert alert-info">
  <?php include "./include/announcement.html"; ?>
</div>
<?php }; ?>

<?php

  $htmlbody = file_get_contents('./include/gen-active.html'); 


  if ( isset($_GET['vtc']) ) {  
    $safeVtc = htmlspecialchars($_GET['vtc'],ENT_QUOTES);
    $htmlbody = str_replace("<tr><td><a href=\"?vtc=" . $safeVtc, "<tr class=\"highlight_address\"><td><a href=\"?vtc=". $safeVtc, $htmlbody);
  };

  if ( isset($_GET['mon']) ) {
    $safeMon = htmlspecialchars($_GET['mon'],ENT_QUOTES);
  };

  echo $htmlbody;

  if ( !isset($_GET['vtc']) && !isset($_GET['mon'])) {
    include "./include/gen-unpaid.html";
    include "./include/gen-tx.html";
  } else {
    include "./bin/tx-user.php";
  }

 
?>
</div>
<div class="panel-footer" style="width: 100%; display: table; font-family: Consolas;">
  <div style="display: table-row">
    <div style="width: auto; display: table-cell;">
      Made by <a href="https://github.com/Cooba13/proxypool-simplestats">Cooba13</a>
      If you feel the need VTC: Vt39dQgGN6oJpycARRHRtGVrz1nngjaV7b MON: MDbTCpvBsMuSBfGRHi4NT8cD5EH1uE9qCa
    </div>
    <div class='foot <?php if ( $current ) echo "current"; else echo "old"; ?>'> <?php echo `git describe --tags`; ?></div>
  </div>
</div>
<?php if ( !$current )  { ?>
<div class='label label-default update-reminder'>New updates available</div>
<?php }; ?>
</body>
</html>
