<div class="bg-black">
	<div class="container profile">
		<div class="row">
			<div class="col-md-3">
				<img class="pr-img" src="<?php print DOMAIN_ROOT . 'public/system/image/' . $accountMeta->getPicture() . '.jpg'; ?>" />
			</div>
			<div class="col-md-9">
				<h1 class="txt-grey"><?php print $accountData->getFirstName() . ' ' . $accountData->getLastName();; ?></h1>
				<p class="txt-white"><?php print $accountMeta->getBio(); ?></p>
				
				<div class="row">
					<div class="col-md-4">
						<div class="pr-stats">
							<div class="top"><?php print date("Y") - $accountMeta->getYearJoined(); ?></div>
							<div class="bottom">Year Member</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="pr-stats">
							<div class="top" data-content="projectsCount">-</div>
							<div class="bottom">Active Projects</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="pr-stats">
							<div class="top" data-content="achievementCount">-</div>
							<div class="bottom">Achievements</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="container">
	<ul class="nav nav-tabs">
			<li class="active"><a href="#projects" data-toggle="tab">Projects</a></li>
			<li><a href="#achievements" data-toggle="tab">Achievements</a></li>
	</ul>
	<div class="content bg-white shadow">
		<div class="tab-content">
			<!-- PROJECTS -->
			<div id="projects" class="tab-pane active fade in">
				<div data-content="projects">
					<div class="text-center">
						<h3>Loading...</h3>
					</div>
				</div>
				<?php if($editable) { ?>
				<a href="#newProjectModal" data-toggle="modal" class="btn btn-grey">New Project</a>
				<a href="" class="btn btn-grey">Join Project</a>


				<!-- New Project Modal -->
					<div class="modal fade" id="newProjectModal" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-lg">
							<div class="modal-content">
								<div class="modal-header">
									<h3>Create a New Project</h3>
								</div>
								<form action="" method="post">
									<div class="modal-body">
										<!-- ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| -->
										<div id="newProjectContent" class="tab-content">
											<label>Project Title</label>
											<input type="text" name="newProjectTitle" class="form-control">
											
											<br />
											<label>Tell us about your Project</label>
											<textarea name="newProjectDescription" class="form-control"></textarea>
											<div data-content="newProjectDescription" style="display:none"></div>

											<br />
											<label>Add an Image</label>
											<div id="image-cropper" data-role="imageCropperProccessingContainer">
												<div class="row text-center">
													<div class="col-md-6">
														<div class="prep-container" data-role="crop-original" data-ratio="4:2">
															<span class="watermark">Original</span>
														</div>
														<button class="btn btn-blue" data-action="selectPicture">Select a Picture</button>
														<button data-action="uploadImage" class="btn btn-blue" style="display:none;">Crop and Upload</button>
														<input type="file" name="imageFileSelector" style="display:none;visibility:hidden" />			
													</div>
													<div class="col-md-6">
														<div class="prep-container" data-role="crop-preview" data-value="false">
															<div class="preview-fixed">
																<img src="null" class="crop-preview" style="max-width: 200px;">
															</div>
															<span class="watermark">
																Preview
															</span>
														</div>
														<button data-action="resetImageCropper" class="btn btn-blue" style="display:none">Remove Picture</button>
														<input type="hidden" value="null" name="uploadedImage" />
														<input type="hidden" name="x1" value="" />
														<input type="hidden" name="y1" value="" />
														<input type="hidden" name="x2" value="" />
														<input type="hidden" name="y2" value="" />
													</div>
												</div>
											</div>
										</div>
										<!-- ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| -->
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-grey" data-dismiss="modal">Close</button>
										<input type="submit" name="saveProject" data-action="saveProject" value="Save Project" class="btn btn-blue" />
									</div>
								</form>
							</div>
						</div>
					</div>



				<?php } ?>
			</div>

			<!-- ACHIEVEMENTS -->
			<div id="achievements" class="tab-pane fade">
				<div class="table-responsive">
					<table class="table" data-content="loadedAwards">
						<thead>
							<th>Award</th>
							<th>Placing</th>
							<th>Level</th>
							<th>Year</th>
							<?php if($editable) { ?>
							<th>Action</th>
							<?php } ?>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>

				<?php if($editable) { ?>
					<a href="#saveAwardModal" data-toggle="modal" class="btn btn-grey">Add Achievement</a>
					<!-- Save Award Modal -->
					<div class="modal fade" id="saveAwardModal" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<h3>Add an Award</h3>
								</div>
								<form action="" method="post">
								<div class="modal-body">
										<div class="row">
											<div class="col-md-12">
												<label for="saveAwardCompetition">Select your Competition</label>
												<select name="saveAwardCompetition" class="form-control">
													<option disabled="disabled" selected="selected">Choose One</option>
													<?php
														foreach($awardMeta as $competition)
														{
															print '<option value="' . $competition['uid'] . '">' . $competition['competition'] . '</option>';
														}
													?>
												</select>
											</div>
										</div>
										<div class="row">
											<div class="col-md-4">
												<label for="saveAwardPlacing">Placing</label>
												<select name="saveAwardPlacing" class="form-control">
													<option disabled="disabled" selected="selected">Select Placing</option>
													<?php
														for($x = 1; $x < 11; $x++)
														{
															print '<option value="' . $x . '">' . $x . '</option>';
														}
													?>
												</select>
											</div>
											<div class="col-md-4">
												<label for="saveAwardYear">Year Awarded</label>
												<select name="saveAwardYear" class="form-control">
													<option disabled="disabled" selected="selected">Select Year</option>
													<?php 
														for($x = date("Y"); $x > date("Y") - 20; $x--)
														{
															print '<option value="' . $x . '">' . $x . '</option>';
														}
													?>
												</select>
											</div>
											<div class="col-md-4">
												<label for="saveAwardLevel">Level</label>
												<select name="saveAwardLevel" class="form-control">
													<option disabled="disabled" selected="selected">Select Level</option>
													<option value="regional">Regional</option>
													<option value="state">State</option>
													<option value="national">National</option>
												</select>
											</div>
										</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-grey" data-dismiss="modal">Close</button>
									<input type="submit" name="saveAward" data-action="addCourseMeta" value="Add" class="btn btn-blue" />
								</div>
								</form>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
</div>
<script type="text/javascript">
	var AccountData = {'uid': <?php print '\'' . $accountData->getUid() . '\'' ?>,'editable':<?php if($editable) { print 1; }else{print 0;}?>};
<?php if($editable) { ?>
	var awardLevels = ["regional","state","national"];
	var awardMeta = [
		<?php
			foreach($awardMeta as $meta)
			{
				$delimiter = ',';

				if($meta['uid'] == $awardMeta[count($awardMeta) - 1]['uid']) 
				{
					$delimiter = '';
				}
				
				print '"' . $meta['uid'] . '"' . $delimiter;
			}
		?>
	];
<?php } ?>
</script>