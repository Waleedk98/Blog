<?php
	include_once 'php/configuration.php';
	include_once 'php/functions.php';
	include_once 'php/strings/'.$configuration['language'].'.php';

	// same in "js/ajax-check-mysql-running.php"
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

	$mysql_running = (bool) false;
	if ($phpmyadmin_config_file_found === true) {
		$mysql_running = check_mysql_running();
	}
	
	download_latest_version_info();
	$latest_version_info = (string) get_latest_version_info();

	if (@fsockopen('www.mamp.info', 80, $errno, $errstr, 10) === false) {
		$online = (bool) false;
	} else {
		$online = (bool) true;
	}
?>
<!doctype html>
<html lang="<?php echo $configuration['language']; ?>">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="css/bootstrap.min.css?t=<?php echo mt_rand(); ?>">
		<link rel="stylesheet" href="css/fonts.css?t=<?php echo mt_rand(); ?>">
		<link rel="stylesheet" href="css/prism.css?t=<?php echo mt_rand(); ?>">
		<link rel="stylesheet" href="css/custom.css?t=<?php echo mt_rand(); ?>">
		<link rel="icon" type="img/ico" href="images/favicon-<?php echo mb_strtolower(str_replace(' ', '-', $configuration['app_name'])); ?>.ico?t=<?php echo mt_rand(); ?>">
		<link rel="shortcut icon" href="images/favicon-<?php echo mb_strtolower(str_replace(' ', '-', $configuration['app_name'])); ?>.ico?t=<?php echo mt_rand(); ?>">
		<title><?php echo $configuration['app_name']; ?></title>
	</head>
	<body>
		<div class="container-fluid bg-light pt-2 pb-2">
			<div class="container ps-0">
				<nav class="navbar navbar-expand-lg navbar-light bg-light">
  				<div class="container-fluid ps-0 pe-0">
						<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="<?php echo $GLOBALS['strings']['_s57_']; ?>">
							<span class="navbar-toggler-icon"></span>
						</button>
						<div class="collapse navbar-collapse" id="navbarMain">
							<ul class="navbar-nav me-auto mb-2 mb-lg-0">
								<li class="nav-item dropdown">
									<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownTools" role="button" data-bs-toggle="dropdown" aria-expanded="false">
										<?php echo $GLOBALS['strings']['_s27_']; ?>
									</a>
									<ul class="dropdown-menu mt-lg-3" aria-labelledby="navbarDropdownTools">
										<li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modal-phpinfo">phpInfo</a></li>

										<li><a class="dropdown-item phpmyadmin-link" href="/phpMyAdmin/?lang=<?php echo $configuration['language']; ?>" target="_blank"<?php echo($mysql_running === false ? ' class="disabled"' : ''); ?>>phpMyAdmin<?php echo($mysql_running === false ? ' ('.$GLOBALS['strings']['_s53_'].')' : ''); ?></a></li>

										<li><a class="dropdown-item" href="/adminer" target="_blank">Adminer</a></li>

										<li><a class="dropdown-item" href="/phpLiteAdmin/" target="_blank">phpLiteAdmin</a></li>

										<li><hr class="dropdown-divider"></li>

										<?php
											if (extension_loaded('apc') === true) {
												echo '<li>';
												echo '<a class="dropdown-item" href="apc.php" target="_blank">APC</a>';
												echo '</li>';
											} else if (extension_loaded('apcu') === true) {
												echo '<li><a class="dropdown-item" href="apc-8.php" target="_blank">APC</a></li>';
											} else {
												echo '<li><a class="dropdown-item disabled" href="#">APC (' . $GLOBALS['strings']['_s31_'] . ')</a></li>';
											}
										?>
										<?php if (extension_loaded('Zend OPcache') === true): ?>
											<li><a class="dropdown-item" href="opcache.php" target="_blank">OPcache</a></li>
										<?php else: ?>
											<li><a class="dropdown-item disabled" href="#">OPcache (<?php echo $GLOBALS['strings']['_s31_']; ?>)</a></li>
										<?php endif; ?>

									</ul>
								</li>
								<li class="nav-item dropdown">
									<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownHelp" role="button" data-bs-toggle="dropdown" aria-expanded="false">
										<?php echo $GLOBALS['strings']['_s32_']; ?>
									</a>
									<ul class="dropdown-menu mt-lg-3" aria-labelledby="navbarDropdownHelp">
										<li><a class="dropdown-item" href="https://apps.mamp.info/remote-help/?ref=<?php echo $configuration['remote_help_entry_point']; ?>&amp;language=<?php echo $configuration['language']; ?>" target="_blank"><?php echo $GLOBALS['strings']['_s33_']; ?></a></li>
										<li><a class="dropdown-item" href="http://www.mamp.tv" target="_blank"><?php echo $GLOBALS['strings']['_s34_']; ?></a></li>
										<li><a class="dropdown-item" href="https://bugs.mamp.info" target="_blank"><?php echo $GLOBALS['strings']['_s35_']; ?></a></li>
									</ul>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="<?php echo $configuration['app_website']; ?>" target="_blank"><?php echo $configuration['app_name'], ' ', $GLOBALS['strings']['_s36_']; ?></a>
								</li>
								<?php
									if ($configuration['app_name'] === 'MAMP') {
										echo '<li class="nav-item">';
										echo '<a class="nav-link" href="'.get_http().'://'.$_SERVER['HTTP_HOST'].'" target="_blank">'.$GLOBALS['strings']['_s51_'].'</a>';
										echo '</li>';
									}
								?>
								<?php $myFavLink=''; ?>
								<?php echo ($myFavLink !== '' ? '<li class="nav-item"><a class="nav-link" href="'.$myFavLink.'" target="_blank">'.$GLOBALS['strings']['_s37_'].'</a></li>' : ''); ?>
							</ul>
							<div class="d-flex">
								<?php
									if (is_bought() === false) {
										echo '<a href="https://www.mamp.info/'.$configuration['os'].'store" target="_blank" class="btn btn-success btn-sm" role="button">'.$GLOBALS['strings']['_s6_'].'</a>';
									}
								?>
							</div>
						</div>
					</div>
				</nav>
			</div>
		</div>
		<div class="container-fluid text-center text-white bg-<?php echo ($configuration['app_name'] === 'MAMP PRO' ? 'mamppro' : 'mamp'); ?> pt-5 pb-4">
			<h1 class="display-4"><?php echo $GLOBALS['strings']['_s1_'], ' ', $configuration['app_name']; ?></h1>
			<p class="lead">
				<?php
					echo $GLOBALS['strings']['_s2_'], ' ', $configuration['version'];
					if ($latest_version_info !== '' && version_compare(prepare_version_string($latest_version_info), prepare_version_string($configuration['version']), '>') === true) {
						echo '&nbsp;&rarr;&nbsp;<a href="'.$GLOBALS['strings']['_s5_'].'" class="text-white">'.$GLOBALS['strings']['_s4_'].' '.$latest_version_info.'</a>';
					} else {
						echo ' ', $GLOBALS['strings']['_s3_'];
					}
				?>				
			</p>
		</div>

		<div class="container mt-5">
			<div class="row row-cols-1 row-cols-lg-3">
				<?php
					if (is_bought() === false || $configuration['app_name'] === 'MAMP') {
						echo '<div class="col mb-4">';
						echo '	<div class="card border-0 h-100">';
						echo '		<div class="card-header p-0 border-0 bg-white">';
						echo '			<h2 class="card-title mb-0 text-center text-secondary">'.$GLOBALS['strings']['_s6_'].'</h2>';
						echo '		</div>';
						echo '		<div class="card-body p-0 mt-3">';
						echo '			<p class="card-text lead text-muted text-center hm mt-2">'.$GLOBALS['strings']['_s7_'].'</p>';
						echo '			<p class="card-text">'.$GLOBALS['strings']['_s8_'].'</p>';
						echo '		</div>';
						echo '		<div class="card-footer p-0 mt-3 border-0 bg-white text-center">';
						echo '		  <div class="d-grid">';
						echo '			  <a href="'.$GLOBALS['strings']['_s10_'].'" target="_blank" class="btn btn-secondary btn-sm" role="button">'.$GLOBALS['strings']['_s9_'].'</a>';
						echo '		  </div>';
						echo '		</div>';
						echo '	</div>';
						echo '</div>';
					} else {
						echo '<div class="col mb-4">';
						echo '	<div class="card border-0 h-100">';
						echo '		<div class="card-header p-0 border-0 bg-white">';
						echo '			<h2 class="card-title mb-0 text-center text-secondary">'.$GLOBALS['strings']['_s11_'].'</h2>';
						echo '		</div>';
						echo '		<div class="card-body p-0 mt-3">';
						echo '			<p class="card-text lead text-muted text-center hm mt-2">'.($configuration['app_name'] === 'MAMP PRO' ? $GLOBALS['strings']['_s52_'] : $GLOBALS['strings']['_s12_']).'</p>';
						echo '			<p class="card-text">'.$GLOBALS['strings']['_s13_'].'</p>';
						echo '		</div>';
						echo '		<div class="card-footer p-0 mt-3 border-0 bg-white text-center">';
						echo '		  <div class="d-grid">';
						echo '			  <a href="http://www.mamp.tv" target="_blank" class="btn btn-secondary btn-sm" role="button">'.$GLOBALS['strings']['_s14_'].'</a>';
						echo '		  </div>';
						echo '		</div>';
						echo '	</div>';
						echo '</div>';
					}

					/* ---------- */

					if ($configuration['app_name'] === 'MAMP PRO') {
						echo '<div class="col mb-4">';
						echo '	<div class="card border-0 h-100">';
						echo '		<div class="card-header p-0 border-0 bg-white">';
						echo '			<h2 class="card-title mb-0 text-center text-secondary">'.$GLOBALS['strings']['_s15_'].'</h2>';
						echo '		</div>';
						echo '		<div class="card-body p-0 mt-3">';
						echo '			<p class="card-text lead text-muted text-center hm mt-2">'.$GLOBALS['strings']['_s16_'].'</p>';
						echo '			<p class="card-text">'.$GLOBALS['strings']['_s17_'].'</p>';
						echo '		</div>';
						echo '		<div class="card-footer p-0 mt-3 border-0 bg-white text-center">';
						echo '		  <div class="d-grid">';
						echo '			  <a href="https://appsolute.zendesk.com/" target="_blank" class="btn btn-secondary btn-sm" role="button">'.$GLOBALS['strings']['_s18_'].'</a>';
						echo '		  </div>';
						echo '		</div>';
						echo '	</div>';
						echo '</div>';
					} else if (is_cloud_bought() === false) {
						echo '<div class="col mb-4">';
						echo '	<div class="card border-0 h-100">';
						echo '		<div class="card-header p-0 border-0 bg-white">';
						echo '			<h2 class="card-title mb-0 text-center text-secondary">'.$GLOBALS['strings']['_s19_'].'</h2>';
						echo '		</div>';
						echo '		<div class="card-body p-0 mt-3">';
						echo '			<p class="card-text lead text-muted text-center hm mt-2">'.$GLOBALS['strings']['_s20_'].'</p>';
						echo '			<p class="card-text">'.$GLOBALS['strings']['_s21_'].'</p>';
						echo '		</div>';
						echo '		<div class="card-footer p-0 mt-3 border-0 bg-white text-center">';
						echo '		  <div class="d-grid">';
						echo '			  <a href="'.$GLOBALS['strings']['_s22_'].'" target="_blank" class="btn btn-secondary btn-sm" role="button">'.$GLOBALS['strings']['_s9_'].'</a>';
						echo '		  </div>';
						echo '		</div>';
						echo '	</div>';
						echo '</div>';
					} else {
						echo '<div class="col mb-4">';
						echo '	<div class="card border-0 h-100">';
						echo '		<div class="card-header p-0 border-0 bg-white">';
						echo '			<h2 class="card-title mb-0 text-center text-secondary">'.$GLOBALS['strings']['_s11_'].'</h2>';
						echo '		</div>';
						echo '		<div class="card-body p-0 mt-3">';
						echo '			<p class="card-text lead text-muted text-center hm mt-2">'.($configuration['app_name'] === 'MAMP PRO' ? $GLOBALS['strings']['_s52_'] : $GLOBALS['strings']['_s12_']).'</p>';
						echo '			<p class="card-text">'.$GLOBALS['strings']['_s13_'].'</p>';
						echo '		</div>';
						echo '		<div class="card-footer p-0 mt-3 border-0 bg-white text-center">';
						echo '		  <div class="d-grid">';
						echo '			  <a href="http://www.mamp.tv" target="_blank" class="btn btn-secondary btn-sm" role="button">'.$GLOBALS['strings']['_s14_'].'</a>';
						echo '		  </div>';
						echo '		</div>';
						echo '	</div>';
						echo '</div>';
					}

					/* ---------- */

					echo '<div class="col mb-4">';
					echo '	<div class="card border-0 h-100">';
					echo '		<div class="card-header p-0 border-0 bg-white">';
					echo '			<h2 class="card-title mb-0 text-center text-secondary">'.$GLOBALS['strings']['_s23_'].'</h2>';
					echo '		</div>';
					echo '		<div class="card-body p-0 mt-3">';
					echo '			<p class="card-text lead text-muted text-center hm mt-2">'.$GLOBALS['strings']['_s59_'].'</p>';
					echo '			<p class="card-text">'.$GLOBALS['strings']['_s60_'].'</p>';
					echo '		</div>';
					echo '		<div class="card-footer p-0 mt-3 border-0 bg-white text-center">';
					echo '			<div class="container">';
					echo '				<div class="row">';
					echo '					<div class="col-12 col-md-6 px-0 pe-md-1 mb-1 m-md-0">';
					echo '		  				<div class="d-grid">';
					echo '		  					<a href="https://twitter.com/mamp_en" target="_blank" class="btn btn-secondary btn-sm"><i class="fa-brands fa-x-twitter"></i> ', $GLOBALS['strings']['_s24_'], '</a>';
					echo '		  				</div>';
					echo '					</div>';
					echo '					<div class="col-12 col-md-6 px-0 ps-md-1 mt-1 m-md-0">';
					echo '		  				<div class="d-grid">';
					echo '		  					<a href="https://www.threads.net/@mamp.pro" target="_blank" class="btn btn-secondary btn-sm"><i class="fa-brands fa-threads"></i> ', $GLOBALS['strings']['_s24_'], '</a>';
					echo '						</div>';
					echo '					</div>';
					echo '				</div>';
					echo '			</div>';
					echo '		</div>';
					echo '	</div>';
					echo '</div>';
				?>
  			</div>
		</div>

		<div class="container mt-4">
			<div class="row">
				<div class="col-12">

					<div class="accordion mb-4" id="accordion-1">
						<div class="accordion-item">
							<h2 class="accordion-header" id="heading-php">
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-php" aria-expanded="false" aria-controls="collapse-php">
									<i class="fab fa-php fa-lg fa-fw me-2 text-secondary"></i> PHP
								</button>
							</h2>
							<div id="collapse-php" class="accordion-collapse collapse" aria-labelledby="heading-php">
								<div class="accordion-body">
									<h3 class="text-secondary fw-light h5">phpinfo</h3>
									<p><?php printf($GLOBALS['strings']['_s48_'], '<a href="#" data-bs-toggle="modal" data-bs-target="#modal-phpinfo">', '</a>', $_SERVER['HTTP_HOST']); ?></p>
									<h3 class="text-secondary fw-light h5">PHP-Caches</h3>
									<ul>
										<?php
											if (extension_loaded('apc') === true) {
												echo '<li><a target="_blank" href="apc.php">APC</a></li>';
											} else if (extension_loaded('apcu') === true) {
												echo '<li><a target="_blank" href="apc-8.php">APC</a></li>';
											} else {
												echo '<li>APC ('.$GLOBALS['strings']['_s31_'].')';
											}
										?>

										<?php if (extension_loaded('Zend OPcache') === true): ?>
											<li><a target="_blank" href="opcache.php">OPcache</a></li>
										<?php else: ?>
											<li>OPcache (<?php echo $GLOBALS['strings']['_s31_']; ?>)</li>
										<?php endif; ?>
									</ul>
								</div>
							</div>
						</div>

						<div class="accordion-item">
							<h2 class="accordion-header" id="heading-mysql">
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-mysql" aria-expanded="false" aria-controls="collapse-mysql">
									<i class="fas fa-database fa-lg fa-fw me-2 text-secondary"></i> MySQL
								</button>
							</h2>
							<div id="collapse-mysql" class="accordion-collapse collapse" aria-labelledby="heading-mysql">
								<div class="accordion-body">
									<p><?php printf($GLOBALS['strings']['_s38_'], '<a href="/phpMyAdmin/?lang='.$configuration['language'].'" class="btn btn-link px-0 py-0 align-baseline phpmyadmin-link'.($mysql_running === false ? ' disabled' : '').'" target="_blank">', ($mysql_running === false ? ' ('.$GLOBALS['strings']['_s53_'].')' : ''), '</a>', '<a href="/adminer" class="btn btn-link px-0 py-0 align-baseline adminer-link'.($mysql_running === false ? ' disabled' : '').'" target="_blank">', ($mysql_running === false ? ' ('.$GLOBALS['strings']['_s53_'].')' : ''), '</a>'); ?></p>
									<p><?php echo $GLOBALS['strings']['_s39_']; ?></p>
									<table class="table table-hover">
										<tr>
											<th style="width:20%"><?php echo $GLOBALS['strings']['_s40_']; ?></th>
											<td><?php echo '<code>'.$cfg['Servers'][1]['host'].'</code> / <code>127.0.0.1</code> '.$GLOBALS['strings']['_s58_']; ?></td>
										</tr>
										<tr>
											<th><?php echo $GLOBALS['strings']['_s41_']; ?></th>
											<td><code><?php echo $cfg['Servers'][1]['port']; ?></code></td>
										</tr>
										<tr>
											<th><?php echo $GLOBALS['strings']['_s42_']; ?></th>
											<td><code><?php echo $cfg['Servers'][1]['user']; ?></code></td>
										</tr>
										<tr>
											<th><?php echo $GLOBALS['strings']['_s43_']; ?></th>
											<td><code><?php echo $cfg['Servers'][1]['password']; ?></code></td>
										</tr>
										<?php if ($configuration['os'] === 'mac'): ?>
										<tr>
											<th><?php echo $GLOBALS['strings']['_s44_']; ?></th>
											<td><code>/Applications/MAMP/tmp/mysql/mysql.sock</code></td>
										</tr>
										<?php endif; ?>
									</table>
									<h3 class="text-secondary fw-light h5"><?php echo $GLOBALS['strings']['_s45_']; ?></h3>

									<ul class="nav nav-tabs nav-fill" id="mysql-examples" role="tablist">
										<li class="nav-item" role="presentation">
											<button class="nav-link text-secondary active" id="mysql-example-1-tab" data-bs-toggle="tab" data-bs-target="#mysql-example-1" type="button" role="tab" aria-controls="mysql-example-1-tab" aria-selected="true">PHP</button>
										</li>
										<li class="nav-item" role="presentation">
											<button class="nav-link text-secondary" id="mysql-example-2-tab" data-bs-toggle="tab" data-bs-target="#mysql-example-2" type="button" role="tab" aria-controls="mysql-example-2-tab" aria-selected="false">Python</button>
										</li>
									</ul>
									<div class="tab-content border border-top-0" id="mysql-examples-content">
										<div class="tab-pane show active" id="mysql-example-1" role="tabpanel" aria-labelledby="mysql-example-1-tab">
										<?php if ($configuration['os'] === 'mac'): ?>
