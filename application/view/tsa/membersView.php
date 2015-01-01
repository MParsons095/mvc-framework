<div class="bg-black">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h1 class="txt-grey">Members</h1>
            </div>
        </div>
    </div>
</div>
<div class="container">
	<div class="content">
		<?php
			$officerList = array();

			foreach($officers as $officer)
			{
				$officerList[] = $officer['account_uid'];
			}

			if(is_array($accountListing))
			{
				$offset = null;

				$counter = 0;

				for($x = 0; $x < count($accountListing); $x++)
				{
					if($counter == 0)
					{
						print '<div class="row content">';
					}
					elseif($counter == 3)
					{
						$counter = 0;

						print '</div>';	

						if($x < count($accountListing) - 1)
						{
							print '<div class="row content">';
						}
					}

					$officerLink = '';
					if(in_array($accountListing[$x]['uid'],$officerList))
					{
						$officerLink = '<a href="#" data-toggle="modal" data-target="#' . $accountListing[$x]['uid'] . '">Officer Role</a>';
					}

					print '
					<div class="col-md-3 col-md-offset-1 content-panel">
							<div class="inner-panel">
								<img src="' . DOMAIN_ROOT . 'public/system/image/' . $accountListing[$x]['picture'] . '.jpg" />
								<h3>' . $accountListing[$x]['firstName'] . ' ' . $accountListing[$x]['lastName'] . '</h3>
								<div class="text-center">
									<a href="' . DOMAIN_ROOT . 'tsa/members/view/' . $accountListing[$x]['slug'] . '">Profile</a>
									' . $officerLink . '
								</div>
							</div>
						</div>
					';

					$counter++;
				}
			}
		?>
	</div>
</div>
</div>

<?php
	foreach($officers as $officer)
	{
		if($officer['account_uid'] != null)
		{
			print '
				<div class="modal fade" id="' . $officer['account_uid'] . '" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header">
								<h3>' . ucwords($officer['position']) . '</h3>
							</div>
							<div class="modal-body">
								' . $officer['role'] . '
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-grey" data-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
				</div>
			';
		}
	}
?>

<?php print '<script type="text/javascript">var officers = ' . json_encode($officers) . '</script>';