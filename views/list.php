<!-- if you need user information, just put them into the $_SESSION variable and output them here -->
<h1>List of LP's</h1>
<ul>
<?php $lp->doLpList();?>
</ul>

<div>
	<a href="new.php">Add new LP</a>

<a href="index.php?logout">Logout</a>
</div>