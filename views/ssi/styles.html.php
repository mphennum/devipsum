<link href='//fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet'>

<?php if (DevIpsum\Config::DEV_MODE) { ?>
<link href="//<?= DevIpsum\Config::CSS_HOST ?>/src/main.css" rel="stylesheet">
<?php } else { ?>
<link href="//<?= DevIpsum\Config::CSS_HOST ?>/min.css" rel="stylesheet">
<?php } ?>

<link rel="shortcut icon" href="//<?= DevIpsum\Config::IMG_HOST ?>/favicon.png">
