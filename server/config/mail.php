<?php

return [
	"driver" => "smtp",
	"host" => "smtp.mailtrap.io",
	"port" => 2525,
	"from" => array(
		"address" => "from@example.com",
		"name" => "Example"
	),
	"username" => "9dc6a0970f9466",
	"password" => "fcae424a45c2ca",
	"sendmail" => "/usr/sbin/sendmail -bs",
	"pretend" => false
];
