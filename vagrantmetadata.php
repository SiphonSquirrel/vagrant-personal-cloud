<?php
header("Content-Type: application/json");

error_log("metadata!");

$versions = array();

foreach (listVersions($repo, $user, $image) as $version) {
	$version_meta = null;
	$version_meta_path = realpath($repo . "/" . $user . "/" . $image . "/" . $version . "/meta.json");
	if ($version_meta_path) {
	  $version_meta_json = json_decode(file_get_contents($version_meta_path));
	  $version_meta = array(
		"description_markdown" => $version_meta_json->description_markdown
	  );
	} else {
	  $version_meta = array(
		"description_markdown" => $version,
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
?>
