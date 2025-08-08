# Установка 

## 1 cp .env.example .env
## 2 docker-compose up -d
## 3 docker-compose exec app composer install
## 4 docker-compose exec app php artisan key:generate
## 5 docker-compose exec app php artisan storage:link
## 6 docker-compose exec app php artisan migrate
## 7 docker-compose exec app php artisan db:seed
## 8 docker-compose exec app php artisan create:admin
## 9 http://localhost/admin
