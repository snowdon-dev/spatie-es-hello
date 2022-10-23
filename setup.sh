touch database/database.sqlite
cp .env.example .env
php artisan key:generate

# start queue etc