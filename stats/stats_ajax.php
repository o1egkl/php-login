	<p>Statistics</p>
	
	<a href="list.php">Back to list</a>
	<br/><br/>
	The number of unique visitors is (updated):
	<?php
	define("HTTP_SERVER_HOST","localhost");
	define("DB_HOST","ec2-107-22-166-233.compute-1.amazonaws.com");
	define("DB_NAME", "d7u117at9rn0sp");
	define("DB_USER", "jfzwjoocgyrjpc");
	define("DB_PASS", "1THGeXjCzH2fiJ9e2zYqJidTkP");	
	// connect to the database
	
	// fill in your databasa data here!
		//pdo
		try
		{
			$db_connection =  new PDO('pgsql:host='.DB_HOST.';port=5432;dbname='.DB_NAME.';', DB_USER, DB_PASS);
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
