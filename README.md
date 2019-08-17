## Language Group

### A PHP application without using a framework (Symfony, laravel, etc...) that will list all the countries which speaks the same language or checks if given two countries speak the same language by using open rest api:​ ​https://restcountries.eu/

### Requirements:

Hints:
To get the country by given parameter:
https://restcountries.eu/rest/v2/name/{name}?fullText=true
To get the list of countries speak a language by language code:
https://restcountries.eu/rest/v2/lang/{et}


### Notes:

Usage of followings is a requirement:
● OOP
● SOLID Principles
● Clean codeUsage of followings will considered as a plus:
● PHP7
● Input validation
● Open sourcing on GitHub
● Using composer as package management (as less package as possible)
● Design patterns
● Unit test

### How to install

1. Clone the repo https://github.com/dhirajpatra/language_group_php_frame_less.git into your project directory
2. Run: composer install
3. Run following commands

1-) It executable from console by giving country name as parameter:
-> `​php public/index.php Spain`
[Output]
Country language code: es
Spain speaks same language with these countries: Uruguay, Bolivia, Argentina..

2-) In case of two parameters given, application should tell if the countries talking the same
language or not
->​ `php public/index.php Spain England` or `php public/index.php "Spain" "United Kingdom"`
[Output]
Spain and England do not speak the same language