<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>


# Трекер разработки [HelperAuditXP]

## О проекте

Аудиторская компания.

Технологии: bitrix VB CentOS9, Laravel 10, PHP 8.2, MySQL5.7.

## Инструкция по установке

1. Склонируйте репозиторий:
   ```bash
   git clone https://github.com/username/repository.git .

2. Скопируйте файл .env

3. Так же готовятся сборки под docker с конфигурацией LEMP и LAMP

## Трекер задач

| Задача | Статус | Ответственный | Примечания |
|:-------|:-------|:-------------|:-----------|
| Восстановление парсера | В процессе | Яковлев Константин | |
| Доработка фильтра | В процессе | Яковлев Константин | |
| Обслуживание сайта на bitrix | Запланировано | Яковлев Константин | |

### Завершённые задачи

- [x] Изменен доступ к Github с ssh на personal tocken (**07.07.2025**)
- [x] Создано рабочее место на bitrix виртуалке с использованием virtualbox с доступом к коду через vscode с расширением: remote SSH (**07.07.2025**)
- [x] Созданы 5 таблиц: (**11.07.2025**)
  - log_tab, log_tbh, log_tjs, log_report для создания триггеров логирования текущей базы: создать, удалить, изменить
  - log_htm - для архивирования html документов полученных парсером
- [x] Изменена настройка mysql (my.cnf) с последующей перезагрузкой (**11.07.2025**)
  ```ini
  [mysqld]
  thread_stack = 256K
- [x] Добавлены триггеры на всю базу для слежения изменений. На каждую таблицу по три триггера
  - table_up_new_tr - это на UPDATE (запись в log_tab)
  - table_dl_new_tr - это на DELETE (запись в log_tjs в формате JSON)
  - table_in_new_tr - это на INSERT (запись в log_tjs в формате JSON)
  - Добавление триггеров влечет за собой более внимательно администрировать СУБД
    - Удаление какой либо колонки, больше не даст редактировать
    - Добавление новой колонки в логи не попадет.
  - Перед глобальными изменениями в СУБД нужно сначало удалить триггер (соответственно логироваться перестанет), создание нового триггера пока ложиться на меня (в ручную)  (**11.07.2025**)
- [x] Проработка README.md файла

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
