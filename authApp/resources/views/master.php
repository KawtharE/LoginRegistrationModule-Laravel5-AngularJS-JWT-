<!DOCTYPE html>
<html lang="en" ng-app="LogRegModule">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login-Registration Module</title>

    <!--CSS files-->
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900italic,900&subset=latin,greek,greek-ext,vietnamese,cyrillic-ext,latin-ext,cyrillic' rel='stylesheet' type='text/css'>
	<link href="FrontEndAngular/node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="FrontEndAngular/css/main.css">

	<!--JS files-->
	<script src="FrontEndAngular/node_modules/angular/angular.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="FrontEndAngular/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
	<script src="FrontEndAngular/node_modules/satellizer/dist/satellizer.js"></script>
	<script src="FrontEndAngular/node_modules/angular-ui-router/release/angular-ui-router.js"></script>

	<script src="FrontEndAngular/js/app.js"></script>
	<script src="FrontEndAngular/js/LoginController.js"></script>
	<script src="FrontEndAngular/js/RegistrationController.js"></script>
	<script src="FrontEndAngular/js/HomeController.js"></script>

</head>
<body>
<div class="container">
	<div class="row">
		<div class="col-xs-10 col-sm-8 col-md-8 col-lg-6 col-xs-offset-1 col-sm-offset-2 col-md-offset-2 col-lg-offset-3">
			<div class="panel panel-logreg">
				<ui-view></ui-view>
			</div>			
		</div>
	</div>
</div>
</body>
</html>