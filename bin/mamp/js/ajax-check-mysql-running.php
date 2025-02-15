<?php

  $configuration = (array) array(
    'os' => (string) (mb_strtolower(substr(PHP_OS, 0, 3)) === 'win' ? 'win' : 'mac'),
    'app_name' => (string) (strpos(__FILE__, '/Library/') !== false) ? 'MAMP PRO' : 'MAMP',
  );

  // same in "index.php"
	$phpmyadmin_config_file_found = (bool) false;
	if ($configuration['os'] === 'win') {
		$path = (string) '../phpMyAdmin/config.inc.php';
		if (file_exists($path) === true) {
			include_once $path;
			$phpmyadmin_config_file_found = true;
		}
		unset($path);
	} else {
		if ($configuration['app_name'] === 'MAMP') {
			$path = (string) '/Applications/MAMP/bin/phpMyAdmin/config.inc.php';
			if (file_exists($path) === true) {
				include_once $path;
				$phpmyadmin_config_file_found = true;
			}
			unset($path);
		} else {
			$path = (string) '/Library/Application Support/appsolute/MAMP PRO/phpMyAdmin/config.inc.php';
			if (file_exists($path) === true) {
				include_once $path;
				$phpmyadmin_config_file_found = true;
			}
			unset($path);
		}
	}

  $return = (int) 0;

  if ($phpmyadmin_config_file_found === true) {
    $db_host = 'localhost';
    $db_user = $cfg['Servers'][1]['user'];
    $db_password = $cfg['Servers'][1]['password'];
    $db_db = 'information_schema';
    $db_port = $cfg['Servers'][1]['port'];
    $db_socket = '/Applications/MAMP/tmp/mysql/mysql.sock';
  
    $mysqli = @new mysqli(
      $db_host,
      $db_user,
      $db_password,
      $db_db,
      $db_port,
      $db_socket
    );
    
    $connect_error = $mysqli->connect_error;
  
    if (is_null($connect_error) === true) {
      $return = 1;
      $mysqli->close();
    }
  }

  echo $return;

?>