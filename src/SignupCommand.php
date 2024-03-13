<?php

namespace WP_CLI\Signup;

use WP_CLI;
use WP_CLI\Utils;
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

	private $fetcher;

	public function __construct() {
		$this->fetcher = new SignupFetcher();
	}

	/**
	 * Lists signups.
	 *
	 * [--field=<field>]
	 * : Prints the value of a single field for each signup.
	 *
	 * [--<field>=<value>]
	 * : Filter results by key=value pairs.
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
	 *   - ids
	 *   - json
	 *   - yaml
	 *   - count
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

		$signups = array();

		$results = $wpdb->get_results( "SELECT * FROM $wpdb->signups", ARRAY_A );

		if ( $results ) {
			foreach ( $results as $r ) {
				$item = $r;
				unset( $item['meta'] );

				// Support features like --active=0.
				foreach ( array_keys( $r ) as $field ) {
					if ( isset( $assoc_args[ $field ] ) && $assoc_args[ $field ] !== $r[ $field ] ) {
						continue 2;
					}
				}

				$signups[] = $item;
			}
		}

		$format = Utils\get_flag_value( $assoc_args, 'format', 'table' );

		if ( 'count' === $format ) {
			WP_CLI::line( count( $signups ) );
		} elseif ( 'ids' === $format ) {
			$formatter = new WP_CLI\Formatter( $assoc_args );
			$formatter->display_items( wp_list_pluck( $signups, 'signup_id' ) );
		} else {
			$formatter = new WP_CLI\Formatter( $assoc_args, $this->obj_fields );
			$formatter->display_items( $signups );
		}
	}

	/**
	 * Activate an user.
	 *
	 * ## OPTIONS
	 *
	 * <user>
	 * : ID, user login, user email or activation key.
	 *
	 * ## EXAMPLES
	 *
	 *     # Activate signup with ID.
	 *     $ wp signup activate 2
	 *     Success: User activated. Password: bZFSGsfzb9xs
	 */
	function activate( $args, $assoc_args ) {
		$signup = $this->fetcher->get( $args[0] );

		if ( false === $signup ) {
			WP_CLI::error( 'Signup not found.' );
		}

		if ( $signup ) {
			$result = wpmu_activate_signup( $signup->activation_key );
		}

		if ( ! is_wp_error( $result ) ) {
			WP_CLI::success( "User activated. Password: {$result['password']}" );
		} else {
			WP_CLI::error( 'User could not be activated. Reason: ' . $result->get_error_message() );
		}
	}

	/**
	 * Delete an user from signups.
	 *
	 * ## OPTIONS
	 *
	 * <user>
	 * : ID, user login, user email or activation key.
	 *
	 * ## EXAMPLES
	 *
	 *     # Delete an user from signups.
	 *     $ wp signup delete johndoe@example.com
	 *     Success: User deleted.
	 */
	function delete( $args, $assoc_args ) {
		global $wpdb;

		$signup = $this->fetcher->get( $args[0] );

		if ( false === $signup ) {
			WP_CLI::error( 'Signup not found.' );
		}

		if ( $signup ) {
			$wpdb->delete( $wpdb->signups, array( 'signup_id' => $signup->signup_id ), array( '%d' ) );
		}

		if ( $wpdb->rows_affected > 0 ) {
			WP_CLI::success( 'User deleted.' );
		} else {
			WP_CLI::error( 'Error occurred while deleting user.' );
		}
	}
}
