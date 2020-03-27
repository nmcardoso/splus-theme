<?php
$url = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$parts = parse_url($url);
$query = array();
if (isset($parts['query'])) {
	parse_str($parts['query'], $query);
}

$error = null;

if (is_user_logged_in()) {
	if (isset($query['action']) && $query['action'] === 'logout') {
		wp_logout();
	}

	wp_redirect(home_url());
	exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (!isset($_POST['_wpnonce']) || 
			!wp_verify_nonce($_POST['_wpnonce'], 'splus_user_login')) {
		$error = 'Failed security check. Try reload the page';
	} else {
		$creds = array(
			'user_login' => $_POST['log'],
			'user_password' => $_POST['pwd'],
			'remember' => false
		);
	
		$user = wp_signon($creds);
	
		if (is_wp_error($user)) {
			$error = $user->get_error_message();
		} else {
			wp_redirect(home_url());
			exit;
		}
	}
}

?>

<?php get_header(); ?>
<?php include_once('includes/icons.php'); ?>
<?php include_once('includes/img-to-base64.php'); ?>

<style type="text/css">
html, body {
	background-image: url(<?php bloginfo('template_url'); ?>/img/login_bg.png);
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
				<div class="d-flex justify-content-between align-items-center">
          <h3 class="pt-2">Sign In</h3>
          <a href="/"><img src="<?php bloginfo('template_url'); ?>/img/splus-cropped@2x.png" height="42px" alt="SPLUS"></a>
        </div>
			</div>
			<div class="card-body">
				<div class="alert alert-warning" style="font-size:.9rem;">
					[March/2020] Due to maintenance problems, all accounts were lost. A notification will be sent by email for all members when registration in opened again. Sorry for the inconvenience.
				</div>
				<?php if (!empty($error)): ?>
				<div class="alert alert-danger" style="font-size:.9rem;">
				<?php echo $error; ?>
				</div>
				<?php endif; ?>
				<form action="" method="POST">
					<?php wp_nonce_field('splus_user_login'); ?>
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
				<div class="d-flex justify-content-end">
					<a class="text-light" href="/register">Register</a>
				</div>
			</div>
		</div>
	</div>
</div>