<h4 class="text-secondary fw-light-4 px-3 pt-3 h5"><?php echo $GLOBALS['strings']['_s47_']; ?></h4>
<pre class="language-php"><code class="language-php"><?php echo htmlentities('<?php', ENT_QUOTES, 'UTF-8'); ?>

  $db_host = 'localhost';
  $db_user = '<?php echo $cfg['Servers'][1]['user']; ?>';
  $db_password = '<?php echo $cfg['Servers'][1]['password']; ?>';
  $db_db = 'mydatabase';
 
  $mysqli = @new mysqli(
    $db_host,
    $db_user,
    $db_password,
    $db_db
  );
	
  if ($mysqli->connect_error) {
    echo 'Errno: '.$mysqli->connect_errno;
    echo '&lt;br&gt;';
    echo 'Error: '.$mysqli->connect_error;
    exit();
  }

  echo 'Success: A proper connection to MySQL was made.';
  echo '&lt;br&gt;';
  echo 'Host information: '.$mysqli->host_info;
  echo '&lt;br&gt;';
  echo 'Protocol version: '.$mysqli->protocol_version;

  $mysqli->close();
<?php echo htmlentities('?>', ENT_QUOTES, 'UTF-8'); ?></code></pre>
<?php endif; ?>
<h4 class="text-secondary fw-light px-3 pt-4 h5"><?php echo $GLOBALS['strings']['_s46_']; ?></h4>
<pre class="language-php"><code class="language-php"><?php echo htmlentities('<?php', ENT_QUOTES, 'UTF-8'); ?>

  $db_host = '127.0.0.1';
  $db_user = '<?php echo $cfg['Servers'][1]['user']; ?>';
  $db_password = '<?php echo $cfg['Servers'][1]['password']; ?>';
  $db_db = 'mydatabase';
  $db_port = <?php echo $cfg['Servers'][1]['port']; ?>;

  $mysqli = new mysqli(
    $db_host,
    $db_user,
    $db_password,
    $db_db,
	$db_port
  );
	
  if ($mysqli->connect_error) {
    echo 'Errno: '.$mysqli->connect_errno;
    echo '&lt;br&gt;';
    echo 'Error: '.$mysqli->connect_error;
    exit();
  }

  echo 'Success: A proper connection to MySQL was made.';
  echo '&lt;br&gt;';
  echo 'Host information: '.$mysqli->host_info;
  echo '&lt;br&gt;';
  echo 'Protocol version: '.$mysqli->protocol_version;

  $mysqli->close();
