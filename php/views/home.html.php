<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="utf-8">

<title>devipsum: lorem ipsum for development</title>

<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no, target-densitydpi=high-dpi">

</head>

<body>

<header><a href="http://<?= DevIpsum\Config::WWW_HOST ?>/">devipsum</a></header>

<h1>Randomly generated development ipsum</h1>

<main>
	<p>source: <a href="//github.com/mphennum/devipsum/">github.com/mphennum/devipsum</a></p>
	<p>docs: <a href="//github.com/mphennum/devipsum/wiki/">github.com/mphennum/devipsum/wiki</a></p>
	<h2>Examples</h2>
	<p>request: <a href="http://api.devipsum.com/user.json?n=10">api.devipsum.com/user.json?n=10</a></p>
	<p>request: <a href="http://api.devipsum.com/text.json?n=5">api.devipsum.com/text.json?n=5</a></p>
</main>


<script>(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','//www.google-analytics.com/analytics.js','ga');ga('create','UA-53886971-1','auto');ga('send','pageview');</script>

</body>

</html>
