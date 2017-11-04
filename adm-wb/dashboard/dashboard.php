<style>
	.panel-default, #refresh-data {
		border-radius: 0 !important;
	}
	#legend-chart li span{
		display: inline-block;
		width: 12px;
		height: 12px;
		margin-right: 5px;
	}
	#legend-chart ul{
		list-style-type: none;
	}
	@media screen and (max-width: 991px) {
		#orderchart-container {
		width: auto;
		height: auto;
		}
		#ord_details{
			max-width: 300px;
			margin: auto;
		}
		#order-detail-chart{
			max-width: 150px;
			position: relative;
			margin: auto;
		}		
	}
	
</style>
<a id="refresh-data" href="#" class="btn btn-success"><i class="fa fa-refresh"></i> Refresh Data
<script>
$(document).ready(function(){
	$('#refresh-data').click(function(){
		$('#adm-content').load('../adm-wb/dashboard/dashboard.php');
	});
});
</script>
</a>

<div class="row">
<div class="col-md-9">
<br />
	<div id="orderchart-container">
	<div id="totalincome" align="right"></div>
	<canvas id="orderchart"></canvas>
	<script>
	$(document).ready(function(){
		$.ajax({
			type: "POST",
			url: "dashboard/dt_chart_line.php",
			dataType: "json",
			success: function(data){
				//console.log(data);
				var tanggalorder = [];
				var totalduit= [];
				for(var i in data) {
					date = new Date(data[i].tanggal);
					month = date.getMonth() + 1;
					tanggal = date.getDate()+ "-" +(month.length > 1 ? month : "0" + month)+ "-" + date.getFullYear();
					tanggalorder.push(tanggal);
					totalduit.push(data[i].totalduit);
				}
				var chartdata = {
					labels: tanggalorder,
					datasets: [{
						label: 'Income Weekly',
						fill: true,
						lineTension: 0.1,
						backgroundColor: "rgba(75,192,192,0.4)",
						borderColor: "rgba(75,192,192,1)",
						borderCapStyle: 'butt',
						borderDash: [],
						borderDashOffset: 0,
						borderJoinStyle: 'miter',
						pointBorderColor: "rgba(75,192,192,1)",
						pointBackgroundColor: "#fff",
						pointBorderWidth: 1,
						pointHoverRadius: 5,
						pointHoverBackgroundColor: "rgba(75,192,192,1)",
						pointHoverBorderColor: "rgba(220,220,220,1)",
						pointHoverBorderWidth: 2,
						pointRadius: 5,
						pointHitRadius: 10,
						data: totalduit,
						spanGaps: false,
						yAxisID: 'y-axis-1'
					}]
				};

					var ctx = $("#orderchart");
					var LineGraph = new Chart(ctx, {
						type: 'line',
						data: chartdata,
						options:{
							responsive: true,
							scales: {
								xAxes: [{
									display: true,
									gridLines: {
										display: false
									},
									labels: {
										show: true,
									}
								}],
								yAxes: [{
									type: "linear",
									display: true,
									position: "left",
									id: "y-axis-1",
									gridLines: {
										display: false
									},
									labels: {
										show: true,
									},
									ticks: {
									   beginAtZero: true,
									   userCallback: function(label, index, labels) {
											if (Math.floor(label) === label) {
											return "IDR " +label;
											}
										},
									}
								}]
							}
						}
					});
					function updatedata(){
						var chartdata = function () {
							$.post("dashboard/dt_dashboard.php").then(function (data) {
								console.log(data);
								tanggalorder = [];
								totalduit= [];
								for(var i in data) {
									date = new Date(data[i].tanggal);
									month = date.getMonth() + 1;
									tanggal = date.getDate()+ "-" +(month.length > 1 ? month : "0" + month)+ "-" + date.getFullYear();

									tanggalorder.push(tanggal);
									totalduit.push(data[i].totalduit);

									LineGraph.data.datasets[0].data[i];
									LineGraph.update();
								}
							});
						}
					}
				}
		});
	});
	</script>
	</div>
</div>
<div class="col-md-3">
<br></br>
<br />
	<div id="ord_details" class="panel panel-default">
		<div class="panel-body">
		<legend align="center">Order Detail</legend>
		<div id="orderchartdet-container">
			<canvas id="order-detail-chart"></canvas>
			<script>
			 $(document).ready(function(){
				$.ajax({
					type: "POST",
					url: "dashboard/dt_chart_dnt.php",
					dataType: "json",
					success: function(data){
						var torder = [];
						var tcancel	= [];
						var tcomplete = [];
						var tincome = [];
						for (var i in data){
							torder.push(data[i].totalorder);
							tcancel.push(data[i].totalcancel);
							tcomplete.push(data[i].totalcompleted);
							tincome.push(data[i].totalincome);
						}
													
						var dtdonat = {
							labels 	: ["Order", "Cancel", "Completed"],
							datasets: [{
								label: "Order Status",
								data: [torder, tcancel, tcomplete],
								backgroundColor: ["#CD5B59", "#A9A9A9", "#46FA8A"],
								borderwidth: [1,1]
							}]
						}
						
						var ctx2 = $("#order-detail-chart");
						var donat= new Chart(ctx2,{
							type: 'doughnut',
							data: dtdonat,
							options: {
								responsive: true,
								cutoutPercentage: 65,
								legend: {
									display: false
								}
							}
						});
						document.getElementById('legend-chart').innerHTML = donat.generateLegend();
						$("#totalincome").append("<p style='font-size:15px;padding-right:20px;'>Total Income:<b> IDR "+tincome+",-<b/></p>");
					}
				});
			});
			</script>
		<div id="legend-chart" style="margin:auto;"></div>
		<br />
		</div>
		</div>
	</div>
</div>
</div>