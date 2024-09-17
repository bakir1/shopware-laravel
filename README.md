<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

Shopware-Laravel Project
Overview
This is a Laravel-based web application that integrates with Shopware via the Shopware Store API and Shopware Admin API. The project was built using Laravel Livewire to dynamically fetch and manage products, including editing product information and associating products with manufacturers.

Features
Database Integration:

A local database table, manufacturers, was created with 10 records populated via factory.
A pivot table (manufacturer_products) was implemented to link products with manufacturers.
Shopware API Integration:

Products are fetched from the Shopware demo store using the Store API.
Only active products are displayed in a Livewire component.
A modal interface allows users to modify product prices and stock, which are updated via the Shopware Admin API.
Dynamic Frontend:

Laravel Livewire is used to dynamically display products in a table format.
A modal is triggered when editing a product, allowing the user to select a manufacturer and update product details.
Technical Stack
Backend: Laravel, PHP
Frontend: Livewire, Blade templates
Database: MySQL (local)
External APIs: Shopware Store API, Shopware Admin API
Tools: Guzzle for API requests
How to Run the Project Locally

Clone the repository:
bash

git clone https://github.com/bakir1/shopware-laravel.git

Install dependencies:

composer install

npm install

Set up the environment:
Copy the .env.example to .env and configure your database settings.
Run the migrations and seeders to create the necessary tables:

php artisan migrate --seed

Start the local server:

php artisan serve

Compile the assets:

npm run dev

Known Issues
API Integration: At this time, there is an issue fetching products from the Shopware demo store. The Store API returns a 401 Unauthorized error due to an incorrect or missing sw-access-key for the specified Sales Channel. This is an external configuration issue, and the API implementation itself is correct and functional when provided with the appropriate access key.

The issue is tied to the incorrect configuration of the Sales Channel API access key (sw-access-key). Once the correct key is provided, the system will function as expected.

What Works
The local environment, database setup, and product management functionalities work as expected.
The user interface for fetching, displaying, and updating products is fully implemented using Laravel Livewire.
The functionality to link manufacturers with products via the pivot table is also implemented and ready to use.

Next Steps
Resolve the sw-access-key Issue: The current Shopware demo environment requires a valid sw-access-key. Once the correct access key is obtained, the Store API will function properly, and the product fetching feature will work without errors.

Extend Features: There are opportunities to extend the application by adding more product management features or integrating additional Shopware APIs (e.g., for categories or orders).

Conclusion
This project demonstrates the integration of Laravel with external APIs (Shopware) while maintaining a dynamic, user-friendly interface. 
All core functionalities are in place, with only an external configuration issue preventing the final deployment of product fetching from Shopware.

Feel free to reach out with any questions or suggestions!
