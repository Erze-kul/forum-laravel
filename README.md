## Требования (Requirements)

* linux system (Ubuntu 20.04)
* docker 19.03.0+
* docker-compose 1.27.0+
* make

## Первый запуск
Перед первым запуском приложения, необходимо выполнить команду make init

- установит env
- запустит билд
- запустит установку зависимых бибилиотек
- установит ключ

Для заполнения базы выполнить make seed

- выполнит посев бд

## Запуск (форум доступен по http://localhost:8080/)
```bash
   make up
```

## Остановка
```bash
   make down
```

## Рестарт
```bash
   make restart
```

## Запуск тестов
```bash
   make test
```

## Генерация документации, доступной по пути http://localhost:8080/docs
```bash
   make docs
```
