# Project 7 OpenClassrooms - Create a web service exposing an API

[![Maintainability](https://api.codeclimate.com/v1/badges/98be662baf14115d9a0d/maintainability)](https://codeclimate.com/github/FloStn/P7/maintainability)

## Context

Student project realized as part of an OpenClassrooms training course.

## Installation

First, make sure that [Composer](https://getcomposer.org) is installed.

**Install project dependencies**

``` bash
composer install
```
**Configure your database in the .env file**

``` env
DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name
```

**Create the database**

``` bash
php bin/console doctrine:database:create
```
**Generate the JWT SSH keys**

``` bash
mkdir -p config/jwt
openssl genrsa -out config/jwt/private.pem -aes256 4096
openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem
```
**Configure the SSH keys path in your `config/packages/lexik_jwt_authentication.yaml`**

``` yaml
lexik_jwt_authentication:
    secret_key:       '%kernel.project_dir%/config/jwt/private.pem' # required for token creation
    public_key:       '%kernel.project_dir%/config/jwt/public.pem'  # required for token verification
    pass_phrase:      'your_secret_passphrase' # required for token creation, usage of an environment variable is recommended
    token_ttl:        3600
```

For more information about the JWT bundle, please refer here [here](https://github.com/lexik/LexikJWTAuthenticationBundle/tree/8c897a098280547871be35954d1d7006a3711d30).

## Load data fixtures (optional)

``` bash
php bin/console hautelook:fixtures:load
```
And confirm by pressing the "y" key.
