## Language Group

### A PHP command line application without using a framework (Symfony, laravel, etc...) that will list all the countries which speaks the same language or checks if given two countries speak the same language by using open rest api:​ ​`https:// restcountries . eu/`

### Requirements:

It used following requirements:

* OOP
* SOLID Principles
* Clean codeUsage of followings will considered as a plus:
* PHP7
* Input validation
* Open sourcing on GitHub
* Using composer as package management (as less package as possible)
* Design patterns
* Unit test

### How to install

1. Clone the repo https://github.com/dhirajpatra/language_group_php_frame_less.git into your project directory
2. Run: `composer install`
3. Run test: `./vendor/bin/phpunit --bootstrap vendor/autoload.php tests/LanguageTest.php`

### How to run from command line

1. It executable from console by giving country name as parameter:

`​php public/index.php Spain`

[Output]
Country language code: es
Spain speaks same language with these countries: Uruguay, Bolivia, Argentina..

2. In case of two parameters given, application should tell if the countries talking the same
language or not. Use double quote for more than one word long country name.

`php public/index.php Spain England` 

or

`php public/index.php "Spain" "United Kingdom"`

[Output]
Spain and England do not speak the same language

### Further implement possible

You can use cache to keep similar kind of command. 
Also API can be called batch wise. 
You can use Database. 
With DI [already installed], middle ware eg. relay, zend-diactoros,  fast-rout, request-handler, response interface, http-emitter can create a powerful framework itself to provide as API back end for any application.  

### Thank you