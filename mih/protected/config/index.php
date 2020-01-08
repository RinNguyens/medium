<?php
// SAVE AS yourapp/facebook-callback.php, review your config main settings, must match.

// SELECT URL MODE.

// USE THIS WHEN URL MANAGER IS ACTIVATED, must match your URL rules: 
// DONT FORGET "?" at the end.
// $url = "index.php/site/crugeconnector/crugekey/facebook/crugemode/callback?";

// USE THIS WHEN YOU ARE NOT USING URL MANAGER:
// 
$url = "index.php?r=/site/crugeconnector&crugekey=facebook&crugemode=callback";

// common code:
foreach($_GET as $key=>$val)
	$url .= "&".$key."=".urlencode($val);
header("Location: ".$url);