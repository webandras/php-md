# PHP-MD static site generator

[![Netlify Status](https://api.netlify.com/api/v1/badges/95c7fae2-38c4-4aca-a24f-f5b77a327ecf/deploy-status)](https://app.netlify.com/sites/phpmd/deploys)

A PHP-based static site generator that uses pure PHP and Markdown. Deploy your website to any shared hosting platforms.

Todo: Create the documentation.

## Basic usage

Generate the posts (from the `/posts` folder) and the blog's index page (see the `\templates\index.php` template):

```php
php generate.php
```

The `\templates\single.php` template is used for the blogposts.
The `\templates\partials` folder contains specific parts of the website (header, footer, side-menu).

## License

MIT © András Gulácsi 2024 - MIT license