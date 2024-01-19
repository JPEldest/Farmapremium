# READ ME

This is a Laravel project built with PHP 8.1 and Docker.

## Getting Started

### Prerequisites

Before you begin, ensure you have the following:

- [PHP](https://www.php.net/) 8.1 or higher
- [Composer](https://getcomposer.org/) - Dependency Manager for PHP
- [Docker](https://www.docker.com/)

### Usage

1. Clone the repository from git to get the project:

    ```bash
    git clone https://github.com/JPEldest/Farmapremium.git
    ```
2. Copy the env. example to an env file

3. Start the Docker containers:

    ```bash
    docker-compose up --build
    ```

4. Run migrations to get the databases [DO NOT DO IT MYSQL IS NOT WORKING]:

    ```bash
    docker-compose exec app php artisan migrate
    ```

### Development

- To stop the Docker containers, run:

    ```bash
    docker-compose down
    ```

- If you need to rebuild the Docker containers, run:

    ```bash
    docker-compose up --build
    ```

### Development services

You can find the documentation of this api in the apidoc.yml file
And you can file the src files in the app folder

## Testing

To execute project's test, run:

```
php artisan test
```
### Comments and further development
First of all thanks for the opportunity to take part of this process.

Next steps for this project would be the integration tests and the acceptance tests.


