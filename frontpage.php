<!DOCTYPE HTML>
<html>
<body>

<div>
  <h2>Users</h2>
  <div><span style="font-weight: bold">Note:</span> To use this server, please set the environment variable <span style="border: 1px; border-style: solid;">VAGRANT_SERVER_URL</span> to <span style="border: 1px; border-style: solid;"><?php print($base_url); ?></span></div>
  <ul>
  <?php foreach (listUsers($repo) as $user) { ?>
	<li><a href="<?php print($base_url."/".$user); ?>"><?php print($user); ?></a></li>
  <?php } ?>
  </ul>
</div>

</body>
</html>