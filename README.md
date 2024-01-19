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
First of all thanks for the opportunity to take part of this process. I enjoyed a lot to code as I used to.

Next would be that the dockerization has been not as good as I wanted to be. My personal laptop was not ready for the task, so in installing and getting it ready I lost a fair amount of time that could have gone to the code. That is the reason the mysql implementation is not working properly, since I could not manage to connected it as I should, or I would have been able but it would have left so little time to the coding itself.

This project is not over yet. There is always room for improvement. 
The first thing would be fixing the mysql container in docker. 
It is not allowing me to connect to the DB, 
for that reason I could not test the application outside the tests or run the migrations.
I would have also loved to install a makefile or something similar, but I decided not to use time on that for such a small project
I also did not have time to use proper TimeDate objects in the actions that require checking the creation time.
Next steps for this project would be the integration tests and the acceptance tests, that I had not time to do, what leaves me only with the Unit tests.
Also a proper error management system is missing, with try and catches to provide better answers with more information about the errors to the user.
And fixing the routes, for some reason I had problems with laravel routing, for this reason I left all the parameters in the path, but that does not make sense to the calls.

Thank you very much, I would like to receive feedback from you about this if you have the time to spare.

Sincerely,
Joan Palleja


