.PHONY: all update-repo dependency-install file-permission migration seed assets-dev assets-production

install: dependency-install dump-autoload file-permission migration seed install-gulp assets-production cache-config
install-dev: dependency-install dump-autoload file-permission migration seed install-gulp assets-dev
update: update-repo dependency-install dump-autoload migration assets-production cache-config
update-dev: update-repo dependency-install dump-autoload migration assets-dev

help:
	@echo 'make install -- download dependencies and install'
	@echo 'make install-dev -- download dependencies and install without minifing assets'
	@echo 'make update-dev -- pull repo and rebuild assets'
	@echo 'make update -- pull repo and rebuild assets without minifing'

update-repo:
	git reset --hard
	git pull origin master

dependency-install:
	composer update

file-permission:
	chmod -R 777 storage/
	chmod -R 777 bootstrap/cache/
	chmod -R 777 public/uploads
	chmod -R 777 public/avatars

migration:
	php artisan migrate --force

seed:
	php artisan db:seed

install-gulp:
	npm install --g gulp
	npm install

assets-production:
	gulp --production

assets_dev:
	gulp

cs:
	vendor/bin/phpcs --colors -p -n --standard=PSR2 --ignore="app/Helpers/Helpers.php" app/
	vendor/bin/phpdoccheck --directory=app

dump-autoload:
	php artisan clear-compiled

cache-config:
	php artisan config:cache
	php artisan optimize

test:
	composer run phpunit
	composer run phpcs
	composer run phpmd
	npm run unit
	npm run lint
