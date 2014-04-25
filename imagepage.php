<!DOCTYPE HTML>
<html>
<body>

<div>
  <h2>Image <?php print($user . "/" . $image); ?></h2>
  <div>See more from <a href="<?php print($base_url."/".$user)?>"><?php print($user); ?></a></div>
  <h3>Vagrant Command for new Packages</h3>
  <pre style="border: 1px; border-style: solid;">
	vagrant init <?php print($user . "/" . $image); ?>
  </pre>
  <h3>Versions:</h3>
  <ul>
  <?php foreach (listVersions($repo, $user, $image) as $version) { ?>
	<li>
		<?php print($version); ?>
		<ul>
		  <?php foreach (listProviders($repo, $user, $image, $version) as $provider) { ?>
			<li><a href="<?php print($base_url."/".$user."/".$image."/download/".$version."/".$provider); ?>"><?php print($provider); ?></a></li>
		  <?php } ?>
		</ul>
	</li>
  <?php } ?>
  </ul>
</div>

</body>
</html>
