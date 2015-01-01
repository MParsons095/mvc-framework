<div class="container">
	<h1>Administration Panel</h1>
	<div class="row">
		<?php include $adminNav; ?>
		<div class="col-md-10 content">
			<ul class="nav nav-tabs">
					<li class="active"><a href="#courseDetails" data-toggle="tab">Details</a></li>
					<?php if($uid != null) { ?>
					<li><a href="#courseCurriculum" data-toggle="tab">Curriculum</a></li>
					<li><a href="#courseRequirements" data-toggle="tab">Course Requirements</a></li>
					<?php } ?>
				</ul>
			<div class="bg-white content shadow">
				<h2><b>Course:</b> <?php if(isset($course)) print $course->getTitle(); ?></h2>
				<div data-role="courseContainer">

				</div>
				<!-- TAB CONTENT -->
				<div class="tab-content">
					<!-- COURSE DETAILS -->
					<div id="courseDetails" class="tab-pane active fade in">
						<form data-form="saveCourse" action="" method="post" name="courseDetails">
							<div class="row">
								<div class="col-md-5">
									<label>Title</label>
									<input type="text" name="courseTitle" class="form-control" value="<?php if(isset($course)) print $course->getTitle(); ?>" />
								</div>
								<div class="col-md-4 col-md-offset-3">
									<label>Credit</label>
									<input type="text" name="courseCredit" class="form-control" value="<?php if(isset($course)) print $course->getCredit(); ?>" />
								</div>
							</div>

							<br />

							<label>Caption:</label>
							<textarea name="courseCaption" class="form-control" placeholder="Insert Caption Here"><?php if(isset($course)) print $course->getCaption(); ?></textarea>

							<br />

							<label>Description</label>
							<textarea name="courseDescription" class="form-control"><?php if(isset($course)) print $course->getDescription(); ?></textarea>

							<br />

							<input type="submit" name="saveCourse" class="btn btn-blue" value="Save Course">
						</form>
					</div>
					<?php if($uid != null) { ?>
					<!-- COURSE CURRICULUM -->
					<div id="courseCurriculum" class="tab-pane fade">
						<div id="curriculumGroup">
					<?php
						$parentCurriculum = array();
						$childCurriculum = array();
						if(is_array($courseCurriculum))
						{
							foreach($courseCurriculum as $c)
							{
								if(!$c->getChildOf())
								{
									$parentCurriculum[] = $c;
								}
								else
								{
									$childCurriculum[] = $c;
								}
							}
							

							foreach($parentCurriculum as $parent)
							{
								print '
									<div class="row">
										<div class="col-md-12">
											<h2>' . $parent->getValue() . '</h2>
											<ul data-id="' . $parent->getUid() . '">
								';

								$children = array();
								foreach($childCurriculum as $child)
								{
									if($child->getChildOf() == $parent->getUid())
									{
										$children[] = '<li>' . $child->getValue() . '</li>';
									}
								}

								if(count($children) == 0)
									{
										print '<li>Lesson Details Not Available</li>';
									}
									else
									{
										print implode('',$children);
									}

								print '
									</ul>
									</div>
									<hr />
								</div>
								';
							}
						}
					?>
						</div>
						<a href="#addCourseCurriculumModal" data-toggle="modal" class="btn btn-blue">Add Curriculum</a>
					</div>

					<!-- COURSE REQUIREMENTS -->
					<div id="courseRequirements" class="tab-pane fade table-responsive">
						<?php if(is_array($courseRequirements)) { ?>
						<table id="courseRequirementsContent" class="table table-hover">
							<thead>
								<tr>
									<th>Value</th>
									<th>Required</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody data-action="loadCourseRequirements">
								<?php 
									if(is_array($courseRequirements)) {
									foreach($courseRequirements AS $req) {
								?>
									<tr>
										<td data-value="value"><?php print $req->getValue(); ?></td>
										<td data-value="isRequired"><input type="checkbox" data-id="<?php print $req->getUid(); ?>" name="courseMetaIsRequired" <?php if($req->getIsRequired() == 1) { print 'checked = "checked"'; } else { print ''; } ?>></td>
										<td><button data-action="deleteCourseMeta" class="btn btn-grey" data-id="<?php print $req->getUid(); ?>">Delete</button>
											<input type="hidden" name="courseMetaId" value="<?php print $req->getUid(); ?>" />
											<input type="hidden" name="courseMetaValue" value="<?php print $req->getValue(); ?>" data-id="<?php print $req->getUid(); ?>" />
											<input type="hidden" name="courseMetaIsRequired" value="<?php print $req->getIsRequired(); ?>" data-id="<?php print $req->getUid(); ?>" />
											<input type="hidden" name="courseMetaChildOf" value="<?php print $req->getChildOf(); ?>" data-id="<?php print $req->getUid(); ?>" />
											<input type="hidden" name="courseMetaType" value="<?php print $req->getType(); ?>" data-id="<?php print $req->getUid(); ?>" />
										</td>
									</tr>
								<?php }} ?>
							</tbody>
						</table>
						<?php } ?>
						<a href="#addCourseRequirementModal" data-toggle="modal" class="btn btn-blue">Add Requirement</a>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>


<!-- Add Course Meta Modal -->
<div class="modal fade" id="addCourseRequirementModal" tabindex="-1" role="dialog" aria-labelledby="addCourseRequirementModal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h3>Add Course Information</h3>
			</div>
			<div class="modal-body">
				<form action="" method="post">
					<label for="addCourseMetaValue">Value</label>
					<textarea name="addCourseMetaValue" class="form-control"></textarea>

					<label for="addCourseMetaIsRequired">required</label>
					<input type="checkbox" name="addCourseMetaRequired"/>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<input type="submit" name="addCourseMetaSubmit" data-action="addCourseMeta" value="Add" class="btn btn-blue" />
				</form>
			</div>
		</div>
	</div>
</div>


<!-- Add Course Meta Modal -->
<div class="modal fade" id="addCourseCurriculumModal" tabindex="-1" role="dialog" aria-labelledby="addCourseMetaCurriculumModal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h3>Add Course Curriculum</h3>
			</div>
			<div class="modal-body">
				<form action="" method="post">
					<label>This Curriculum is a</label>
					<select name="courseCurriculumChildOf" class="form-control">
						<option value="0">New Lesson</option>
						<?php
							if(isset($courseCurriculum) && is_array($courseCurriculum))
							{
								foreach($courseCurriculum as $item)
								{
									if(!$item->getChildOf())
									{
										print '<option value="' . $item->getUid()  . '">Child of ' . $item->getValue() . '</option>';
									}
								}
							}
						?>
					</select>

					<label for="addCourseCurriculumValue">Value</label>
					<textarea name="addCourseCurriculumValue" class="form-control"></textarea>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<input type="submit" name="addCourseCurriculumSubmit" data-action="saveCourseCurriculum" value="Add" class="btn btn-blue" />
				</form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var courseData = {'uid': <?php if($uid != null && $uid != 'null') { print "'" . $uid . "'"; } else { print 'null'; } ?>};
	var courseCurriculum = 
		<?php
			$jsonCurriculum = array();
			
			if(isset($courseCurriculum) && is_array($courseCurriculum))
			{
				foreach($courseCurriculum as $item)
				{
					if(!$item->getChildOf())
					{
						$jsonCurriculum[] = array('uid' => $item->getUid(), 'value' => $item->getValue());
					}
				}

				print json_encode(json_encode($jsonCurriculum));
			}
			else
			{
				print '[{}]'; 
			}
		?>;
</script>