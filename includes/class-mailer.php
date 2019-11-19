<?php
define('OPT_HOST', 'splus_smtp_host');
define('OPT_PORT', 'splus_smtp_port');
define('OPT_SECURE', 'splus_smtp_secure');
define('OPT_USERNAME', 'splus_smtp_username');
define('OPT_PASSWORD', 'splus_smtp_password');
define('OPT_DISPLAY_NAME', 'splus_smtp_display_name');

class Mailer {
  private $mailer;

  function __construct() {
    global $phpmailer;

    if (!is_object($phpmailer) || !is_a($phpmailer, 'PHPMailer')) {
      require_once ABSPATH . WPINC . '/class-phpmailer.php';
      require_once ABSPATH . WPINC . '/class-smtp.php';
      $phpmailer = new PHPMailer(true);
    }

    $this->mailer = $phpmailer;
    $this->configureMailer($this->mailer);
  }

  private function configureMailer($mailer){
    $mailer->isSMTP();
    $mailer->SMTPDebug = defined('WP_DEBUG') && WP_DEBUG ? 2 : 0;
    $mailer->Host = get_option(OPT_HOST, '');
    $mailer->Port = get_option(OPT_PORT, '');
    $mailer->SMTPSecure = get_option(OPT_SECURE, '');
    $mailer->SMTPAuth = true;
    $mailer->Username = get_option(OPT_USERNAME, '');
    $mailer->Password = get_option(OPT_PASSWORD, '');
    $mailer->From = get_option(OPT_USERNAME, '');
    $mailer->FromName = get_option(OPT_DISPLAY_NAME, '');
  }

  public function setSubject($subject) {
    $this->mailer->Subject = $subject;
  }

  public function addAddress($email, $name) {
    $this->mailer->addAddress($email, $name);
  }

  public function html($html) {
    $this->mailer->msgHTML($html);
  }

  public function text($txt) {
    $this->mail->AltBody = $txt;
  }

  public function send() {
    return $this->mailer->send();
  }

  public function getError() {
    return $this->mailer->ErrorInfo;
  }
}