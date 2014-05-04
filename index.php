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

<body>
<div class="container">
<h2>Simple stats for proxypool</h2>
<p>This is just fetch from database, dont take numbers seriously, it is really rough estimate ;)
<p>More info on <a href="http://whatever.kn.vutbr.cz:9172/static/">http://whatever.kn.vutbr.cz:9172/static/</a> where you can find out how to mine and see Vertcoin stats for p2pool node. Monocle is mined separetly and there are no stats for that.
<p>All times are in local time, CEST which is UTC+2.
<p>You can now use <b>http://whatever.kn.vutbr.cz/proxypool/?vtc=YourVTCAddress&mon=YourMONAddress</b> to highlight your VTC and MON address ;)
<?php

  $htmlbody = file_get_contents('./include/gen-active.html') . file_get_contents('./include/gen-unpaid.html') . file_get_contents('./include/gen-tx.html');

  if ( isset($_GET['vtc']) ) {  
    $safeVtc = htmlspecialchars($_GET['vtc'],ENT_QUOTES);
    $htmlbody = str_replace(">" . $safeVtc, " class=\"highlight_address\">". $safeVtc, $htmlbody);
  };
  if ( $_GET['mon'] ) {
    $safeMon = htmlspecialchars($_GET['mon'],ENT_QUOTES);
    $htmlbody = str_replace(">" . $safeMon, " class=\"highlight_address\">". $safeMon, $htmlbody);
  };

  echo $htmlbody;
?>
</div>
</body>
</html>
