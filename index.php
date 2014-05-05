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
<h2>Simple stats for proxypool</h2>
<p>This is just fetch from database, dont take numbers seriously, it is really rough estimate ;)
<p>More info on <?php echo '<a href="' . $p2pool_address . '">'. $p2pool_address; ?></a> where you can find out how to mine and see Vertcoin stats for p2pool node. Monocle is mined separetly and there are no stats for that.
<p>All times are in <?php echo $local_timezone; ?> time.
<p>You can click on your VTC/MON address to get to your stats page.
<p>Sudden drop of unpaid balances since laste update is because there was a bug with reading of database. Theese values should be ok ;)

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
