# Symfony REST Application (Test task for "PHP Symfony Developer (Middle-Senior)" vacancy)

This is a a dockerized test project designed to calculate the price of products, applying taxes and coupons and processing payments.

## Information

This project uses the latest versions of Symfony, PHP and PostgreSQL.
I decided on using Docker as it is far easier to setup and it doesn't need you to download and install composer, have the right PHP version, etc.
Also using Docker makes it only a few tweaks away to be production ready.

Apart from the classic Symfony/Laravel directory structure, we have a `/tests` folder, which contains the PHPUnit tests. A `/dockerfiles` folder that contains both app and database Dockerfiles. And a `/config` directory that holds all configurations (except the .env file and composer packages).

For the Docker HTTP server I used `php-fpm`, `nginx` and `supervisor`. And for the database I chose a PostgreSQL database with the fixtures already loaded in the initialization folder.

## Setup

To get the project up and running follow these prerequisites and steps:

### Prerequesites

- Have Docker and Docker Compose installed.

### Steps

1. Clone the repo:
```bash
git clone https://github.com/alejosagues/symfony-rest-test.git
```

2. Build and run using Docker Compose:
```bash
docker compose up --build
```

3. Once you finish using it, delete the containers:
```bash
docker compose down
```

## Endpoints

This app provides two endpoints:
- `POST /calculate-price`: Given a product an european tax number and optionally a coupon code, returns the price to pay for that product.
- `POST /purchase`: Completes the purchase of the product using those calculations, letting you choose the payment processor.

## Usage

Use any HTTP client to make requests to the app, using your local ip. Here are some examples using curl:

### Calculate Price
```bash
curl --location 'http://localhost:8000/calculate-price' \
--header 'Content-Type: application/json' \
--data '{
    "product": 1,
    "taxNumber": "DE123456789",
    "couponCode": "P10"
}'
```

### Purchase
```bash
curl --location 'http://localhost:8000/purchase' \
--header 'Content-Type: application/json' \
--data '{
    "product": 1,
    "taxNumber": "DE123456789",
    "couponCode": "P10",
    "paymentProcessor": "paypal"
}'
```

## Testing

This project uses PHPUnit tests, you can run them following these steps:

1. Run the docker container.

2. Get into the container:
```bash
docker exec -i app sh
```

3. Run either of these commands:
```bash
./vendor/bin/phpunit
```
OR
```bash
php bin/phpunit
```
