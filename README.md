### Kurulum

Bir geliştirme ortamını kurma adımları:

1. Projeyi klonlayın:
    ```
    git clone https://github.com/turkayaltintas/laravel-api-project.git
    ```
2. Bağımlılıkları Composer ile yükleyin:
    ```
    cd laravel-api-project
    composer install
    ```
3. `.env` dosyasını yapılandırın:
    ```
    cp .env.example .env
    ```
4. Uygulama anahtarını oluşturun:
    ```
    php artisan key:generate
    ```
5. Veritabanını ve kullanıcıları oluşturun (öncelikle `.env` dosyanızda veritabanı ayarlarınızı yapılandırın):
    ```
    php artisan migrate
    php artisan db:seed
    php artisan db:seed --class=UsersTableSeeder
    ```

Sonra tarayıcınızda `http://localhost:8000` adresini ziyaret edin.

## Postman Collection

Bu projenin Postman Collection'ını [buradan](https://github.com/turkayaltintas/laravel-api-project/blob/main/Laravel%20API%20Collection.postman_collection.json) indirebilirsiniz.

Postman Collection : 
```
    Laravel API Collection.postman_collection.json
```
