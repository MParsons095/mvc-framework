<div class="bg-black">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h1 class="txt-grey">TSA Awards</h1>
            </div>
        </div>
    </div>
</div>
<div class="container">
	<div class="content">
		<?php

			if(is_array($awardList) && count($awardList) > 0)
			{
				$levels = array(
					'national' => array(),
					'state' => array(),
					'regional' => array()
				);

				foreach($awardList as $award)
				{
					foreach($levels as $key => $level)
					{
						if($award['level'] == $key)
						{
							$levels[$key][] = $award;
						}
					}
				}

				$x = 0;
				foreach($levels as $key => $level)
				{
					print '<h2>' . ucfirst($key) . '</h2>';

					if(count($level) == 0)
					{
						print '<div class="text-center"><h3>No Awards Listed</h3></div>';
					}

					foreach($level as $k => $award)
					{
						if($x == 3 && $k != 0)
						{
							$offset = '1-half';
							print '</div><div class="row content">';
							$x = 0;
						}
						elseif($k == 0)
						{
							$offset = '1-half';
							print '<div class="row content">';
						}
						else
						{
							$offset = '1';
						}

						print '
						<div class="col-md-3 col-md-offset-' . $offset . ' content-panel">
							<div class="inner-panel">
								<div class="row">
									<div class="col-md-3">
										<img src="' . DOMAIN_ROOT . 'public/system/image/' .  $award['picture'] . '.jpg" />
									</div>
									<div class="col-md-9">
										<h3>' . $award['firstName'] . ' ' . $award['lastName'] . '</h3>
										<div><b>' . $award['competition'] . '</b></div>
										<div><b>Place:</b> ' . $award['placing'] . '</b></div>
										<div><b>Year:</b> ' . $award['yearOf'] . '</b></div>
									</div>
								</div>
							</div>
						</div>';

						if($k == count($level) - 1)
						{
							print '</div>';
						}

						$x++;
					}

					$x = 0;
				}
			}
			else
			{
				print '<div class="text-center"><h3>We don\'t have any awards yet, but we will soon!</div>';
			}
		?>
	</div>
</div>