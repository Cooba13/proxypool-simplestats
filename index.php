<!DOCTYPE html>
<html lang="en">
<head>
<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
<title>Simple ProxyPool stats</title>
</head>

<body>

<h2>Simple stats for proxypool</h2>
<p>This is just fetch from database, dont take numbers seriously, it is really rough estimate ;)
<p>More info on <a href="http://whatever.kn.vutbr.cz:9172/static/">http://whatever.kn.vutbr.cz:9172/static/</a> where you can find out how to mine and see Vertcoin stats for p2pool node. Monocle is mined separetly and there are no stats for that.
<p>All times are in local time, CEST which is UTC+2.
<p>You can now use <b>http://whatever.kn.vutbr.cz/proxypool/?vtc=YourVTCAddress&mon=YourMONAddress</b> to highlight your VTC and MON address ;)
<?php

  $htmlbody = file_get_contents('./include/gen-active.html') . file_get_contents('./include/gen-unpaid.html') . file_get_contents('./include/gen-tx.html');

  if ( isset($_GET['vtc']) ) {  
    $safeVtc = htmlspecialchars($_GET['vtc'],ENT_QUOTES);
    $htmlbody = str_replace(">" . $safeVtc . "><span>". $safeVtc . "</span>", $htmlbody);
  };
  if ( $_GET['mon'] ) {
    $safeMon = htmlspecialchars($_GET['mon'],ENT_QUOTES);
    $htmlbody = str_replace(">" . $safeMon, "><span>". $safeMon . "</span>", $htmlbody);
  };

  echo $htmlbody;
?>

</body>
</html>
