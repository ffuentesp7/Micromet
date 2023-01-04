<div id="footpanel">
	<ul>
		<li title = "P&aacute;gina Principal"><a href="../system/index.php?sid=<?=$_SESSION['session_nombre_sesion']?>"><img src="../img/footpanel/home.png"/></a></li>
	</ul>
	<span class="jx-separator-left"></span>
	<ul>
		<li title="Mis Datos"><a href="../system/mis_datos.php?sid=<?=$_SESSION['session_nombre_sesion']?>"><img src="../img/footpanel/user.png"/></a></li>
		<?php if(get_parameter('INTERNAL_MAIL_SYSTEM') == "ON"){ ?>
		<li title="Mensajes"><a href="../system/index.php?sid=<?=$_SESSION['session_nombre_sesion']?>"><img src="../img/footpanel/mail.png"/></a></li>
		<?php }?>
	</ul>
	<?php
	if($_SESSION['session_usuario_administrador'] == 1){
	?>
	<span class="jx-separator-left"></span>
	<ul>
		<li title="Panel de Administraci&oacute;n"><a href="../admin/index.php?sid=<?=$_SESSION['session_nombre_sesion']?>"><img src="../img/footpanel/settings.png"/></a></li>
		<li title="Agregar Usuario"><a href="../admin/usuarios.php?sid=<?=$_SESSION['session_nombre_sesion']?>&page=add"><img src="../img/footpanel/user-plus.png"/></a></li>
		<li title="Estad&iacute;sticas"><a href="../admin/estadisticas.php?sid=<?=$_SESSION['session_nombre_sesion']?>"><img src="../img/footpanel/chart.png"/></a></li>
		<li title="Permisos"><a href="../admin/permisos.php?sid=<?=$_SESSION['session_nombre_sesion']?>"><img src="../img/footpanel/key.png"/></a></li>
		<li title="Bit&aacute;cora"><a href="../admin/bitacora.php?sid=<?=$_SESSION['session_nombre_sesion']?>"><img src="../img/footpanel/log.png"/></a></li>
		<li title="Bit&aacute;cora de Eventos Escrita"><a href="../admin/bitacora_escrita.php?sid=<?=$_SESSION['session_nombre_sesion']?>"><img src="../img/footpanel/write-log.png"/></a></li>
		<li title="Monitor de Estaciones"><a href="../admin/estaciones.descarga.php?sid=<?=$_SESSION['session_nombre_sesion']?>&page=main"><img src="../img/footpanel/monitor.png"/></a></li>
	</ul>
	<?php
	}
	?>
	<span class="jx-separator-left"></span>
	
	
        <ul class="jx-bar-button-right">
        	<li title="Desconectar"><a href="../index.php?sid=<?=$_SESSION['session_nombre_sesion']?>"><img src="../img/footpanel/plug-disconnect.png"/></a></li>
        </ul>
        <ul class="jx-bar-button-right">
        	<li title="Subir P&aacute;gina"><a href="#pageup" id="link_up_page"><img src="../img/footpanel/arrow_up.png"/></a></li>
        </ul>
        
        <!--[if lt IE 9]>
        <ul class="jx-bar-button-right">
		<li title="Advertencia de Navegador"><a href="#" id="navegador_incompatible"><img src="../img/footpanel/error.png" alt="Navegador Incompatible" /></a>
                	<ul>
                		<li><p align="justify" style="color: #fff;">Su navegador es incompatible con los est&aacute;ndares de este sitio web, si desea mejorar su experiencia de usuario actual&iacute;celo o elija una de las siguientes alternativas en su &uacute;ltima versi&oacute;n.</p></li>
        			<li><a href='http://www.mozilla-europe.org/es/firefox/' target='_blank'><img src='../img/footpanel/firefox.png' alt='Descargar Firefox'/></a></li>
		        	<li><a href='http://windows.microsoft.com/es-ES/internet-explorer/products/ie/home' target='_blank'><img src='../img/footpanel/iexplorer.png' alt='Descargar IExplorer'/></a></li>
		        	<li><a href='http://www.apple.com/es/safari/download/' target='_blank'><img src='../img/footpanel/safari.png' alt='Descargar Safari'/></a></li>
		        	<li><a href='http://www.opera.com/browser/download/' target='_blank'><img src='../img/footpanel/opera.png' alt='Descargar Opera'/></a></li>
		        	<li><a href='http://www.google.com/chrome?hl=es' target='_blank'><img src='../img/footpanel/chrome.png' alt='Descargar Google Chrome'/></a></li>
                	</ul>
		</li>
        </ul>
        <script type="text/javascript">
	$(document).ready(function() {
		$('#navegador_incompatible').click();
	});
	</script>
	<![endif]-->

</div>
<script type="text/javascript">
    $(document).ready(function() {
		$("#footpanel").jixedbar();
		
		$('#link_up_page').click(function() {
			var elementClicked = $(this).attr("href");
			var destination = $(elementClicked).offset().top;
			$("html:not(:animated),body:not(:animated)").animate({ scrollTop: destination-20}, 500 );
			return false;
		});
    });
</script>

<input type="hidden" name="sid" id="sid" value="<?=$_SESSION['session_nombre_sesion']?>"/>