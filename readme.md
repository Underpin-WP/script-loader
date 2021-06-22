# Underpin Script Loader

Loader That assists with adding scripts to a WordPress website.

## Installation

### Using Composer

`composer require underpin/script-loader`

### Manually

This plugin uses a built-in autoloader, so as long as it is required _before_
Underpin, it should work as-expected.

`require_once(__DIR__ . '/underpin-scripts/scripts.php');`

## Setup

1. Install Underpin. See [Underpin Docs](https://www.github.com/underpin-wp/underpin)
1. Register new scripts as-needed.

## Example

A very basic example could look something like this.

```php
underpin()->scripts()->add( 'test', [
        'handle'      => 'test',
        'src'         => 'path/to/script/src',
        'name'        => 'test',
        'description' => 'The description'
] );
```

Alternatively, you can extend `Script` and reference the extended class directly, like so:

```php
underpin()->scripts()->add('key','Namespace\To\Class');
```

## Enqueuing Scripts

To enqueue a script, run the loader and reference the script ID, like so:

```php
underpin()->scripts()->enqueue('test'); // Enqueue the test script
```

A common practice is to extend `do_actions` in the script class to add the actions necessary to enqueue the script. If
you don't need to use any logic to enqueue your script, the simplest way to enqueue the script is with
the [enqueue script middleware](#Enqueuing-With-Middleware).

## Localizing Scripts

Underpin expands on how script localization works. A common problem with using `wp_localize_script` is that the data
needed to localize the script has to all be placed in one single call. Underpin gets around that by using
the `set_param`
method.

For example, say you wanted to localize `ajaxUrl` as your site's admin AJAX URL. You could do that at any time, like so:

```php
underpin()->scripts()->get( 'test' )->set_param( 'ajaxUrl', admin_url( 'admin-ajax.php' ) );
```

As long as this is done before `enqueue` is fired, `ajaxUrl` will be localized. All items are localized inside of an
object named after the `localized_var`. If no `localized_var` is specified, the var will be the `handle`.

So, if you enqueued `ajaxUrl` on a script with a handle called `example`, you would get something like:

```js
// console.log(example)
{
	ajaxUrl: 'https://www.underpin.com/admin-ajax.php'
}
```

## Script Middleware

Sometimes, it is necessary to localize the same set of paramaters, or even run the same actions across many scripts.
This is where script middleware comes in handy.

For example, let's say you want to build a script that utilizes the REST API, and as a result needs a nonce and the root
URL localized in the script. Doing this without a script is pretty straightforward, but verbose:

```php

// Register script
underpin()->scripts()->add( 'test', [
        'handle'      => 'test',
        'src'         => 'path/to/script/src',
        'name'        => 'test',
        'description' => 'The description'
] );

$script = underpin()->scripts()->get('test');

// Localize script
$script->set_param('nonce', wp_create_nonce('wp_rest'));
$script->set_param('rest_url', get_rest_url());

// Enqueue script
$script->enqueue();
```

This is a very common scenario for WordPress scripts. Because of
this, [a middleware package](https://www.github.com/underpin-wp/underpin-rest-middleware) exists to handle this
automatically. The example below would accomplish the exact same thing:

```php
// Register script
underpin()->scripts()->add( 'test', [
        'handle'      => 'test',
        'src'         => 'path/to/script/src',
        'name'        => 'test',
        'description' => 'The description',
        'middlewares' => [
          'Underpin_Rest_Middleware\Factories\Rest_Middleware'
        ]
] );

// Enqueue script
$script = underpin()->scripts()->get('test')->enqueue();
```

The key part of the example above is the `middlewares` argument. Middlewares is an array of `Script_Middleware` items
that run in the provided order, and are intended to automate the steps needed to set up a script.

### Enqueuing With Middleware

In circumstances where you _always_ need to enqueue the script, you can use the provided enqueue middleware.

To enqueue on admin screens:

```php
underpin()->scripts()->add( 'test', [
        'handle'      => 'test',
        'src'         => 'path/to/script/src',
        'name'        => 'test',
        'description' => 'The description',
        'middlewares' => [
          'Underpin_Scripts\Factories\Enqueue_Admin_Script'
        ]
] );
```

To enqueue on the front-end:

```php
underpin()->scripts()->add( 'test', [
        'handle'      => 'test',
        'src'         => 'path/to/script/src',
        'name'        => 'test',
        'description' => 'The description',
        'middlewares' => [
          'Underpin_Scripts\Factories\Enqueue_Script'
        ]
] );
```

To enqueue on both front-end and back-end:

```php
underpin()->scripts()->add( 'test', [
        'handle'      => 'test',
        'src'         => 'path/to/script/src',
        'name'        => 'test',
        'description' => 'The description',
        'middlewares' => [
          'Underpin_Scripts\Factories\Enqueue_Script',
          'Underpin_Scripts\Factories\Enqueue_Admin_Script'
        ]
] );
```

### Create Your Own Middleware

The `middlewares` array uses `Underpin::make_class` to create the class instances. This means that you can pass either:

1. a string that references an instance of `Script_Middleware` (see example above).
1. An array of arguments to construct an instance of `Script_Middleware` on-the-fly.

```php
underpin()->scripts()->add( 'test', [
	'handle'      => 'test',
	'src'         => 'path/to/script/src',
	'name'        => 'test',
	'description' => 'The description',
	'middlewares' => [
		'Underpin_Rest_Middleware\Factories\Rest_Middleware', // Will localize script params.
		'Underpin_Scripts\Factories\Enqueue_Script',          // Will enqueue the script on the front end all the time.
		[                                                     // Will instantiate an instance of Script_Middleware_Instance using the provided arguments
			'name'                => 'Custom setup params',
			'description'         => 'Sets up custom parameters specific to this script',
			'priority'            => 10, // Optional. Default 10.
			'do_actions_callback' => function ( \Underpin_Scripts\Abstracts\Script $loader_item ) {
				// Do actions
			},
		],
	],
] );
```