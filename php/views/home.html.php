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

<hr>

<h2>Examples</h2>
<p>user request: <a href="http://api.devipsum.com/user.json?n=10">api.devipsum.com/user.json?n=10</a></p>
<p>text request: <a href="http://api.devipsum.com/text.json?n=5">api.devipsum.com/text.json?n=5</a></p>

<hr>

<h2>Demo</h2>
<p>Note: requests are cached for 15 seconds</p>
<p>
	api.devipsum.com/<input class="di-request" type="text" value="user.json?n=5">
	<button class="di-send">try it out</button>
</p>
<!-- p>api.devipsum.com/<input class="di-request" type="text" value="text.json?n=5"> <button class="di-send">try it out</button></p -->
<div class="di-display" style="display: none"></div>
<p><textarea class="di-text" style="display: none"></textarea></p>

</main>

<script>
(function() {

$.support.cors = true;

// response

var $text = $('.di-text');
var $display = $('.di-display');

var request = function() {
	var $request = $(this).parent().children('.di-request');

	$.getJSON('http://api.devipsum.com/' + $request.val()).always(function(resp, textStatus, error) {
		resp = resp.responseJSON || resp;

		$text.show();
		$display.show();

		if (resp && resp.statusText && /access is denied/i.test(resp.statusText)) {
			$text.val('Your browser is not supported.');
			return;
		}

		$text.val(JSON.stringify(resp, null, '    '));

		$display.empty();
		if (resp && resp.result) {
			if (resp.result.users) {
				var users = resp.result.users;
				for (var i = 0, n = users.length; i < n; i++) {
					var user = users[i];
					var $user = $('<p class="di-user" />');

					var contact = user.contact;
					var name = user.name.full;
					var address = user.address;

					$user.append('<img class="di-user-profile" width="60" height="60" src="' + contact.social.profile + '" alt="Profile picture for ' + name + '">');

					$user.append('<span class="di-user-top"><span class="di-user-name">' + name + '</span> (' + user.birth.age + ' years old)</span>');

					$user.append('<span class="di-user-address">Address: ' + address.street + ', ' + address.city + ', ' + address.state + ', ' + address.country + ', ' + address.zip + '</span>');

					$user.append('<span class="di-user-contact">Contact: <a class="di-user-phone" href="tel:' + contact.phone + '">' + contact.phone + '</a>, <a class="di-user-email" href="mailto:' + contact.email + '">' + contact.email + '</a>');

					$display.append($user);
				}

				$display.append('<hr>');
			} else if (resp.result.text) {
				var text = resp.result.text;
				for (var i = 0, n = text.length; i < n; i++) {
					$display.append('<p>' + text[i] + '</p>');
				}

				$display.append('<hr>');
			}
		}
	});
};

// request

$('.di-send').click(request);
$('.di-request').keypress(function(e) {
	if (e.keyCode === 13 || e.charCode === 13) {
		request.call(this);
	}
});

})();
</script>

<?php include __DIR__ . '/ssi/scripts-async.html.php'; ?>

</body>

</html>
