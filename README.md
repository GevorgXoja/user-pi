# REST API для работы с пользователями

## Конфигурация

##Для подключения к базе данных настройте файл `config.php`:
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "users_db";


1: Настройка запроса (createUser)
Откройте Postman и создайте новый запрос.
Установите метод запроса на POST.
Введите URL вашего сервера. Например, если вы используете встроенный PHP-сервер, это может быть что-то вроде http://localhost:8000/api.php/users.

2: Настройка заголовков
Перейдите на вкладку Headers.
Добавьте новый заголовок с ключом Content-Type и значением application/json.

3: Настройка тела запроса
Перейдите на вкладку Body.
Выберите raw.
Убедитесь, что тип установлен на JSON.
Введите JSON-данные, которые вы хотите отправить. Например:

{
    "username": "testr",
    "password": "passord123",
    "email": "test@test.ru"
}
Обновление информации пользователя (updateUser)
URL: /users/{id}
Метод: PUT
Описание: Обновляет информацию о пользователе с указанным ID.
Удаление пользователя (deleteUser)
URL: /users/{id}
Метод: DELETE
Описание: Удаляет пользователя с указанным ID.
Авторизация пользователя (authenticateUser)
URL: /auth
Метод: POST
Описание: Авторизует пользователя.
Получение информации о пользователе (getUser)
URL: /users/{id}
Метод: GET
Описание: Возвращает информацию о пользователе с указанным ID.

