<?php

  # called from bin/unpaid.php

  function check_updates () {
    $installed = `git rev-parse HEAD`;
    
    $url = "https://api.github.com/repos/Cooba13/proxypool-simplestats/commits";
    $options = array('http' => array('user_agent'=> 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.137 Safari/537.36', 'timeout' => '5'));
    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);
    $commits = json_decode($response);
    
    if ( trim($installed) == $commits[0]->sha ) {
      return False;
    } else
      return True;
  }

  $file = dirname(__FILE__) . "/../include/gen-update.php";

  if ( check_updates() ) {
    file_put_contents($file, '<?php $current = false; ?>');
  } else {
    file_put_contents($file, '<?php $current = true; ?>');
  }
  
?>