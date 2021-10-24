
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movimientos</title>
    <script src="http://35.173.186.107/lib/js/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
	<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-style@0.5.0"></script>
</head>
<body>
	<div>
		<canvas id="myChart" height="380" ></canvas>
	</div>


    <script>


var chartColors = {
	red: 'rgb(255, 99, 132)',
	orange: 'rgb(255, 159, 64)',
	yellow: 'rgb(255, 205, 86)',
	green: 'rgb(75, 192, 192)',
	blue: 'rgb(54, 162, 235)',
	purple: 'rgb(153, 102, 255)',
	grey: 'rgb(201, 203, 207)'
};
var effectColors = {
	highlight: 'rgba(255, 255, 255, 0.75)',
	shadow: 'rgba(0, 0, 0, 0.5)',
	glow: 'rgb(255, 255, 0)'	
};

function randomScalingFactor() {
	return Math.round(Math.random() * 2000);
}

var color = Chart.helpers.color;
var config = {
	type: 'doughnut',
	data: {
		labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
		datasets: [{
			data: [0, 0, 0, 0].map(function() {
				return randomScalingFactor();
			}),
			backgroundColor: [
				window.chartColors.red,
				window.chartColors.orange,
				window.chartColors.yellow,
				window.chartColors.green,
				window.chartColors.blue,
			],
			shadowOffsetX: 3,
			shadowOffsetY: 3,
			shadowBlur: 20,
			shadowColor: effectColors.shadow,
			bevelWidth: 2,
			bevelHighlightColor: effectColors.highlight,
			bevelShadowColor: effectColors.shadow,
			hoverInnerGlowWidth: 20,
			hoverInnerGlowColor: effectColors.glow,
			hoverOuterGlowWidth: 20,
			hoverOuterGlowColor: effectColors.glow
		}],
		labels: [
			'Compras',
			'Entretenimiento',
			'Movilidad',
			'Comida/Viajes'
		]
	},
	options: {
		title: {
			display: true,
			text: '',
            fontColor: 'rgb(0, 0, 0)',
            fontSize: 20
		},
		tooltips: {
			shadowOffsetX: 3,
			shadowOffsetY: 3,
			shadowBlur: 10,
			shadowColor: effectColors.shadow,
			bevelWidth: 2,
			bevelHighlightColor: effectColors.highlight,
			bevelShadowColor: effectColors.shadow
		},
		animation: {
			animateScale: true,
			animateRotate: true
		},
		layout: {
			padding: {
				bottom: 10
			}
		},
        legend: {
            display: true,
            labels: {
                fontColor: 'rgb(255, 255, 255)',
                fontSize: 15
            }
        }
      
	}
};

window.onload = function() {
	var ctx = document.getElementById('myChart').getContext('2d');
	window.myChart = new Chart(ctx, config);
};









    </script>
</body>
</html>