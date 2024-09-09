<p align="center">
    <a href="https://sylius.com" target="_blank">
        <picture>
          <source media="(prefers-color-scheme: dark)" srcset="https://media.sylius.com/sylius-logo-800-dark.png">
          <source media="(prefers-color-scheme: light)" srcset="https://media.sylius.com/sylius-logo-800.png">
          <img alt="Sylius Logo." src="https://media.sylius.com/sylius-logo-800.png">
        </picture>
    </a>
</p>

<h1 align="center">Sylius Workshop</h1>

<p align="center">This is Sylius Standard Edition repository for learning about Sylius.</p>

## Documentation

Documentation is available at [docs.sylius.com](http://docs.sylius.com).

## Installation

### Docker

- Make sure you have installed [Docker](https://docs.docker.com/get-docker/) and Docker Compose on your local machine.
- Run docker-compose build
- Run docker-compose up -d
- Execute `make install` in your favorite terminal and wait some time until the services will be ready.
  Then enter `localhost` in your browser or execute `open localhost` in your terminal.

There are some useful commands that you can use:
- `make install` - install the project
- `make rdb` - recreate the database
- `make frontend` - install frontend dependencies
- `make php-shell` - enter the PHP container'
