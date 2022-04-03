# Vending Machine

You can find Postman Collection blew
## Postman collection
```https://www.getpostman.com/collections/249a453e07bba954f7eb```

## Steps to Run with Docker
- clone the repo 
    ```git clone git@github.com:AbdelrhamanAmin/vending-machine.git ```
- Switch to the repo directory 
    ```cd vending-machine```
- Copy the example env file and make the required configuration changes in the .env file
    ```cp .env.exmple .env```
- run
    ```
    docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
    ```
    
- Start the app
    ```./vendor/bin/sail up -d```
    ```./vendor/bin/sail artisan key:generate```
- Run migrations 
    ```./vendor/bin/sail artisan migrate ```
