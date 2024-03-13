<?php

namespace WP_CLI\Signup;

use WP_CLI\Fetchers\Base;

/**
 * Fetch a signup based on one of its attributes.
 */
class SignupFetcher extends Base {

	/**
	 * Get a signup by one of its identifying attributes.
	 *
	 * @param string $arg The raw CLI argument.
	 * @return stdClass|false The item if found; false otherwise.
	 */
	public function get( $arg ) {
		global $wpdb;

		$signup_object = null;

		// Fetch signup with signup_id.
		if ( is_numeric( $arg ) ) {
			$result = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $wpdb->signups WHERE signup_id = %d", $arg ) );

			if ( $result ) {
				$signup_object = $result;
			}
		}

		// Try to fetch with other keys.
		foreach ( array( 'user_login', 'user_email', 'activation_key' ) as $field ) {
			$result = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $wpdb->signups WHERE $field = %s", wp_unslash( $arg ) ) );
			if ( $result ) {
				$signup_object = $result;
				break;
			}
		}

		if ( $signup_object ) {
			return $signup_object;
		}

		return false;
	}
}
