# Проект Laravel

Это проект на базе Laravel.

## Установка

1. Клонируйте репозиторий:
   ```bash
       git clone https://github.com/Edinstvenij/laravel-example.git
   ```

2. Перейдите в директорию проекта:

   ```bash
        cd laravel-example
   ```

3. Установите зависимости с помощью Composer:

```bash
   composer install
```

4. Скопируйте файл .env.example и переименуйте его в .env:

```bash
   cp .env.example .env
```

5. Сгенерируйте ключ приложения Laravel:

```bash
php artisan key:generate
```

6. Настройте соединение с базой данных в файле .env:

```
DB_CONNECTION=mysql
DB_HOST=your-database-host
DB_PORT=your-database-port
DB_DATABASE=your-database-name
DB_USERNAME=your-database-username
DB_PASSWORD=your-database-password
```

6. Запустите миграции для создания таблиц в базе данных:

```bash
php artisan migrate
```

7. Запустите веб-сервер разработки:

```bash
php artisan serve
```

Откройте браузер и перейдите по адресу http://localhost:8000. Вы должны увидеть домашнюю страницу проекта.

## Тестирование

Для запуска модульных и функциональных тестов используйте следующую команду:

```bash
php artisan test
```

Тест проверяет правильность синхронизации данных с базой данных