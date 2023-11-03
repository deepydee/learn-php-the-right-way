#!/bin/sh

Check if we can connect to the database
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
    echo -e "\e[32mPreparing dev\e[0m";
    templater /var/www/html/.env.loc -s > /var/www/html/.env;
elif [[ "${STAND}" = "stage" ]]; then
    echo -e "\e[32mPreparing stage\e[0m";
    templater /var/www/html/.env.stage -s > /var/www/html/.env;
elif [[ "${STAND}" = "prod" ]]; then
    echo -e "\e[32mPreparing prod\e[0m";
    templater /var/www/html/.env.prod -s > /var/www/html/.env;
fi

if [[ "${STAND}" = "loc" ]]; then
   echo -e "\e[32mInstall vendor\e[0m"
   composer install --prefer-dist --no-progress --no-interaction
fi

# if [[ "${APP_TYPE}" != "worker" ]]; then
#     echo -e "\e[32mStart migrations\e[0m"
#     if [[ "${STAND}" = "stage" ]] || [[ "${STAND}" = "prod" ]]; then
#         php artisan migrate --force
#     else
#         php artisan migrate
#     fi
# fi

# echo -e "\e[32mOptimize clear\e[0m"
# php artisan optimize:clear

# echo -e "\e[32mOptimize\e[0m"
# php artisan optimize

# echo -e "\e[32mlighthouse:cache\e[0m"
# php artisan lighthouse:cache

# php artisan storage:link

echo -e "\e[32mStarting services\e[0m"
if [[ "${APP_TYPE}" = "worker" ]]; then
    exec /usr/bin/supervisord -c /etc/worker.conf
else
    exec /usr/bin/supervisord -c /etc/supervisord.conf
fi
