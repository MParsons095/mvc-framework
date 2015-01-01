<div class="bg-black">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h1 class="txt-grey">About TSA and Our Chapter</h1>
                <h2 class="txt-light-grey page-introduction"><i>"Learning to Live in a Technical World"</i> - TSA Motto</h2>
            </div>
        </div>
    </div>
</div>
<div class="container">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#Chapter" data-toggle="tab">Our Chapter</a><li>
		<li><a href="#TSA" data-toggle="tab">About TSA</a></li>
	</ul>
		<div class="content bg-white shadow">
			<div class="tab-content">
				<!-- Creed -->
				<div id="TSA" class="tab-pane fade">
					<h2>Overview of TSA</h2>
					<p class="text-center">TSA (Technology Student Association) is one of the eight Career and Technical Student Organizations recognized by the federal government. This organization provides middle and high school students opportunities for leadership opportunities, teamwork, community service, personal growth, and recognition for achievements. The goal of the TSA organization is to educate students in technology and prepare them for careers primarily related to engineering, computer science, design, and innovation.</p>

					<h3>Creed</h3>
					<div class="row">
						<div class="col-md-8 col-md-offset-2">
							<i>
								"I believe that Technology Education holds an important place in my life in the technical world. I believe there is a need for the development of good attitudes concerning work, tools, materials, experimentation, and processes of industry.
							<br />
							<br />
								Guided by my teachers, artisans from industry, and my own initiative, I will strive to do my best in making my school, community, state, 	and nation better places in which to live.
							<br />
							<br />
								I will strive to develop a cooperative attitude and will exercise tact and respect for other individuals.
							<br />
							<br />
								Through the work of my hands and mind, I will express my ideas to the best of my ability.
							<br />
							<br />
								I will make it my goal to do better each day the task before me, and to be steadfast in my belief in my God, and my fellow Americans."
							</i>
							<br />
						</div>
					</div>
					<hr />
					<h2>Competitive Events</h2>
					<p>TSA hosts regional, state, and national competitions every year. These competitions give members the opportunity to compete in dozens of events. Each event requires knowledge in engineering, design, CAD, computer science, or research skills. We have provided a list of the high school competitive events below. If you would like more detailed information on a given event, visit the official TSA <a href="http://www.tsaweb.org/High-School-Competitions" target="_blank">high school competitions</a> page.</p>
					<ul>
					<?php
						if(is_array($competitions))
						{
							foreach($competitions as $event)
							{
								print '<li>' . $event['competition'] . '</li>';
							}
						}
					?>
					</ul>
				</div>
				<!-- Officers -->
				<div id="Chapter" class="tab-pane active fade in">
					<div class="row">
						<div class="col-md-4">
							<div class="pr-stats">
								<div class="top"><?php print $statistics['members'] ?></div>
								<div class="bottom">Active Members</div>
								<br />
								<a href="<?php print DOMAIN_ROOT ?>tsa/members" class="btn btn-grey">View All Members</a>
							</div>
						</div>
						<div class="col-md-4">
							<div class="pr-stats">
								<div class="top"><?php print $statistics['awards'] ?></div>
								<div class="bottom">Awards Won</div>
								<br />
								<a href="<?php print DOMAIN_ROOT ?>tsa/awards" class="btn btn-grey">View All Awards</a>
							</div>
						</div>
						<div class="col-md-4">
							<div class="pr-stats">
								<div class="top"><?php print $statistics['projects'] ?></div>
								<div class="bottom">Ongoing Projects</div>
								<br />
								<a href="<?php print DOMAIN_ROOT ?>tsa/projects" class="btn btn-grey">View All Projects</a>
							</div>
						</div>
					</div>

					<hr />

					<h2>Officers</h2>
						<h3 class="text-center">Our officer list has not been released yet.</h3>
					<h2>Projects</h2>

					<?php
						if(is_array($projectsList) && count($projectsList) > 0)
						{
							$counter = 0;
							$offset = null;

							for($i = 0; $i < count($projectsList); $i++)
							{
								if($i == 4)
								{
									break;
								}

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
			</div>
		</div>
</div>