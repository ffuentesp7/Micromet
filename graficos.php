<?php

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
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://code.jscharting.com/latest/jscharting.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js" integrity="sha512-QSkVNOCYLtj73J4hbmVoOV6KVZuMluZlioC+trLpewV8qMjsWqlIQvkn1KGX2StWvPMdWGBqim1xlC8krl1EKQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>



    <title>Micromet - Biovision</title>
</head>

<!-- Global IE fix to avoid layout crash when single word size wider than column width -->
<!-- Following line MUST remain as a comment to have the proper effect -->
<!--[if IE]><style type="text/css"> body {word-wrap: break-word;}</style><![endif]-->

<body>
    <!-- CONTAINER FOR ENTIRE PAGE -->
    <!-- <div class="d-flex" id="wrapper">


		<div class="content" id="page-content-wrapper"> -->

    <br>
    <div class="container-fluid">
        <h5 class="alert alert-success" role="alert">Datos de Estación Meteorológica</h5>
        <hr>

        <div class="row row-cols-2 row-cols-md-3 g-4">
            <div class="col">
            <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Radiación</h5>
                    </div>
                    <div class="card-body">
                    <div id="chartDiv" style="width: 100%; height: 250px;"></div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Temperatura</h5>
                    </div>
                    <div class="card-body">
                    <canvas id="myChart" style="width: 100%; height: 250px;"></canvas>

                    </div>
                </div>
            </div>
            <div class="col">
            <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Humedad</h5>
                    </div>
                    <div class="card-body">
                    <canvas id="myChart2" style="width: 100%; height: 250px;"></canvas>
                        
                    </div>
                </div>
            </div>
            <div class="col">
            <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Precipitaciones</h5>
                    </div>
                    <div class="card-body">
                    <canvas id="myChart3" style="width: 100%; height: 250px;"></canvas>
                    </div>
                </div>
            </div>
            <div class="col">
            <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Velocidad del viento</h5>
                    </div>
                    <div class="card-body">
                    <canvas id="myChart4" style="width: 100%; height: 250px;"></canvas>

                    </div>
                </div>
            </div>
            <div class="col">
            <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Dirección del viento</h5>
                    </div>
                    <div class="card-body">
                    <div id="chartDiv2" style="width: 100%; height: 350px;">
    </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- </div>
	</div> -->

</body>

</html>
<script>
    JSC.Chart("chartDiv", {
  series: [
    {
      points: [
        { x: "Enero", y: 210 }, 
        { x: "Febrero", y: 160 },
        { x: "Marzo", y: 140 },
        { x: "Abril", y: 95 },
        { x: "Mayo", y: 70 },
        { x: "Junio", y: 50 },
        { x: "Julio", y: 65 },
        { x: "Agosto", y: 90 },
        { x: "Septiembre", y: 120 },
        { x: "Octubre", y: 160 },
        { x: "Noviembre", y: 190 },
        { x: "Diciembre", y: 220 }
    ]
    }
  ]
});

const ctx = document.getElementById('myChart');
const ctx2 = document.getElementById('myChart2');
const ctx3 = document.getElementById('myChart3');
const ctx4 = document.getElementById('myChart4');
const myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio',
    'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        datasets: [{
            label: 'Promedio Temperatura',
            data: [31, 29, 26, 21, 18, 16, 19, 23, 26, 28, 30, 32],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',

            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
const myChart3 = new Chart(ctx3, {
    type: 'bar',
    data: {
        labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio',
    'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        datasets: [{
            label: 'Promedio Precipitaciones (mm)',
            data: [0, 2, 40, 120, 170, 150, 80, 60, 45, 28, 20, 5],
            backgroundColor: [
                'rgba(20, 200, 132, 0.2)',

            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
const myChart4 = new Chart(ctx4, {
    type: 'line',
    data: {
        labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio',
    'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        datasets: [{
            label: 'Promedio Velocidad (Km/h)',
            data: [25, 23, 26, 26, 30, 35, 38, 32, 34, 30, 28, 30],
            backgroundColor: [
                'rgba(55, 99, 132, 0.2)',

            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: false
            }
        }
    }
});
const data = {
    labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio',
    'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
  datasets: [
    {
      label: '%',
      data: [40,45,50,60,66,70, 85, 65, 60, 55, 50, 40],
      borderColor: 'rgba(25, 150, 100, 0.8)',
      backgroundColor: 'rgba(255, 99, 132, 0.2)',
      pointStyle: 'circle',
      pointRadius: 10,
      pointHoverRadius: 15
    }
  ]
};
const myChart2 = new Chart(ctx2, {
    type: 'line',
  data: data,
  options: {
    responsive: true,
    plugins: {
      title: {
        display: true
        
      }
    }
  }
});

var chart; 
  
JSC.fetch('./wrd.csv') 
  .then(function(response) { 
    return response.text(); 
  }) 
  .then(function(text) { 
    var data = JSC.csv2Json(text); 
    chart = renderChart(data); 
  }); 
function renderChart(data) { 
  return JSC.chart('chartDiv2', { 
    debug: true, 
    type: 'radar column', 
    animation_duration: 1000, 
    title: { 
      label_text: 'Wind Rose', 
      position: 'center'
    }, 
    legend: { 
      title_label_text: 'Velocidad del viento ( mph)', 
      position: 'bottom', 
      template: '%icon %name', 
      reversed: true
    }, 
    annotations: [ 
      { 
        label: { 
          text: 'Calm: 17%<br>Vel promedio: 7.9 mph', 
          style_fontSize: 14 
        }, 
        position: 'inside bottom right'
      } 
    ], 
    defaultSeries_shape_padding: 0.02, 
    yAxis: { 
      defaultTick_label_text: '%value%', 
      scale: { type: 'stacked' }, 
      alternateGridFill: 'none'
    }, 
    xAxis: { 
      scale: { range: [0, 360], interval: 45 }, 
      customTicks: [ 
        { value: 360, label_text: 'N' }, 
        { value: 45, label_text: 'NE' }, 
        { value: 90, label_text: 'E' }, 
        { value: 135, label_text: 'SE' }, 
        { value: 180, label_text: 'S' }, 
        { value: 225, label_text: 'SO' }, 
        { value: 270, label_text: 'O' }, 
        { value: 315, label_text: 'NO' } 
      ] 
    }, 
    palette: [ 
      '#c62828', 
      '#ff7043', 
      '#fff176', 
      '#aed581', 
      '#80cbc4', 
      '#bbdefb'
    ], 
    defaultPoint: { 
      tooltip: 
        '<b>%seriesName</b> %xValue° %yValue%'
    }, 
    series: JSC.nest() 
      .key('speed') 
      .key('angle') 
      .rollup('percent') 
      .series(data) 
      .reverse() 
  }); 
} 
</script>