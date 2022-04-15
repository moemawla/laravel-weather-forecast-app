# Weather Forecast application

## Overview
This application is a simple weather forecast application that allows users to select a city from a dropdown list and get the weather forecast in that city for the next 5 days.

It is built using PHP and Laravel, and it retrieves the weather information from the *Open Weather Map* API (https://openweathermap.org/)

## Requirements
Make sure you have php 7 (and above) and composer installed.

## Installation
After cloning the code from the repository:
* cd inside the project directory
* copy the .env.example file to .env file
* run ```composer install```
* run ```php artisan key:generate``` to generate application encryption key

## Running the app
* run ```./vendor/bin/phpunit``` to run the unit tests
* run ```php artisan serve``` to start serving the application locally
* open ```http://127.0.0.1:8000/``` in your browser to land on the main page 
