			<div class="navbar-collapse collapse navbar-right">
				<ul class="nav navbar-nav">
					<li><a href="<?php print DOMAIN_ROOT; ?>">Home</a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Department</a>
						<ul class="dropdown-menu">
							<li><a href="<?php print DOMAIN_ROOT; ?>department/instructor">Instructor</a></li>
							<li><a href="<?php print DOMAIN_ROOT; ?>public/document/brochure.pdf" target="_blank">Brochure (Download)</a></li>
							<!-- <li><a href="<?php print DOMAIN_ROOT; ?>department/events">Events</a></li> -->
							<li><a href="<?php print DOMAIN_ROOT; ?>public/document/career-pathway.pdf" target="_blank">Career Pathway (Download)</a></li>
							<li><a href="<?php print DOMAIN_ROOT; ?>department/higher-education">Higher Education</a></li>
							<li><a href="<?php print DOMAIN_ROOT; ?>department/contact">Contact</a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Courses</a>
						<ul class="dropdown-menu">
							<li><a href="<?php print DOMAIN_ROOT; ?>course/view/gateway-to-technology">Gateway to Technology</a></li>
							<li><a href="<?php print DOMAIN_ROOT; ?>course/view/introduction-to-engineering-design">Introduction to Engineering Design</a></li>
							<li><a href="<?php print DOMAIN_ROOT; ?>course/view/computer-integrated-manufacturing">Computer Integrated Manufacturing</a></li>
							<li><a href="<?php print DOMAIN_ROOT; ?>course/view/principles-of-engineering">Principles of Engineering</a></li>
							<li><a href="<?php print DOMAIN_ROOT; ?>course/view/digital-electronics">Digital Electronics</a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">TSA</a>
						<ul class="dropdown-menu">
							<li><a href="<?php print DOMAIN_ROOT; ?>tsa/">Our Chapter</a></li>
							<li><a href="<?php print DOMAIN_ROOT; ?>tsa/members">Members</a></li>
							<li><a href="<?php print DOMAIN_ROOT; ?>tsa/awards">Awards</a></li>
							<li><a href="<?php print DOMAIN_ROOT; ?>tsa/projects">Projects</a></li>
							<!-- <li><a href="<?php print DOMAIN_ROOT; ?>tsa/membership-application">Membership Application</a></li>
							<li><a href="<?php print DOMAIN_ROOT; ?>tsa/officer-application">Officer Application</a></li> -->
							<li><a href="http://mshsprojects.net/learn-to-code">2014 Design Brief</a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">About</a>
						<ul class="dropdown-menu">
							<li><a href="<?php print DOMAIN_ROOT; ?>about/meet-the-development-team">Meet the Development Team</a></li>
							<li><a href="<?php print DOMAIN_ROOT; ?>about/building-this-website">Building this Website</a></li>
						</ul>
					</li>
					<?php if(!$this->Session->get('id')) { ?>
						<li><a href="#" data-toggle="modal" data-target="#loginModal">Login</a></li>
						<li><a href="<?php print DOMAIN_ROOT; ?>account/register">Register</a></li>
					<?php } else { ?>
						<li>
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php print $this->Session->get('name'); ?><b class="caret"></b></a>
							<ul class="dropdown-menu">
					            <li><a href="<?php print DOMAIN_ROOT . 'account/profile'; ?>">Profile</a></li>
					            <?php if($_SESSION['accountType'] == 'admin') { ?>
					            <li><a href="<?php print DOMAIN_ROOT . 'admin'; ?>">Admin Panel</a></li>
					            <?php } ?>
					        	<li><a href="<?php print DOMAIN_ROOT . 'account/logout' ?>">Logout</a></li>
					        </ul>
						</li>
					<?php } ?>
				</ul>
			</div>

			<!-- Login Modal -->
			<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
			  <div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-header">
			      	<div class="banner-image">
			        	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			        	<h4 class="modal-title" id="myModalLabel">Login</h4>
			        </div>
			      </div>
			      <div class="modal-body">
			        <form action="" method="post">
			        	<label for="loginEmail">Email</label>
			        	<input type="text" name="loginEmail" placeholder="john.doe@website.com" class="form-control" />
			        	
			        	<label for="loginPassword">Password</label>
			        	<input type="password" name="loginPassword" placeholder="password" class="form-control" />
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-grey" data-dismiss="modal">Close</button>
			        <input type="submit" name="loginSubmit" value="Login" class="btn btn-blue" />
			        </form>
			      </div>
			    </div>
			  </div>
			</div>