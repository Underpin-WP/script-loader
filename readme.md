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
	'class' => 'Underpin_Scripts\Factories\Script_Instance',
	'args'  => [
		[
		    'handle'      => 'test',
		    'src'         => 'path/to/script/src',
			'name'        => 'test',
			'description' => 'The description'
		]
	],
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

## Localizing Scripts

Underpin expands on how script localization works. A common problem with using `wp_localize_script` is that the data
needed to localize the script has to all be placed in one single call. Underpin gets around that by using the `set_param`
method.

For example, say you wanted to localize `ajaxUrl` as your site's admin AJAX URL. You could do that at any time, like so:

```php
underpin()->scripts()->get( 'test' )->set_param( 'ajaxUrl', admin_url( 'admin-ajax.php' ) );
```

As long as this is done before `enqueue` is fired, `ajaxUrl` will be localized. All items are localized inside
of an object named after the `localized_var`. If no `localized_var` is specified, the var will be the `handle`.

So, if you enqueued `ajaxUrl` on a script with a handle called `example`, you would get something like:
```js
// console.log(example)
{
	ajaxUrl: 'https://www.underpin.com/admin-ajax.php'
}
```