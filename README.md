# SVG ID Prefixer Addon for Statamic

This Statamic addon extends the functionality of the original SVG tag by introducing a new attribute, `replace_ids="true"`. When this attribute is added to the SVG tag, the addon automatically prefixes all IDs within the SVG with a unique identifier, preventing conflicts with duplicate IDs from multiple embedded SVGs on a single page.

## Why Use This Addon?

Avoid ID conflicts when embedding multiple SVGs on a single page. This addon provides a convenient solution to ensure unique IDs within SVG elements, enhancing compatibility and preventing unintended styling or scripting issues.

## How to Install

You can run the following command from your project root:

``` bash
composer require mundgold/svg-tag-unique-id
```

## How to Use
Simply include the `replace_ids="true"` attribute in your Statamic SVG tag:

```
{{ svg replace_ids="true" path="path/to/your/svg/file.svg" }}
```

## License
This addon is open-sourced software licensed under the MIT license.
