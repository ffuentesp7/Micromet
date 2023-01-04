<?php
	require('../aut_verifica.inc.php');
	require('../funciones.inc.php');
	estadisticas('WEB','PAGE_VIEW');
	estadisticas('USER_USE','MOD_FORECAST_ADMIN');
	$HASH = get_parameter('TWITTER_HASH');
	$TWEET_URL = get_parameter('TWITTER_SERVER');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<!--  Version: Multiflex-5.4 / Overview                     -->
<!--  Date:    Nov 23, 2010                                 -->
<!--  Design:  www.1234.info                                -->
<!--  Modified:  roaguilar@utalca.cl                        -->
<!--  License: Fully open source without restrictions.      -->
	<head>
  		<meta http-equiv="content-type" content="text/html; charset=iso 8859-2" />
		<meta http-equiv="cache-control" content="no-cache" />
		<meta http-equiv="expires" content="3600" />
		<meta name="revisit-after" content="2 days" />
		<meta name="robots" content="index,follow" />
		
		<meta name="copyright" content="Micromet - Biovisión" />
		
		<meta name="distribution" content="global" />
		<meta name="description" content="Micromet" />
		<meta name="keywords" content="vizualizaci�n, agua, agricultura, agroclimatolog�a, climatolog�a" />
		<link rel="stylesheet" type="text/css" media="screen,projection,print" href="../css/mf54_reset.css" />
  		<link rel="stylesheet" type="text/css" media="screen,projection,print" href="../css/mf54_grid.css" />
  		<link rel="stylesheet" type="text/css" media="screen,projection,print" href="../css/mf54_content.css" />
		<link rel="icon" type="image/x-icon" href="../img/favicon.ico" />
		<?php require_once('../head.link.script.php'); ?>
		<script type="text/javascript" src="../js/msdropdown/js/jquery.dd.js"></script>
		<script type="text/javascript" src="../system_modules/js/mod_forecast.js"></script>
		<link rel="stylesheet" type="text/css" media="screen,projection,print" href="../js/msdropdown/dd.css" />
		<title>Micromet - Biovision</title>
	</head>

