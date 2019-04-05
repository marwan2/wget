<?php
	$output = array();
	if(isset($_POST['getfile']))
	{
		if($_POST['filepath']!='')
		{
			$file = $_POST['filepath'];
			exec("wget " . $file);
			$output['message'] = 'File downloaded successfully';
		} else {
			$output['message'] = ' No file to get ';
		}
	}

?>

<?php if(!empty($output)): ?>
	<div style="background:yellow;padding:20px;"><?= $output['message'] ?></div>
<?php endif; ?>
<form action="#" method="post">
	<input type="hidden" name="getfile" value="1">
	<p>
		<input type="text" name="filepath" style="width:100%; padding:10px; font-size:25px;"><br>
	</p>
	<p>
		<input type="submit" value="Get file">
	</p>
</form>