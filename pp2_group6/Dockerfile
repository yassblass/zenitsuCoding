FROM php:fpm-alpine
WORKDIR /pp2_group6
COPY package.json /pp2_group6
RUN npm install
COPY . /pp2_group6
CMD ["php", "artisan", "serve"]