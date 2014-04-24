<?php

function listUsers($repo) {
  $retVal = array();

  $path = realpath($repo);
  if (!$path) {
    return $retVal;
  }
  
  $d = dir($path);
  while (false !== ($entry = $d->read())) {
    if (($entry[0] != '.') and is_dir($path . "/" . $entry)) {
	  array_push($retVal, $entry);
	}
  }
  $d->close();
  return $retVal;
}

function listImages($repo, $user) {
  $retVal = array();

  $path = realpath($repo . "/" . $user);
  if (!$path) {
    return $retVal;
  }
  
  $d = dir($path);
  while (false !== ($entry = $d->read())) {
    if (($entry[0] != '.') and is_dir($path . "/" . $entry)) {
	  array_push($retVal, $entry);
	}
  }
  $d->close();
  return $retVal;
}

function listVersions($repo, $user, $image) {
  $retVal = array();

  $path = realpath($repo . "/" . $user . "/" . $image);
  if (!$path) {
    return $retVal;
  }
  
  $d = dir($path);
  while (false !== ($entry = $d->read())) {
    if (($entry[0] != '.') and is_dir($path . "/" . $entry)) {
	  array_push($retVal, $entry);
	}
  }
  $d->close();
  return $retVal;
}

function listProviders($repo, $user, $image, $version) {
  $retVal = array();

  $path = realpath($repo . "/" . $user . "/" . $image . "/" . $version);
  if (!$path) {
    return $retVal;
  }
  
  $d = dir($path);
  while (false !== ($entry = $d->read())) {
    if (($entry[0] != '.') and is_dir($path . "/" . $entry)) {
	  array_push($retVal, $entry);
	}
  }
  $d->close();
  return $retVal;
}

?>