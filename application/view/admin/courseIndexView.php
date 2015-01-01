<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h1>Administration Panel</h1>
			</div>
		</div>

		<div class="row">
			<?php include $adminNav; ?>
			<!-- Content -->
			<div class="col-md-10 content bg-white shadow">
				<div class="row">
					<div class="col-md-6">
						<h2>Courses</h2>
					</div>
					<div class="col-md-6 text-right">
						<a href="<?php print DOMAIN_ROOT . 'admin/courses/new'; ?>" class="btn btn-blue heading-btn">New Course</a>
					</div>
				</div>
				<div class="text-center">
					<h3>This Part of the Admin Panel is Under Maintenance. Please Do Not Perform Any Actions Here Until this Message is Removed</h3>
				</div>
				<div data-role="courseContainer">

				</div>
				<?php
					if($response['state'] === false)
					{
						print $response['state'];
					}
					else
					{
				?>
				<form action="" method="post">
					<div class="table-responsive">
						<table class="table table-hover">
							<thead>
								<tr>
									<th>Title</th>
									<th>Date Added</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
									foreach($courses as $course)
									{
									?>
										<tr>
											<td><?php print $course->getTitle(); ?></td>
											<td>March 17, 2014</td>
											<td data-id="<?php print $course->getUid(); ?>">
												<a href="<?php print DOMAIN_ROOT . 'admin/courses/view/' . $course->getSlug(); ?>">Edit</a>
												<a href="#" data-action="delete-course">Delete</a>
											</td>
										</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</form>
				<?php } ?>
			</div>
		</div>
</div>