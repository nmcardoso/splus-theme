<?php

include_once(__DIR__ . '/includes/email-helper.php');

$errors = array();
$firstname = '';
$lastname = '';
$username = '';
$email = '';
$password = '';
$password2 = '';
$institution = '';
$position = '';
$register_success = false;
$is_email_verification = false;
$email_verification_success = false;
$is_user_authorization = false;
$user_authorization_success = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $firstname = $_POST['firstname'];
  $lastname = $_POST['lastname'];
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $password2 = $_POST['password2'];
  $institution = $_POST['institution'];
  $position = $_POST['position'];

  if (empty($firstname)) {
    $errors['firstname'] = 'Invalid first name';
  }

  if (!array_key_exists('firstname', $errors) && 
      strlen($firstname) > 128) {
    $errors['firstname'] = 'First name too long';
  }

  if (empty($lastname)) {
    $errors['lastname'] = 'Invalid last name';
  }
  
  if (!array_key_exists('lastname', $errors) && 
      strlen($lastname) > 128) {
    $errors['lastname'] = 'Last name too long';
  }

  if (!validate_username($username)) {
    $errors['username'] = 'Invalid username';
  }
  
  if (!array_key_exists('username', $errors) && 
      username_exists($username)) {
    $errors['username'] = 'Username already registered';
  }

  if ($password !== $password2) {
    $errors['password'] = 'Password doesn\'t match';
  }
  
  if (!array_key_exists('password', $errors) &&
      strlen($password) < 8) {
    $errors['password'] = 'Password lenght must be higher than 8';
  }
  
  if (!array_key_exists('password', $errors) &&
      strlen($password) > 32) {
    $errors['password'] = 'Password too long. Maximum size: 32';
  }

  if (!is_email($email)) {
    $errors['email'] = 'Invalid email address';
  }
  
  if (!array_key_exists('email', $errors) &&
      email_exists($email)) {
    $errors['email'] = 'Email already registered';
  }

  if (empty($institution)) {
    $errors['institution'] = 'Invalid institution';
  }

  if (empty($position)) {
    $errors['position'] = 'Invalid position';
  }

  if (count($errors) === 0) {
    $data = array(
      'user_pass' => $password,
      'user_login' => $username,
      'user_email' => $email,
      'first_name' => $firstname,
      'last_name' => $lastname,
      'show_admin_bar_front' => false,
      'role' => 'subscriber'
    );

    $user_id = wp_insert_user($data); // todo: verify if var is wp_error

    // Tokens
    $email_ver_token = md5(uniqid(microtime(), true));
    $auth_token = md5(uniqid(microtime(), true));

    update_user_meta($user_id, 'splus_institution', $institution);
    update_user_meta($user_id, 'splus_position', $position);
    update_user_meta($user_id, 'splus_email_verified', 'false');
    update_user_meta($user_id, 'splus_email_verification_token', $email_ver_token);
    update_user_meta($user_id, 'splus_user_authorized', 'false');
    update_user_meta($user_id, 'splus_user_authorization_token', $auth_token);

    $confirm_url = get_site_url() . '/register?user=' . $username . '&token=' . $email_ver_token;

    // Email
    $mail = array(
      'to' => $email,
      'subject' => 'SPLUS email confirmation',
      'html' => get_validate_email($email, $confirm_url)
    );

    $options = array(
      'headers' => array('Content-Type' => 'application/json; charset=utf-8'),
      'body' => json_encode($mail),
      'method' => 'POST',
      'data_format' => 'body'
    );

    $resp = wp_remote_post('https://splus-mailer.glitch.me/mail', $options);

    $body = json_decode(wp_remote_retrieve_body($resp), true);

    if (empty($body) || $body['success'] == false) {
      $error['register'] = 'Sorry. An error occurred during registration. Try again later.';
    } else {
      $register_success = true;
    }
  }
} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  $url = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
  $parts = parse_url($url);
  $query = array();
  if (isset($parts['query'])) {
    parse_str($parts['query'], $query);
  }

  if (count($query) == 2 && isset($query['user']) && isset($query['token'])) {
    $is_email_verification = true;

    $user = get_user_by('login', $query['user']);
    
    $db_token = get_user_meta($user->ID, 'splus_email_verification_token', true);

    if ($db_token === $query['token']) {
      // Email
      $firstname = get_user_meta($user->ID, 'first_name', 'Undefined', true);
      $lastname = get_user_meta($user->ID, 'last_name', 'Undefined', true);
      $name = $firstname . ' ' . $lastname;
      $email = $user->user_email;
      $institution = get_user_meta($user->ID, 'splus_institution', 'Undefined', true);
      $position = get_user_meta($user->ID, 'splus_position', 'Undefined', true);
      $auth_token = get_user_meta($user->ID, 'splus_user_authorization_token', true);
      $auth_url = get_site_url() . '/register?user=' . $user->user_login . '&auth_token=' . $auth_token;

      $mail = array(
        'to' => 'splus.team@yahoo.com',
        'subject' => 'SPLUS user authorization',
        'html' => get_auth_email($name, $email, $institution, $position, $auth_url)
      );

      $options = array(
        'headers' => array('Content-Type' => 'application/json; charset=utf-8'),
        'body' => json_encode($mail),
        'method' => 'POST',
        'data_format' => 'body'
      );

      $resp = wp_remote_post('https://splus-mailer.glitch.me/mail', $options);

      $body = json_decode(wp_remote_retrieve_body($resp), true);

      if (empty($body) || $body['success'] == false) {
        $error['verification'] = 'Sorry. An error occurred during email verification. Try again later.';
      } else {
        update_user_meta($user->ID, 'splus_email_verified', 'true');
        delete_user_meta($user->ID, 'splus_email_verification_token');
        $email_verification_success = true;
      }
    }
  } else if (count($query) == 2 && isset($query['user']) && isset($query['auth_token'])) {
    $is_user_authorization = true;

    $user = get_user_by('login', $query['user']);

    $db_token = get_user_meta($user->ID, 'splus_user_authorization_token', true);

    if ($db_token === $query['auth_token']) {
      // Email
      $email = $user->user_email;

      $mail = array(
        'to' => $email,
        'subject' => 'SPLUS Registration Authorized',
        'html' => get_authorized_email($email)
      );

      $options = array(
        'headers' => array('Content-Type' => 'application/json; charset=utf-8'),
        'body' => json_encode($mail),
        'method' => 'POST',
        'data_format' => 'body'
      );

      $resp = wp_remote_post('https://splus-mailer.glitch.me/mail', $options);

      $body = json_decode(wp_remote_retrieve_body($resp), true);

      if (empty($body) || $body['success'] == false) {
        $error['authorization'] = 'Sorry. An error occurred during user authorization. Try again later.';
      } else {
        update_user_meta($user->ID, 'splus_user_authorized', 'true');
        delete_user_meta($user->ID, 'splus_user_authorization_token');
        $user_authorization_success = true;
      }
    }
  }
}

