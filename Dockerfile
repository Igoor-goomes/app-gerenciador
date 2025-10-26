# Imagem base: PHP 8.3 + Apache
FROM php:8.3-apache

# Instala dependências do sistema necessárias pro Laravel e pro Postgres
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libonig-dev \
    libzip-dev \
    zip \
    curl \
    && docker-php-ext-install pdo pdo_pgsql zip

# Habilita mod_rewrite pro Apache (necessário pro Laravel rodar rotas bonitas)
RUN a2enmod rewrite

# Define o DocumentRoot para /var/www/html/public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

# Atualiza config do Apache pra apontar pro /public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf \
 && sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# Copia composer do container oficial do composer pra dentro dessa imagem
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Workdir dentro do container
WORKDIR /var/www/html

# Dá permissão de escrita pro www-data antecipadamente
RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

# Expondo porta padrão do Apache
EXPOSE 80

# Comando padrão (apache rodando em foreground)
CMD ["apache2-foreground"]
