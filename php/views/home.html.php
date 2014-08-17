<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="utf-8">

<title>devipsum: lorem ipsum for development</title>

<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no, target-densitydpi=high-dpi">

<?php include __DIR__ . '/ssi/styles.html.php'; ?>
<?php include __DIR__ . '/ssi/scripts-sync.html.php'; ?>

</head>

<body>

<header><a href="http://<?= DevIpsum\Config::WWW_HOST ?>/">devipsum</a></header>

<main>

<h1>Randomly generated development ipsum</h1>
<p>source: <a href="//github.com/mphennum/devipsum/">github.com/mphennum/devipsum</a></p>
<p>docs: <a href="//github.com/mphennum/devipsum/wiki/">github.com/mphennum/devipsum/wiki</a></p>

<h2>Examples</h2>
<p>user request: <a href="http://api.devipsum.com/user.json?n=10">api.devipsum.com/user.json?n=10</a></p>
<p>text request: <a href="http://api.devipsum.com/text.json?n=5">api.devipsum.com/text.json?n=5</a></p>

<h2>Demo</h2>
<p>api.devipsum.com/<input class="di-request" type="text" value="user.json"> <button class="di-send">try it out</button></p>
<!-- p>api.devipsum.com/<input class="di-request" type="text" value="text.json?n=5"> <button class="di-send">try it out</button></p -->
<p><textarea class="di-response"></textarea></p>

<script>
(function() {

var $response = $('.di-response');

var request = function() {
	var $request = $(this).parent().children('.di-request');
	var jqXHR = $.getJSON('http://api.devipsum.com/' + $request.val()).always(function(jqXHR, textStatus, error) {
		if (jqXHR.responseJSON) {
			jqXHR = jqXHR.responseJSON;
		}

		$response.val(JSON.stringify(jqXHR, null, '  '));
	});
};

$('.di-send').click(request);
$('.di-request').keypress(function(e) {
	if (e.keyCode === 13 || e.charCode === 13) {
		request.call(this);
	}
});

})();
</script>

</main>

<?php include __DIR__ . '/ssi/scripts-async.html.php'; ?>

</body>

</html>
