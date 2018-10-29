#Notes
- Instead of symfony 3.4 I use symfony 4.1 in this project as it's the latest stable version. 
- This code runs only in development environment and have not been tested in production
- Additionally I use Semantic-UI here as CSS framework to get rid of design issues
- I will need php 7 and higher to run the code and nodeJS installed as symfony 4 shipped with [webpack encore](https://symfony.com/doc/current/frontend.html) which uses nodeJS

#Installation
- `git clone https://github.com/letchik/address-book.git`
- `cd address-book`
- `composer install`
- `yarn install` or `npm install`
- `yarn encore dev` or `npm run encore dev`
- `bin/console doctrine:migrations:migrate`
- `bin/console server:run`
- go to http://localhost:8000

#tests
Just run `phpunit` from the root folder.

--

Cheers
