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
	<style type="text/css">
      body {
        background-color: #d3d4d6;
      }

      .form-signin {
        max-width: 300px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }

    </style>
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
		
		<div class="container">			
				<div class="form-signin">

<?php
require_once("libraries/OneFileLoginApplication.php");
// run the application
$application = new OneFileLoginApplication();
?>			
				</div>			
		</div>
	<script src="../js/bootstrap.min.js"></script>    
  </body>
</html>
