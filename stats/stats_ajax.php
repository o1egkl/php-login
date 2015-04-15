	<p>Statistics</p>
	
	<a href="list.php">Back to list</a>
	<br/><br/>
	The number of unique visitors is:
	<?php
	define("HTTP_SERVER_HOST","localhost");
	define("DB_HOST",HTTP_SERVER_HOST);
	define("DB_NAME", "admin");
	define("DB_USER", "root");
	define("DB_PASS", "");	
	// connect to the database
	
	// fill in your databasa data here!
		//pdo
		try
		{
			$db_connection =  new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8', DB_USER, DB_PASS);
			$query = "select distinct ip from tracker WHERE page LIKE "."'". htmlspecialchars($_GET['page'])."'";
			$result = $db_connection->query($query);
			if ($result->rowCount() > 0) {
				// show the number
				echo $result->rowCount();
			}
			$query = "select * from tracker WHERE page LIKE "."'". htmlspecialchars($_GET['page'])."'";
			$result = $db_connection->query($query);
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
		
	?>
	Site's visitors: <?= $result->rowCount(); ?>
	<br/><br/>
	<table border="1" style="width:80%;">
		<tr>
			<th>IP</th>
			<th>User agent</th>
			<th>Country</th>
			<th>City</th>
			<th>Referer</th>
			<th>Is a bot?</th>
		</tr>
		<?php
		// get the list of visitors
		
		////pdo
		while($row = $result->fetch(PDO::FETCH_ASSOC))
		{
			?>
			<tr>
				<td><?php echo $row['ip'];?></td>
				<td><?php echo $row['http_user_agent'];?></td>
				<td><?php echo $row['country'];?></td>
				<td><?php echo $row['city'];?></td>
				<td><?php echo $row['http_referer'];?></td>
				<td><?php if ($row['isbot']==1) echo "yes"; else echo "no";?></td>
			</tr>
			<?php
		}
		?>
	</table>
