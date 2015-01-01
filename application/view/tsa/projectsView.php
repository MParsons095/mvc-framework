<div class="bg-black">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h1 class="txt-grey">Our Projects</h1>
            </div>
        </div>
    </div>
</div>
<div class="container">
	<?php
		if(is_array($projectsList) && count($projectsList) > 0)
		{
			$counter = 0;
			$offset = null;

			for($i = 0; $i < count($projectsList); $i++)
			{
				if($i % 2 == 0)
				{
					print '
					<div class="row content">
					<div class="presentation-block col-md-5 col-md-offset-1-half" >
						<a href="' . DOMAIN_ROOT . 'tsa/projects/' . $projectsList[$i]->getSlug() . '">
							<div class="overlay">
								<img src="' . DOMAIN_ROOT . 'public/system/image/' .  $projectsList[$i]->getPicture() . '.jpg" />
							</div>
							<div class="inner shadow">
								<h3>' . ucwords($projectsList[$i]->getTitle()) . '</h3>
							</div>
						</a>
					</div>';
				}
				else
				{
					print '
					<div class="presentation-block col-md-5 col-md-offset-1" >
						<a href="' . DOMAIN_ROOT . 'tsa/projects/' . $projectsList[$i]->getSlug() . '">
							<div class="overlay">
								<img src="' . DOMAIN_ROOT . 'public/system/image/' .  $projectsList[$i]->getPicture() . '.jpg" />
							</div>
							<div class="inner shadow">
								<h3>' . ucwords($projectsList[$i]->getTitle()) . '</h3>
							</div>
						</a>
					</div></div>';
				}

				if($i == count($projectsList) - 1 && count($projectsList) % 2 == 1)
				{
					print '</div>';
				}
			}
		}
		else
		{
			print '<h3 class="text-center">Sorry. We have no active projects.</h3>';
		}
	?>
</div>