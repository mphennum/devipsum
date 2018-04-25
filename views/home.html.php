<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="utf-8">

<title>devipsum: lorem ipsum for development</title>

<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">

<?php include __DIR__ . '/ssi/styles.html.php'; ?>
<?php include __DIR__ . '/ssi/scripts-sync.html.php'; ?>

</head>

<body>

<header><a href="//<?= DevIpsum\Config::WWW_HOST ?>/">devipsum</a></header>

<main>

<h1>Randomly generated development ipsum</h1>
<p><a href="//github.com/mphennum/devipsum/">github.com/mphennum/devipsum</a></p>

<hr>

<h2>Examples</h2>
<p>user request: <a href="//<?= DevIpsum\Config::API_HOST ?>/user.json?n=10"><?= DevIpsum\Config::API_HOST ?>/user.json?n=10</a></p>
<p>text request: <a href="//<?= DevIpsum\Config::API_HOST ?>/text.json?n=5"><?= DevIpsum\Config::API_HOST ?>/text.json?n=5</a></p>

<hr>

<h2>Demo</h2>
<p>Note: requests are cached for 15 seconds</p>
<p>
	<?= DevIpsum\Config::API_HOST ?>/<input class="di-request" type="text" value="user.json?n=5">
	<button class="di-send">try it out</button>
</p>
<div class="di-display" style="display: none"></div>
<p><textarea class="di-text" style="display: none"></textarea></p>

</main>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
(function() {

var $ = window.jQuery;
var JSON = window.JSON;

// response

var $text = $('.di-text');
var $display = $('.di-display');

var noop = function() {};

var requestXHR = function(url, callback) {
	callback = callback || noop;

	var xhr = new XMLHttpRequest();
	xhr.open('GET', url, true);

	var complete = false;
	xhr.onreadystatechange = function() {
		if (xhr.readyState === 4 && !complete) {
			complete = true;
			callback(JSON.parse(xhr.responseText));
		}
	};

	xhr.send(null);
};

var requestXDR = function(url, callback) {
	callback = callback || noop;

	var xdr = new XDomainRequest();
	xdr.onprogress = noop;
	xdr.ontimeout = noop;
	xdr.onerror = noop;

	var complete = false;
	xdr.onload = function() {
		if (!complete) {
			complete = true;
			callback(JSON.parse(xdr.responseText));
		}
	};

	xdr.open('GET', url);
	xdr.send();
};

var trueRequest = (XMLHttpRequest && 'withCredentials' in new XMLHttpRequest()) ? requestXHR : requestXDR;

var request = function() {
	var $request = $(this).parent().children('.di-request');

	trueRequest('http://<?= DevIpsum\Config::API_HOST ?>/' + $request.val(), function(resp) {
		$text.show();
		$display.show();

		if (!resp) {
			$text.val('Error connecting to server.');
			return;
		}

		$text.val(JSON.stringify(resp, null, '\t'));
		$display.empty();

		if (!resp.result) {
			return;
		}

		if (resp.result.users) {
			var users = resp.result.users;
			for (var i = 0, n = users.length; i < n; ++i) {
				var user = users[i];
				var $user = $('<p class="di-user"/>');

				var contact = user.contact;
				var name = user.name.full;
				var address = user.address;

				$user.append('<img class="di-user-profile" src="' + contact.social.profile + '" alt="Profile picture for ' + name + '">');

				$user.append('<span class="di-user-top"><span class="di-user-name">' + name + '</span> (' + user.birth.age + ' years old)</span>');

				$user.append('<span class="di-user-address">Address: ' + address.street + ', ' + address.city + ', ' + address.state + ', ' + address.country + ', ' + address.zip + '</span>');

				$user.append('<span class="di-user-contact">Contact: <a class="di-user-phone" href="tel:' + contact.phone + '">' + contact.phone + '</a>, <a class="di-user-email" href="mailto:' + contact.email + '">' + contact.email + '</a>');

				$display.append($user);
			}

			$display.append('<hr>');
		} else if (resp.result.text) {
			var text = resp.result.text;
			for (var i = 0, n = text.length; i < n; ++i) {
				$display.append('<p>' + text[i] + '</p>');
			}

			$display.append('<hr>');
		}
	});
};

// request

$('.di-send').click(request);
$('.di-request').keypress(function(event) {
	if (event.keyCode === 13 || event.charCode === 13) {
		request.call(this);
	}
});

})();
</script>

<?php include __DIR__ . '/ssi/scripts-async.html.php'; ?>

</body>

</html>
