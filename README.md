# Lumen PHP Framework

[![Build Status](https://travis-ci.org/laravel/lumen-framework.svg)](https://travis-ci.org/laravel/lumen-framework)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel/framework)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Stable Version](https://img.shields.io/packagist/v/laravel/framework)](https://packagist.org/packages/laravel/lumen-framework)
[![License](https://img.shields.io/packagist/l/laravel/framework)](https://packagist.org/packages/laravel/lumen-framework)

Laravel Lumen is a stunningly fast PHP micro-framework for building web applications with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Lumen attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as routing, database abstraction, queueing, and caching.

## Project Run Steps
Database: Create a database named `product-crud`. Make sure that `.env` file database information is synced with current environment.
Command: Run with `php -S localhost:8000 -t public`.

## Endpoints



|    Request Method            |Endpoint                          |Desciption                         |
|----------------|-------------------------------|-----------------------------|
|GET|`/products`            |Return All Products            |
|GET|`/product/1`            |Return product with id equals 1            |
|POST          |`/product?_method=post`|Creates a product|
|PUT          |`/product/1?_method=put`|Updates a product with id as 1|
|DELETE          |`/product/1?_method=delete`|Deletes a product with id as 1|