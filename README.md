ernilambar/signup-command
=========================





Quick links: [Using](#using) | [Installing](#installing) | [Contributing](#contributing) | [Support](#support)

## Using

This package implements the following commands:

### wp signup list

Lists signups.

~~~
wp signup list [--field=<field>] [--<field>=<value>] [--fields=<fields>] [--format=<format>]
~~~

	[--field=<field>]
		Prints the value of a single field for each signup.

	[--<field>=<value>]
		Filter results by key=value pairs.

	[--fields=<fields>]
		Limit the output to specific object fields.

	[--format=<format>]
		Render output in a particular format.
		---
		default: table
		options:
		  - table
		  - csv
		  - ids
		  - json
		  - yaml
		  - count
		---

**AVAILABLE FIELDS**

These fields will be displayed by default for each signup:

* signup_id
* user_login
* user_email
* registered
* active
* activation_key

These fields are optionally available:

* domain
* path
* title
* activated
* meta

**EXAMPLES**

    # List signup IDs.
    $ wp signup list --field=signup_id
    1

    # List all signups.
    $ wp signup list
    +-----------+------------+---------------------+---------------------+--------+------------------+
    | signup_id | user_login | user_email          | registered          | active | activation_key   |
    +-----------+------------+---------------------+---------------------+--------+------------------+
    | 1         | bobuser    | bobuser@example.com | 2024-03-13 05:46:53 | 1      | 7320b2f009266618 |
    | 2         | johndoe    | johndoe@example.com | 2024-03-13 06:24:44 | 0      | 9068d859186cd0b5 |
    +-----------+------------+---------------------+---------------------+--------+------------------+



### wp signup get

Gets details about the signup.

~~~
wp signup get <signup> [--field=<field>] [--fields=<fields>] [--format=<format>]
~~~

**OPTIONS**

	<signup>
		Signup ID, user login, user email or activation key.

	[--field=<field>]
		Instead of returning the whole signup, returns the value of a single field.

	[--fields=<fields>]
		Get a specific subset of the signup's fields.

	[--format=<format>]
		Render output in a particular format.
		---
		default: table
		options:
		  - table
		  - csv
		  - json
		  - yaml
		---

**EXAMPLES**

    # Get signup.
    $ wp signup get 1 --format=csv
    signup_id,user_login,user_email,registered,active,activation_key
    1,bobuser,bobuser@example.com,"2024-03-12 05:46:53",0,663b5af63dd930fd



### wp signup activate

Activates a signup.

~~~
wp signup activate <signup>
~~~

**OPTIONS**

	<signup>
		Signup ID, user login, user email or activation key.

**EXAMPLES**

    # Activate signup.
    $ wp signup activate 2
    Success: Signup activated. Password: bZFSGsfzb9xs



### wp signup delete

Deletes a signup.

~~~
wp signup delete <signup>
~~~

**OPTIONS**

	<signup>
		Signup ID, user login, user email or activation key.

**EXAMPLES**

    # Delete signup.
    $ wp signup delete johndoe@example.com
    Success: Signup deleted.

## Installing

Installing this package requires WP-CLI v2.10 or greater. Update to the latest stable release with `wp cli update`.

Once you've done so, you can install the latest stable version of this package with:

```bash
wp package install ernilambar/signup-command:@stable
```

To install the latest development version of this package, use the following command instead:

```bash
wp package install ernilambar/signup-command:dev-master
```

## Contributing

We appreciate you taking the initiative to contribute to this project.

Contributing isn’t limited to just code. We encourage you to contribute in the way that best fits your abilities, by writing tutorials, giving a demo at your local meetup, helping other users with their support questions, or revising our documentation.

For a more thorough introduction, [check out WP-CLI's guide to contributing](https://make.wordpress.org/cli/handbook/contributing/). This package follows those policy and guidelines.

### Reporting a bug

Think you’ve found a bug? We’d love for you to help us get it fixed.

Before you create a new issue, you should [search existing issues](https://github.com/ernilambar/signup-command/issues?q=label%3Abug%20) to see if there’s an existing resolution to it, or if it’s already been fixed in a newer version.

Once you’ve done a bit of searching and discovered there isn’t an open or fixed issue for your bug, please [create a new issue](https://github.com/ernilambar/signup-command/issues/new). Include as much detail as you can, and clear steps to reproduce if possible. For more guidance, [review our bug report documentation](https://make.wordpress.org/cli/handbook/bug-reports/).

### Creating a pull request

Want to contribute a new feature? Please first [open a new issue](https://github.com/ernilambar/signup-command/issues/new) to discuss whether the feature is a good fit for the project.

Once you've decided to commit the time to seeing your pull request through, [please follow our guidelines for creating a pull request](https://make.wordpress.org/cli/handbook/pull-requests/) to make sure it's a pleasant experience. See "[Setting up](https://make.wordpress.org/cli/handbook/pull-requests/#setting-up)" for details specific to working on this package locally.

## Support

GitHub issues aren't for general support questions, but there are other venues you can try: https://wp-cli.org/#support


*This README.md is generated dynamically from the project's codebase using `wp scaffold package-readme` ([doc](https://github.com/wp-cli/scaffold-package-command#wp-scaffold-package-readme)). To suggest changes, please submit a pull request against the corresponding part of the codebase.*
