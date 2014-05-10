<?php

  $db_host = 'localhost'; # machine running mysql db
  $db_user = 'proxypool'; # mysql user for proxypool
  $db_password = 'password'; # password
  $db_db = 'proxypool'; # name of database

  $local_timezone = 'Europe/Prague'; # set your timezone, list of available settings is at http://www.php.net/manual/en/timezones.php

  $p2pool_port = '9171'; # specify port of p2pool
  $p2pool_address = 'p2pool_address'; # url of your p2pool vtc node (do not use http:// or port
  $p2pool_fee = '1.0'; #fee of your node

  $node_location = 'node_location'; # location of the node
  $table_consolas = True; # True or False
  $announcement = False; # True or False show announcement 
  
  $vtc_wallet_address = 'localhost:5888'; # rpc address of vtc wallet
  $vtc_wallet_user = 'vertcoinrpc'; # rpc user of vtc wallet
  $vtc_wallet_password = 'rpcpassword'; # rpc password of vtc wallet

  $mon_wallet_address = 'localhost:6888'; # rpc address of vtc wallet
  $mon_wallet_user = 'monoclerpc'; # rpc user of vtc wallet
  $mon_wallet_password = 'rpcpassword'; # rpc password of vtc wallet
  
  $vtc_autopayout = '0.2'; # VTC Payout threshold (as set in /proxypool/payout/sharelogger.conf)
  $mon_autopayout = '0.4'; # MON Payout threshold (as set in /proxypool/payout/sharelogger.conf)
  
  $show_email = False; # show email True or False
  $lhs = 'support'; # part of email before @ (*support*@example.com)
  $rhs = 'example.com'; # part of email after @ (support@*example.com*)
  $subject = 'P2Proxy support'; # subject of email
  
?>
