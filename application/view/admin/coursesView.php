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
				<h2>Courses</h2>
				<form action="" method="post">
					<div class="table-responsive">
						<table class="table table-hover">
							<thead>
								<tr>
									<th><input type="checkbox" name="checkbox-select-all" /></th>
									<th>Title</th>
									<th>Date Added</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><input type="checkbox" name="checkbox-select-item" data-id="12345" /></td>
									<td>Introduction to Engineering Design</td>
									<td>March 17, 2014</td>
									<td>
										<a href="#">Edit</a>
										<a href="#">Hide</a>
										<a href="#">Delete</a>
									</td>
								</tr>
								<tr>
									<td><input type="checkbox" name="checkbox-select-item" data-id="12345" /></td>
									<td>Introduction to Engineering Design</td>
									<td>March 17, 2014</td>
									<td>
										<a href="#">Edit</a>
										<a href="#">Hide</a>
										<a href="#">Delete</a>
									</td>
								</tr>
								<tr>
									<td><input type="checkbox" name="checkbox-select-item" data-id="12345" /></td>
									<td>Introduction to Engineering Design</td>
									<td>March 17, 2014</td>
									<td>
										<a href="#">Edit</a>
										<a href="#">Hide</a>
										<a href="#">Delete</a>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<label>Bulk Actions:</label>
					<input type="submit" name="bulk-action-hide" value="Hide" class="btn btn-blue" />
					<input type="submit" name="bulk-action-Delete" value="Delete" class="btn btn-blue" />
				</form>
			</div>
		</div>
</div>