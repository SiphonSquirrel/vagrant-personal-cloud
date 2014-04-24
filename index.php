<?php

require_once("utils.php");
require_once("config.php");

$vagrant_date_time_format = DateTime::ISO8601;

$base_url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
if (substr($base_url, -4) == '.php') {
	$base_url = substr($base_url, 0, strrpos($base_url, "/"));
}
$base_url = trim($base_url, "/");

if (isset($_GET['_url'])) {
  $url = preg_split("/\\//", trim($_GET['_url'], "/"));
  if (count($url) == 2) {
    header("Content-Type: application/json");
	
	$user = $url[0];
	$image = $url[1];
	
	$versions = array();
	
	foreach (listVersions($repo, $user, $image) as $version) {
		$version_meta = null;
		$version_meta_path = realpath($repo . "/" . $user . "/" . $image . "/meta.json");
		if ($version_meta_path) {
		  $version_meta_json = json_decode(file_get_contents($version_meta_path));
		  $version_meta = array(
			"description_markdown" => $version_meta_json->description_markdown
		  );
		} else {
		  $version_meta = array(
			"description_markdown" => $image,
		  );
		}
	
		$providers = array();
		foreach (listProviders($repo, $user, $image, $version) as $provider) {
			$p = array(
				"name" => $provider,
				"url" => $base_url . "/" . $user . "/" . $image . "/download/" . $version . "/" . $provider
			);
			array_push($providers, $p);
		}
		$v = array(
			"version" => $version,
			"status" => "active",
			"description_html" => "<p>" . $version_meta["description_markdown"] . "</p>",
			"description_markdown" => $version_meta["description_markdown"],
			"providers" => $providers
		);
		array_push($versions, $v);
	}

	$image_meta = null;
	$image_meta_path = realpath($repo . "/" . $user . "/" . $image . "/meta.json");
	if ($image_meta_path) {
	  $image_meta_json = json_decode(file_get_contents($image_meta_path));
	  $image_meta = array(
	    "description_markdown" => $image_meta_json->description_markdown,
		"short_description" => $image_meta_json->short_description,
	  );
	} else {
	  $image_meta = array(
	    "description_markdown" => $image,
		"short_description" => $image,
	  );
	}
	
	$image_info = array(
	  "description" => $image_meta["description_markdown"],
	  "short_description" => $image_meta["short_description"],
	  "name" => $user . "/" . $image,
	  "versions" => $versions
	);

    print(str_replace('\/','/',json_encode($image_info)));
  } else if ((count($url) == 5) && ($url[2] == "download")) { 
  	$user = $url[0];
	$image = $url[1];
	$version = $url[3];
	$system = $url[4];
	
	$file = realpath($repo . "/" . $user . "/" . $image . "/" . $version . "/" . $system . "/package.box");
	
	if (!$file) {
	  header("HTTP/1.0 404 Not Found");
	  print "File not found.";
	  exit;
	}
	
	if (substr_compare($file, $repo . "/", 0, strlen($repo . "/") != 0)) {
	  header("HTTP/1.0 404 Not Found");
	  print "File not found.";
	  exit;
	}
	
	header("Content-Type: application/octet-stream");
	ob_end_flush();
    readfile($file);
  } else {
    print_r($url);
  }
  
} else {
  print "Is mod_rewrite enabled?";
  exit(-1);  
}
?>
