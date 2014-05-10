<?php

  require_once dirname(__FILE__) . "/../include/jsonRPCClient.php";
  require_once dirname(__FILE__) . "/../include/config.php";
  
  function diffTime ($time) {
    $now = date("U");
    $diff = $now - $time;
    
    $days = $diff / 86400;
    $hours = ($diff % 86400) / 3600;
    $minutes = ($diff % 3600) / 60;
    
    return sprintf ("%dd %02d:%02d", $days, $hours, $minutes);
  }
  
  function findBlock ($wallet) {

    $output = array("found_time" => "n/a",
                    "since_time" => "n/a");
    $found_block = False;
    $last_tx_checked = array("txid" => "n/a",
                             "addr" => "n/a");
    $count = 25;
    
    do {
      $transactions = $wallet->listtransactions("", $count);
      
      if ( count($transactions) > 0 ) { // check if there are transactions
        $value = end($transactions);
          
        do { // searching for immature or generated blocks
          if ( (array_search('immature', $value) !== False)  || (array_search('generated', $value) !== False) ) {
            $output['found_time'] = date("Y-m-d H:i:s", $value['time']);
            $output['since_time'] = diffTime($value['time']);
            $found_block = True;
            break;
          }
          if ( prev($transactions) === False ) {
            break;
          } else {
            $value = current($transactions);
          }
        } while ( True );
      }
      
      if ( $last_tx_checked['txid'] == $value['txid'] && $last_tx_checked['addr'] == $value['address'] ) {
        break;
      } else {
        $last_tx_checked['txid'] = $value['txid'];
        $last_tx_checked['addr'] = $value['address'];
      }
      
      $count += $count;
    } while ( !$found_block );

    return $output;
  }
  
  $vertcoin_rpc = "http://" . $vtc_wallet_user . ":" . $vtc_wallet_password . "@" . $vtc_wallet_address . "/";
  $vertcoin = new jsonRPCClient($vertcoin_rpc);
  $vertcoin_found = findBlock($vertcoin);

  $monocle_rpc = "http://" . $mon_wallet_user . ":" . $mon_wallet_password . "@" . $mon_wallet_address . "/";
  $monocle = new jsonRPCClient($monocle_rpc);
  $monocle_found = findBlock($monocle);

  $output = '<?php $vtc_block_found="' . $vertcoin_found['found_time'] . '"; ';
  $output .= '$vtc_block_since="' . $vertcoin_found['since_time'] . '"; ';
  $output .= '$mon_block_found="' . $monocle_found['found_time'] . '"; ';
  $output .= '$mon_block_since="' . $monocle_found['since_time'] . '"; ?>';
  
  $file = dirname(__FILE__) . "/../include/gen-lastblock.php";
  file_put_contents($file, $output);

?>