#Koala.io Code Test

##Installation
1. Clone, or extract the zip file into a directory.

2. Open a terminal window and copy `.env.docker` to `.env`
3. Run `./bin/sail up --build -d`. This will build the Docker containers, set up the project including Composer dependencies, database migration, and seed restaurant data needed for the code test.
4. The application can be accessed in a web browser/Postman/curl/http client of choice at:
   `http://localhost:80`

**NOTE:** The application port can be changed in case port 80 is taken by another process by modifying the `APP_PORT` value in the `.env` file.

##Usage
Please refer to the Postman collection `Koala.io Code Test.postman_collection.json`, or the OpenAPI yaml file `Koala.io Code Test.postman_collection.json-OpenApi3Yaml.yaml` included in this repo for documentation.
Available endpoints
* `GET /brands` - List of brands registered in the api
* `GET /koala` - The Koala brand
* `GET /koala/locations` - All locations associated with the Koala brand
* `GET /koala/locations/{id}` - A single location associated with the Koala brand
* `GET /koala/locations/{id}/menu` - The menu associated with the location

###Strategy
My goal was to set up a system to easily configure data mapping for both JSON and XML sets of data.
Feed parsing makes heavy use of Dependency Injection to read data from JSON and XML formats, and translate that data into a common set of models that represent brands, locations, and their menus.

The hierarchy between those models are set up as a simple tree structure.

    - Brand
        - Location
            - Menu
                - Category
                    - Item
                    - Item
                    ...
                - Category
                    - Item
                    - Item
                    - Item
                    ...

Some assumptions have been made for the purpose of the code test.
* There is only one brand - "Koala"
* Locations can only have one menu
* Menus do not have a default "root" category. If the item does not have a category, then it is not added to a menu.
* Location hours and holidays are not implemented

###Further Improvements
* Api responses could be cleaned up a bit by making use of model resources. Some data, like `feed_id`s, not meant for public consumption.
* There is a lot of data in the menu and location feeds that were not used in this api.   
    * Location hours and holidays
    * Variants, options, add-ons, and prices for menu items
    * Menu availability for items - e.g. Breakfast and Lunch, Limited time only
    * Time dependent items


<hr>
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