<?php echo htmlentities('?>', ENT_QUOTES, 'UTF-8'); ?></code></pre>
										</div>
										<div class="tab-pane" id="mysql-example-2" role="tabpanel" aria-labelledby="mysql-example-2-tab">
<?php if ($configuration['os'] === 'mac'): ?>
<h4 class="text-secondary fw-light px-3 pt-3 h5"><?php echo $GLOBALS['strings']['_s47_']; ?></h4>
<pre class="language-python"><code class="language-python">#!/usr/bin/env /Applications/MAMP/Library/bin/python

import mysql.connector

config = {
  'user': '<?php echo $cfg['Servers'][1]['user']; ?>',
  'password': '<?php echo $cfg['Servers'][1]['password']; ?>',
  'host': 'localhost',
  'unix_socket': '/Applications/MAMP/tmp/mysql/mysql.sock',
  'database': 'mydatabase',
  'raise_on_warnings': True
}

cnx = mysql.connector.connect(**config)

cursor = cnx.cursor(dictionary=True)

cursor.execute('SELECT `id`, `name` FROM `test`')

results = cursor.fetchall()

for row in results:
  id = row['id']
  title = row['name']
  print '%s | %s' % (id, title)

cnx.close()
</code></pre>
<?php endif; ?>
<h4 class="text-secondary fw-light px-3 pt-4 h5"><?php echo $GLOBALS['strings']['_s46_']; ?></h4>
<pre class="language-python"><code class="language-python">#!/usr/bin/env /Applications/MAMP/Library/bin/python