<!-- Global IE fix to avoid layout crash when single word size wider than column width -->
<!-- Following line MUST remain as a comment to have the proper effect -->
<!--[if IE]><style type="text/css"> body {word-wrap: break-word;}</style><![endif]-->

	<body>
		<!-- CONTAINER FOR ENTIRE PAGE -->
		<div class="container">

    			 <!-- B. NAVIGATION BAR -->
			 <?php require('../system/navigation_bar.inc.php'); ?>   
  
			<!-- C. MAIN SECTION -->      
			<div class="main">

				<!-- C.1 CONTENT -->
				<div class="content">
					<a id="anchor-heading-1"></a>
					<div class="corner-content-1col-top"></div> 
					<?php
						$page = 'main';
						if(isset($_GET['page'])){
							$page = $_GET['page'];
						}
						
						if($page == 'main'){
						?>
						<div class="content-1col-nobox">
							<h1 class="webtemplate" id="top_title">Pron&oacute;stico del Tiempo - Administraci&oacute;n</h1>
							<h2>Listado de Pronosticos:</h2>
							<p id="lista_pronosticos">
							</p>
						</div> 
						<?php
						}
						elseif($page == 'add'){
						?>
						<script type="text/javascript">
							var tweet_hash = '<?php //=$HASH?>';
							var tweet_url = '<?php //=$TWEET_URL?>';
							jQuery(document).ready(function(){
								jQuery( "#fecha" ).datepicker({
									dateFormat : "yy-mm-dd",
									showAnim : "blind",
									changeMonth: true,
									changeYear: true
								});
							});
							jQuery(document).ready(function(){
								$("#clima").msDropDown({visibleRows:5, rowHeight:48});
								$("#clima").bind("change",function(){
									$("#pronos_img").attr("src","../img/climaicons/"+$("#clima option:selected").val()+".png");
								});
								
								$("#clima1").msDropDown({visibleRows:5, rowHeight:48});
								$("#clima1").bind("change",function(){
									$("#pronos_img1").attr("src","../img/climaicons/"+$("#clima1 option:selected").val()+".png");
								});
								
								$("#clima2").msDropDown({visibleRows:5, rowHeight:48});
								$("#clima2").bind("change",function(){
									$("#pronos_img2").attr("src","../img/climaicons/"+$("#clima2 option:selected").val()+".png");
								});
								
								$("#clima3").msDropDown({visibleRows:5, rowHeight:48});
								$("#clima3").bind("change",function(){
									$("#pronos_img3").attr("src","../img/climaicons/"+$("#clima3 option:selected").val()+".png");
								});
							});
						</script>
						<div class="content-1col-nobox">
							<h1 class="webtemplate" id="top_title">Pron&oacute;stico del Tiempo - Agregar</h1>
							<p><a href="mod_forecast_index.php?sid=<?=$_SESSION['session_nombre_sesion']?>">volver</a></p>
							<div class="contactform" id="cuadroingreso">
								<form>
									<fieldset><legend>&nbsp;NUEVO PRON&Oacute;STICO&nbsp;</legend>
										<table style="width: 90%">
											<tr>
												<th><p>Fecha:</p></th>
												<td><input type="text" name="fecha" id="fecha" class="field" value="<?=date("Y-m-d")?>" style="width: 100px; text-align:center;" /></td>
											</tr>
											<tr>
												<th><p>Temperatura M&iacute;nima:</p></th>
												<td><input type="text" name="temp_min" id="temp_min" class="field" value="" tabindex="4" style="width: 40px; text-align:center;"/>&ordm;C a las 
													<select name="temp_min_hora" id="temp_min_hora" class="combo" style="width: 45px;">
														<option value="00">00</option>
														<option value="01">01</option>
														<option value="02">02</option>
														<option value="03">03</option>
														<option value="04">04</option>
														<option value="05">05</option>
														<option value="06">06</option>
														<option value="07">07</option>
														<option value="08">08</option>
														<option value="09">09</option>
														<option value="10">10</option>
														<option value="11">11</option>
														<option value="12">12</option>
														<option value="13">13</option>
														<option value="14">14</option>
														<option value="15">15</option>
														<option value="16">16</option>
														<option value="17">17</option>
														<option value="18">18</option>
														<option value="19">19</option>
														<option value="20">20</option>
														<option value="21">21</option>
														<option value="22">22</option>
														<option value="23">23</option>
													</select>
													:
													<select name="temp_min_minuto" id="temp_min_minuto" class="combo" style="width: 45px;">
            													<option value="00">00</option>
            													<option value="01">01</option>
            													<option value="02">02</option>
            													<option value="03">03</option>
            													<option value="04">04</option>
            													<option value="05">05</option>
            													<option value="06">06</option>
            													<option value="07">07</option>
            													<option value="08">08</option>
            													<option value="09">09</option>
            													<option value="10">10</option>
            													<option value="11">11</option>
            													<option value="12">12</option>
            													<option value="13">13</option>
            													<option value="14">14</option>
            													<option value="15">15</option>
            													<option value="16">16</option>
            													<option value="17">17</option>
            													<option value="18">18</option>
            													<option value="19">19</option>
            													<option value="20">20</option>
            													<option value="21">21</option>
            													<option value="22">22</option>
            													<option value="23">23</option>
            													<option value="24">24</option>
            													<option value="25">25</option>
            													<option value="26">26</option>
            													<option value="27">27</option>
            													<option value="28">28</option>
            													<option value="29">29</option>
            													<option value="30">30</option>
            													<option value="31">31</option>
            													<option value="32">32</option>
            													<option value="33">33</option>
            													<option value="34">34</option>
            													<option value="35">35</option>
            													<option value="36">36</option>
            													<option value="37">37</option>
            													<option value="38">38</option>
            													<option value="39">39</option>
            													<option value="40">40</option>
            													<option value="41">41</option>
            													<option value="42">42</option>
            													<option value="43">43</option>
            													<option value="44">44</option>
            													<option value="45">45</option>
            													<option value="46">46</option>
            													<option value="47">47</option>
            													<option value="48">48</option>
            													<option value="49">49</option>
            													<option value="50">50</option>
            													<option value="51">51</option>
            													<option value="52">52</option>
            													<option value="53">53</option>
            													<option value="54">54</option>
            													<option value="55">55</option>
            													<option value="56">56</option>
            													<option value="57">57</option>
            													<option value="58">58</option>
            													<option value="59">59</option>
            												</select>hrs.
												</td>
											</tr>
											<tr>
												<th><p>Temperatura M&aacute;xima Ayer:</p></th>
												<td><input type="text" name="temp_max_ay" id="temp_max_ay" class="field" value="" tabindex="4" style="width: 40px; text-align:center;"/>&ordm;C a las 
													<select name="temp_max_ay_hora" id="temp_max_ay_hora" class="combo" style="width: 45px;">
														<option value="00">00</option>
														<option value="01">01</option>
														<option value="02">02</option>
														<option value="03">03</option>
														<option value="04">04</option>
														<option value="05">05</option>
														<option value="06">06</option>
														<option value="07">07</option>
														<option value="08">08</option>
														<option value="09">09</option>
														<option value="10">10</option>
														<option value="11">11</option>
														<option value="12">12</option>
														<option value="13">13</option>
														<option value="14">14</option>
														<option value="15">15</option>
														<option value="16">16</option>
														<option value="17">17</option>
														<option value="18">18</option>
														<option value="19">19</option>
														<option value="20">20</option>
														<option value="21">21</option>
														<option value="22">22</option>
														<option value="23">23</option>
													</select>
													:
													<select name="temp_max_ay_minuto" id="temp_max_ay_minuto" class="combo" style="width: 45px;">
            													<option value="00">00</option>
            													<option value="01">01</option>
            													<option value="02">02</option>
            													<option value="03">03</option>
            													<option value="04">04</option>
            													<option value="05">05</option>
            													<option value="06">06</option>
            													<option value="07">07</option>
            													<option value="08">08</option>
            													<option value="09">09</option>
            													<option value="10">10</option>
            													<option value="11">11</option>
            													<option value="12">12</option>
            													<option value="13">13</option>
            													<option value="14">14</option>
            													<option value="15">15</option>
            													<option value="16">16</option>
            													<option value="17">17</option>
            													<option value="18">18</option>
            													<option value="19">19</option>
            													<option value="20">20</option>
            													<option value="21">21</option>
            													<option value="22">22</option>
            													<option value="23">23</option>
            													<option value="24">24</option>
            													<option value="25">25</option>
            													<option value="26">26</option>
            													<option value="27">27</option>
            													<option value="28">28</option>
            													<option value="29">29</option>
            													<option value="30">30</option>
            													<option value="31">31</option>
            													<option value="32">32</option>
            													<option value="33">33</option>
            													<option value="34">34</option>
            													<option value="35">35</option>
            													<option value="36">36</option>
            													<option value="37">37</option>
            													<option value="38">38</option>
            													<option value="39">39</option>
            													<option value="40">40</option>
            													<option value="41">41</option>
            													<option value="42">42</option>
            													<option value="43">43</option>
            													<option value="44">44</option>
            													<option value="45">45</option>
            													<option value="46">46</option>
            													<option value="47">47</option>
            													<option value="48">48</option>
            													<option value="49">49</option>
            													<option value="50">50</option>
            													<option value="51">51</option>
            													<option value="52">52</option>
            													<option value="53">53</option>
            													<option value="54">54</option>
            													<option value="55">55</option>
            													<option value="56">56</option>
            													<option value="57">57</option>
            													<option value="58">58</option>
            													<option value="59">59</option>
            												</select>&nbsp;hrs.
												</td>
											</tr>
											<tr>
												<th><p>Humedad Relativa del Aire:</p></th>
												<td><input type="text" name="humedad" id="humedad" class="field" value="" tabindex="4" style="width: 40px; text-align:center;"/>&nbsp;&#037;</td>
											</tr>
											<tr>
												<th><p>Presi&oacute;n Atmosf&eacute;rica:</p></th>
												<td><input type="text" name="presion" id="presion" class="field" value="" tabindex="4" style="width: 40px; text-align:center;"/>&nbsp;Hectopascales</td>
											</tr>
											<tr>
												<th><p>Evaporaci&oacute;n:</p></th>
												<td><input type="text" name="evaporacion" id="evaporacion" class="field" value="" tabindex="4" style="width: 40px; text-align:center;"/>&nbsp;mm.</td>
											</tr>
											<tr>
												<th colspan="2"><p>Precipitaciones</p></th>
											</tr>
											<tr>
												<th><p>&Uacute;ltima Lluvia:</p></th>
												<td><input type="text" name="pp_ultima" id="pp_ultima" class="field" value="" tabindex="4" style="width: 40px; text-align:center;"/>&nbsp;mm.</td>
											</tr>
											<tr>
												<th><p>Total a la fecha:</p></th>
												<td><input type="text" name="pp_total" id="pp_total" class="field" value="" tabindex="4" style="width: 40px; text-align:center;"/>&nbsp;mm.</td>
											</tr>
											<tr>
												<th><p>Normal a la fecha:</p></th>
												<td><input type="text" name="pp_normal" id="pp_normal" class="field" value="" tabindex="4" style="width: 40px; text-align:center;"/>&nbsp;mm.</td>
											</tr>
											<tr>
												<th><p>Superavit a la fecha:</p></th>
												<td><input type="text" name="pp_superavit" id="pp_superavit" class="field" value="" tabindex="4" style="width: 40px; text-align:center;"/>&nbsp;mm. que equivalen al <input type="text" name="pp_superavit_por" id="pp_superavit_por" class="field" value="" tabindex="4" style="width: 30px; text-align:center;"/> &#037;</td>
											</tr>
											<tr>
												<th><p>D&eacute;ficit a la fecha:</p></th>
												<td><input type="text" name="pp_deficit" id="pp_deficit" class="field" value="" tabindex="4" style="width: 40px; text-align:center;"/>&nbsp;mm. que equivalen al <input type="text" name="pp_deficit_por" id="pp_deficit_por" class="field" value="" tabindex="4" style="width: 30px; text-align:center;"/> &#037;</td>
											</tr>
											<tr>
												<th colspan="2"><h2>Pron&oacute;sticos</h2></th>
											</tr>
											<tr>
												<th><p>Pron&oacute;stico hoy:</p></th>
												<td>
													<textarea id="prono" style="width: 200px; height: 100px;"></textarea>
													<img src="../img/climaicons/noimg.png" id="pronos_img" />
													<br />
													<select id="clima" class="combo" style="width: 220px; float: right;">
														<option value="noimg" title="../img/climaicons/noimg.png">Sin Imagen</option>
														<option value="solcaluroso" title="../img/climaicons/solcaluroso.png">Despejado Alta T.</option>
														<option value="sol" title="../img/climaicons/sol.png">Despejado</option>
														<option value="neblina" title="../img/climaicons/neblina.png">Neblina</option>
														<option value="niebla" title="../img/climaicons/niebla.png">Niebla</option>
														<option value="parcialalta" title="../img/climaicons/parcialalta.png">Nub. Parcial Alta</option>
														<option value="parcial" title="../img/climaicons/parcial.png">Nub. Parcial</option>
														<option value="parcial2" title="../img/climaicons/parcial2.png">Nub. Parcial</option>
														<option value="bruma01" title="../img/climaicons/bruma01.png">Bruma</option>
														<option value="bruma02" title="../img/climaicons/bruma02.png">Bruma</option>
														<option value="bruma03" title="../img/climaicons/bruma03.png">Bruma</option>
														<option value="cubierto" title="../img/climaicons/cubierto.png">Cubierto</option>
														<option value="llovizna" title="../img/climaicons/llovizna.png">Llovizna</option>
														<option value="lluvia" title="../img/climaicons/lluvia.png">Lluvia</option>
														<option value="lluviamatinal" title="../img/climaicons/lluviamatinal.png">Lluvia Matinal</option>
														<option value="lluviavientofuerte" title="../img/climaicons/lluviavientofuerte.png">Lluvia y viento fuerte</option>
														<option value="lluviavientomoderado" title="../img/climaicons/lluviavientomoderado.png">Lluvia y viento moderado</option>
														<option value="granizo" title="../img/climaicons/granizo.png">Granizo</option>
														<option value="lluvianieve" title="../img/climaicons/lluvianieve.png">Lluvia con Nieve</option>
														<option value="nieve" title="../img/climaicons/nieve.png">Nieve</option>
														<option value="nieveviento" title="../img/climaicons/nieveviento.png">Nieve con Viento</option>
														<option value="parciallluvia" title="../img/climaicons/parciallluvia.png">Lluvia a Parcial</option>
														<option value="lluviaelectrica" title="../img/climaicons/lluviaelectrica.png">T. Electrica</option>
														<option value="lluviaelectricasol" title="../img/climaicons/lluviaelectricasol.png">T. Electrica a Parcial</option>
														<option value="cubiertofrio" title="../img/climaicons/cubiertofrio.png">Cubierto y Baja Temperatura</option>
														<option value="despejadofrio" title="../img/climaicons/despejadofrio.png">Despejado y Baja Temperatura</option>
														<option value="friomatinal" title="../img/climaicons/friomatinal.png">Baja Temperatura Matinal</option>
														<option value="parcialfrio" title="../img/climaicons/parcialfrio.png">Parcial y Baja Temperatura</option>
													</select>
													
												</td>
											</tr>
											<tr>
												<th><p>Pron&oacute;stico para 1 d&iacute;a:</p></th>
												<td>
													<textarea id="prono1" style="width: 200px; height: 100px;"></textarea>
													<img src="../img/climaicons/noimg.png" id="pronos_img1" />
													<br />
													<select id="clima1" class="combo" style="width: 220px; float: right;">
														<option value="noimg" title="../img/climaicons/noimg.png">Sin Imagen</option>
														<option value="solcaluroso" title="../img/climaicons/solcaluroso.png">Despejado Alta T.</option>
														<option value="sol" title="../img/climaicons/sol.png">Despejado</option>
														<option value="neblina" title="../img/climaicons/neblina.png">Neblina</option>
														<option value="niebla" title="../img/climaicons/niebla.png">Niebla</option>
														<option value="parcialalta" title="../img/climaicons/parcialalta.png">Nub. Parcial Alta</option>
														<option value="parcial" title="../img/climaicons/parcial.png">Nub. Parcial</option>
														<option value="parcial2" title="../img/climaicons/parcial2.png">Nub. Parcial</option>
														<option value="bruma01" title="../img/climaicons/bruma01.png">Bruma</option>
														<option value="bruma02" title="../img/climaicons/bruma02.png">Bruma</option>
														<option value="bruma03" title="../img/climaicons/bruma03.png">Bruma</option>
														<option value="cubierto" title="../img/climaicons/cubierto.png">Cubierto</option>
														<option value="llovizna" title="../img/climaicons/llovizna.png">Llovizna</option>
														<option value="lluvia" title="../img/climaicons/lluvia.png">Lluvia</option>
														<option value="lluviamatinal" title="../img/climaicons/lluviamatinal.png">Lluvia Matinal</option>
														<option value="lluviavientofuerte" title="../img/climaicons/lluviavientofuerte.png">Lluvia y viento fuerte</option>
														<option value="lluviavientomoderado" title="../img/climaicons/lluviavientomoderado.png">Lluvia y viento moderado</option>
														<option value="granizo" title="../img/climaicons/granizo.png">Granizo</option>
														<option value="lluvianieve" title="../img/climaicons/lluvianieve.png">Lluvia con Nieve</option>
														<option value="nieve" title="../img/climaicons/nieve.png">Nieve</option>
														<option value="nieveviento" title="../img/climaicons/nieveviento.png">Nieve con Viento</option>
														<option value="parciallluvia" title="../img/climaicons/parciallluvia.png">Lluvia a Parcial</option>
														<option value="lluviaelectrica" title="../img/climaicons/lluviaelectrica.png">T. Electrica</option>
														<option value="lluviaelectricasol" title="../img/climaicons/lluviaelectricasol.png">T. Electrica a Parcial</option>
														<option value="cubiertofrio" title="../img/climaicons/cubiertofrio.png">Cubierto y Baja Temperatura</option>
														<option value="despejadofrio" title="../img/climaicons/despejadofrio.png">Despejado y Baja Temperatura</option>
														<option value="friomatinal" title="../img/climaicons/friomatinal.png">Baja Temperatura Matinal</option>
														<option value="parcialfrio" title="../img/climaicons/parcialfrio.png">Parcial y Baja Temperatura</option>
													</select>
													
												</td>
											</tr>
											<tr>
												<th><p>Pron&oacute;stico para 2 d&iacute;as:</p></th>
												<td>
													<textarea id="prono2" style="width: 200px; height: 100px;"></textarea>
													<img src="../img/climaicons/noimg.png" id="pronos_img2" />
													<br />
													<select id="clima2" class="combo" style="width: 220px; float: right;">
														<option value="noimg" title="../img/climaicons/noimg.png">Sin Imagen</option>
														<option value="solcaluroso" title="../img/climaicons/solcaluroso.png">Despejado Alta T.</option>
														<option value="sol" title="../img/climaicons/sol.png">Despejado</option>
														<option value="neblina" title="../img/climaicons/neblina.png">Neblina</option>
														<option value="niebla" title="../img/climaicons/niebla.png">Niebla</option>
														<option value="parcialalta" title="../img/climaicons/parcialalta.png">Nub. Parcial Alta</option>
														<option value="parcial" title="../img/climaicons/parcial.png">Nub. Parcial</option>
														<option value="parcial2" title="../img/climaicons/parcial2.png">Nub. Parcial</option>
														<option value="bruma01" title="../img/climaicons/bruma01.png">Bruma</option>
														<option value="bruma02" title="../img/climaicons/bruma02.png">Bruma</option>
														<option value="bruma03" title="../img/climaicons/bruma03.png">Bruma</option>
														<option value="cubierto" title="../img/climaicons/cubierto.png">Cubierto</option>
														<option value="llovizna" title="../img/climaicons/llovizna.png">Llovizna</option>
														<option value="lluvia" title="../img/climaicons/lluvia.png">Lluvia</option>
														<option value="lluviamatinal" title="../img/climaicons/lluviamatinal.png">Lluvia Matinal</option>
														<option value="lluviavientofuerte" title="../img/climaicons/lluviavientofuerte.png">Lluvia y viento fuerte</option>
														<option value="lluviavientomoderado" title="../img/climaicons/lluviavientomoderado.png">Lluvia y viento moderado</option>
														<option value="granizo" title="../img/climaicons/granizo.png">Granizo</option>
														<option value="lluvianieve" title="../img/climaicons/lluvianieve.png">Lluvia con Nieve</option>
														<option value="nieve" title="../img/climaicons/nieve.png">Nieve</option>
														<option value="nieveviento" title="../img/climaicons/nieveviento.png">Nieve con Viento</option>
														<option value="parciallluvia" title="../img/climaicons/parciallluvia.png">Lluvia a Parcial</option>
														<option value="lluviaelectrica" title="../img/climaicons/lluviaelectrica.png">T. Electrica</option>
														<option value="lluviaelectricasol" title="../img/climaicons/lluviaelectricasol.png">T. Electrica a Parcial</option>
														<option value="cubiertofrio" title="../img/climaicons/cubiertofrio.png">Cubierto y Baja Temperatura</option>
														<option value="despejadofrio" title="../img/climaicons/despejadofrio.png">Despejado y Baja Temperatura</option>
														<option value="friomatinal" title="../img/climaicons/friomatinal.png">Baja Temperatura Matinal</option>
														<option value="parcialfrio" title="../img/climaicons/parcialfrio.png">Parcial y Baja Temperatura</option>
													</select>
													
												</td>
											</tr>
											<tr>
												<th><p>Pron&oacute;stico para 3 d&iacute;as:</p></th>
												<td>
													<textarea id="prono3" style="width: 200px; height: 100px;"></textarea>
													<img src="../img/climaicons/noimg.png" id="pronos_img3" />
													<br />
													<select id="clima3" class="combo" style="width: 220px; float: right;">
														<option value="noimg" title="../img/climaicons/noimg.png">Sin Imagen</option>
														<option value="solcaluroso" title="../img/climaicons/solcaluroso.png">Despejado Alta T.</option>
														<option value="sol" title="../img/climaicons/sol.png">Despejado</option>
														<option value="neblina" title="../img/climaicons/neblina.png">Neblina</option>
														<option value="niebla" title="../img/climaicons/niebla.png">Niebla</option>
														<option value="parcialalta" title="../img/climaicons/parcialalta.png">Nub. Parcial Alta</option>
														<option value="parcial" title="../img/climaicons/parcial.png">Nub. Parcial</option>
														<option value="parcial2" title="../img/climaicons/parcial2.png">Nub. Parcial</option>
														<option value="bruma01" title="../img/climaicons/bruma01.png">Bruma</option>
														<option value="bruma02" title="../img/climaicons/bruma02.png">Bruma</option>
														<option value="bruma03" title="../img/climaicons/bruma03.png">Bruma</option>
														<option value="cubierto" title="../img/climaicons/cubierto.png">Cubierto</option>
														<option value="llovizna" title="../img/climaicons/llovizna.png">Llovizna</option>
														<option value="lluvia" title="../img/climaicons/lluvia.png">Lluvia</option>
														<option value="lluviamatinal" title="../img/climaicons/lluviamatinal.png">Lluvia Matinal</option>
														<option value="lluviavientofuerte" title="../img/climaicons/lluviavientofuerte.png">Lluvia y viento fuerte</option>
														<option value="lluviavientomoderado" title="../img/climaicons/lluviavientomoderado.png">Lluvia y viento moderado</option>
														<option value="granizo" title="../img/climaicons/granizo.png">Granizo</option>
														<option value="lluvianieve" title="../img/climaicons/lluvianieve.png">Lluvia con Nieve</option>
														<option value="nieve" title="../img/climaicons/nieve.png">Nieve</option>
														<option value="nieveviento" title="../img/climaicons/nieveviento.png">Nieve con Viento</option>
														<option value="parciallluvia" title="../img/climaicons/parciallluvia.png">Lluvia a Parcial</option>
														<option value="lluviaelectrica" title="../img/climaicons/lluviaelectrica.png">T. Electrica</option>
														<option value="lluviaelectricasol" title="../img/climaicons/lluviaelectricasol.png">T. Electrica a Parcial</option>
														<option value="cubiertofrio" title="../img/climaicons/cubiertofrio.png">Cubierto y Baja Temperatura</option>
														<option value="despejadofrio" title="../img/climaicons/despejadofrio.png">Despejado y Baja Temperatura</option>
														<option value="friomatinal" title="../img/climaicons/friomatinal.png">Baja Temperatura Matinal</option>
														<option value="parcialfrio" title="../img/climaicons/parcialfrio.png">Parcial y Baja Temperatura</option>
													</select>
													
												</td>
											</tr>
											<tr>
												<th><p>Observaciones:</p></th>
												<td>
													<textarea id="observaciones" style="width: 300px; height: 100px;"></textarea>
													
												</td>
											</tr>
											<tr>
												<td colspan="2" id="button_cell">
													<input type="button" name="submit" id="submit_1" class="button" onclick="save_forecast()" value="Ingresar Pron&oacute;stico" tabindex="6" style="width: auto; margin: 0px 0px 0px 300px;" />
												</td>
											</tr>
										</table>
									</fieldset>
								</form>
							</div>
							<div id="info"></div>
						</div>
						<?php
						}
						elseif($page == 'edit'){
						
						function get_index_from_image($get_in){
							switch($get_in){
								case "noimg":
									return 0;
									break;
								case "solcaluroso":
									return 1;
									break;
								case "sol":
									return 2;
									break;
								case "niebla":
									return 3;
									break;
								case "parcialalta":
									return 4;
									break;
								case "parcial":
									return 5;
									break;
								case "parcial2":
									return 6;
									break;
								case "bruma01":
									return 7;
									break;
								case "bruma02":
									return 8;
									break;
								case "bruma03":
									return 9;
									break;
								case "cubierto":
									return 10;
									break;
								case "llovizna":
									return 11;
									break;
								case "lluvia":
									return 12;
									break;
								case "granizo":
									return 13;
									break;
								case "lluvianieve":
									return 14;
									break;
								case "nieve":
									return 15;
									break;
								case "nieveviento":
									return 16;
									break;
								case "parciallluvia":
									return 17;
									break;
								case "lluviaelectrica":
									return 18;
									break;
								case "lluviaelectricasol":
									return 19;
									break;
								default:
									return 0;
							}
						}
						
						$FID = $_REQUEST['fid'];
						
						$SQL = "SELECT 	fecha, 
								temp_min, 
								temp_min_hora, 
								temp_max_ayer,
								temp_max_hora, 
								hum_rel_aire, 
								presion_atmosferica, 
								evaporacion, 
								pp_ultima_lluvia, 
								pp_total_a_la_fecha, 
								pp_normal_a_la_fecha, 
								pp_superavit, 
								pp_superavir_porcentaje, 
								pp_deficit, 
								pp_deficit_porcentaje, 
								pronostico_hoy, 
								pronostico_hoy_imagen, 
								pronostico_1_dia, 
								pronostico_1_dia_imagen, 
								pronostico_2_dia, 
								pronostico_2_dia_imagen, 
								pronostico_3_dia, 
								pronostico_3_dia_imagen, 
								observaciones, 
								usuario_id
							FROM	eve_pronostico 
							WHERE 	id = $FID
							ORDER	BY fecha DESC LIMIT 1";
							
						$SQLR = consulta_sql($SQL);
						
						$SQLD = mysqli_fetch_array($SQLR);
						
						$fecha = $SQLD[0];
						$temp_min = $SQLD[1]; 
						$temp_min_hora = $SQLD[2];
						
						$temp_min_hora_ex = explode(":",$temp_min_hora);
						
						$temp_max_ayer = $SQLD[3];
						$temp_max_hora = $SQLD[4];
						
						$temp_max_hora_ex = explode(":",$temp_max_hora);
						
						$hum_rel_aire = $SQLD[5];
						$presion_atmosferica = $SQLD[6];
						$evaporacion = $SQLD[7];
						$pp_ultima_lluvia = ($SQLD[8]==-9999?'':$SQLD[8]);
						$pp_total_a_la_fecha = ($SQLD[9]==-9999?'':$SQLD[9]);
						$pp_normal_a_la_fecha = ($SQLD[10]==-9999?'':$SQLD[10]);
						$pp_superavit = ($SQLD[11]==-9999?'':$SQLD[11]);
						$pp_superavir_porcentaje = ($SQLD[12]==-9999?'':$SQLD[12]);
						$pp_deficit = ($SQLD[13]==-9999?'':$SQLD[13]);
						$pp_deficit_porcentaje = ($SQLD[14]==-9999?'':$SQLD[14]); 
						$pronostico_hoy = $SQLD[15];
						$pronostico_hoy_imagen = $SQLD[16];
						$pronostico_1_dia = $SQLD[17];
						$pronostico_1_dia_imagen = $SQLD[18];
						$pronostico_2_dia = $SQLD[19];
						$pronostico_2_dia_imagen = $SQLD[20];
						$pronostico_3_dia = $SQLD[21];
						$pronostico_3_dia_imagen = $SQLD[22];
						$observaciones = $SQLD[23];
						$usuario_id = $SQLD[24];
						
						$pronostico_hoy_imagen_index = get_index_from_image($pronostico_hoy_imagen);
						$pronostico_1_dia_imagen_index = get_index_from_image($pronostico_1_dia_imagen);
						$pronostico_2_dia_imagen_index = get_index_from_image($pronostico_2_dia_imagen);
						$pronostico_3_dia_imagen_index = get_index_from_image($pronostico_3_dia_imagen);
						
						?>
						<script type="text/javascript">
							jQuery(document).ready(function(){
								$("#clima").msDropDown({visibleRows:5, rowHeight:48});
								$("#clima").bind("change",function(){
									$("#pronos_img").attr("src","../img/climaicons/"+$("#clima option:selected").val()+".png");
								});
								
								$("#clima1").msDropDown({visibleRows:5, rowHeight:48});
								$("#clima1").bind("change",function(){
									$("#pronos_img1").attr("src","../img/climaicons/"+$("#clima1 option:selected").val()+".png");
								});
								
								$("#clima2").msDropDown({visibleRows:5, rowHeight:48});
								$("#clima2").bind("change",function(){
									$("#pronos_img2").attr("src","../img/climaicons/"+$("#clima2 option:selected").val()+".png");
								});
								
								$("#clima3").msDropDown({visibleRows:5, rowHeight:48});
								$("#clima3").bind("change",function(){
									$("#pronos_img3").attr("src","../img/climaicons/"+$("#clima3 option:selected").val()+".png");
								});
								
								var oHandler = jQuery('#clima').msDropDown().data("dd");
								oHandler.selectedIndex(<?=$pronostico_hoy_imagen_index?>);
								jQuery('#clima').change();

								var oHandler1 = jQuery('#clima1').msDropDown().data("dd");
								oHandler1.selectedIndex(<?=$pronostico_1_dia_imagen_index?>);
								jQuery('#clima1').change();
								
								var oHandler2 = jQuery('#clima2').msDropDown().data("dd");
								oHandler2.selectedIndex(<?=$pronostico_2_dia_imagen_index?>);
								jQuery('#clima2').change();
								
								var oHandler3 = jQuery('#clima3').msDropDown().data("dd");
								oHandler3.selectedIndex(<?=$pronostico_3_dia_imagen_index?>);
								jQuery('#clima3').change();
								
								jQuery('#temp_min_hora option[value=<?=$temp_min_hora_ex[0]?>]').attr('selected','selected');
								jQuery('#temp_min_minuto option[value=<?=$temp_min_hora_ex[1]?>]').attr('selected','selected');
								
								jQuery('#temp_max_ay_hora option[value=<?=$temp_max_hora_ex[0]?>]').attr('selected','selected');
								jQuery('#temp_max_ay_minuto option[value=<?=$temp_max_hora_ex[1]?>]').attr('selected','selected');
							});
						</script>
						<div class="content-1col-nobox">
							<h1 class="webtemplate" id="top_title">Pron&oacute;stico del Tiempo - Agregar</h1>
							<p><a href="mod_forecast_index.php?sid=<?=$_SESSION['session_nombre_sesion']?>">volver</a></p>
							<div class="contactform" id="cuadroingreso">
								<form>
									<input type="hidden" name="fid" value="<?=$FID?>" id="fid" />
									<fieldset><legend>&nbsp;EDITAR PRON&Oacute;STICO&nbsp;</legend>
										<table style="width: 90%">
											<tr>
												<th><p>Fecha:</p></th>
												<td><input type="text" name="fecha" id="fecha" class="field" value="<?=$fecha?>" readonly="true" style="width: 100px; text-align:center;" /></td>
											</tr>
											<tr>
												<th><p>Temperatura M&iacute;nima:</p></th>
												<td><input type="text" name="temp_min" id="temp_min" class="field" tabindex="4" style="width: 40px; text-align:center;" value="<?=$temp_min?>"/>&ordm;C a las 
													<select name="temp_min_hora" id="temp_min_hora" class="combo" style="width: 45px;">
														<option value="00">00</option>
														<option value="01">01</option>
														<option value="02">02</option>
														<option value="03">03</option>
														<option value="04">04</option>
														<option value="05">05</option>
														<option value="06">06</option>
														<option value="07">07</option>
														<option value="08">08</option>
														<option value="09">09</option>
														<option value="10">10</option>
														<option value="11">11</option>
														<option value="12">12</option>
														<option value="13">13</option>
														<option value="14">14</option>
														<option value="15">15</option>
														<option value="16">16</option>
														<option value="17">17</option>
														<option value="18">18</option>
														<option value="19">19</option>
														<option value="20">20</option>
														<option value="21">21</option>
														<option value="22">22</option>
														<option value="23">23</option>
													</select>
													:
													<select name="temp_min_minuto" id="temp_min_minuto" class="combo" style="width: 45px;">
            													<option value="00">00</option>
            													<option value="01">01</option>
            													<option value="02">02</option>
            													<option value="03">03</option>
            													<option value="04">04</option>
            													<option value="05">05</option>
            													<option value="06">06</option>
            													<option value="07">07</option>
            													<option value="08">08</option>
            													<option value="09">09</option>
            													<option value="10">10</option>
            													<option value="11">11</option>
            													<option value="12">12</option>
            													<option value="13">13</option>
            													<option value="14">14</option>
            													<option value="15">15</option>
            													<option value="16">16</option>
            													<option value="17">17</option>
            													<option value="18">18</option>
            													<option value="19">19</option>
            													<option value="20">20</option>
            													<option value="21">21</option>
            													<option value="22">22</option>
            													<option value="23">23</option>
            													<option value="24">24</option>
            													<option value="25">25</option>
            													<option value="26">26</option>
            													<option value="27">27</option>
            													<option value="28">28</option>
            													<option value="29">29</option>
            													<option value="30">30</option>
            													<option value="31">31</option>
            													<option value="32">32</option>
            													<option value="33">33</option>
            													<option value="34">34</option>
            													<option value="35">35</option>
            													<option value="36">36</option>
            													<option value="37">37</option>
            													<option value="38">38</option>
            													<option value="39">39</option>
            													<option value="40">40</option>
            													<option value="41">41</option>
            													<option value="42">42</option>
            													<option value="43">43</option>
            													<option value="44">44</option>
            													<option value="45">45</option>
            													<option value="46">46</option>
            													<option value="47">47</option>
            													<option value="48">48</option>
            													<option value="49">49</option>
            													<option value="50">50</option>
            													<option value="51">51</option>
            													<option value="52">52</option>
            													<option value="53">53</option>
            													<option value="54">54</option>
            													<option value="55">55</option>
            													<option value="56">56</option>
            													<option value="57">57</option>
            													<option value="58">58</option>
            													<option value="59">59</option>
            												</select>hrs.
												</td>
											</tr>
											<tr>
												<th><p>Temperatura M&aacute;xima Ayer:</p></th>
												<td><input type="text" name="temp_max_ay" id="temp_max_ay" class="field" value="<?=$temp_max_ayer?>" tabindex="4" style="width: 40px; text-align:center;"/>&ordm;C a las 
													<select name="temp_max_ay_hora" id="temp_max_ay_hora" class="combo" style="width: 45px;">
														<option value="00">00</option>
														<option value="01">01</option>
														<option value="02">02</option>
														<option value="03">03</option>
														<option value="04">04</option>
														<option value="05">05</option>
														<option value="06">06</option>
														<option value="07">07</option>
														<option value="08">08</option>
														<option value="09">09</option>
														<option value="10">10</option>
														<option value="11">11</option>
														<option value="12">12</option>
														<option value="13">13</option>
														<option value="14">14</option>
														<option value="15">15</option>
														<option value="16">16</option>
														<option value="17">17</option>
														<option value="18">18</option>
														<option value="19">19</option>
														<option value="20">20</option>
														<option value="21">21</option>
														<option value="22">22</option>
														<option value="23">23</option>
													</select>
													:
													<select name="temp_max_ay_minuto" id="temp_max_ay_minuto" class="combo" style="width: 45px;">
            													<option value="00">00</option>
            													<option value="01">01</option>
            													<option value="02">02</option>
            													<option value="03">03</option>
            													<option value="04">04</option>
            													<option value="05">05</option>
            													<option value="06">06</option>
            													<option value="07">07</option>
            													<option value="08">08</option>
            													<option value="09">09</option>
            													<option value="10">10</option>
            													<option value="11">11</option>
            													<option value="12">12</option>
            													<option value="13">13</option>
            													<option value="14">14</option>
            													<option value="15">15</option>
            													<option value="16">16</option>
            													<option value="17">17</option>
            													<option value="18">18</option>
            													<option value="19">19</option>
            													<option value="20">20</option>
            													<option value="21">21</option>
            													<option value="22">22</option>
            													<option value="23">23</option>
            													<option value="24">24</option>
            													<option value="25">25</option>
            													<option value="26">26</option>
            													<option value="27">27</option>
            													<option value="28">28</option>
            													<option value="29">29</option>
            													<option value="30">30</option>
            													<option value="31">31</option>
            													<option value="32">32</option>
            													<option value="33">33</option>
            													<option value="34">34</option>
            													<option value="35">35</option>
            													<option value="36">36</option>
            													<option value="37">37</option>
            													<option value="38">38</option>
            													<option value="39">39</option>
            													<option value="40">40</option>
            													<option value="41">41</option>
            													<option value="42">42</option>
            													<option value="43">43</option>
            													<option value="44">44</option>
            													<option value="45">45</option>
            													<option value="46">46</option>
            													<option value="47">47</option>
            													<option value="48">48</option>
            													<option value="49">49</option>
            													<option value="50">50</option>
            													<option value="51">51</option>
            													<option value="52">52</option>
            													<option value="53">53</option>
            													<option value="54">54</option>
            													<option value="55">55</option>
            													<option value="56">56</option>
            													<option value="57">57</option>
            													<option value="58">58</option>
            													<option value="59">59</option>
            												</select>&nbsp;hrs.
												</td>
											</tr>
											<tr>
												<th><p>Humedad Relativa del Aire:</p></th>
												<td><input type="text" name="humedad" id="humedad" class="field" value="<?=$hum_rel_aire?>" tabindex="4" style="width: 40px; text-align:center;"/>&nbsp;&#037;</td>
											</tr>
											<tr>
												<th><p>Presi&oacute;n Atmosf&eacute;rica:</p></th>
												<td><input type="text" name="presion" id="presion" class="field" value="<?=$presion_atmosferica?>" tabindex="4" style="width: 40px; text-align:center;"/>&nbsp;Hectopascales</td>
											</tr>
											<tr>
												<th><p>Evaporaci&oacute;n:</p></th>
												<td><input type="text" name="evaporacion" id="evaporacion" class="field" value="<?=$evaporacion?>" tabindex="4" style="width: 40px; text-align:center;"/>&nbsp;mm.</td>
											</tr>
											<tr>
												<th colspan="2"><p>Precipitaciones</p></th>
											</tr>
											<tr>
												<th><p>&Uacute;ltima Lluvia:</p></th>
												<td><input type="text" name="pp_ultima" id="pp_ultima" class="field" value="<?=$pp_ultima_lluvia?>" tabindex="4" style="width: 40px; text-align:center;"/>&nbsp;mm.</td>
											</tr>
											<tr>
												<th><p>Total a la fecha:</p></th>
												<td><input type="text" name="pp_total" id="pp_total" class="field" value="<?=$pp_total_a_la_fecha?>" tabindex="4" style="width: 40px; text-align:center;"/>&nbsp;mm.</td>
											</tr>
											<tr>
												<th><p>Normal a la fecha:</p></th>
												<td><input type="text" name="pp_normal" id="pp_normal" class="field" value="<?=$pp_normal_a_la_fecha?>" tabindex="4" style="width: 40px; text-align:center;"/>&nbsp;mm.</td>
											</tr>
											<tr>
												<th><p>Superavit a la fecha:</p></th>
												<td><input type="text" name="pp_superavit" id="pp_superavit" class="field" value="<?=$pp_superavit?>" tabindex="4" style="width: 40px; text-align:center;"/>&nbsp;mm. que equivalen al <input type="text" name="pp_superavit_por" id="pp_superavit_por" class="field" value="<?=$pp_superavir_porcentaje?>" tabindex="4" style="width: 30px; text-align:center;"/> &#037;</td>
											</tr>
											<tr>
												<th><p>D&eacute;ficit a la fecha:</p></th>
												<td><input type="text" name="pp_deficit" id="pp_deficit" class="field" value="<?=$pp_deficit?>" tabindex="4" style="width: 40px; text-align:center;"/>&nbsp;mm. que equivalen al <input type="text" name="pp_deficit_por" id="pp_deficit_por" class="field" value="<?=$pp_deficit_porcentaje?>" tabindex="4" style="width: 30px; text-align:center;"/> &#037;</td>
											</tr>
											<tr>
												<th colspan="2"><h2>Pron&oacute;sticos</h2></th>
											</tr>
											<tr>
												<th><p>Pron&oacute;stico hoy:</p></th>
												<td>
													<textarea id="prono" style="width: 200px; height: 100px;"><?=utf8_decode($pronostico_hoy)?></textarea>
													<img src="../img/climaicons/noimg.png" id="pronos_img" />
													<br />
													<select id="clima" class="combo" style="width: 220px; float: right;">
														<option value="noimg" title="../img/climaicons/noimg.png">Sin Imagen</option>
														<option value="solcaluroso" title="../img/climaicons/solcaluroso.png">Despejado Alta T.</option>
														<option value="sol" title="../img/climaicons/sol.png">Despejado</option>
														<option value="neblina" title="../img/climaicons/neblina.png">Neblina</option>
														<option value="niebla" title="../img/climaicons/niebla.png">Niebla</option>
														<option value="parcialalta" title="../img/climaicons/parcialalta.png">Nub. Parcial Alta</option>
														<option value="parcial" title="../img/climaicons/parcial.png">Nub. Parcial</option>
														<option value="parcial2" title="../img/climaicons/parcial2.png">Nub. Parcial</option>
														<option value="bruma01" title="../img/climaicons/bruma01.png">Bruma</option>
														<option value="bruma02" title="../img/climaicons/bruma02.png">Bruma</option>
														<option value="bruma03" title="../img/climaicons/bruma03.png">Bruma</option>
														<option value="cubierto" title="../img/climaicons/cubierto.png">Cubierto</option>
														<option value="llovizna" title="../img/climaicons/llovizna.png">Llovizna</option>
														<option value="lluvia" title="../img/climaicons/lluvia.png">Lluvia</option>
														<option value="lluviamatinal" title="../img/climaicons/lluviamatinal.png">Lluvia Matinal</option>
														<option value="lluviavientofuerte" title="../img/climaicons/lluviavientofuerte.png">Lluvia y viento fuerte</option>
														<option value="lluviavientomoderado" title="../img/climaicons/lluviavientomoderado.png">Lluvia y viento moderado</option>
														<option value="granizo" title="../img/climaicons/granizo.png">Granizo</option>
														<option value="lluvianieve" title="../img/climaicons/lluvianieve.png">Lluvia con Nieve</option>
														<option value="nieve" title="../img/climaicons/nieve.png">Nieve</option>
														<option value="nieveviento" title="../img/climaicons/nieveviento.png">Nieve con Viento</option>
														<option value="parciallluvia" title="../img/climaicons/parciallluvia.png">Lluvia a Parcial</option>
														<option value="lluviaelectrica" title="../img/climaicons/lluviaelectrica.png">T. Electrica</option>
														<option value="lluviaelectricasol" title="../img/climaicons/lluviaelectricasol.png">T. Electrica a Parcial</option>
														<option value="cubiertofrio" title="../img/climaicons/cubiertofrio.png">Cubierto y Baja Temperatura</option>
														<option value="despejadofrio" title="../img/climaicons/despejadofrio.png">Despejado y Baja Temperatura</option>
														<option value="friomatinal" title="../img/climaicons/friomatinal.png">Baja Temperatura Matinal</option>
														<option value="parcialfrio" title="../img/climaicons/parcialfrio.png">Parcial y Baja Temperatura</option>
													</select>
													
												</td>
											</tr>
											<tr>
												<th><p>Pron&oacute;stico para 1 d&iacute;a:</p></th>
												<td>
													<textarea id="prono1" style="width: 200px; height: 100px;"><?=utf8_decode($pronostico_1_dia)?></textarea>
													<img src="../img/climaicons/noimg.png" id="pronos_img1" />
													<br />
													<select id="clima1" class="combo" style="width: 220px; float: right;">
														<option value="noimg" title="../img/climaicons/noimg.png">Sin Imagen</option>
														<option value="solcaluroso" title="../img/climaicons/solcaluroso.png">Despejado Alta T.</option>
														<option value="sol" title="../img/climaicons/sol.png">Despejado</option>
														<option value="neblina" title="../img/climaicons/neblina.png">Neblina</option>
														<option value="niebla" title="../img/climaicons/niebla.png">Niebla</option>
														<option value="parcialalta" title="../img/climaicons/parcialalta.png">Nub. Parcial Alta</option>
														<option value="parcial" title="../img/climaicons/parcial.png">Nub. Parcial</option>
														<option value="parcial2" title="../img/climaicons/parcial2.png">Nub. Parcial</option>
														<option value="bruma01" title="../img/climaicons/bruma01.png">Bruma</option>
														<option value="bruma02" title="../img/climaicons/bruma02.png">Bruma</option>
														<option value="bruma03" title="../img/climaicons/bruma03.png">Bruma</option>
														<option value="cubierto" title="../img/climaicons/cubierto.png">Cubierto</option>
														<option value="llovizna" title="../img/climaicons/llovizna.png">Llovizna</option>
														<option value="lluvia" title="../img/climaicons/lluvia.png">Lluvia</option>
														<option value="lluviamatinal" title="../img/climaicons/lluviamatinal.png">Lluvia Matinal</option>
														<option value="lluviavientofuerte" title="../img/climaicons/lluviavientofuerte.png">Lluvia y viento fuerte</option>
														<option value="lluviavientomoderado" title="../img/climaicons/lluviavientomoderado.png">Lluvia y viento moderado</option>
														<option value="granizo" title="../img/climaicons/granizo.png">Granizo</option>
														<option value="lluvianieve" title="../img/climaicons/lluvianieve.png">Lluvia con Nieve</option>
														<option value="nieve" title="../img/climaicons/nieve.png">Nieve</option>
														<option value="nieveviento" title="../img/climaicons/nieveviento.png">Nieve con Viento</option>
														<option value="parciallluvia" title="../img/climaicons/parciallluvia.png">Lluvia a Parcial</option>
														<option value="lluviaelectrica" title="../img/climaicons/lluviaelectrica.png">T. Electrica</option>
														<option value="lluviaelectricasol" title="../img/climaicons/lluviaelectricasol.png">T. Electrica a Parcial</option>
														<option value="cubiertofrio" title="../img/climaicons/cubiertofrio.png">Cubierto y Baja Temperatura</option>
														<option value="despejadofrio" title="../img/climaicons/despejadofrio.png">Despejado y Baja Temperatura</option>
														<option value="friomatinal" title="../img/climaicons/friomatinal.png">Baja Temperatura Matinal</option>
														<option value="parcialfrio" title="../img/climaicons/parcialfrio.png">Parcial y Baja Temperatura</option>
													</select>
													
												</td>
											</tr>
											<tr>
												<th><p>Pron&oacute;stico para 2 d&iacute;as:</p></th>
												<td>
													<textarea id="prono2" style="width: 200px; height: 100px;"><?=utf8_decode($pronostico_2_dia)?></textarea>
													<img src="../img/climaicons/noimg.png" id="pronos_img2" />
													<br />
													<select id="clima2" class="combo" style="width: 220px; float: right;">
														<option value="noimg" title="../img/climaicons/noimg.png">Sin Imagen</option>
														<option value="solcaluroso" title="../img/climaicons/solcaluroso.png">Despejado Alta T.</option>
														<option value="sol" title="../img/climaicons/sol.png">Despejado</option>
														<option value="neblina" title="../img/climaicons/neblina.png">Neblina</option>
														<option value="niebla" title="../img/climaicons/niebla.png">Niebla</option>
														<option value="parcialalta" title="../img/climaicons/parcialalta.png">Nub. Parcial Alta</option>
														<option value="parcial" title="../img/climaicons/parcial.png">Nub. Parcial</option>
														<option value="parcial2" title="../img/climaicons/parcial2.png">Nub. Parcial</option>
														<option value="bruma01" title="../img/climaicons/bruma01.png">Bruma</option>
														<option value="bruma02" title="../img/climaicons/bruma02.png">Bruma</option>
														<option value="bruma03" title="../img/climaicons/bruma03.png">Bruma</option>
														<option value="cubierto" title="../img/climaicons/cubierto.png">Cubierto</option>
														<option value="llovizna" title="../img/climaicons/llovizna.png">Llovizna</option>
														<option value="lluvia" title="../img/climaicons/lluvia.png">Lluvia</option>
														<option value="lluviamatinal" title="../img/climaicons/lluviamatinal.png">Lluvia Matinal</option>
														<option value="lluviavientofuerte" title="../img/climaicons/lluviavientofuerte.png">Lluvia y viento fuerte</option>
														<option value="lluviavientomoderado" title="../img/climaicons/lluviavientomoderado.png">Lluvia y viento moderado</option>
														<option value="granizo" title="../img/climaicons/granizo.png">Granizo</option>
														<option value="lluvianieve" title="../img/climaicons/lluvianieve.png">Lluvia con Nieve</option>
														<option value="nieve" title="../img/climaicons/nieve.png">Nieve</option>
														<option value="nieveviento" title="../img/climaicons/nieveviento.png">Nieve con Viento</option>
														<option value="parciallluvia" title="../img/climaicons/parciallluvia.png">Lluvia a Parcial</option>
														<option value="lluviaelectrica" title="../img/climaicons/lluviaelectrica.png">T. Electrica</option>
														<option value="lluviaelectricasol" title="../img/climaicons/lluviaelectricasol.png">T. Electrica a Parcial</option>
														<option value="cubiertofrio" title="../img/climaicons/cubiertofrio.png">Cubierto y Baja Temperatura</option>
														<option value="despejadofrio" title="../img/climaicons/despejadofrio.png">Despejado y Baja Temperatura</option>
														<option value="friomatinal" title="../img/climaicons/friomatinal.png">Baja Temperatura Matinal</option>
														<option value="parcialfrio" title="../img/climaicons/parcialfrio.png">Parcial y Baja Temperatura</option>
													</select>
													
												</td>
											</tr>
											<tr>
												<th><p>Pron&oacute;stico para 3 d&iacute;as:</p></th>
												<td>
													<textarea id="prono3" style="width: 200px; height: 100px;"><?=utf8_decode($pronostico_3_dia)?></textarea>
													<img src="../img/climaicons/noimg.png" id="pronos_img3" />
													<br />
													<select id="clima3" class="combo" style="width: 220px; float: right;">
														<option value="noimg" title="../img/climaicons/noimg.png">Sin Imagen</option>
														<option value="solcaluroso" title="../img/climaicons/solcaluroso.png">Despejado Alta T.</option>
														<option value="sol" title="../img/climaicons/sol.png">Despejado</option>
														<option value="neblina" title="../img/climaicons/neblina.png">Neblina</option>
														<option value="niebla" title="../img/climaicons/niebla.png">Niebla</option>
														<option value="parcialalta" title="../img/climaicons/parcialalta.png">Nub. Parcial Alta</option>
														<option value="parcial" title="../img/climaicons/parcial.png">Nub. Parcial</option>
														<option value="parcial2" title="../img/climaicons/parcial2.png">Nub. Parcial</option>
														<option value="bruma01" title="../img/climaicons/bruma01.png">Bruma</option>
														<option value="bruma02" title="../img/climaicons/bruma02.png">Bruma</option>
														<option value="bruma03" title="../img/climaicons/bruma03.png">Bruma</option>
														<option value="cubierto" title="../img/climaicons/cubierto.png">Cubierto</option>
														<option value="llovizna" title="../img/climaicons/llovizna.png">Llovizna</option>
														<option value="lluvia" title="../img/climaicons/lluvia.png">Lluvia</option>
														<option value="lluviamatinal" title="../img/climaicons/lluviamatinal.png">Lluvia Matinal</option>
														<option value="lluviavientofuerte" title="../img/climaicons/lluviavientofuerte.png">Lluvia y viento fuerte</option>
														<option value="lluviavientomoderado" title="../img/climaicons/lluviavientomoderado.png">Lluvia y viento moderado</option>
														<option value="granizo" title="../img/climaicons/granizo.png">Granizo</option>
														<option value="lluvianieve" title="../img/climaicons/lluvianieve.png">Lluvia con Nieve</option>
														<option value="nieve" title="../img/climaicons/nieve.png">Nieve</option>
														<option value="nieveviento" title="../img/climaicons/nieveviento.png">Nieve con Viento</option>
														<option value="parciallluvia" title="../img/climaicons/parciallluvia.png">Lluvia a Parcial</option>
														<option value="lluviaelectrica" title="../img/climaicons/lluviaelectrica.png">T. Electrica</option>
														<option value="lluviaelectricasol" title="../img/climaicons/lluviaelectricasol.png">T. Electrica a Parcial</option>
														<option value="cubiertofrio" title="../img/climaicons/cubiertofrio.png">Cubierto y Baja Temperatura</option>
														<option value="despejadofrio" title="../img/climaicons/despejadofrio.png">Despejado y Baja Temperatura</option>
														<option value="friomatinal" title="../img/climaicons/friomatinal.png">Baja Temperatura Matinal</option>
														<option value="parcialfrio" title="../img/climaicons/parcialfrio.png">Parcial y Baja Temperatura</option>
													</select>
													
												</td>
											</tr>
											<tr>
												<th><p>Observaciones:</p></th>
												<td>
													<textarea id="observaciones" style="width: 300px; height: 100px;"><?=utf8_decode($observaciones)?></textarea>
													
												</td>
											</tr>
											<tr>
												<td colspan="2" id="button_cell">
													<input type="button" name="submit" id="submit_1" class="button" onclick="save_edited_forecast()" value="Actualizar Pron&oacute;stico" tabindex="6" style="width: auto; margin: 0px 0px 0px 300px;" />
												</td>
											</tr>
										</table>
									</fieldset>
								</form>
							</div>
							<div id="info"></div>
						</div>
						<?php
						}
					?>
					<div class="corner-content-1col-bottom"></div>
    				</div>
    				<!-- C.2 SUBCONTENT-->
				<div class="subcontent">
					<!-- NAVIGATION SIDEBAR -->
					<?php require('../system/navigation_sidebar.inc.php'); ?>   
				</div>
    				<!-- END OF CONTENT -->
    			</div>
			<!-- D. FOOTER -->      
			<?php require('../footer.inc.php');?>       
		</div>
		<!-- D. FOOT PANEL --> 
		<?php require('../system/footpanel.inc.php');?>
	</body>
</html>



