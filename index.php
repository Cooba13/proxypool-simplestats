<html>
<head>

<style>
body { font-family: monospace; }
table, tr, th, td { border: 1px solid black; }
th { font-weight: bold; }
span { background-color: #222222; color: #cccccc; }
</style>

<title>Simple ProxyPool stats</title>
</head>

<body>

<h2>Simple stats for proxypool</h2>
<p>This is just fetch from database, dont take numbers seriously, it is really rough estimate ;)
<p>More info on <a href="http://whatever.kn.vutbr.cz:9172/static/">http://whatever.kn.vutbr.cz:9172/static/</a> where you can find out how to mine and see Vertcoin stats for p2pool node. Monocle is mined separetly and there are no stats for that.
<p>All times are in local time, CEST which is UTC+2.
<p>You can now use <b>http://whatever.kn.vutbr.cz/proxypool/?vtc=YourVTCAddress&mon=YourMONAddress</b> to highlight your VTC and MON address ;)
<?


  $htmlbody = file_get_contents('./include/gen-active.html') . file_get_contents('./include/gen-unpaid.html') . file_get_contents('./include/gen-tx.html');

  if ( $_GET['vtc'] ) {  
    $htmlbody = str_replace(">" . $_GET['vtc'], "><span>". $_GET['vtc'] . "</span>", $htmlbody);
  };
  if ( $_GET['mon'] ) {
    $htmlbody = str_replace(">" . $_GET['mon'], "><span>". $_GET['mon'] . "</span>", $htmlbody);
  };

  echo $htmlbody;

  #nclude "./active.html";

  #include "./unpaid.html";

  #include "./tx.html"; 

?>

</body>
</html>
