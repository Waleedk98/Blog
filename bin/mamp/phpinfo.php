<?php
    include_once 'php/configuration.php';
	include_once 'php/functions.php';
	include_once 'php/strings/'.$configuration['language'].'.php';

    $table_width = (string) '1140px';
?>
<!doctype html>
<html lang="<?php echo $configuration['language']; ?>">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="icon" type="img/ico" href="images/favicon.ico">
		<link rel="shortcut icon" href="images/favicon.ico">
		<title><?php echo $configuration['app_name']; ?> - PHP <?php echo phpversion(); ?> - phpinfo()</title>
        <style>
            body {background-color: #fff; color: #212529; font-family: sans-serif; font-size: 0.9rem; font-weight: 400; line-height: 1.6;}
            pre {margin: 0; font-family: monospace;}
            a:link {color: #009; text-decoration: none; background-color: #fff;}
            a:hover {text-decoration: underline;}
            table {border-collapse: collapse; border: 0; width: <?php echo $table_width; ?>;}
            .center {text-align: center;}
            .center table {margin: 1em auto; text-align: left;}
            .center th {text-align: center !important;}
            td, th {border: 1px solid #666; vertical-align: baseline; padding: 4px 5px;}
            th {position: sticky; top: 0; background: inherit;}
            h1 {font-size: 150%;}
            h2 {font-size: 125%;}
            .p {text-align: left;}
            .e {background-color: #ccf; width: 320px; font-weight: bold;}
            .h {background-color: #99c; font-weight: bold;}
            .v {background-color: #ddd; max-width: 320px; overflow-x: auto; word-wrap: break-word;}
            .v i {color: #999;}
            img {float: right; border: 0; margin: 5px;}
            hr {width: <?php echo $table_width; ?>; background-color: #ccc; border: 0; height: 1px;}
        </style>
    </head>
	<body>
        <?php echo get_phpinfo(); ?>
	</body>
</html>