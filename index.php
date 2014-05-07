<!DOCTYPE html>
<html lang="en">
<head>
<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
<link href="./theme/basic.css" rel="stylesheet">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Simple ProxyPool stats</title>
</head>

<?php
  require_once dirname(__FILE__) . "/include/config.php";
?>

<body>
<div class="container">
<h2>VTC/MON Merged Mining</h2>
<table>
<tr>
<td style="width:474px">
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
       <td></td>
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
</td>
</tr>
</table>
</table>
<br />
<?php if ( $announcement ) { ?>
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
<div class="panel-footer">
Made by <a href="https://github.com/Cooba13/proxypool-simplestats">Cooba13</a>
If you feel the need VTC: Vt39dQgGN6oJpycARRHRtGVrz1nngjaV7b MON: MDbTCpvBsMuSBfGRHi4NT8cD5EH1uE9qCa
</div>
</body>
</html>
