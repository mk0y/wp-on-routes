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

```php
function wor_dump() {
  var_dump($_GET);
}

add_action('wor_action', 'wor_dump');

$routing = \WoR\Main::get_instance();

$routing->add_routes(
  array(
    'get' => array(
      'path' => '/foo/*/bar/:p1?',
      'action' => 'wor_action',
      'agent' => '/Firefox/',
      'include_template' => true
    )
  )
);
```

In example above, if you target `/foo/a/b/c/bar/test`, browser will answer with HTTP status 200, with following code, with header and footer included, only in Firefox browser:

```
array (size=2)
  'p1' => string 'test' (length=4)
  'splats' => 
    array (size=1)
      0 => string 'a/b/c' (length=5)
```




Details
===

At this point there are several capabilities:

1. Add custom routes to your WordPress installation
2. Set method GET/POST/DELETE etc.
3. Set body (as text, or template) or action (using add/do_action). If both are defined, `action` takes precedence over `body`.
4. Set header (e.g. 'Content-Type' => 'text/html; charset=UTF-8')
5. Exclude header (e.g. 'Set-Cookie')
6. Set parameters like `/my/route/:param1/:param2` or as splats `/foo/*/bar`
7. Add agents or filter by agents, using regular expressions
8. Agent filter for negative logic (e.g. `/^((?!Firefox).)*$/`, which tells "every browser except Firefox")
9. Include header and footer


Options you can set:

1. `path` (string)
2. `body` OR `action` (string)
3. `agent` (string/regex)
4. `include_template` (boolean; default: false)
5. `headers` (array)
  + `exclude` (array)



Tests
===

Reference to tests/instructions.txt to read how to test output of your WordPress website.
