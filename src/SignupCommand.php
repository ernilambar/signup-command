<?php

namespace WP_CLI\Signup;

use WP_CLI;
use WP_CLI_Command;

class SignupCommand extends WP_CLI_Command {

	protected $obj_fields = array(
		'signup_id',
		'user_login',
		'user_email',
		'registered',
		'active',
		'activation_key',
	);

	/**
	 * Lists signups.
	 *
	 * [--field=<field>]
	 * : Prints the value of a single field for each signup.
	 *
	 * [--fields=<fields>]
	 * : Limit the output to specific object fields.
	 *
	 * [--format=<format>]
	 * : Render output in a particular format.
	 * ---
	 * default: table
	 * options:
	 *   - table
	 *   - csv
	 *   - json
	 *   - yaml
	 * ---
	 *
	 * ## AVAILABLE FIELDS
	 *
	 * These fields will be displayed by default for each signup:
	 *
	 * * signup_id
	 * * user_login
	 * * user_email
	 * * registered
	 * * active
	 * * activation_key
	 *
	 * These fields are optionally available:
	 *
	 * * domain
	 * * path
	 * * title
	 * * activated
	 *
	 * ## EXAMPLES
	 *
	 *     # List signup IDs.
	 *     $ wp signup list --field=signup_id
	 *     1
	 *
	 * @package wp-cli
	 */
	public function list( $args, $assoc_args ) {
		global $wpdb;

		if ( isset( $assoc_args['fields'] ) ) {
			$assoc_args['fields'] = explode( ',', $assoc_args['fields'] );
		} else {
			$assoc_args['fields'] = $this->obj_fields;
		}

		$results = $wpdb->get_results( "SELECT * FROM $wpdb->signups WHERE active = 0" );

		$formatter = new WP_CLI\Formatter( $assoc_args );
		$formatter->display_items( $results );
	}
}
