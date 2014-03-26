=== WordPress on Routes ===

Contributors: markzero

Tags: routes, custom paths, custom parameters, query, headers, exclude header, agent, filter agents, mustache

Requires at least: 3.8

Tested up to: 3.8

Stable tag: 0.1.0



This plugin adds API-like functionality to your WordPress instance.



== Description ==

This plugin allows you to:
1. Add custom routes to your WordPress installation
2. Set method GET/POST/DELETE etc.
3. Set body (as text, or template) or action (using add/do_action)
4. Set header (e.g. `Content-Type` => `text/html; charset=UTF-8`)
5. Exclude header (e.g. `Set-Cookie`)
6. Set parameter like `/my/route/:param1/:param2?` and use splats (`/foor/*/bar`)
7. Add agents or filter by agents, using regular expressions
8. Agent filter for negative logic (e.g. `/^((?!Firefox).)*$/`, which tells "every browser except Firefox")
9. Use Mustache templating with query parameters
10. Define content without having page template (includes header & footer)
