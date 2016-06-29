<?php //helper.php

define("MYSQLI_DUPLICATE_KEY", 1062);

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

?>