function valid_class($k, $var) {
  if (array_key_exists($k, $var)) {
    echo 'is-invalid';
  } else {
    echo 'is-valid';
  }
}

?>

<?php get_header(); ?>

<style type="text/css">
  html {
    height: 100%;
  }

  body {
    height: 100%;
    background: rgb(161, 34, 195);
    background: linear-gradient(168deg, rgba(161, 34, 195, 1) 0%, rgba(253, 187, 45, 1) 100%);
    background-repeat: no-repeat;
    background-attachment: fixed;
    font-family: 'Open Sans', sans-serif;
  }

  .container {
    height: 100%;
    align-content: center;
  }

  .card {
    margin-top: auto;
    margin-bottom: auto;
    width: 550px;
    border: none;
    border-radius: .75rem;
    /* background-color: rgba(0, 0, 0, 0.5) !important; */
  }

  .card-header {
    background-color: #fff;
    border: none;
  }

  .card-header:first-child {
    border-radius: .75rem .75rem 0 0;
  }

  .card-header h3 {
    font-family: 'Open Sans', sans-serif;
    font-weight: 700;
  }

  label {
    font-size: .9rem;
    margin-bottom: .2rem;
  }

  .form-group {
    margin-bottom: .7rem;
  }

  .spinner {
    height: 60px;
    width: 60px;
    margin: auto;
    display: flex;
    position: absolute;
    -webkit-animation: rotation .6s infinite linear;
    -moz-animation: rotation .6s infinite linear;
    -o-animation: rotation .6s infinite linear;
    animation: rotation .6s infinite linear;
    border-left: 6px solid rgba(21, 135, 235, .15);
    border-right: 6px solid rgba(21, 135, 235, .15);
    border-bottom: 6px solid rgba(21, 135, 235, .15);
    border-top: 6px solid rgba(21, 135, 235, .8);
    border-radius: 100%;
  }

  @-webkit-keyframes rotation {
    from {
      -webkit-transform: rotate(0deg);
    }
    to {
      -webkit-transform: rotate(359deg);
    }
  }

  @-moz-keyframes rotation {
    from {
      -moz-transform: rotate(0deg);
    }
    to {
      -moz-transform: rotate(359deg);
    }
  }

  @-o-keyframes rotation {
    from {
      -o-transform: rotate(0deg);
    }
    to {
      -o-transform: rotate(359deg);
    }
  }

  @keyframes rotation {
    from {
      transform: rotate(0deg);
    }
    to {
      transform: rotate(359deg);
    }
  }

  #overlay {
    position: absolute;
    display: none;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0,0,0,0.25);
    z-index: 2;
    cursor: pointer;
    border-radius: .75rem;
  }
