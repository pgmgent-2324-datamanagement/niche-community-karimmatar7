# Laravel en ddev opstarten


1. Install
   
``` bash
ddev start
ddev composer create --prefer-dist --no-install --no-scripts laravel/laravel -y
ddev composer install
npm install
```

2. [.env file aanmaken](https://www.pgm.gent/laravel/laravel/databases/connecting.html#configuratie-via-env)

Dupliceer de `.env-example` en hernoem die naar `.env`
Pas de connectiegegevens aan volgens de standaard ddev database

```
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=db
DB_USERNAME=db
DB_PASSWORD=db
```

3. Initial DB install

``` bash
ddev artisan migrate
```

