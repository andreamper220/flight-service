# flight-service

sudo apt update

sudo apt install postgresql postgresql-contrib

sudo apt-get install php8.0-pgsql

sudo -u postgres createuser -P -s -e flight (ввести свой пароль)

php bin/console secrets:set DATABASE_PASSWORD (тот же пароль, что и выше)

sudo -u postgres createdb flight

php bin/console doctrine:migrations:migrate

php bin/console doctrine:fixtures:load
