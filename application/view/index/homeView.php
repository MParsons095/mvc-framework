<div class="container">
	<div>
		<h1>What are we doing?</h1>

		<!-- CONTENT PANELS -->
		<div class="row content">
			<?php
			if(is_array($projects) && count($projects) > 0)
			{
				if(count($projects) > 2)
				{
					$projectCount = 2;
				}
				else
				{
					$projectCount = count($projects);
				}

				$counter = 0;
				$offset = null;

				for($i = 0; $i < $projectCount; $i++)
				{
					if($counter % 2 == 1)
					{
						$offset = 'col-md-offset-1';	
					}

					print '
						<div class="presentation-block col-md-5 ' .  $offset . '" >
							<a href="' . DOMAIN_ROOT . 'tsa/projects/' . $projects[$i]->getSlug() . '">
								<div class="overlay">
									<img src="' . DOMAIN_ROOT . 'public/system/image/' .  $projects[$i]->getPicture() . '.jpg" />
								</div>
								<div class="inner shadow">
									<h3>' . ucwords($projects[$i]->getTitle()) . '</h3>
								</div>
							</a>
						</div>';

					$counter++;
					$offset = null;
				}
			}
			else
			{
				print '<h3 class="text-center">Sorry. We have no active projects.</h3>';
			}
			?>
		</div>	
	</div>

	<div class="content">
		<!-- CALENDAR WIDGETS -->
		<h1>Recent/Current Events</h1>
			<div class="text-center">
				<!--<h3>Coming Soon!</h3>-->
			</div>
		
		<div class="row">
			<div class="cal-widget col-md-3 col-md-offset-1-half stack-seperation">
				<div class="cal-date shadow">
					<div>May</div>
					<div>30</div>
				</div>
				<div class="cal-event">
					<h3>Last Day of School</h3>
					<p>Have a good summer</p>
				</div>
			</div>
			<div class="cal-widget col-md-3 col-md-offset-1-half stack-seperation">
				<div class="cal-date shadow">
					<div>June</div>
					<div>1</div>
				</div>
				<div class="cal-event">
					<h3>Graduation</h3>
					<p>Good Luck Seniors!</p>
				</div>
			</div>

			<div class="cal-widget col-md-3 col-md-offset-1-half stack-seperation">
				<div class="cal-date shadow">
					<div>June</div>
					<div>27</div>
				</div>
				<div class="cal-event">
					<h3>TSA National Competition</h3>
					<p>June 27 - July 1</p>
				</div>
			</div>
		</div>
	</div>
</div>