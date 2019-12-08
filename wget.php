<?php
	$output = array();

	if(isset($_POST['getfile']))
	{
		$msg = '';
		$status = 'success';

		if($_POST['filepath']!='')
		{
			$file = $_POST['filepath'];
			exec("wget " . $file);

			$msg = 'File: <strong>'.$file.'</strong><br> Downloaded successfully';
		} else {
			$msg = 'File: <strong>'.$file.'</strong><br> No file to get ';
			$status = 'danger';
		}

		header('location: wget.php?file='.$file.'&msg=' . $msg .'&status=' . $status);
	}

	function getFilename($path) {
		$last = strrpos($path, "/");
		return substr($path, $last + 1);
	}

	function getFilesize($filename) {
		$size = filesize($filename);

		if($size) {
			$size = $size / (1024 * 1024); //Size in MB
		}

		return $size;
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Transferer App</title>
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<style>
		body { background: #f5f5f5; }
	</style>
</head>
<body>
	<div class="container">
		<?php if(isset($_GET['msg']) && !empty($_GET['msg'])): ?>
			<div class="alert alert-<?= (isset($_GET['status']))?'success':'warning' ?> alert-dismissible fade show mt-3">

				<?php if(isset($_GET['msg'])): ?>
					<?= $_GET['msg'] ?>
				<?php endif; ?>

				<br>

				<?php
					if(isset($_GET['file'])):
						$fsize = getFilesize(getFilename($_GET['file']));
				?>
					File size imported: <?= round($fsize) ?> MB 
				<?php endif; ?>

				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				    <span aria-hidden="true">&times;</span>
				</button>
			</div>
		<?php endif; ?>

		<form action="#" method="post" id="form_trans" class="form-horizontal">
			<div class="card text-white bg-dark mt-5">
			  <div class="card-header text-uppercase">
			    Transfer overseas
			  </div>
			  <div class="card-body">
			    <input type="hidden" name="getfile" value="1">
				<div class="form-group">
					<input type="text" name="filepath" id="filepath" placeholder="Enter full file URL here " class="form-control form-control-lg">
				</div>
			  </div>
			  <div class="card-footer text-muted">
			    <button type="submit" class="btn btn-primary btn-lg btn_trans">
					Let's Transfer it
				</button>
			  </div>
			</div>			
		</form>
	</div>

	<div class="row mt-3">
		<div class="col-md-12 text-center text-muted">
			<small>Powered by WebWorks</small>
		</div>
	</div>

	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
		integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8=" 
		crossorigin="anonymous"></script>

		<script>
			$(document).ready(function() {
				$(document).on('click', '.btn_trans', function(event) {
					event.preventDefault();
					if($('#filepath').val()=='')
					{
						alert('Please enter file path');
						$('#filepath').focus();
					}
					else {
						$(this).html('Loading data ...');
						$(this).addClass('disabled');
						$(this).attr('disabled', 'disabled');
						$('#form_trans').submit();
					}
				});
				$(document).on('click', '.close', function(event) {
					event.preventDefault();
					$(this).parents('.alert').hide();
				});
			});
		</script>
</body></html>