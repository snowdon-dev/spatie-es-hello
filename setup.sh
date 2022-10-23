set -o xtrace
git clean -xfd
touch database/database.sqlite
cp .env.example .env
npm install && npm run dev
docker-compose up -d --force-recreate
docker-compose exec app rm -rf vendor composer.lock
docker-compose exec app composer install
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan migrate
docker-compose exec app php artisan test