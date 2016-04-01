# Note for Posts and WordPress Plugin Boilerplate

Adding note to Wordpress post or any post types such as page, attachment, woocommerce products, easy digital downloads and other registered Wordpress Post Type.

Employs the best coding pratices for you to create your own plugin by providing you a quick TODOs to make an easier modification and customization.

## Quick TODOs
Just find and replace text using your favorite editor such as sublime, notepad++, text wrangler, etc
> Only Replace If You Are Creating Your Own Plugin
 * @todo replace Plugin Name
 * @todo replace Plugin URI
 * @todo replace Description
 * @todo replace Version
 * @todo replace Text Domain
 * @todo replace Author
 * @todo replace Author URI

Find and Replace to each files.
 * @todo `Note_For_Posts` Main Class Name. Find all and replace text
 * @todo `N4P` - Prefices for Classes. Find all and replace text
 * @todo `n4p` - Prefixes for Functions. Find all and replace text
 * @todo `note` - Post Type. Find all and replace text
 * @todo `NOTE_FOR_POSTS` - Constant. Find all and replace text

Don't forget to change the filename to your own custom plugin.


## Contents

The Note for Posts Plugin includes the following files:

* `.gitignore`. Used to exclude certain files from the repository.
* `CHANGELOG.md`. The list of changes to the core project.
* `README.md`. The file that you’re currently reading.
* A `note-for-posts` directory that contains the source code - a fully executable WordPress plugin.

## Features
* Able to add custom notes (testimonials, feedbacks, comments, etc) to a particular post type such as page, post, product (Woocommerce), download (Easy Digital Downloads), and other registered post type.
* Able to display results through widget and shortcode.
* The Boilerplate is based on the [Plugin API](http://codex.wordpress.org/Plugin_API), [Coding Standards](http://codex.wordpress.org/WordPress_Coding_Standards), and [Documentation Standards](https://make.wordpress.org/core/handbook/best-practices/inline-documentation-standards/php/).
* All classes, functions, and variables are well-documented so that you know what you need to be changed.
* The Boilerplate uses a strict file organization scheme that correspond both to the WordPress Plugin Repository structure, and that make it easy to organize the files that compose the plugin.
* The project includes a `.pot` file as a starting point for internationalization.

## Installation

Note that this will activate the source code of the Boilerplate, with real functionalities such as meta boxes, custom post type, shortcodes, taxonomies, admin settings.

## Recommended Tools

### i18n Tools

The WordPress Plugin Boilerplate uses a variable to store the text domain used when internationalizing strings throughout the Boilerplate. To take advantage of this method, there are tools that are recommended for providing correct, translatable files:

* [Poedit](http://www.poedit.net/)
* [makepot](http://i18n.svn.wordpress.org/tools/trunk/)
* [i18n](https://github.com/grappler/i18n)

Any of the above tools should provide you with the proper tooling to internationalize the plugin.

## License

The WordPress Plugin Boilerplate is licensed under the GPL v2 or later.

> This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License, version 2, as published by the Free Software Foundation.

> This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

> You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA

A copy of the license is included in the root of the plugin’s directory. The file is named `LICENSE`.

## Important Notes

### Licensing

The WordPress Plugin Boilerplate is licensed under the GPL v2 or later; however, if you opt to use third-party code that is not compatible with v2, then you may need to switch to using code that is GPL v3 compatible.

For reference, [here's a discussion](http://make.wordpress.org/themes/2013/03/04/licensing-note-apache-and-gpl/) that covers the Apache 2.0 License used by [Bootstrap](http://twitter.github.io/bootstrap/).

### Includes

Note that if you include your own classes, or third-party libraries, there are three locations in which said files may go:

* `note-for-posts/includes` is where functionality shared between the admin area and the public-facing parts of the site reside
* `note-for-posts/includes/admin` is for all admin-specific functionality
* `note-for-posts/language` is for languages


# Credits
Official Wordpress Documentation
Wordpress Functions was created by [Elvin D.](https://twitter.com/esstat17).
[WordPress Plugin Boilerplate](https://github.com/DevinVinson/WordPress-Plugin-Boilerplate) - A standardized, organized, object-oriented foundation for building high-quality WP Plugins
[EDD Extension Boilerplate](https://github.com/easydigitaldownloads/EDD-Extension-Boilerplate) serves as a foundation and aims to provide a standardized guide for building extensions. 

## Documentation, FAQs, and More
If you’re interested in writing any documentation or creating tutorials please [let me know](http://innovedesigns.com/contact/)
