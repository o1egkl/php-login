<html>
<head>
<script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
    selector: "textarea",
    plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
});
</script>
</head>
<body>

<?php
	$lp->doLpEdit($_GET['title']);
?>

<div style="width:50%;border:0px solid black;">
<form method="post" name="form1" action="new.php" id="form1">
  	<label for="input_title">Title</label>
    <input id="input_title" type="text" name="title" required value="<?= (!empty($lp->title))?substr($lp->title,0,strpos($lp->title,'.lp')):'';?>"/>
    <br><br>
    <textarea name="text1" id="text1">
    <?php 
    	if(!empty($lp->html)) 
    			echo ($lp->html); 
    	
    ?>
    </textarea>
</form>
<button type="submit" form="form1" value="Submit">Submit</button>

</div>
<?php 
?>
<br>
<a href="list.php">List</a> <a href="index.php?logout">Logout</a> 
</body>
</html>