<!DOCTYPE html>
<html lang="en">
	<head>
    <meta charset="utf-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Le styles -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/bootstrap-responsive.min.css" rel="stylesheet">
	    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../img/apple-touch-icon-144x144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../img/apple-touch-icon-114x114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../img/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="../img/apple-touch-icon-72x72-precomposed.png">
                                   <link rel="shortcut icon" href="../img/favicon.ico">
	</head>
	<body>
	<div class="navbar navbar-inverse ">
      <div class="navbar-inner">
        <div class="container-fluid">
          <div class="brand" href="#">MonitrAll</div>
        </div>
      </div>
    </div>
		
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="span12">

<?php
require_once("libraries/OneFileLoginApplication.php");
// run the application
$application = new OneFileLoginApplication();
?>			
				</div>
			</div>
		</div>
	<script src="../js/bootstrap.min.js"></script>    
  </body>
</html>
