<?php 
	/*
	if ($logged_in == FALSE) 
	{
		echo 'This is the <b>Grants Management and Information System</b> for Phase 5 of the UNDP Small Grants Programme.<br />';
		echo 'Please log in to access content.';
	}
	else
	{
		echo '<h1>DASHBOARD</h1>';
	}	
	*/
?>	
<div class="container">
	<h1><span class="glyphicon glyphicon-dashboard"></span> DASHBOARD</h1>
	<p>&nbsp;</p>
	<div class="alert alert-info">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		This page will show an overview of the system data. Current items on display are just mockups.
	</div>
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
	<div class="row">
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<strong><span class="glyphicon glyphicon-th-list"></span> Updates</strong>
				</div>
				<div class="panel-body">
					<p><strong><span class="glyphicon glyphicon-folder-open"></span>&nbsp; Grants due for completion</strong></p>
					<ul class="list-group">
					  <li class="list-group-item">First item</li>
					  <li class="list-group-item">Second item</li>
					  <li class="list-group-item">Third item</li>
					  <li class="list-group-item">Fourth item</li>
					  <li class="list-group-item">Fifth item</li>
					</ul>
					
					<p><strong><span class="glyphicon glyphicon-folder-open"></span>&nbsp; Recently added grants</strong></p>
					<ul class="list-group">
					  <li class="list-group-item">First item</li>
					  <li class="list-group-item">Second item</li>
					  <li class="list-group-item">Third item</li>
					  <li class="list-group-item">Fourth item</li>
					  <li class="list-group-item">Fifth item</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-md-5">
			<div class="panel panel-default">
				<div class="panel-heading">
					<strong><span class="glyphicon glyphicon-screenshot"></span> Target Indicators</strong>
				</div>
				<div class="panel-body">
					<!--barchart for target indicators-->
					<div id="bar_indicators" data-sort="false" data-width="340" data-x_label="% Attained" class="jChart chart-lg" name="">
						<div class="define-chart-row" data-color="#337AB7" title="Output 1.1">30</div>
						<div class="define-chart-row" data-color="#337AB7" title="Output 1.2">40</div>
						<div class="define-chart-row" data-color="#337AB7" title="Output 1.3">70</div>
						<div class="define-chart-row" data-color="#337AB7" title="Output 1.4">90</div>
						<div class="define-chart-row" data-color="#337AB7" title="Output 2.1">30</div>
						<div class="define-chart-row" data-color="#337AB7" title="Output 2.2">25</div>
						<div class="define-chart-row" data-color="#337AB7" title="Output 3.1">75</div>
						<div class="define-chart-row" data-color="#337AB7" title="Output 4.1">40</div>
						<div class="define-chart-row" data-color="#337AB7" title="Output 4.2">45</div>
						<div class="define-chart-row" data-color="#337AB7" title="Output 4.3">56</div>
						<div class="define-chart-row" data-color="#337AB7" title="Output 4.4">52</div>
						<div class="define-chart-row" data-color="#337AB7" title="Output 5.1">38</div>
						<div class="define-chart-row" data-color="#337AB7" title="Output 5.2">61</div>
						<div class="define-chart-row" data-color="#337AB7" title="Output 5.3">96</div>
						
						<div class="define-chart-footer">20</div>
						<div class="define-chart-footer">40</div>
						<div class="define-chart-footer">60</div>
						<div class="define-chart-footer">80</div>
						<div class="define-chart-footer">100</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="panel panel-default">
				<div class="panel-heading">
					<strong><span class="glyphicon glyphicon-stats"></span> Quick Stats</strong>
				</div>
				<div class="panel-body">
					<p><strong><span class="glyphicon glyphicon-folder-open"></span>&nbsp; Grants Distribution</strong></p>
					<!--
					<ul class="list-group">
						<li class="list-group-item"><span class="badge">46</span> Total Phase-5 grants</li>
						<li class="list-group-item"><span class="badge">10</span> Outcome 1 grants</li>
						<li class="list-group-item"><span class="badge">13</span> Outcome 2 grants</li>
						<li class="list-group-item"><span class="badge">19</span> Outcome 3 grants</li>
						<li class="list-group-item"><span class="badge">12</span> Outcome 4 grants</li>
						<li class="list-group-item"><span class="badge">11</span> Outcome 5 grants</li>
					</ul>
					<hr />
					<ul class="list-group">
						<li class="list-group-item"><span class="badge">46</span> Ongoing</li>
						<li class="list-group-item"><span class="badge">12</span> Pending approval</li>
						<li class="list-group-item"><span class="badge">98</span> Historical grants</li>
					</ul>
					-->
					<div id="pie_grant_type"></div>
					<div id="pie_grant_status"></div>
					<div id="pie_grant_outcome"></div>
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
		$("#bar_indicators").jChart();
	});
	
	//Distribution by Outcome
	var pie = new d3pie("pie_grant_outcome", {
	"header": {
			"title": {
				"text": "By Outcome",
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
			"canvasHeight": 200,
			"canvasWidth": 250,
			"pieOuterRadius": "80%"
		},
		"data": {
			"content": [
				{
					"label": "1",
					"value": 12,
					"color": "#094b83"
				},
				{
					"label": "2",
					"value": 25,
					"color": "#1266AB"
				},
				{
					"label": "3",
					"value": 33,
					"color": "#5393C8"
				},
				{
					"label": "4",
					"value": 15,
					"color": "#7EB1DC"
				},
				{
					"label": "5",
					"value": 9,
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

	
	
	//Distribution by status
	var pie = new d3pie("pie_grant_status", {
	"header": {
			"title": {
				"text": "By Status",
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
			"canvasHeight": 200,
			"canvasWidth": 250,
			"pieOuterRadius": "80%"
		},
		"data": {
			"content": [
				{
					"label": "Ongoing",
					"value": 40,
					"color": "#094b83"
				},
				{
					"label": "Pending",
					"value": 21,
					"color": "#1266AB"
				},
				{
					"label": "Historical",
					"value": 99,
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
	
	
	//Distribution by grant type
	var pie = new d3pie("pie_grant_type", {
	"header": {
			"title": {
				"text": "By Grant Type",
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
			"canvasHeight": 200,
			"canvasWidth": 250,
			"pieOuterRadius": "80%"
		},
		"data": {
			"content": [
				{
					"label": "Small",
					"value": 51,
					"color": "#094b83"
				},
				{
					"label": "Planning",
					"value": 25,
					"color": "#1266AB"
				},
				{
					"label": "Strategic",
					"value": 10,
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
</script>