</style>

<?php if ($register_success): ?>

<div class="container">
  <div class="d-flex justify-content-center h-100">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
          <h3 class="pt-2">Confirm your email</h3>
          <a href="/"><img src="<?php bloginfo('template_url'); ?>/img/splus@2x.png" height="42px" alt="SPLUS"></a>
        </div>
      </div>
      <div class="card-body">
        <p>To complete your registration, please confirm your email address.</p>
        <p>A confirmation email has been sent to the registered email <b><?php echo $email; ?></b></p>
      </div>
    </div>
  </div>
</div>

<?php elseif ($is_email_verification): ?>

<div class="container">
  <div class="d-flex justify-content-center h-100">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
          <h3 class="pt-2">Email verification</h3>
          <a href="/"><img src="<?php bloginfo('template_url'); ?>/img/splus@2x.png" height="42px" alt="SPLUS"></a>
        </div>
      </div>
      <div class="card-body">
        <?php if ($email_verification_success): ?>
        <p>Your email address was <b>successfully verified</b>.</p>
        <p>Your registration has been submitted for <b>staff evaluation</b> and you will be able to login once your registration is approved.</p>
        <p>You will receive an email as soon as your registration is approved.</p>
        <?php else: ?>
        <p><b>Invalid</b> verification code: your email has not been verified.</p>
        <p>Contact the staff for more info.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<?php elseif ($is_user_authorization): ?>

<div class="container">
  <div class="d-flex justify-content-center h-100">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
          <h3 class="pt-2">User authorization</h3>
          <a href="/"><img src="<?php bloginfo('template_url'); ?>/img/splus@2x.png" height="42px" alt="SPLUS"></a>
        </div>
      </div>
      <div class="card-body">
        <?php if ($user_authorization_success): ?>
        <p>User registration <b>successfully</b> authorized.</p>
        <p>An email has been sent to the user.</p>
        <?php else: ?>
        <p><b>Invalid</b> verification code: user can't be authorized.</p>
        <p>Contact the staff for more info.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<?php else: ?>

<div class="container">
  <div class="d-flex justify-content-center h-100">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
          <h3 class="pt-2">REGISTER</h3>
          <a href="/"><img src="<?php bloginfo('template_url'); ?>/img/splus@2x.png" height="42px" alt="SPLUS"></a>
        </div>
      </div>
      <div class="card-body">
        <div id="overlay">
          <div class="w-100 d-flex justify-content-center align-items-center">
            <div class="spinner"></div>
          </div>
        </div>
        <?php if (count($errors) > 0): ?>
        <div class="alert alert-danger" role="alert">
          <ul class="mb-0 pb-0 pl-3" style="font-size: .9rem;">
            <?php foreach($errors as $e): ?>
            <li><?php echo $e; ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
        <?php endif; ?>
        <form method="POST" action="" id="register_form">
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="firstname">First Name</label>
              <input type="text" class="form-control" id="firstname" placeholder="First Name" name="firstname" value="<?php echo $firstname; ?>">
            </div>

            <div class="form-group col-md-6">
              <label for="lastname">Last Name</label>
              <input type="text" class="form-control" id="lastname" placeholder="Last Name" name="lastname" value="<?php echo $lastname; ?>">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="username">Username</label>
              <input type="text" class="form-control" id="username" placeholder="Username" name="username" value="<?php echo $username; ?>">
            </div>

            <div class="form-group col-md-6">
              <label for="email">Email</label>
              <input type="email" class="form-control" id="email" placeholder="Email" name="email" value="<?php echo $email; ?>">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="password">Password</label>
              <input type="password" class="form-control" id="password" placeholder="Password" name="password">
            </div>

            <div class="form-group col-md-6">
              <label for="password2">Confirm Password</label>
              <input type="password" class="form-control" id="password2" placeholder="Confirm Password" name="password2">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="institution">Institution</label>
              <input type="text" class="form-control" id="institution" placeholder="Institution" name="institution" value="<?php echo $institution; ?>">
            </div>

            <div class="form-group col-md-6">
              <label for="position">Position</label>
              <select name="position" id="position" class="form-control">
                <?php
                $options = array(
                  'undergraduated' => 'Undergraduated Student',
                  'graduated' => 'Graduated Student',
                  'professor' => 'Professor',
                  'postdoc' => 'Postdoc',
                  'other' => 'Other'
                );
                ?>
                <option value="" <?php echo empty($position) ? 'selected' : ''; ?>>Choose..</option>
                <?php foreach($options as $k => $v): ?>
                <option value="<?php echo $k; ?>" <?php echo $position == $k ? 'selected' : ''?>><?php echo $v; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <div class="form-group mt-3">
            <input type="submit" value="Register" class="btn btn-primary"> or <a href="/login">Login</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php endif; ?>

<?php get_footer(); ?>
