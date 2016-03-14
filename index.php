<?php

require_once("utils.php");
require_once("config.php");

//Setup data format
$vagrant_date_time_format = DateTime::ISO8601;

//Get base URL
$base_url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
if (substr($base_url, -4) == '.php') {
	$base_url = substr($base_url, 0, strrpos($base_url, "/"));
}
$base_url = trim($base_url, "/");

//Fetch headers
$headers = apache_request_headers();

if (isset($_GET['_url'])) {
  $url = preg_split("/\\//", trim($_GET['_url'], "/"));
  if (count($url) == 1) {
	$user = $url[0];

	if ($user == "") {
		require("frontpage.php");
	} else {
		require("userpage.php");
	}
  } else if (count($url) == 2) {
	$user = $url[0];
	$image = $url[1];

  error_log(strpos($headers["Accept"], "html"));
	if (strpos($headers["Accept"], "html") !== false) {
		require("imagepage.php");
	} else {
		require("vagrantmetadata.php");
	}
  } else if ((count($url) == 5) && ($url[2] == "download")) {
  	$user = $url[0];
	$image = $url[1];
	$version = $url[3];
	$system = $url[4];

	require("vagrantdownload.php");
  } else {
	header("HTTP/1.0 404 Not Found");
    print "Could not understand request.";
  }

} else {
  print "Is mod_rewrite enabled?";
  exit(-1);
}
?>
