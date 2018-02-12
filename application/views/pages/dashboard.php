<div class="container">
	<h1><span class="glyphicon glyphicon-dashboard"></span> DASHBOARD</h1>
	<p>&nbsp;</p>
	<div class="alert alert-info">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<!-- This page will show an overview of the system data. Current items on display are just mockups. -->
		<?php		
		$user = $this->ion_auth->user()->row();
		$username = ucfirst($user->username);
		echo 'You are logged in as user '.$username.'.';
		?>
	</div>
	<!--
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<strong><span class="glyphicon glyphicon-alert"></span> Reminders</strong>
				</div>
				<div class="panel-body">
					Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla magna neque, suscipit et dolor nec, mollis accumsan neque. Nunc maximus interdum efficitur. Vivamus maximus imperdiet odio, eget pulvinar lacus. Integer enim leo, varius ac laoreet vel, bibendum id velit. Praesent varius porta commodo. Aenean tortor libero, tincidunt eget magna vel, rutrum faucibus lectus. Vestibulum sed justo a neque pulvinar dapibus. Aliquam diam tortor, consectetur sit amet varius sed, posuere vel magna.
				</div>
			</div>
		</div>
	</div>
	-->
	<div class="row">
	<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<strong><span class="glyphicon glyphicon-stats"></span> Quick Stats</strong>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-4" id="pie_gender"></div>
						<div class="col-md-4" id="pie_type"></div>
						<div class="col-md-4" id="pie_barangay"></div>
					</div>
					
				</div>
			</div>
			
			<!--
			<div class="panel panel-default">
				<div class="panel-heading">
					<strong><span class="glyphicon glyphicon-stats"></span> Quick Stats</strong>
				</div>
				<div class="panel-body">
					<p><strong><span class="glyphicon glyphicon-folder-open"></span>&nbsp; Demographics</strong></p>
					
					
				</div>
			</div>
			-->

		</div>
	</div>
	<div class="row">
		<div class="col-md-8">
			<div class="panel panel-default">
				<div class="panel-heading">
					<strong><span class="glyphicon glyphicon-th-list"></span> Updates</strong>
				</div>
				
				<div class="panel-body">
					<div class="row">
						<div class="col-md-6">
							<p><strong><span class="glyphicon glyphicon-folder-open"></span>&nbsp; Recent Scholarship Grantees</strong></p>
							<ul class="list-group">
							<?php

								if ($recent_scholars == NULL)
								{
									echo '<li class="list-group-item">There are currently no projects nearing completion.</li>';
								}
								else
								{
									foreach ($recent_scholars as $recent_scholar) 
									{
										$link = base_url('scholarships/view/'.$recent_scholar['scholarship_id']);
										$display = strtoupper($recent_scholar['fname'].' '.$recent_scholar['lname']).', '.$recent_scholar['age'].'<br />('.$recent_scholar['course'].')';
										echo '<li class="list-group-item"><a href="'.$link.'">'.$display.'</a></li>';
									}
								}
							?>
							</ul>
						</div>
						<div class="col-md-6">
							<p><strong><span class="glyphicon glyphicon-folder-open"></span>&nbsp; Recent Service Recipients</strong></p>
							<ul class="list-group">
								<?php 
									foreach ($recent_service_availments['r'] as $rsa) 
									{
										$link = base_url('services/view/'.$rsa['service_id']);
										$display = $rsa['fname'].' '.$rsa['lname'].', VID: '.$rsa['id_no_comelec'].'<br />'.
													'('.ucfirst($rsa['service_type']).' Assistance)';
										echo '<li class="list-group-item"><a href="'.$link.'">'.$display.'</a></li>';
									}
								
									foreach ($recent_service_availments['n'] as $rsa) 
									{
										$link = base_url('services/view/'.$rsa['service_id']);
										$display = $rsa['fname'].' '.$rsa['lname'].'<br />('.ucfirst($rsa['service_type']).' Assistance)';
										echo '<li class="list-group-item"><a href="'.$link.'">'.$display.'</a></li>';
									}
								?>
							</ul>
						</div>
					</div>
				</div>

			</div>
		</div>
		
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<strong><span class="glyphicon glyphicon-th-list"></span> Reminders</strong>
				</div>
				<div class="panel-body">
					<p>
					Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut eget mauris eu urna congue tempus. Aliquam erat volutpat. Sed hendrerit posuere felis, eu tempus sem euismod ac. Phasellus dapibus ipsum erat, vitae consequat arcu tempus sed. Etiam eget dictum arcu. Nunc sed odio eget metus tristique pharetra eget a ex. Fusce euismod nec urna consectetur scelerisque. Etiam cursus eros non dui facilisis, sagittis sagittis odio placerat. Aliquam sed auctor orci. Vestibulum vel mi vitae metus ultricies mollis.
					</p>
					<p>
					Vivamus in arcu ac tortor suscipit sodales. Curabitur sit amet nibh malesuada nulla fermentum efficitur. Sed a porttitor dolor. Pellentesque fermentum hendrerit erat, nec lobortis eros lobortis nec. Maecenas porttitor nulla ut sollicitudin efficitur. Sed sed elit finibus, commodo mi a, ullamcorper turpis. Phasellus condimentum justo dolor, et dignissim tortor porttitor non. Sed malesuada a enim id aliquet. Nulla vehicula, velit in varius dictum, quam massa hendrerit est, non hendrerit dui magna et nisl. Nam ante sapien, pretium non sagittis vel, sagittis sit amet turpis.
					</p>
				</div>
			</div>
		</div>

	</div>
	
	<div class="alert alert-danger">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong>Alert!</strong> Set base url.
	</div>
	
