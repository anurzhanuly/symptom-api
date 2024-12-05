serve:
	php artisan serve

reload-config:
	php artisan config:clear && php artisan config:cache

reload-server:
	php artisan config:clear && php artisan config:cache && sudo systemctl reload php8.1-fpm.service && sudo systemctl restart php8.1-fpm.service
