# Менеджер задач

[![Actions Status](https://github.com/aldmarinka/php-project-57/actions/workflows/hexlet-check.yml/badge.svg)](https://github.com/aldmarinka/php-project-57/actions)
[![Actions Status](https://github.com/aldmarinka/php-project-57/actions/workflows/php.yml/badge.svg)](https://github.com/aldmarinka/php-project-57/actions)
[![Maintainability](https://api.codeclimate.com/v1/badges/b8a11545e4fc41d65433/maintainability)](https://codeclimate.com/github/aldmarinka/php-project-9/maintainability)

Task Manager – система управления задачами, подобная http://www.redmine.org/. Она позволяет ставить задачи, назначать исполнителей и менять их статусы. Для работы с системой требуется регистрация и аутентификация.

### Установка
```
$ git clone https://github.com/aldmarinka/php-project-57.git
$ cd php-project-57
$ make setup
```

### Запуск
```
$ php artisan migrate:fresh --seed
$ make start
```

После менеджер задач будет доступен на http://localhost:8000/

### Demo
https://php-project-57-nqs9.onrender.com/