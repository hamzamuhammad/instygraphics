<?php //helper.php

ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
//mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
define("MYSQLI_DUPLICATE_KEY", 1062);

require("/var/www/instygraphics.com/public_html/PHPMailer-master/PHPMailerAutoload.php");

function sanitizeString($var) {
  $var = stripslashes($var);
  $var = htmlentities($var);
  $var = strip_tags($var);
  return $var;
}

function sanitizeMySQL($connection, $var) {
  $var = $connection->real_escape_string($var);
  $var = sanitizeString($var);
  return $var;
}

function mysql_entities_fix_string($connection, $string) {
 return htmlentities(mysql_fix_string($connection, $string));
}

function mysql_fix_string($connection, $string) {
 if (get_magic_quotes_gpc()) $string = stripslashes($string);
 return $connection->real_escape_string($string);
}

function lock_table($connection) {
  $query = "LOCK TABLES users WRITE";
  $result = $connection->query($query);
  if (!$result)
    die($connection->error);
}

function unlock_table($connection) {
  $query = "UNLOCK TABLES";
  $result = $connection->query($query);
  if (!$result)
    die($connection->error);
}

/**
 * Generate a random string, using a cryptographically secure 
 * pseudorandom number generator (random_int)
 * 
 * For PHP 7, random_int is a PHP core function
 * For PHP 5.x, depends on https://github.com/paragonie/random_compat
 * 
 * @param int $length      How many characters do we want?
 * @param string $keyspace A string of all possible characters
 *                         to select from
 * @return string
 */
function random_str($length)
{
    $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $str = '';
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
        $str .= $keyspace[random_int(0, $max)];
    }
    return $str;
}

function send_email($email_address, $message) { 
  date_default_timezone_set('Etc/UTC');
  $mail = new PHPMailer;
  $mail->isSMTP();
  $mail->SMTPDebug = 0;
  $mail->Debugoutput = 'html';
  $mail->Host = 'smtp.gmail.com';
  $mail->Port = 587;
  $mail->SMTPSecure = 'tls';
  $mail->SMTPAuth = true;
  $mail->Username = "instygraphics@gmail.com";
  $mail->Password = "dassak123";
  $mail->setFrom('admin@instygraphics.com', 'instygraphics');
  $mail->addReplyTo('noreply@instygraphics.com', 'Admin');
  $mail->addAddress($email_address, 'John Doe');
  $mail->Subject = 'Account Validation';
  $mail->Body = 'Go to www.instygraphics.com/validate.php and enter in '
      . $verify_string . ' to verify your email address.';
  $mail->AltBody = 'Go to www.instygraphics.com/validate.php and enter in '
      . $verify_string . ' to verify your email address.';
  $mail->addAttachment('logo.png');
  if (!$mail->send()) {
      echo "Mailer Error: " . $mail->ErrorInfo;
  }
} 
?>