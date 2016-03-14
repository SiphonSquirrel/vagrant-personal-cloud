<?php
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

header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename=' . $user . '-' . $image . '-' . $version . '.box');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($file));
ob_end_clean();
flush();
readfile($file);
flush();
exit;
?>
