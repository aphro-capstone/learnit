

<div class="row">
 	<div class="col col-xs-12 col-sm-6 col-md-4 col-lg-3">
 		<div class="panel panel-has-icon">
	 		<div class="panel-heading">
	 			<h3>Users</h3>
	 		</div>
	 		<div class="panel-content">
	 			<p class="count">268</p>
	 			<p class="count-subtext mb-0"> Testing text</p>
	 		</div>
	 		<i class="fa fa-user icon icon-overlay"></i>

	 	</div>
 	</div>
 	<div class="col col-xs-12 col-sm-6 col-md-4 col-lg-3">
 		<div class="panel panel-has-icon">
	 		<div class="panel-heading">
	 			<h3>Classess</h3>
	 		</div>
	 		<div class="panel-content">
	 			<p class="count">268</p>
	 			<p class="count-subtext mb-0"> Testing text</p>
	 		</div>
	 		<i class="fa fa-users icon icon-overlay"></i>

	 	</div>
 	</div>
 	<div class="col col-xs-12 col-sm-6 col-md-4 col-lg-3">
 		<div class="panel panel-has-icon">
	 		<div class="panel-heading">
	 			<h3>Groups</h3>
	 		</div>
	 		<div class="panel-content">
	 			<p class="count">268</p>
	 			<p class="count-subtext mb-0"> Testing text</p>
	 		</div>
	 		<i class="fa fa-object-group icon icon-overlay"></i>
	 	</div>
 	</div>
 	<div class="col col-xs-12 col-sm-6 col-md-4 col-lg-3">
 		<div class="panel calendar-upper">
	 		<div class="panel-content">
	 			<div id="Calendar"></div>
	 		</div> 
	 	</div>
 	</div>
</div>
<div class="row mt-4">
	<div class="col-sm-12 col-md-9 col-lg-9">
		<div class="panel">
			<canvas id="myChart" height="400" style="width:100%"></canvas>
		</div>
	</div>
</div>






<script>	
		window.onload = function(){
			var ctx = document.getElementById('myChart').getContext('2d');
			var myChart = new Chart(ctx, {
					type: 'bar',
					data: {
						labels: ["1900", "1950", "1999", "2050"],
						datasets: [
						{
							label: "Successfull",
							backgroundColor: "#3e95cd",
							data: [133,221,783,2478]
						}, {
							label: "Failed",
							backgroundColor: "#8e5ea2",
							data: [408,547,675,734]
						}
						]
					},
					options: {
						title: {
						display: true,
						text: 'Number of successful registrations per month over unsuccesful registrations'
						}
					}
				});
		}
</script>