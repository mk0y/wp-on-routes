=== WordPress on Routes ===
Contributors: markzero
Tags: routes, path, HTTP method, custom paths, custom parameters, query, headers, exclude header, agent, filter agents
Requires at least: 3.8
Tested up to: 4.1.1
Stable tag: 0.2.0

This plugin adds API-like functionality to your WordPress instance.

== Description ==

WordPress on Routes is a plugin for WordPress, inspired mainly by Ruby micro-frameworks. It adds ability to add custom routes to your WordPress instance. Useful for form submissions, API-like features, etc.

This plugin allows you to:

1. Add custom routes to your WordPress installation
1. Set method GET/POST/DELETE etc.
1. Set body (as text, or template) or action (using add/do_action). If both are defined, `action` takes precedence over `body`.
1. Set header (e.g. 'Content-Type' => 'text/html; charset=UTF-8')
1. Exclude header (e.g. 'Set-Cookie')
1. Set parameter like '/my/route/:param1/:param2'
1. Add agents or filter by agents, using regular expressions
1. Agent filter for negative logic (e.g. /^((?!Firefox).)*$/, which tells "every browser except Firefox")*
1. Include header and footer

For basic and advanced usage examples, take a look at [https://github.com/markzero/wp-on-routes](https://github.com/markzero/wp-on-routes).

== Installation ==

Good old plugin installation applies here too - download it / clone it to `plugins/` dir, activate.

If you want to clone it, here is the repository: [https://github.com/markzero/wp-on-routes](https://github.com/markzero/wp-on-routes)

No UI involved.

== Changelog ==

= 0.3.0 =
* Added predefined path `/posts.json` to get all posts list as application/json response

= 0.2.0 =
* Added test environment and some tests for methods, parameters and splats
