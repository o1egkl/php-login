<div id="statistics">	
	<p>Statistics</p>
	<a href="list.php">Back to list</a>
	<br/><br/>
	The number of unique visitors is:
<?php
	echo $stats->doGetDistinctStats($_GET['page']);
	$stats->doGetStats($_GET['page']);
?>
	Site's visitors: <?= $stats->result->rowCount(); ?>
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
		
		//pdo
		while($row = $stats->result->fetch(PDO::FETCH_ASSOC))
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
</div>	
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script language="javascript" type="text/javascript">

setInterval(function(){
	//	alert('refreshing');
    $('#statistics').load('stats/stats_ajax.php?page=<?php echo $_GET['page'];?>');
},6000);
</script>