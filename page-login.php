<?php
$url = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$parts = parse_url($url);
parse_str($parts['query'], $query);

if (is_user_logged_in()) {
	if ($query['action'] === 'logout') {
		wp_logout();
	}

	wp_redirect(home_url());
	exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$creds = array(
		'user_login' => $_POST['log'],
		'user_password' => $_POST['pwd'],
		'remember' => false
	);

	$user = wp_signon($creds);

	if (is_wp_error($user)) {
		echo $user->get_error_message();
	} else {
		var_dump($user);
	}

	return;
}

?>

<?php get_header(); ?>
<?php include_once('includes/icons.php'); ?>
<?php include_once('includes/img-to-base64.php'); ?>

<style type="text/css">
html, body {
	background-image: url(<?php img_to_base64(__DIR__ . '/img/login_bg.png'); ?>);
  background-size: cover;
  background-repeat: no-repeat;
  height: 100%;
  font-family: 'Raleway', sans-serif;
}

.container {
  height: 100%;
  align-content: center;
}

.card {
  /*height: 370px;*/
  margin-top: auto;
  margin-bottom: auto;
  width: 400px;
  background-color: rgba(0,0,0,0.5) !important;
}

.card-header h3 {
  color: white;
  font-family: 'Open Sans', sans-serif;
  font-weight: 700;
  text-transform: uppercase;
}

.input-group-prepend span {
  background-color: #FFF;
  color: black;
  border: 0 !important;
  border-radius: 1.5rem;
}

input:focus {
  outline: 0 0 0 0  !important;
  box-shadow: 0 0 0 0 !important;
}

input.form-control {
  border: 0;
	border-radius: 1.5rem;
	padding-left: 0 !important;
}

.links {
  color: white;
}

.links a {
  margin-left: 4px;
} 
</style>

<div class="container">
	<div class="d-flex justify-content-center h-100">
		<div class="card">
			<div class="card-header">
				<h3>Sign In</h3>
				<div class="d-flex justify-content-end social_icon">
				</div>
			</div>
			<div class="card-body">
				<form action="" method="POST">
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text svg-icon icon-lg">
								<?php get_icon('user'); ?>
							</span>
						</div>
						<input type="text" class="form-control" placeholder="username" name="log">
					</div>
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text svg-icon icon-lg">
								<?php get_icon('key'); ?>
							</span>
						</div>
						<input type="password" class="form-control" placeholder="password" name="pwd">
					</div>
					<!--<div class="row align-items-center">
						<input type="checkbox">
            <label for="">Remember me</label>
					</div>-->
					<div class="form-group">
						<input type="submit" value="Login" class="btn base float-right mt-4">
					</div>
				</form>
			</div>
			<div class="card-footer">
				<div class="d-flex justify-content-center">
					<a class="text-light" href="#">Forgot your password?</a>
				</div>
			</div>
		</div>
	</div>
</div>