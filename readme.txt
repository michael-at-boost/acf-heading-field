=== ACF Heading Field ===
Contributors: basicbydesign
Tags: seo headings, acf, heading field, seo help, seo tools
Requires at least: 5
Tested up to: 6.1.1
Stable tag: 1.0.0
Requires PHP: 7.0
License: MIT
License URI: https://opensource.org/licenses/MIT

A lean text entry field with selector for HTML heading level for ACF.  

== Description ==

Any text that might have SEO value can be given the correct header value from WP Admin.
Decouple SEO updates from code changes.

![ScreenShot](screenshots/acf-heading-field-buttons.png)  

![ScreenShot](screenshots/acf-heading-field-dropdown.png)  

Allow frontend users to make SEO decisions about heading levels.

== Configuration ==

Per field:
* Button group or select UI
* Default element
* Return HTML (markup) or data array
* (Optional) CSS class to include with HTML markup return

(see screenshots above).


== Markup ==

Returns a single HTML element with optional CSS class. 
```html
<h1>your text</h1>
```
```html
<h1 class='your-class'>your text</h1>
```
(where h1 is the selected heading level.)

== Data ==
Returns data in an array.
```php
[ 
  'text' => 'your text',
  'level' => 'h1'
]
```

== Screenshots ==

1. Heading buttons
2. Heading dropdown
2. Field settings

== Changelog ==

= v1.0.0 =
Added default values.
Initially the default tag is <p>
This can be overwritten theme-wide and per field.

= v0.9.1 =
Release candidate for v1.  
Seems to be working fine but hasn't been battle tested.  
Thanks for submitting any issues that you come across.

