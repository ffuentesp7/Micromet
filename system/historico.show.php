<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=iso 8859-2" />
		<meta http-equiv="cache-control" content="no-cache" />
		<meta http-equiv="expires" content="3600" />
		<link rel="stylesheet" type="text/css" media="screen,projection,print" href="../css/tablas.css" />
		<title>Datos Hist&oacute;ricos - Tabla de Datos</title>
		<style>
			body {
				background-color:rgb(240,240,240);
			}
			img.centernoborder {
				clear:both; float:none; display:block; margin:0 auto; border:none; background-color: transparent;
			}
		</style>
		<?php require_once('../head.link.script.php'); ?>
		<script type="text/javascript">
			$(document).ready(function(e){
				url = '<?=$_GET['url']?>';
				url2 = url.replace(/@/gi,"&");
				$.get(url2,'',function(data){
					$('#table_content').html(data);	
				});				
			});
		</script>
		<script type="text/javascript" src="js/historico_show.js"></script>
		
	</head>
	<body>
	<h3><?=$_GET['title']?></h3>
	<span id="table_content">
		<br />
		<br />
		<p style="text-align: center; width: 100%;">Cargando datos...</p>
		<br />
		<img class="centernoborder" src="../img/loaders/loader-06.gif" />
	</span>
	</body>
</html>