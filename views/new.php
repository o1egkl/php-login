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
if (!empty($_POST)){
	var_dump($_POST);
	if($lp->doLpAdd()){
		echo "Success";
		header("Location: list.php");
		die();
	}else{
		if ($lp->errors) {
			foreach ($login->errors as $error) {
				echo $error;
			}
		}
	}
}else{
}
?>

<div style="width:50%;border:0px solid black;">
<form method="post" name="form1" action="new.php" id="form1">
  	<label for="input_title">Title</label>
    <input id="input_title" type="text" name="title" required value="<?= (!empty($_POST['title']))?$_POST['title']:'';?>"/>
    <br><br>
    <textarea name="text1" id="text1">
    <?php 
    	if(!empty($_POST['text1'])) 
    			echo $_POST['text1']; 
    	
    ?>
    </textarea>
</form>
<button type="submit" form="form1" value="Submit">Submit</button>

</div>
<?php 
?>
<br>
<a href="list.php?">List</a> <a href="index.php?logout">Logout</a> 
</body>
</html>