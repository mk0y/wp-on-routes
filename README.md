WordPress on Routes
============

WordPress on Routes is a plugin for WordPress, inspired mainly by Ruby micro-frameworks. It adds ability to add custom routes to your WordPress instance. Useful for form submissions, API-like features, etc.


Installation
===
Good old plugin installation applies here too - download it / clone it to `plugins/` dir, activate.

No UI involved.


Basic Usage
=====

In your functions.php:

```php
$routing = \WoR\Main::get_instance();

$routing->add_routes(
  array(
    'get' => array(
      'path' => '/foo/bar',
      'body' => 'Hello Buz!',
      'headers' => array(
        'Content-Type' => 'text/html; charset=UTF-8',
        'exclude' => array(
          'x-powered-by', 'x-pingback'
        )
      )
    )
  )
);
```

Naturally, you have to check for class existence (e.g. in `lib/routes.php` file):

```php
if (!class_exists('\WoR\Main')) {
  return;
}
```

And use it in `functions.php`:

```php
require_once('lib/routes.php');
```

Remember, because of using namespaces your PHP installation version must be [>= 5.3.0](http://www.php.net/manual/en/language.namespaces.rationale.php).

Extended Usage
===

At this point there are several capabilities:

1. Method declaration: GET, POST, DELETE, etc. In place where `'get'` is set.
2. Defining path like in example above.
3. Action callback: instead of `'body'` you can have `'action'` which will call any action defined by `add_action`. If both are defined, `action` takes precedence over `body`.
4. Define/exclude `headers` as new array.
5. Add / filter by agents.
