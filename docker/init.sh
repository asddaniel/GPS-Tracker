#!/bin/bash

su -s /bin/bash -c 'composer deploy-docker' www-data

cron

su -s /bin/bash -c 'php artisan serve --host=0.0.0.0 --port=80' www-data
