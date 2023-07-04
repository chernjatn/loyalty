# Сервис лояльности

## Основной стэк
- PHP 8.0
- Laravel 9

### Используемые инструменты
- [Laravel Tzsk/SMS](https://github.com/tzsk/sms)

## Установка

1. Клонируем репозиторий
    ```
    git clone git@gl.erkapharm.ru:ultrashop/loyalty.git
    ```
2. Устанавливаем зависимости
    ```
    composer install
    ```
3. Настраиваем файл .env
    ```
    cp .env.example .env
    php artisan key:gen
    // заполняем параметры APP_*,
    // заполняем доступы к ECOM
    ECOM_URL=
    ECOM_USERNAME=
    ECOM_PASSWORD=
    // заполняем параметры к redis
    REDIS_HOST=redis
    REDIS_CLIENT=predis
    ```
    Запуск
    ```
    // первоначально 
    docker-compose --build
    // 
    docker-compose up
       ```

## Документация API
[Confluence: Сервис лояльности (loyalty)](https://kb.erkapharm.com/confluence/pages/viewpage.action?pageId=119835044)

## Линтеры

### Laravel Pint
- `composer lint` - проверка код-стайла
- `composer lint-fix` - проверка код-стайла с автоисправлением
- Правила настраиваются в файле `pint.json`

### Larastan
- `composer larastan` - статический анализ кода
- Правила настраиваются в файле `phpstan.neon`
