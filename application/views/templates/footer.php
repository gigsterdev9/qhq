		<?php 
			date_default_timezone_set('Asia/Manila'); 
			
			$y = date('Y'); 
			if ($y == '2015') 
			{
				$year = '2015';
			}
			else{
				$year = '2015-'.$y;
			}
		?>
		<div class="container">
			<p>&nbsp;</p>
			<div id="footer-div" class="small text-right">
				<?php		
				$user = $this->ion_auth->user()->row();
				$username = ucfirst($user->username);
				echo '<i>Logged in as '.$username.'.</i><br />';
				?>
				<p>Page rendered in {elapsed_time} seconds using {memory_usage} of memory.</p>
				Q-CRM System v.0.01.
				&copy; <?php echo $year ?>. 
				Office of Rep. Romero Federico Quimbo <br /> 
				House of Representatives, Republic of the Philippines. All Rights Reserved.<br />
				<!--CodeIgniter <?php echo CI_VERSION; ?>-->
				</div>
			</div>
		</div><!-- container -->

		<!-- SCRIPTS -->

		<script>
			$(document).ready(function(){
				
				//nav menu script 
				$('.dropdown-submenu a.test').on("click", function(e){
					$(this).next('ul').toggle();
					e.stopPropagation();
					e.preventDefault();
				});

				//initialize enhanced select dropdown fields
				$('.select2-single').select2({
					placeholder: 'Select an option'
				});


			});
		</script>


    </body>
</html>
