# symfony_training

1) Download symphony CLI https://symfony.com/download
check :   symfony check:requirements

# Project Setup
2)  symfony new my_project_name --full 


composer update
symfony serve   //http://127.0.0.1:8000


bin/console doctrine:database:create
bin/console make:entity
bin/console make:migration
bin/console doctrine:migrations:migrate

## composer require orm-fixtures --dev
##  bin/console make:fixtures

bin/console make:crud
bin/console server:run