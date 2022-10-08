docker-compose up -d --build
docker exec -i -u root dockyard chmod 777 -R storage
docker exec -i -u root dockyard php -r "file_exists('.env') || copy('.env.example', '.env');"
docker exec -i -u root dockyard composer install
docker exec -i -u root dockyard php artisan key:generate
docker exec -i -u root dockyard php artisan migrate