import mysql.connector

config = {
  'user': '<?php echo $cfg['Servers'][1]['user']; ?>',
  'password': '<?php echo $cfg['Servers'][1]['password']; ?>',
  'host': '127.0.0.1',
  'port': <?php echo $cfg['Servers'][1]['port']; ?>,
  'database': 'mydatabase',
  'raise_on_warnings': True
}

cnx = mysql.connector.connect(**config)

cursor = cnx.cursor(dictionary=True)

cursor.execute('SELECT `id`, `name` FROM `test`')

results = cursor.fetchall()

for row in results:
  id = row['id']
  title = row['name']
  print '%s | %s' % (id, title)

cnx.close()
</code></pre>
										</div>
									</div>

								</div>
							</div>
						</div>

						<?php if ($configuration['app_name'] === 'MAMP PRO' && $configuration['os'] === 'mac'): ?>
							<div class="accordion-item">
								<h2 class="accordion-header" id="heading-redis">
									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-redis" aria-expanded="false" aria-controls="collapse-redis">
									<i class="fas fa-database fa-lg fa-fw me-2 text-secondary"></i> Redis
									</button>
								</h2>
								<div id="collapse-redis" class="accordion-collapse collapse" aria-labelledby="heading-redis">
									<div class="accordion-body">
										<h3 class="text-secondary fw-light h5"><?php echo $GLOBALS['strings']['_s45_']; ?></h3>
										<ul class="nav nav-tabs nav-fill" id="redis-examples" role="tablist">
											<li class="nav-item" role="presentation">
												<button class="nav-link text-secondary active" id="redis-example-1-tab" data-bs-toggle="tab" data-bs-target="#redis-example-1" type="button" role="tab" aria-controls="redis-example-1-tab" aria-selected="true">PHP<br><small><?php echo $GLOBALS['strings']['_s47_']; ?></small></button>
											</li>
											<li class="nav-item" role="presentation">
												<button class="nav-link text-secondary" id="redis-example-2-tab" data-bs-toggle="tab" data-bs-target="#redis-example-2" type="button" role="tab" aria-controls="redis-example-2-tab" aria-selected="false">PHP<br><small><?php echo $GLOBALS['strings']['_s46_']; ?></small></button>
											</li>
										</ul>
										<div class="tab-content border border-top-0 p-3" id="redis-examples-content">
									  	<div class="tab-pane show active" id="redis-example-1" role="tabpanel" aria-labelledby="redis-example-1-tab">
