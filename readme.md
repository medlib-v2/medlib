## Medlib

[![Build Status](https://travis-ci.org/medlib-v2/medlib.svg)](https://travis-ci.org/medlib-v2/medlib)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

Medlib est une application de recherche bibliographique open-source basée sur [Laravel](http://laravel.com).

## Screenshot

![Screenshot](https://medlib.fr/screenshot.png)

## Que fait Medlib ?

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](http://laravel.com/docs/contributions).

## Technologies utilisées
    
- [x] Laravel 5.4
- [x] Z39.50 (Yaz)
- [x] Bootstrap
- [x] Node.js
- [x] Redis
- [x] Memcached
- [x] JWT-Auth
- [x] Socket.io
- [x] Supervisor

## En relation avec le développement

- [x] Gulp
- [x] Less
- [x] Codception
- [x] PHP CodeSniffer
- [x] PHP Docblock Checker
- [x] PHP CS Fixer
- [x] Travis-ci
- [x] Style-CI
- [x] Gitlab-Ci

## Installation Exigences environnementales

- [PHP](http://www.php.net) 5.6.4+ ou supérieur (PHP7 recommandé)
- Base de données recommandée [MySQL](https://www.mysql.com) ou [PostgreSQL](http://www.postgresql.org). Bien sûr, [SQLite](https://www.sqlite.org) peut également fonctionner.
- [Composer](https://getcomposer.org)
- [Système de file d'attente](http://laravel.com/docs/5.3/queues), recommandé [beanstalkd](http://kr.github.io/beanstalkd/) ou Redis.

### En option

- Pour assurer une bonne écoute de file d'attente d'opération, websoket et d'autres services de back-office, nous recommandons [superviseur](http://supervisord.org)
- Service Cache recommandé Memcached, plus de choix de système de cache Voir [serveur de cache](http://laravel.com/docs/5.3/cache).

## Installation manuelle

I. Clonage du projet.

```shell
$ git clone https://github.com/medlib-v2/medlib.git
$ git clone https://github.com/medlib-v2/test-unit.git tests
```

II. Copie du fichier .env.example vers .env

```shell
$ cp .env.example .env
```

III. Installation de dépendances.

```shell
$ composer install -o --no-dev
```

IV. Installation de socket.io

```shell
$ yarn install --production
```

V. Permission storage bootstrap/cache, public/uploads, public/avatars.

```shell
$ make file-permission
```

VI. Mise en œuvre de Medlib

```shell
$ php artisan medlib:install
```

VII. Mise en œuvre du WebSocket
###### Sur le terminal (Laisser le terminal ouvert avec la commande en marche)
```shell
$ node server.js start
```

### License

The Medlib is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
