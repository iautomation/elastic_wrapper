# elastic_wrapper
A wrapper for Elastic Mail HTTP API

# usage
<?php
include 'elastic_wrapper.php';

$el = new elastic_wrapper('xxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxx');
echo $el->send([
	'to'=>'whereyoucanemailme@gmail.com',
	'from'=>'someemail@domain.xyz',
	'subject'=>'George are we still on for the meet',
	'body_html'=>'Answer quickly you stupid head'
]);
?>