<pre class="language-php"><code class="language-php">// Connecting to Redis server on localhost
$redis = new Redis();

$redis->connect('/Applications/MAMP/tmp/redis.sock');

// Check whether server is running or not
echo 'Redis is running: ' . $redis->ping() . '&lt;br&gt;';

// Set the value of a key
$key = 'product';
$redis->set($key, 'MAMP PRO');

// Get the value of a key
echo 'Key "' . $key . '" has the value "' . $redis->get($key) . '"' . '&lt;br&gt;';

// Store data in redis list
$redis->lPush('list', 'MAMP PRO');
$redis->lPush('list', 'Apache');
$redis->lPush('list', 'MySQL');
$redis->lPush('list', 'Redis');

// Get the list data
$list = $redis->lRange('list', 0, 3);
echo '&lt;br&gt;';
echo 'Stored list:';
echo '&lt;pre&gt;';
print_r($list);
echo '&lt;/pre&gt;';

// Clean up
if ($redis->exists([$key, 'list']) === 2) {
  $redis->del($key);
  $redis->del('list');
}
</code></pre>
									  	</div>
									  	<div class="tab-pane" id="redis-example-2" role="tabpanel" aria-labelledby="redis-example-2-tab">
<pre class="language-php"><code class="language-php">// Connecting to Redis server on localhost
$redis = new Redis();

