# Underpin Script Loader

Loader That assists with adding scripts to a WordPress website.

## Installation

### Using Composer

`composer require underpin/loaders/scripts`

### Manually

This plugin uses a built-in autoloader, so as long as it is required _before_
Underpin, it should work as-expected.

`require_once(__DIR__ . '/underpin-scripts/scripts.php');`

## Setup

1. Install Underpin. See [Underpin Docs](https://www.github.com/underpin/underpin)
1. Register new scripts as-needed.

## Example

A very basic example could look something like this.

```php
underpin()->scripts()->add( 'test', [
	'class' => 'Underpin_Scripts\Factories\Script_Instance',
	'args'  => [
		[
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
