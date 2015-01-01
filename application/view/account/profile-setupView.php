<div class="bg-black">
	<div class="container">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<h1 class="txt-grey">Account Setup</h1>
				<p class="txt-white">Thanks for joining our Technology Student Association chapter. Through the profile you have just created, you will be able to show off your TSA achievements, projects, and activities on our site! But before you do, we need a couple pieces of information to complete your profile. Just follow the next couple of steps. It won't take too long.</p>
			</div>
		</div>
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="content">
				<form action="" method="post" data-form="addAccountMeta">
					<div class="tab-content">
						<!-- YEAR JOINED -->
						<div id="yearJoined" class="tab-pane fade active in">
							<h2>What year did you join TSA?</h2>
							<p>I joined Madison Southern's TSA chapter in
								<select name="yearJoined" class="form-control" style="width: auto !important; display:inline-block">
									<option disabled="disabled" selected="selected">Select a Year</option>
									<?php
										for($x = date("Y") - 20; $x <= date("Y"); $x++)
										{
											print '<option>' . $x . '</option>';
										}
									?>
								</select>
							</p>
							<a href="#bio" data-toggle="tab" class="btn btn-blue">Next</a>
						</div>

						<!-- BIO -->
						<div id="bio" class="tab-pane fade">
							<h2>Tell Us About Yourself</h2>
							<p>What are you doing, or plan on doing, in our chapter? Feel free to list off your goals, interests, etc. Keep in mind that this will be public.</p>
							<p><b>At least 15 words must be entered into this field.</b></p>

							<textarea name="bio" class="form-control" style="max-width: 600px; margin-bottom: 25px;"></textarea>

							<a href="#yearJoined" data-toggle="tab"class="btn btn-grey">Back</a>
							<a href="#portrait" data-toggle="tab" class="btn btn-blue">Next</a>
						</div>

						<!-- PORTRAIT -->
						<div id="portrait" class="tab-pane fade">
							<h2>Add a Profile Pic</h2>
							<p><b>This is completely optional</b>, but if you would like to put a face to your work so our viewers can recognize your projects and acheivements, feel free to upload a picture of yourself. Please read our
							<button type="button" class="btn btn-grey" data-toggle="collapse" data-target="#legal">Terms of Use and Disclaimer</button>before uploading a profile picture.</p>
							<p><b>This picture must be of yourself and no one else!</b></p>
							<div id="legal" class="collapse bg-white shadow content">
								<div class="alert alert-info">
									<b>Terms of Use</b>
									<p>By uploading a profile picture, you are agreeing to the following terms:</p>

									<ul>
										<li>This site [mshsprojects.net] has permission to publish/display your profile image on any pages (of this site) that are deemed fit by the development team.</li>
										<li>Your picture may be stored on our server and databases.</li>
										<li>The picture you upload <b>must only</b> show an appropriate profile of the user [you].</li>
										<li>Our website development team, TSA instructors, and Madison County School authorities have permission to remove your picture if it is deemed inappropriate. The following content is considered 'inappropriate':
											<ul>
												<li>Gang Signs</li>
												<li>References to illegal drugs, alcohal, or tobacco products</li>
												<li>Pornographic Images</li>
												<li>Images that degrade or slander a person, business, religion, or race</li>
												<li>Any other content that is interpreted as 'offensive' or 'inappropriate for its purpose' by our development team or TSA chapter instructors</li>
											</ul>
										</li>
										<li>Your profile picture will not be sold or distributed to other websites, businesses, people, or sources.</li>
										<li>You have the right to request for all of your uploaded pictures to be deleted/removed permanently from our servers.</li>
									</ul>
								</div>

								<div class="alert alert-warning">
									<b>Disclaimer</b>
									<p>This website is not directly related to or affiliated with the Madison County School system or any individual school within it.</p>
									<p>You may upload a profile picture <b>at your own risk</b>. This site, it's owners, the development team, and TSA organization are not responsible for stolen, hacked, or illegal distribution of your picture.</p>
								</div>
								<button type="button" class="btn btn-grey" data-toggle="collapse" data-target="#legal">Close</button>
							</div>
							<div id="image-cropper" data-role="imageCropperProccessingContainer">
								<div class="row text-center">
									<div class="col-md-6">
										<div class="prep-container" data-role="crop-original">
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

							<hr />

							<a href="#bio" data-toggle="tab" class="btn btn-grey">Back</a>
							<a href="#summary" data-toggle="tab" class="btn btn-blue">Next</a>
						</div>

						<!-- PORTRAIT -->
						<div id="summary" class="tab-pane fade">
							<h2>Summary</h2>
							<p>You're finished! Before you submit all of your information, please make sure it is correct. If you would like to make any changes, use the gray buttons below to navigate to each part of the account setup process.</p>
							<div class="content bg-white shadow profile">
								<div class="row">
									<div class="col-md-3">
										<img class="pr-img" src="<?php print DOMAIN_ROOT; ?>public/image/graphic/profile-placeholder.jpg" data-content="profile-picture" />
									</div>
									<div class="col-md-9">
										<h1 class="txt-orange"><?php print $_SESSION['name'] ?></h1>
										<p class="txt-black" data-content="bio">No Bio</p>
										
										<div class="row">
											<div class="col-md-12">
												<div class="pr-stats">
													<div class="top" style="color: #333 !important;">Joined In</div>
													<div class="bottom" data-content="yearJoined">XXXX</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-6">
									<p>Go to 
										<a href="#yearJoined" data-toggle="tab"class="btn btn-grey">Year Joined</a>
										<a href="#bio" data-toggle="tab"class="btn btn-grey">Biography</a>
										<a href="#portrait" data-toggle="tab"class="btn btn-grey">Profile Picture</a>
									</p>
								</div>
								<div class="col-md-6 text-right">
									<input type="submit" name="saveAccountMeta" class="btn btn-orange" value="Finish" />
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	var AccountData = {'uid': '<?php print $_SESSION['uid']; ?>'};
</script>;