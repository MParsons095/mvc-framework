<!DOCTYPE html>
<html>
	<head>
		<title><?php print (isset($this->View->title)) ?  $this->View->title : '' ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="<?php print DOMAIN_ROOT . 'public/stylesheet/index.css' ?>">
		<link rel="stylesheet" type="text/css" href="<?php print DOMAIN_ROOT . 'public/stylesheet/bootstrap.css' ?>">

		<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700|Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Rokkitt:400,700' rel='stylesheet' type='text/css'>

		<link rel="stylesheet" type="text/css" href="<?php print DOMAIN_ROOT . 'public/stylesheet/plugin/imgareaselect-default.css'; ?>" />

		<!-- BROWSER COMPATIBILITY HACKS -->
		<script type='text/javascript' src="//cdnjs.cloudflare.com/ajax/libs/modernizr/2.7.1/modernizr.min.js"></script>
		<script type="text/javascript" src="<?php print DOMAIN_ROOT . 'public/javascript/core' ?>/mediaQueries.js"></script>

		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->

		<!--[if lt IE 8]>
			<link href="<?php print DOMAIN_ROOT . 'public/stylesheet' ?>/bootstrap-ie-7.css" rel="stylesheet">
		<![endif]-->


	</head>

	<body style="zoom: 1;" class="">
	<div class="navbar navbar-default no-border-radius">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				</button>

				<a href="#" class="navbar-brand txt-orange"><div>Madison Southern</div><div>Engineering Dept.</div></a>
			</div>

			<?php include SERVER_ROOT . 'application/view/component/navigation/default-navView.php'; ?>
		</div>
	</div>