$redis->connect('127.0.0.1', 6379);

// Check whether server is running or not
echo 'Redis is running: ' . $redis->ping() . '&lt;br&gt;';

// Set the value of a key
$key = 'product';
$redis->set($key, 'MAMP PRO');

// Get the value of a key
echo 'Key "' . $key . '" has the value "' . $redis->get($key) . '"' . '&lt;br&gt;';

// Store data in redis list
$redis->lPush('list', 'MAMP PRO');
$redis->lPush('list', 'Apache');
$redis->lPush('list', 'MySQL');
$redis->lPush('list', 'Redis');

// Get the list data
$list = $redis->lRange('list', 0, 3);
echo '&lt;br&gt;';
echo 'Stored list:';
echo '&lt;pre&gt;';
print_r($list);
echo '&lt;/pre&gt;';

// Clean up
if ($redis->exists([$key, 'list']) === 2) {
  $redis->del($key);
  $redis->del('list');
}
</code></pre>
									  	</div>
								  	</div>
									</div>
								</div>
							</div>
						<?php endif; ?>

						<div class="accordion-item">
							<h2 class="accordion-header" id="heading-sqlite">
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-sqlite" aria-expanded="false" aria-controls="collapse-sqlite">
								 <i class="fas fa-database fa-lg fa-fw me-2 text-secondary"></i> SQLite
								</button>
							</h2>
							<div id="collapse-sqlite" class="accordion-collapse collapse" aria-labelledby="heading-sqlite">
								<div class="accordion-body">
									<p><?php printf($GLOBALS['strings']['_s50_'], '<a href="/phpLiteAdmin/" target="_blank">', '</a>'); ?></p>
									<h3 class="text-secondary fw-light h5"><?php echo $GLOBALS['strings']['_s45_']; ?></h3>

									<ul class="nav nav-tabs nav-fill" id="sqlite-examples" role="tablist">
										<li class="nav-item" role="presentation">
											<button class="nav-link text-secondary active" id="sqlite-example-1-tab" data-bs-toggle="tab" data-bs-target="#sqlite-example-1" type="button" role="tab" aria-controls="sqlite-example-1-tab" aria-selected="true">PHP<br><small><?php echo $GLOBALS['strings']['_s55_']; ?></small></button>
										</li>
										<li class="nav-item" role="presentation">
											<button class="nav-link text-secondary" id="sqlite-example-2-tab" data-bs-toggle="tab" data-bs-target="#sqlite-example-2" type="button" role="tab" aria-controls="sqlite-example-2-tab" aria-selected="false">PHP<br><small><?php echo $GLOBALS['strings']['_s56_']; ?></small></button>
										</li>
									</ul>
									<div class="tab-content border border-top-0" id="sqlite-examples-content">
									  <div class="tab-pane show active" id="sqlite-example-1" role="tabpanel" aria-labelledby="sqlite-example-1-tab">
