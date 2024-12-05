serve:
	php artisan serve

reload-config:
	php artisan config:clear && php artisan config:cache
