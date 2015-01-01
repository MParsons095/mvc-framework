	<div id="footer" class="navbar navbar-default no-border-radius">
		<div class="container">
			<div class="navbar-header">
				<a href="#" class="navbar-brand txt-orange"><div>Madison Southern</div><div>Engineering Dept.</div></a>
			</div>
		</div>
	</div>
</div> <!-- end wrapper -->
	<script type="text/javascript" src="<?php print DOMAIN_ROOT ?>public/javascript/jquery.js"></script>
	<!-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.1/jquery-ui.min.js"></script> -->
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
	<script type="text/javascript" src="<?php print DOMAIN_ROOT ?>public/javascript/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php print DOMAIN_ROOT ?>public/javascript/validate.js"></script>
	<script type="text/javascript" src="<?php print DOMAIN_ROOT ?>public/javascript/component.js"></script>

	<script type="text/javascript" src="<?php print DOMAIN_ROOT ?>public/javascript/plugin/imgareaselect.js"></script>
	<?php if(!$this->Session->get('id') || !$this->Session->get('lastActivity')) { ?>
		<?php
			$this->Session->end();
		?>
		<script type="text/javascript" src="<?php print DOMAIN_ROOT ?>public/javascript/account/login.js"></script>
	<?php } ?>
	


	<?php print $js; ?>
	<script type="text/javascript">
		$('[data-toggle="tooltip"]').tooltip();
	</script>
	</body>
</html>