</div>
<script language="javascript" >
$(document).ready(function() {
	
	//Target indicator percentage chart
	//$("#bar_indicators").jChart();
	
	//Distribution by Barangay
	var pie = new d3pie("pie_barangay", {
	"header": {
			"title": {
				"text": "Barangay",
				"fontSize": 12,
				"font": "verdana"
			},
			"subtitle": {
				"color": "#999999",
				"fontSize": 10,
				"font": "verdana"
			},
			"titleSubtitlePadding": 12
		},
		"footer": {
			"color": "#999999",
			"fontSize": 11,
			"font": "open sans",
			"location": "bottom-center"
		},
		"size": {
			"canvasHeight": 250,
			"canvasWidth": 300,
			"pieOuterRadius": "80%"
		},
		"data": {
			"content": [
				{
					"label": "Conc Uno",
					"value": 20,
					"color": "#094b83"
				},
				{
					"label": "Conc Dos",
					"value": 10,
					"color": "#1266AB"
				},
				{
					"label": "Nangka",
					"value": 10,
					"color": "#5393C8"
				},
				{
					"label": "Parang",
					"value": 10,
					"color": "#7EB1DC"
				},
				{
					"label": "Mrkna\nHts",
					"value": 10,
					"color": "#337BB7"
				},
				{
					"label": "Tumana",
					"value": 10,
					"color": "#337BB7"
				}
				]
		},
		"labels": {
			"outer": {
				"format": "label-value2",
				"pieDistance": 0
			},
			"mainLabel": {
				"font": "verdana"
			},
			"percentage": {
				"color": "#e1e1e1",
				"font": "verdana",
				"decimalPlaces": 0
			},
			"value": {
				"color": "#7e7a7a",
				"font": "verdana"
			},
			"lines": {
				"enabled": true,
				"color": "#cccccc"
			},
			"truncation": {
				"enabled": true
			}
		},
		"effects": {
			"pullOutSegmentOnClick": {
				"effect": "linear",
				"speed": 400,
				"size": 8
			}
		}
	});

	
	
	//Distribution by service type
	var pie = new d3pie("pie_type", {
	"header": {
			"title": {
				"text": "Type",
				"fontSize": 12,
				"font": "verdana"
			},
			"subtitle": {
				"color": "#999999",
				"fontSize": 10,
				"font": "verdana"
			},
			"titleSubtitlePadding": 12
		},
		"footer": {
			"color": "#999999",
			"fontSize": 11,
			"font": "open sans",
			"location": "bottom-center"
		},
		"size": {
			"canvasHeight": 250,
			"canvasWidth": 300,
			"pieOuterRadius": "80%"
		},
		"data": {
			"content": [
				{
					"label": "Social Services",
					"value": 100,
					"color": "#094b83"
				},
				{
					"label": "Scholarships",
					"value": 100,
					"color": "#1266AB"
				},
				{
					"label": "Livelihood Programs",
					"value": 100,
					"color": "#1266AB"
				}
			]
		},
		"labels": {
			"outer": {
				"format": "label-value2",
				"pieDistance": 0
			},
			"mainLabel": {
				"font": "verdana"
			},
			"percentage": {
				"color": "#e1e1e1",
				"font": "verdana",
				"decimalPlaces": 0
			},
			"value": {
				"color": "#7e7a7a",
				"font": "verdana"
			},
			"lines": {
				"enabled": true,
				"color": "#cccccc"
			},
			"truncation": {
				"enabled": true
			}
		},
		"effects": {
			"pullOutSegmentOnClick": {
				"effect": "linear",
				"speed": 400,
				"size": 8
			}
		}
	});
	
	
	//Distribution by gender
	var pie = new d3pie("pie_gender", {
	"header": {
			"title": {
				"text": "Gender",
				"fontSize": 12,
				"font": "verdana"
			},
			"subtitle": {
				"color": "#999999",
				"fontSize": 10,
				"font": "verdana"
			},
			"titleSubtitlePadding": 12
		},
		"footer": {
			"color": "#999999",
			"fontSize": 11,
			"font": "open sans",
			"location": "bottom-center"
		},
		"size": {
			"canvasHeight": 250,
			"canvasWidth": 300,
			"pieOuterRadius": "80%"
		},
		"data": {
			"content": [
				{
					"label": "Male",
					"value": 20,
					"color": "#094b83"
				},
				{
					"label": "Female",
					"value": 50,
					"color": "#5393C8"
				}
			]
		},
		"labels": {
			"outer": {
				"format": "label-value2",
				"pieDistance": 0
			},
			"mainLabel": {
				"font": "verdana"
			},
			"percentage": {
				"color": "#e1e1e1",
				"font": "verdana",
				"decimalPlaces": 0
			},
			"value": {
				"color": "#7e7a7a",
				"font": "verdana"
			},
			"lines": {
				"enabled": true,
				"color": "#cccccc"
			},
			"truncation": {
				"enabled": true
			}
		},
		"effects": {
			"pullOutSegmentOnClick": {
				"effect": "linear",
				"speed": 400,
				"size": 8
			}
		}
	});

});
</script>

<?php
//$this->output->enable_profiler(TRUE);
?>
