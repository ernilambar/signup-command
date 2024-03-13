<?php

if ( ! class_exists( 'WP_CLI' ) ) {
	return;
}

$wpcli_signup_autoloader = __DIR__ . '/vendor/autoload.php';

if ( file_exists( $wpcli_signup_autoloader ) ) {
	require_once $wpcli_signup_autoloader;
}

WP_CLI::add_command(
	'signup',
	'WP_CLI\Signup\SignupCommand',
	array(
		'before_invoke' => function () {
			if ( ! is_multisite() ) {
				WP_CLI::error( 'This is not a multisite installation.' );
			}
		},
	)
);
