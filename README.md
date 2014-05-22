Тестовое задание
================

PHP Developer, Эксмо, издательство
----------------------------------

Посмотреть можно на [тестовом сервере][1]
Рядом со всеми ссылками и кнопками (кроме верхнего меню) при наведении появляется кнопка "json", которая по клику покажет результат запроса на тот же адрес, но отправленный с http accept json.

Основной код в [WonkaCinemaBundle][2].

```sh
Метод   URL
----------------------------------------------------
GET     /api/cinema/{cinema_slug}/schedule
        /api/cinema/{cinema_slug}/schedule/{hall_id}

GET     /api/film/{film_slug}/schedule

GET     /api/session/{session_id}/places

POST    /api/tickets/buy/{session_id}/{places}

POST    /api/tickets/reject/{code}
```

* {cinema_slug} - название кинотеатра
* {hall_id}     - ID зала
* {film_slug}   - название фильма
* {session_id}  - ID сеанса
* {places}      - номера мест, разделённые запятыми
* {code}        - код для удаления

[1]:    http://test-eksmo.sfdev.ru/
[2]:    https://github.com/sfdev/test-eksmo/tree/eksmo/src/Wonka/CinemaBundle
