#simpleApi

## How To
```
composer install

php artisan serve

List of API
curl --location 'http://127.0.0.1:8000/api/tasks'

curl --location 'http://127.0.0.1:8000/api/tasks' \
--header 'Content-Type: application/json' \
--data '{
    "title":"Test 01a",
    "description": "description"
}'

curl --location --request PUT 'http://127.0.0.1:8000/api/tasks/2/complete'

curl --location --request PUT 'http://127.0.0.1:8000/api/tasks/2'

curl --location --request DELETE 'http://127.0.0.1:8000/api/tasks/2'

``` 


## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
