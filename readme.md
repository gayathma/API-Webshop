<p align="center">API Webshop</p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About API Webshop

This is the implementation of a simplified mini webshop. It consists of customers, products and orders. The goal is first to import CSV files with some example data and then create an API for orders.

## Installation

* type `git clone git@github.com:gayathma/API-Webshop.git` to clone the repository or download as a zip file and unzip it in your folder.  
* type `cd API-Webshop`
* type composer install
* copy *.env.example* to *.env*
* create database `api_webshop` using mysql 
* update `DB_DATABASE, DB_USERNAME, DB_PASSWORD` values in .env file
* this application require php 7.1.3 or higher version.
* type `php artisan migrate` to migrate the user tables
* type `php artisan passport:install` to install laravel passport 
* type `php artisan db:seed` to seed the master data from csv files
* type `php artisan serve` with the given url you can access the application in the browser
* you can create a new user using the 'Register' menu item. And then login into the system using the credentials.

## Scenarios
* Register Endpoint
Method `POST` URL `/api/register`

Headers
```
Content-Type     : application/json
X-Requested-With : XMLHttpRequest
```
Body
```
{
"name": "Gemma_King2441",
"email":"Gemma_King2441@cispeto.com",
"password":"Gemma_King2441@cispeto.com"
}
```
![Alt text](/screenshots/register.png?raw=true "Register Endpoint")

* Login Endpoint to get the token
Method `POST` URL `/api/login`

Headers
```
Content-Type     : application/json
X-Requested-With : XMLHttpRequest
```
Body
```
{
"email":"Gemma_King2441@cispeto.com",
"password":"Gemma_King2441@cispeto.com"
}
```
![Alt text](/screenshots/login.png?raw=true "Login Endpoint")

* Create order Endpoint
Method `POST` URL `/api/orders`

Headers
```
Content-Type        : application/json
Authorization       : Bearer <token>
```
Body
```
{
	"customer_id": 50
}
```
![Alt text](/screenshots/create.png?raw=true "Create Order Endpoint")

* List orders Endpoint
Method `GET` URL `/api/orders`

Headers
```
Authorization : Bearer <token>
```
![Alt text](/screenshots/list.png?raw=true "List Orders Endpoint")


* Show order Endpoint
Method `GET` URL `/api/orders/<order_id>`

Headers
```
Content-Type        : application/json
Authorization       : Bearer <token>
```
![Alt text](/screenshots/show.png?raw=true "Show Order Endpoint")

## Tests

* This API has been developed using Test Driven Development. PHPUnit is used to run the testcases. Navigate to the project root and run `composer test` after installing all the composer dependencies and after the .env file was created.

## License

The Laravel framework is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
