#!/bin/sh

# Check if we can connect to the database
echo -e "\e[32mTesting connection to MySQL\e[0m"
while ! mysqladmin ping -h${DB_HOST} --silent; do
   echo -e "\e[32mWaiting on database connection...\e[0m"
   sleep 5
done

echo -e "\e[32mPreparing ENV\e[0m"
if [[ "${STAND}" = "dev" ]]; then
    echo -e "\e[32mPreparing dev\e[0m";
    templater /var/www/html/.env.dev -s > /var/www/html/.env;
elif [[ "${STAND}" = "loc" ]]; then
    echo -e "\e[32mPreparing loc\e[0m";
    templater /var/www/html/.env.loc -s > /var/www/html/.env;
fi

if [[ "${STAND}" = "loc" ]]; then
   echo -e "\e[32mInstall vendor\e[0m"
   composer install --prefer-dist --no-progress --no-interaction
fi

php artisan storage:link

# start all the services
echo "Starting services"
exec crond -f -l 2 -L /dev/stdout