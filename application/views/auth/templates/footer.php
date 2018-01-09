		<?php 
			date_default_timezone_set('Asia/Manila'); 
			
			$y = date('Y'); 
			if ($y == '2017') 
			{
				$year = '2015';
			}
			else{
				$year = '2015-'.$y;
			}
		?>
		<div class="container">
			<p>&nbsp;</p>
			<div id="footer-div" class="small text-right">&copy; <?php echo $year ?>. 
			Office of Rep. Romero Federico Quimbo, House of Representatives, Republic of the Philippines. All Rights Reserved.</div>
		</div><!-- container -->
	
	</div>
</body>
</html>
