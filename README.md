# 🍎🥕 Fruits and Vegetables

## 🎯 Goal
We want to build a service which will take a `request.json` and:
* Process the file and create two separate collections for `Fruits` and `Vegetables`
* Each collection has methods like `add()`, `remove()`, `list()`;
* Units have to be stored as grams;
* As a bonus you might consider giving option to decide which units are returned (kilograms/grams);
* As a bonus you might consider how to implement `search()` method collections;

## Usage
For this case a CLI command was introduced. It will parse the json request and create data transfer objects for all entries.
It has two types of entries: fruit and vegetables. The CLI command will return 2 lists seperated by these types. 

Start the container with
```bash
docker compose up -d
```
Run the CLI command
```bash
 docker compose exec app bin/console app:read-request request.json
```
With optional parameters
```bash
 docker compose exec app bin/console app:read-request request.json --unit=kg --search=something
```