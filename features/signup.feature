Feature: Manage signups in a multisite installation

	Scenario: List signups
		Given a WP multisite install
		And I run `wp eval 'wpmu_signup_user( "bobuser", "bobuser@example.com" );'`
		And I run `wp eval 'wpmu_signup_user( "johnuser", "johnuser@example.com" );'`

		When I run `wp signup list --fields=signup_id,user_login,user_email,active --format=csv`
		Then STDOUT should be:
			"""
			signup_id,user_login,user_email,active
			1,bobuser,bobuser@example.com,0
			2,johnuser,johnuser@example.com,0
			"""

		When I run `wp signup list --format=count --active=1`
		Then STDOUT should be:
			"""
			0
			"""

		When I run `wp signup activate bobuser`
		Then STDOUT should contain:
			"""
			Success: Signup activated.
			"""

		When I run `wp signup list --fields=signup_id,user_login,user_email,active --format=csv --active=1`
		Then STDOUT should be:
			"""
			signup_id,user_login,user_email,active
			1,bobuser,bobuser@example.com,1
			"""

	Scenario: Get signup
		Given a WP multisite install
		And I run `wp eval 'wpmu_signup_user( "bobuser", "bobuser@example.com" );'`

		When I run `wp signup get bobuser --fields=signup_id,user_login,user_email,active --format=csv`
		Then STDOUT should be:
			"""
			signup_id,user_login,user_email,active
			1,bobuser,bobuser@example.com,0
			"""

	Scenario: Delete signup
		Given a WP multisite install

		When I run `wp eval 'wpmu_signup_user( "bobuser", "bobuser@example.com" );'`
		And I run `wp signup get bobuser --field=user_login`
		Then STDOUT should be:
			"""
			bobuser
			"""

		When I run `wp signup delete bobuser@example.com`
		Then STDOUT should be:
			"""
			Success: Signup deleted.
			"""

		When I try `wp signup get bobuser`
		Then STDERR should be:
			"""
			Error: Signup not found.
			"""

	Scenario: Activate signup
		Given a WP multisite install
		And I run `wp eval 'wpmu_signup_user( "bobuser", "bobuser@example.com" );'`

		And I run `wp signup get bobuser --field=active`
		Then STDOUT should be:
			"""
			0
			"""

		When I run `wp signup activate bobuser`
		Then STDOUT should contain:
			"""
			Success: Signup activated.
			"""

		When I run `wp signup get bobuser --field=active`
		Then STDOUT should be:
			"""
			1
			"""
