<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
	<title>CUSTOMER LOGIN</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.css');?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/main.css');?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/form.css');?>">
	<script src="<?php echo base_url('assets/js/jquery-3.5.1.js');?>"></script>
	<script src="<?php echo base_url('assets/js/bootstrap.js');?>"></script>
	<script src="<?php echo base_url('assets/js/main.js');?>"></script>
</head>
<body>
	<nav class="navbar navbar-expand-md">
		<a class="navbar-brand" href="#">Logo</a>
		<button class="navbar-toggler navbar-dark" type="button" data-toggle="collapse" data-target="#main-navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="main-navigation">
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" href="home">Home</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">Login</a>
				</li>
				
			</ul>
		</div>
	</nav>

	<div class="header">
		<div class="overlay">
			<div class="form_reg clearfix">
			<div class="form-style-3 clearfix">
			<form method="post">
			<fieldset><legend>LOGIN</legend>
				<label for="field1"><span>Name <span class="required">*</span></span><input type="text" class="input-field" name="name" value="" /></label>
				
				<label for="field2"><span>Password <span class="required">*</span></span><input type="password" class="input-field" name="password" value="" /></label>
				
			</fieldset>

			<label><span> </span><input type="submit" name="signin" value="Sign In" /></label>

			</form>
			</div>
			</div>
		</div>
	</div>

</body>
</html>
