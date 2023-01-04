<?php

$MODELDESCRIPTIONS = array(
    "1_ETO" => array(
            "abr" => "ETo",
            "nombre" => "Evapotranspiraci&oacute;n de Referencia",
            "descripcion" =>
                "<img src='../img/model_descriptions/1_ETO.png'/>El t&eacute;rmino de evapotranspiraci&oacute;n se utiliza para englobar tanto el proceso f&iacute;sico de
                p&eacute;rdida de agua por evaporaci&oacute;n como el proceso de evaporaci&oacute;n del agua absorbida
                por las plantas (transpiraci&oacute;n). La superficie de referencia es muy similar a una superficie
                extensa de pasto verde, bien regada, de altura uniforme, creciendo activamente y dando sombra totalmente
                al suelo."
    ),
    "2_HF72" => array(
            "abr" => "HF72",
            "nombre" => "Horas Fr&iacute;o Base 7.2",
            "descripcion" =>
                "<img src='../img/model_descriptions/2_HF72.png'/>Cantidad de horas en un rango determinado de
                tiempo en donde las temperaturas son inferiores a una cierta cantidad de grados, este l&iacute;mite
                en la temperatura es llamado \"temperatura base\" y generalmente son 7.2&deg;C. As&iacute; cada hora
                que pasa con temperatura menor que 7.2&deg;C se cuenta como 1 hora fr&iacute;o."
    ),
    "3_GDD10" => array(
            "abr" => "GDD10",
            "nombre" => "Grados D&iacute;a Base 10",
            "descripcion" =>
                "<img src='../img/model_descriptions/3_GDD10.png'/>Se define para un periodo espec&iacute;fico
                como los grados acumulados sobre una temperatura umbral (generalmente 10&deg;C). Es decir la
                diferencia entre la temperatura media de un d&iacute;a y la temperatura umbral."
    ),
    "4_IH" => array(
            "abr" => "IH",
            "nombre" => "Indice Heliot&eacute;rmico de Huglin Adaptado",
            "descripcion" =>
                "Este índice fue propuesto por Huglin (1978) el
                cual considera las condiciones t&eacute;rmicas favorables a la actividad fotosint&eacute;tica durante
                la fracci&oacute;n iluminada del d&iacute;a y se calcula para un per&icute;odo de seis meses comprendido
                entre el 1 septiembre y el 28 de febrero para el Hemisferio Sur. Este &iacute;ndice se calcula como sigue:<br/>
                <br/>
                IH = SUMATORIA{Tmedia -10 + (Tm&aacute;xima -10)} / 2k<br/>
                <br/>
                Donde, Tmedia y Tm&aacute;xima corresponden a la temperatura media y m&aacute;xima del día (&deg;C),
                respectivamente. k es un coeficiente que depende de la latitud.<br/>
                Los valores del &iacute;ndice dan lugar a seis clases de clima. Huglin y Schneider (1998) estiman
                que el l&iacute;mite inferior de las posibilidades del cultivo de la vid se alcanza con un valor de
                1400 de su IH. Para obtener una tasa de az&uacute;cares del orden de 180-200 g L<sup>-1</sup> para
                los cepajes Merlot y Cabernet - Sauvignon el valor de IH es de 1900.
"
    ),
    "5_GDAE" => array(
            "abr" => "GDAE",
            "nombre" => "Grados D&iacute;a Acumulados Efectivos",
            "descripcion" =>
                "Es similar al conocido &iacute;ndice de grados d&iacute;a acumulados, a excepci&oacute;n
                que involucra una correcci&oacute;n por la latitud para incorporar el efecto de d&iacute;as
                m&aacute;s largos en las latitudes m&aacute;s extremas. Se calcula como sigue:<br/>
                <br/>
                GDAE = &#91;SUMATORIA{(Tm&aacute;xima - Tm&iacute;nima) / 2)} - 10&#93; * d<br/>
                <br/>
                Calculados entre el 01 de mayo al 31 marzo y donde d es un factor de ajuste respecto
                al largo del d&iacute;a y latitud."
    ),
    "6_TMMC" => array(
            "abr" => "TMMC",
            "nombre" => "&Iacute;ndice de Temperaturas M&aacute;ximas del mes m&aacute;s c&aacute;lido",
            "descripcion" =>
                "Este &iacute;ndice ha sido utilizado para la zonificaci&oacte;n vit&iacute;cola en Sud &Aacute;frica
                y Nueva Zelanda (Villiers, 1997) donde se ha encontrado una relaci&oacute;n entre esta temperatura
                (valores superiores a 25&deg; C) y los vinos de calidad superior.<br/>
                <br/>
                TMMC = MEDIA(Tm&aacute;xima)<br/>
                <br/>
                Este &iacute;ndice es calculado para el mes de Enero y establece cinco clases clim&aacute;ticas
                distintas que van desde un clima fresco (TMMC <= 28 &deg;C) hasta un clima muy c&aacute;lido
                (TMMC >= 32 &deg;C)."
    ),
);




?>