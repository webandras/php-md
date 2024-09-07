# PHP-MD static site generator

[![Netlify Status](https://api.netlify.com/api/v1/badges/95c7fae2-38c4-4aca-a24f-f5b77a327ecf/deploy-status)](https://app.netlify.com/sites/phpmd/deploys)

A PHP-based static site generator that uses pure PHP and Markdown. Deploy your website to any shared hosting platforms.

- Todo: Improve the documentation.
- Todo: Add search functionality (or at least enable the usage of Algolia)
- Todo: Add multi-language support to the site generator

## Build your website

Generate the posts, the index page, and the archive page:

```php
php generate.php --env=dev
```

For production, use a value other that "dev" for the `env` argument.

## Data / Template structure

The `\posts` folder contains all the blogposts in markdown files.
The `\templates\views` contains the templates used for the pages.
The `\templates\partials` folder contains specific parts of the website (header, footer, introduction, post header,
breadcrumb, and meta).

## Publishing a website to Netlify

[Register to Netlify](https://www.netlify.com/)

The `netlify.toml` configuration file contains important properties:

```raw
[build]
  base    = "/"
  publish = "public"
  command = "php generate.php --env=prod"
```

It tells Netlify the base path, the publish folder, and the command to run when building the website into the "public"
folder.

### netlify/build

Netlify builds website with its buildbot. It starts a Docker container running
the [Netlify build image](https://hub.docker.com/r/netlify/build/#!)

Netlify installs a lot of packages to be able to run the various tools to build a static
website. And this is done inside a [Docker container](https://docs.docker.com/get-started/).

When the Docker fires up, a script like this runs:*
https://github.com/netlify/build-image/blob/focal/run-build.sh

This was the Dockerfile from which the Netlify image is built (currently based on `ubuntu:20.04`, older Ubuntu base
images, like 16.04, are deprecated now):*
https://github.com/netlify/build-image/blob/focal/Dockerfile

_*Note that Netlify archived the public GitHub repo at Jan 25, 2023, and moved its build image to a private repository,
unfortunately.
So the above links does not show the up-to-date build image they use._

### CI/CD pipeline - processing stages

Netlify uses a CI/CD pipeline to perform numerous steps during the deployment stages (initializing, building, deploying,
cleanup, post-processing).

For example at the post-processing stage, it is processing the header rules (defined in the `_headers` file) and
redirection rules (defined in `_redirects` file).

## Configuration

In the `_headers` file you can specify the HTTP headers and set Content Security Policy (CSP) rules for the
Netlify server. You can also specify these in `netlify.toml`.

The `_redirects` file is currently empty. When you have a custom domain, you can make a redirect from _.netlify.com_ to
your custom domain there.

The `robots.txt` blocks indexing the /admin url.

## Netlify Forms

Netlify automatically discovers the contact form via a custom "netlify" attribute added to the form. A bot field is
present
in the form to protect against spam bots.

[Netlify Forms Docs](https://docs.netlify.com/forms/setup/)

## Decap CMS support

The `\public\admin` folder contains all configuration, files for the integration.

Steps to get started:

1. Enable Netlify Identity
2. Enable Git Gateway
3. Set registration to "invite only", and invite yourself
4. Add "/admin" segment to the verification link you receive in the invitation email
5. Add your password

[Decap CMS documentation](https://decapcms.org/docs/choosing-a-backend/#setup-on-netlify)

## Security

All the configuration (security headers, and content security policy - CSP) is here: `\public\_headers`.
Replace `phpmd.netlify.app` to your domain at the CSP settings where present.

CSP whitelist added for:

- Netlify,
- Decap CMS,
- Algolia,
- Cloudfront,
- Google Fonts,
- jsDelivr


## Supplementary information about Docker

A Docker container is basically a writable **OverlayFS** layer created on the very top of the numerous
read-only OverlayFS layers of the Docker image (files copied on top of each other: each layer represents a command in
the Dockerfile). A container is destroyed after the build has been completed (the top writable layer is removed).
However, the data can be made permanent using volumes (which are kept).

Docker is using the kernel and obviously the shared resources of the host (server), and is meant for process
isolation. Containers are more lightweight, and don't have the overheads Virtual Machines
do. [More about it](https://www.simplilearn.com/tutorials/docker-tutorial/docker-vs-virtual-machine).

The images are based on **base images** (the FROM statement at the first line of a Dockerfile) that are special
distributions that "think they are operating systems", but are more lightweight that a complete OS.

[Alpine Linux](https://hub.docker.com/_/alpine/) is the most lightweight of them (around 5MB).

Interesting to note,
that [images can built from scratch as well](https://codeburst.io/docker-from-scratch-2a84552470c8) (scratch is a
reserved image that is empty, and thus does nothing). The base images are built this way (_"FROM scratch"_).

Lots of images are **pre-built** for us (like the `netlify/build` image) and stored in the **Docker registry** (not
DockerHub, since that is just a user interface). There is no need to build them from Dockerfile, just to download them
from the registry.

## License

MIT © András Gulácsi 2024 - MIT license