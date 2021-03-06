# customer-api
Fetch random users from RandomUser.Me API and save user's information to database.

## Authors
- [Jozell Rili](https://github.com/jozellrili)

## Stack
- Lumen
- Laravel-Doctrine
- MySQL

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

### Fresh installation
```
make init
```
### Start Container
- To start container
```
make start
```

### Database Migration
- To check for migration diffs
```
make migrate-diff
```
- To start migration
```
make migrate
```

## Console Commands
- To fetch user from the API and save to database

Artisan:
```
php artisan user:fetch
```

Make:
```
make fetch 
```

- Fetch user with parameter

Parameter is optional and by default the value for count is `10` and nationality is `au`
```
php artisan user:fetch {count} {nationality}

php artisan user:fetch 100 au
```


## API Dependencies
- Random User Generator API Documenation: [randomeuser](https://randomuser.me/documentation)
- API: [generate](https://randomuser.me/api)

## Customer API
URL | Method | Parameters| Description
:---|--------|------|------------
/customers| Get| `null`| retrieve the list of all customers from the database.|
/customers/{id}|Get| int| retrieve more details of a single customer
