<?php

return [

	// The default gateway to use
	'default' => 'superpay',

	// Add in each gateway here
	'gateways' => [
		'superpay' => [
			'driver'  => 'SuperPay',
			'options' => [
				'username'  => env( 'SUPERPAY_USERNAME', '' ),
            	'password'  => env( 'SUPERPAY_PASSWORD', '' ),
			]
		]
	]

];