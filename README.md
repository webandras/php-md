# PHP-MD static site generator

A PHP-based static site generator that uses pure PHP and Markdown. Deploy your website to any shared hosting platforms.

## Basic usage

Generate the posts (from the `/posts` folder) and the blog's index page (see the `\templates\index.php` template):

```php
php generate.php
```

The `\templates\single.php` template is used for the blogposts.
The `\templates\partials` folder contains specific parts of the website (header, footer, side-menu).

## License

MIT © András Gulácsi 2024 - MIT license