<?php

  // Called from bin/active.php

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
  
  function walletLogic ($wallet, $minbalance) {

    $output = array("found_time" => "n/a",
                    "since_time" => "n/a",
                    "immature" => 0,
                    "balance" => 0);
    $found_block = False;
    $last_tx_checked = array("txid" => "n/a",
                             "addr" => "n/a");
    $count = 25;
    
    do {
      $transactions = $wallet->listtransactions("", $count);
      $output['immature'] = 0;
      
      if ( count($transactions) > 0 ) { // check if there are transactions
        $value = end($transactions);
          
        do { // searching for immature or generated blocks
          if ( (array_search('immature', $value) !== False)  || (array_search('generate', $value) !== False) ) {
            if ( $output['found_time'] == 'n/a' ) {
              $output['found_time'] = date("Y-m-d H:i:s", $value['time']);
              $output['since_time'] = diffTime($value['time']);
            }
            if ( $value['category'] == 'generate' ) {
              $found_block = True;
              break;
            }
            if ( $value['category'] == 'immature' ) {
              $output['immature'] += sprintf("%.08f", $value['amount']);
            }
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

    $output['balance'] = sprintf("%.08f", $wallet->getbalance("") - $output['immature'] - $minbalance);
    if ( $output['balance'] < 0 ) $output['balance'] = 0;

    return $output;
  }

  if ( !isset($minbalance) ) $minbalance = 1.0;
  
  $vertcoin_rpc = "http://" . $vtc_wallet_user . ":" . $vtc_wallet_password . "@" . $vtc_wallet_address . "/";
  $vertcoin = new jsonRPCClient($vertcoin_rpc);
  $vertcoin_found = walletLogic($vertcoin, $minbalance);

  $monocle_rpc = "http://" . $mon_wallet_user . ":" . $mon_wallet_password . "@" . $mon_wallet_address . "/";
  $monocle = new jsonRPCClient($monocle_rpc);
  $monocle_found = walletLogic($monocle, $minbalance);

  $output = '<?php $vtc_block_found="' . $vertcoin_found['found_time'] . '"; ';
  $output .= '$vtc_block_since="' . $vertcoin_found['since_time'] . '"; ';
  $output .= '$vtc_balance="' . $vertcoin_found['balance'] . '"; ';
  $output .= '$vtc_immature="' . $vertcoin_found['immature'] . '"; ';
  $output .= '$mon_block_found="' . $monocle_found['found_time'] . '"; ';
  $output .= '$mon_block_since="' . $monocle_found['since_time'] . '"; ';
  $output .= '$mon_balance="' . $monocle_found['balance'] . '"; ';
  $output .= '$mon_immature="' . $monocle_found['immature'] . '"; ?>';
  
  
  $file = dirname(__FILE__) . "/../include/gen-lastblock.php";
  file_put_contents($file, $output);

?>