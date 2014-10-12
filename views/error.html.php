<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="utf-8">

<title>devipsum: error 404</title>

<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">

<?php include __DIR__ . '/ssi/styles.html.php'; ?>
<?php include __DIR__ . '/ssi/scripts-sync.html.php'; ?>

</head>

<body>

<header><a href="http://<?= DevIpsum\Config::WWW_HOST ?>/">devipsum</a></header>

<main>
	<h1>Error 404</h1>
	<p>The requested page could not be found.</p>
</main>

<?php include __DIR__ . '/ssi/scripts-async.html.php'; ?>

</body>

</html>
