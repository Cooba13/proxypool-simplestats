<?

  require getcwd() . "/../include/config.php";
  $db = mysql_connect($db_host, $db_user, $db_password);
  if (!$db) die('Error connecting to db');

  mysql_select_db($db_db);

  $now = date("c");

  $sum_mon = 0;
  $sum_vtc = 0;

  $output = '';

  $result = mysql_query("select distinct(user), auxuser, sum(monvalue), sum(vtcvalue) from stats_shares group by user;");
  $rows = mysql_num_rows($result);
  if ($rows = 0) {
     $output = "Nothing to display";
  } else {
    $output .= "<h3>All times, good times</h3><p>This is table of not yet paid submitted shares<table><th>VTC</th><th>MON</th><th>MON value</th><th>VTC value</th>";
    $output .= "<p>This table is updated every 5 minutes. Last update " . $now;
    while ( $row = mysql_fetch_array($result) ): {
      $sum_mon += $row[2];
      $sum_vtc += $row[3];
      $output .= "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td><td>" . $row[3] . "</td></tr>";
    } endwhile;
    $output .= "<tr><td colspan=\"2\"><td>" . $sum_mon . "</td><td>" . $sum_vtc . "</td></table>";
  };

  mysql_close($db);

  $file = getcwd() . "/../include/gen-unpaid.html";
  file_put_contents($file, $output);

?>
