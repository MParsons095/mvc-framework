<?php
	$required = array();
	$recommended = array();

	if(is_array($courseRequirements))
	{
		foreach($courseRequirements as $requirement)
		{
			if($requirement->getIsRequired() == 1)
			{
				$required[] = $requirement;
			}
			else
			{
				$recommended[] = $requirement;
			}
		}
	}
?>
<div class="bg-black">
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<h1 class="txt-grey"><?php print $course->getTitle(); ?></h1>
				<?php if($course->getCaption() != ''){ ?>
				<h2 class="txt-light-grey page-introduction">
                	<?php print $course->getCaption(); ?>
                </h2>
                <?php } ?>
			</div>
		</div>
	</div>
</div>
<div class="container">
	<div class="row content no-margin">
		<div class="content col-md-8 content bg-white shadow">
			<h2>Description</h2>

			<p><?php print $course->getDescription(); ?></p>

			<?php
				if(is_array($courseCurriculum))
				{
					print '<h2>Curriculum</h2><br />';
					$parentCurr = array();
					$childCurr = array();

					foreach($courseCurriculum as $item)
					{
						if(!$item->getChildOf())
						{
							$parentCurr[] = $item;
						}
						else
						{
							$childCurr[] = $item;
						}
					}

					foreach($parentCurr as $k => $p)
					{
						print '<h3>' . $p->getValue() . '</h3><ol>';
						
						$currList = array();
						foreach($childCurr as $i => $c)
						{
							if($c->getChildOf() == $p->getUid())
							{
								$currList[] = $c;
							}
						}

						if(count($currList) > 0)
						{
							foreach($currList as $b)
							{
								print '<li>' . $b->getValue() . '</li>';
							}
						}
						else
						{
							print '<li>Lesson Details Not Available';
						}

						print '</ol><br /><hr /><br />';
					}
				}
			?>
			<!--
			<h3>Lorem Ipsum Dolor</h3>
			<ol>
				<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
				<li>Nam pellentesque leo posuere fringilla rutrum.</li>
				<li>Mauris vel risus ac libero tincidunt elementum.</li>
			</ol>

			<h3>Lorem Ipsum Dolor</h3>
			<ol>
				<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
				<li>Nam pellentesque leo posuere fringilla rutrum.</li>
				<li>Mauris vel risus ac libero tincidunt elementum.</li>
			</ol>

			<h3>Lorem Ipsum Dolor</h3>
			<ol>
				<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
				<li>Nam pellentesque leo posuere fringilla rutrum.</li>
				<li>Mauris vel risus ac libero tincidunt elementum.</li>
			</ol>
			-->
		</div>
		<div class="content bg-white shadow col-md-3 col-md-offset-1">
		    <h3>Credits: <small class="txt-dark-grey font-body"><?php print $course->getCredit(); ?></small></h3>
		    <hr/>
		    <h3>Requirments</h3>
		    	<ul>
		    		<?php
			    		if(count($required) > 0)
			    		{
			    			foreach($required as $item)
			    			{
			    				print '<li>' . $item->getValue() . '</li>';
			    			}
			    		}
			    		else
			    		{
			    			print '<li>None</li>';
			    		}
		    		?>
		        </ul>
		    <hr/>
		    <h3>Recommendations</h3>
		    	<ul>
		        	<?php
			    		if(count($recommended) > 0)
			    		{
			    			foreach($recommended as $item)
			    			{
			    				print '<li>' . $item->getValue() . '</li>';
			    			}
			    		}
			    		else
			    		{
			    			print '<li>None</li>';
			    		}
		    		?>
		        </ul>
		</div>
	</div>
</div>