<pre class="language-php"><code class="language-php">&lt;?php
  $db = new SQLite3('/Applications/MAMP/db/sqlite/mydatabase.db');
  $db-&gt;exec(&quot;CREATE TABLE items(id INTEGER PRIMARY KEY, name TEXT)&quot;);
  $db-&gt;exec(&quot;INSERT INTO items(name) VALUES('Name 1')&quot;);
  $db-&gt;exec(&quot;INSERT INTO items(name) VALUES('Name 2')&quot;);

  $last_row_id = $db-&gt;lastInsertRowID();

  echo 'The last inserted row ID is '.$last_row_id.'.';

  $result = $db-&gt;query('SELECT * FROM items');

  while ($row = $result-&gt;fetchArray()) {
    echo '&lt;br&gt;';
    echo 'id: '.$row['id'].' / name: '.$row['name'];
  }

  $db-&gt;exec('DELETE FROM items');

  $changes = $db-&gt;changes();

  echo '&lt;br&gt;';
  echo 'The DELETE statement removed '.$changes.' rows.';
?&gt;</code></pre>
									  </div>
									  <div class="tab-pane" id="sqlite-example-2" role="tabpanel" aria-labelledby="sqlite-example-2-tab">
<pre class="language-php"><code class="language-php">&lt;?php
  $db = new SQLite3(':memory:');
  $db-&gt;exec(&quot;CREATE TABLE items(id INTEGER PRIMARY KEY, name TEXT)&quot;);
  $db-&gt;exec(&quot;INSERT INTO items(name) VALUES('Name 1')&quot;);
  $db-&gt;exec(&quot;INSERT INTO items(name) VALUES('Name 2')&quot;);

  $last_row_id = $db-&gt;lastInsertRowID();

  echo 'The last inserted row ID is '.$last_row_id.'.';

  $result = $db-&gt;query('SELECT * FROM items');

  while ($row = $result-&gt;fetchArray()) {
    echo '&lt;br&gt;';
    echo 'id: '.$row['id'].' / name: '.$row['name'];
  }

  $db-&gt;exec('DELETE FROM items');

  $changes = $db-&gt;changes();

  echo '&lt;br&gt;';
  echo 'The DELETE statement removed '.$changes.' rows.';
