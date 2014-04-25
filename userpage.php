<!DOCTYPE HTML>
<html>
<body>

<div>
  <h2>Images for <?php print($user); ?></h2>
  <div>See more users <a href="<?php print($base_url)?>">here</a></div>
  <ul>
  <?php foreach (listImages($repo, $user) as $image) { ?>
	<li><a href="<?php print($base_url."/".$user."/".$image); ?>"><?php print($image); ?></a></li>
  <?php } ?>
  </ul>
</div>

</body>
</html>