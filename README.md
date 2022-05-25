# customer-api
Fetch random users from RandomUser.Me API.

## Stack
- Lumen
- Laravel-Doctrine

## Setup
Before you start the application, create the following file inside the root directory to store secrets.
- Store root db password
```
db_root_password.txt
```
- Store user db password
```
db_root_password.txt
```

## Useful commands

- To start container
```
docker-compose up -d
```

- To fetch user
```
php artisan user:fetch
```
