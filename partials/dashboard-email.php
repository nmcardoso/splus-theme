<?php

define('OPT_HOST', 'splus_smtp_host');
define('OPT_PORT', 'splus_smtp_port');
define('OPT_SECURE', 'splus_smtp_secure');
define('OPT_USERNAME', 'splus_smtp_username');
define('OPT_PASSWORD', 'splus_smtp_password');
define('OPT_DISPLAY_NAME', 'splus_smtp_display_name');
define('OPT_EMAIL', 'splus_smtp_email');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  update_option(OPT_HOST, $_POST['host']);
  update_option(OPT_PORT, $_POST['port']);
  update_option(OPT_SECURE, $_POST['secure']);
  update_option(OPT_USERNAME, $_POST['username']);
  update_option(OPT_PASSWORD, $_POST['password']);
  update_option(OPT_DISPLAY_NAME, $_POST['display_name']);
  update_option(OPT_EMAIL, $_POST['email']);
}

$host = get_option(OPT_HOST, '');
$port = get_option(OPT_PORT, '');
$secure = get_option(OPT_SECURE, '');
$username = get_option(OPT_USERNAME, '');
$password = get_option(OPT_PASSWORD, '');
$display_name = get_option(OPT_DISPLAY_NAME, '');
$email = get_option(OPT_EMAIL, '');

?>

<h1>Email Settings</h1>

<p>Email credentials settings</p>

<form action="" method="POST">
  <h2>Send Settings</h2>
  <p>Configure the sender email settings</p>
  <p>This email is used to send confirmation email after registration, authorization email to staff and authorization notification to users</p>
  <p><b>IMPORTANT:</b> If this email is hosted by Google (Gmail or G-Suite), then you need to configure the account to <b>allow low security apps</b>, otherwise this site can't send email through the server</p>
  <table class="form-table">
    <tbody>
      <tr>
        <th><label for="_host">SMTP Host</label></th>
        <td>
          <input id="_host" type="text" name="host" class="regular-text" value="<?php echo $host; ?>">
        </td>
      </tr>

      <tr>
        <th><label for="_port">SMTP Port</label></th>
        <td>
          <input id="_port" name="port" class="regular-text" type="text" value="<?php echo $port; ?>">
        </td>
      </tr>

      <tr>
        <th><label for="_secure">SMTP Secure</label></th>
        <td>
          <select name="secure" id="_secure">
            <option value="tls" <?php if ($secure == 'tls') echo 'selected'; ?>>TLS</option>
            <option value="ssl" <?php if ($secure == 'ssl') echo 'selected'; ?>>SSL</option>
          </select>
        </td>
      </tr>

      <tr>
        <th><label for="_username">Username</label></th>
        <td>
          <input id="_username" name="username" type="text" class="regular-text" value="<?php echo $username; ?>">
        </td>
      </tr>

      <tr>
        <th><label for="_password">Password</label></th>
        <td>
          <input type="password" name="password" id="_password" class="regular-text" value="<?php echo $password; ?>">
        </td>
      </tr>

      <tr>
        <th><label for="_display_name">Display Name</label></th>
        <td>
          <input id="_display_name" name="display_name" type="text" class="regular-text" value="<?php echo $display_name; ?>">
          <p class="description">The name who recipients will see.</p>
        </td>
      </tr>
    </tbody>
  </table>

  <h2>Receive Settings</h2>
  <p>Configure the email who will receive messages.</p>
  <p>This email is used to receive user approval request after registration</p>
  <p>This email will just receive messages and can belong to any server</p>
  <table class="form-table">
    <tbody>
      <tr>
        <th><label for="_email">Email Address</label></th>
        <td>
          <input type="email" name="email" id="_email" class="regular-text" value="<?php echo $email; ?>">
        </td>
      </tr>
    </tbody>
  </table>

  <p class="submit">
    <input type="submit" name="submit" id="submit" value="Update Settings" class="button button-primary">
  </p>
</form>