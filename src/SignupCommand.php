<?php

namespace WP_CLI\Signup;

use WP_CLI;
use WP_CLI_Command;

class SignupCommand extends WP_CLI_Command {

	/**
	 * List signups.
	 *
	 * @param array $args       Indexed array of positional arguments.
	 * @param array $assoc_args Associative array of associative arguments.
	 */
	public function list( $args, $assoc_args ) {
		WP_CLI::success( 'Hello World!' );
	}
}
