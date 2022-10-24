set -o xtrace
git clean -xfd
touch database/database.sqlite
cp .env.example .env
docker run -it --rm -v $(pwd):/app -w /app -u 1000:1000 node bash -c "npm install --silent 1&> /dev/null && npm run dev 1&> /dev/null"
docker-compose up -d --force-recreate
docker-compose exec app composer install
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan migrate
docker-compose exec app php artisan test