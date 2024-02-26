FROM php:8.2-fpm

#arguments defined in docker-compose.yml
ARG user
ARG uid

#install system dependencies
RUN apt-get update && apt-get install -y \
  sqlite3 \
  git \
  curl \
  libpng-dev \
  libonig-dev \
  libxml2-dev \
  zip \
  unzip \
  nano
  
#clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

#RUN apt-get install nano -y

#install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd sockets

# get latest composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini && \
        sed -i -e "s/^ *memory_limit.*/memory_limit = 4G/g" /usr/local/etc/php/php.ini

#copy .env.example to .env extension=php_sockets.dll

# generate artisan key

# create system user to run composer and artisan commands
#RUN useradd -G www-data,root -u $uid -d /home/$user $user
#RUN mkdir -p /home/$user/.composer && \
    #chown -R $user:$user /home/$user

#set working directory
WORKDIR /var/www

#RUN composer create project larave/laravel .
#RUN composer install 

#USER $user