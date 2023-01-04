

<div class="bg-light border-left" id="sidebar-wrapper">
	<div class="sidebar-heading"><a href="#"><img srcset="../Logo_Micromet_1.png 40x" ></a></div>

	<div class="sidebar-heading">Estaciones </div>
		<div class="list-group list-group-flush vh-80">
			<div class="body-sidebar">
				<div id="navigation_sidebar_ajax_loader">
					<?php print_r($_SESSION['estaciones_string']);?>
				</div>
			</div>
		</div>
</div>


<script type="text/javascript">
	function toggleMenu(id){
		var display = $('#'+id).css('display');
		if(display == 'none'){
			$('.sidebar_station_link').slideUp();
			$('#'+id).slideDown();
		}
		else{
			$('#'+id).slideUp();
		}
	}
	
	function toggleMenuModel(id){
		var display = $('#'+id).css('display');
		if(display == 'none'){
			$('.sidebar_model_link').slideUp();
			$('#'+id).slideDown();
		}
		else{
			$('#'+id).slideUp();
		}
	}
	
	function activateInstrument(){
		$('#span_estaciones_menu_lateral').hide("fast");
		$('#span_instrumento_menu_lateral').fadeIn("fast");
		$('#span_instrumento_menu_lateral').makeFloat({x:"current",y:70,speed:"fast"});
		$('#link_desactivar_instrumento').show("fast");
		$('#link_activar_instrumento').hide("fast");
	}
	
	function desactivateInstrument(){
		$('#span_instrumento_menu_lateral').fadeOut("fast");
		$('#span_estaciones_menu_lateral').fadeIn("fast");
		$('#link_desactivar_instrumento').hide("fast");
		$('#link_activar_instrumento').show("fast");
		
	}
	
	$(document).ready(function(){
		var sid = $('#sid').val();
		
		//var url = '../system/navigation_sidebar_ajax.inc.php?sid='+sid;
		var estaciones = <?php ($_SESSION['estaciones_string']);?>
		console.log(estaciones);
		$('#navigation_sidebar_ajax_loader').html(estaciones);
			<?php
			if(isset($_GET['eid'])){
				echo "toggleMenu('sidebar_station_link_".$_GET['eid']."');";
				echo "toggleMenuModel('sidebar_model_link_".$_GET['eid']."');";
				// echo "walala";
			}
			?>
		
		// $.get(url,'',function(data){

		// });
		
		<?php
			if(isset($_GET['tipo']) && isset($_GET['tiid'])){
		?>
		$('#link_activar_instrumento').click(function(e){
			activateInstrument();
		});
		
		$('#link_desactivar_instrumento').click(function(e){
			desactivateInstrument();
		});
		
		
		<?php	
				if($_GET['tipo'] == "WINDSPEED" || $_GET['tipo'] == "WINDDIR"){
					?>
					$('#instrumento_lateral').jQueryInstrument({instrumentType:"<?=$_GET['tipo']?>",imgWidth: "250px"});
					<?php	
				}
				else{
					?>
					$('#instrumento_lateral').jQueryInstrument({instrumentType:"<?=$_GET['tipo']?>"});
					<?php
				}
		
			}
		?>
	});

</script>