?&gt;</code></pre>
									  </div>
								  </div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<footer class="border-top pt-3 text-center">
			<p>&copy; 2013 - 2024 <a href="https://www.mamp.info" target="_blank" class="text-body text-decoration-underline">MAMP GmbH</a></p>
		</footer>
		<script src="js/bootstrap.bundle.min.js?t=<?php echo mt_rand(); ?>"></script>
		<script defer src="js/fontawesome.js?t=<?php echo mt_rand(); ?>"></script>
		<script>
			window.FontAwesomeConfig = {
				searchPseudoElements: true
			}
		</script>
		<script src="js/prism.js?t=<?php echo mt_rand(); ?>"></script>

		<div class="modal" id="modal-phpinfo" tabindex="-1" role="dialog" aria-labelledby="modal-phpinfo-label" aria-hidden="true">
			<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-fullscreen" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="modal-phpinfo-label">phpInfo</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?php echo $GLOBALS['strings']['_s28_']; ?>"></button>
					</div>
					<div class="modal-body overflow-hidden p-0">
						<iframe id="modal-phpinfo-iframe" src="about:blank" style="width: 100%; border: 0;"></iframe>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo $GLOBALS['strings']['_s28_']; ?></button>
					</div>
				</div>
			</div>
		</div>
		<script>
			document.getElementById('modal-phpinfo').addEventListener('show.bs.modal', function (event) {
				document.getElementById('modal-phpinfo-iframe').src = 'phpinfo.php?embed=1'
			})

			document.getElementById('modal-phpinfo').addEventListener('shown.bs.modal', function (event) {
				document.getElementById('modal-phpinfo-iframe').style.height = (document.querySelector('#modal-phpinfo .modal-body').offsetHeight).toString() + 'px'
			})
		</script>

		<script>
			const checkMySQLRunning = function() {
				console.log('checkMySQLRunning')
				const url = '<?php echo $configuration['check_mysql_running_path']; ?>'
				const options = {
					method: 'GET',
					cache: 'no-cache'
				}
				window.setInterval(function() {
					fetch(url, options)
						.then(async (data) => {
							if (data.ok) {
								data = await data.json()
								document.querySelectorAll('.phpmyadmin-link').forEach(function(element) {
									element.classList.remove('disabled')
									element.text = 'phpMyAdmin'
								
									if (data == 0) {
										element.classList.add('disabled')
										element.text = 'phpMyAdmin (<?php echo $GLOBALS['strings']['_s53_']; ?>)'
									}
								})
								document.querySelectorAll('.adminer-link').forEach(function(element) {
									element.classList.remove('disabled')
									element.text = 'Adminer'
								
									if (data == 0) {
										element.classList.add('disabled')
										element.text = 'Adminer (<?php echo $GLOBALS['strings']['_s53_']; ?>)'
									}
								})
							}
						}).catch(error => {
							console.log('<?php echo $GLOBALS['strings']['_s54_']; ?>', error)
						})
				}, 5000)
			}
			
			if (document.readyState === 'complete' || (document.readyState !== 'loading' && !document.documentElement.doScroll)) {
				checkMySQLRunning()
			} else {
				document.addEventListener('DOMContentLoaded', checkMySQLRunning)
			}
		</script>
	</body>
</html>