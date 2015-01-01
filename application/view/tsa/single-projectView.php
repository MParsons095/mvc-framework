<div class="container">
	<div class="row">
		<div class="col-md-2 content">
			<a href="<?php print DOMAIN_ROOT; ?>tsa/projects" class="btn btn-orange">Back to Projects</a>
		</div>
		<div class="col-md-8 content">
			<img src="<?php print DOMAIN_ROOT . 'public/system/image/' . $project->getPicture() . '.jpg'; ?>" />
			<div class="bg-white shadow" style="padding: 15px">
				<h1><?php print ucwords($project->getTitle()); ?></h1>
				<?php print $project->getDescription(); ?>
				<hr />

				<?php
					if(isset($projectMeta) && is_array($projectMeta))
					{
						print '<h2>Project Members</h2><ul>';

						foreach($projectMeta as $key => $value)
						{
							print '<li><a href="' . DOMAIN_ROOT . 'tsa/members/view/' . $value['slug'] . '">' . $value['firstName'] . ' ' . $value['lastName'] . '</a></li>';
						}

						print '</ul>';
					}
				?>
			</div>
		</div>
	</div>
</div>