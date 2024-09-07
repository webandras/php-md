# PHP-MD static site generator

[![Netlify Status](https://api.netlify.com/api/v1/badges/95c7fae2-38c4-4aca-a24f-f5b77a327ecf/deploy-status)](https://app.netlify.com/sites/phpmd/deploys)

A PHP-based static site generator that uses pure PHP and Markdown. Deploy your website to any shared hosting platforms.

Todo: Create the documentation.

## Basic usage

Generate the posts (), the index page, and the archive page:

```php
php generate.php --env=dev
```

For production, use a value other that "dev" for the `env` argument.

## Structure

The `\posts` folder contains all the blogposts in markdown files.
The `\templates\views` contains the templates used for the pages.
The `\templates\partials` folder contains specific parts of the website (header, footer, introduction, post header, breadcrumb, and meta).

## License

MIT © András Gulácsi 2024 - MIT license