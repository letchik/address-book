# Notes
- Instead of symfony 3.4 I use symfony 4.1 in this project as it's the latest stable version. 
- This code runs only in development environment and have not been tested in production
- Additionally I use Semantic-UI here as CSS framework to get rid of design issues
- It will need php 7 and higher to run the code and NodeJS installed as symfony 4 shipped with [webpack encore](https://symfony.com/doc/current/frontend.html) which uses NodeJS

# upd:
- I removed Webpack Encore dependency since NodeJS is not allowed. On the other side, Webpack Encore is a recommended bundling tool even for Symfony 3.4 (https://symfony.com/doc/3.4/frontend.html). That's not clear for me why NodeJS is still an issue. 

# Installation
- `git clone https://github.com/letchik/address-book.git`
- `cd address-book`
- `composer install`
- `bin/console doctrine:migrations:migrate`
- `bin/console server:run`
- go to http://localhost:8000/contacts

# Tests
Just run `bin/phpunit` from the root folder.

--

Cheers
