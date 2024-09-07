## Install the project

#### Build and run Docker containers in daemon mode

```
docker-compose up -d --build
```

#### Install composer

```
docker compose exec php composer install
```

#### Apply migrations

```
docker compose exec php php bin/console doctrine:migrations:migrate
```

After that backend will be available on [http://localhost](http://localhost),
and frontend will be available on [http://localhost:8080](http://localhost:8080).

The api endpoints you can see in the file `/data/shipping.http`


## UnitTests

#### Create test database

```
docker compose exec php php bin/console doctrine:database:create --env=test
```

#### Create test database and apply test migrations

```
docker compose exec php php bin/console doctrine:database:create --env=test
docker compose exec php php bin/console doctrine:migrations:migrate --env=test
```

#### Run all tests

```
docker compose exec php php bin/phpunit
```

## P.S.

Создана таблица `shipping` для хранения рассчитанных посылок.
Т.е. каждая рассчитанная посылка в форме фронтенда тут же записывается в БД.

Можно посмотреть список сохраненных посылок, кликнув на ссылку `Go to list of shipping`.
Список отсортирован по дате создания, начиная от самых свежих.
_Предоставил скриншоты HR-менеджеру._

Т.к. проект не продовольственный (и в ТЗ совет делать без особого фанатизма), то некоторые моменты
не "отполированны".

- Например, можно было бы написать гораздо больше тестов, например, добавить API тесты.

- В БД добавить таблицу перевозчиков и из нее брать доступных для элемента селект на фронтенде отдельным API эндпоинтом,
а не просто хардкодить их названия во фронтенде в селект элементе.

- На фронтенде можно было бы не просто рассчитывать посылку и отображать их, а сделать также их редактирование и удаление (CRUD).

Единственная причина того, что многое не сделано - дефицит времени, а также проект бы достаточно сильно вырос
и перестал бы походить на ТЗ. Хотел предоставить задание по возможности без промедления.
