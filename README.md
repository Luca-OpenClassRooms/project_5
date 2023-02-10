# Personal blog
[![Codacy Badge](https://app.codacy.com/project/badge/Grade/0802e5c1aeed436e8158530244b831c1)](https://www.codacy.com?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=Luca-OpenClassRooms/project_5&amp;utm_campaign=Badge_Grade)

# How to install

## Clone the repository

```
git clone https://github.com/Luca-OpenClassRooms/project_5.git
```

## Install the dependencies

```
composer install
```

## Setup environment variables

```
cp .env.example .env
```

Edit the .env file and set your credentials.

## Start app 

Start the server on http://127.0.0.1:8000

```
php serve.php
```

If you use a web server, you can use the public folder as the root folder.

## Use db test

You can use the db test in the file db_test.sql

### Admin user

```
email: root@root.fr
password: root
```

### Default user
```
email: test@test.fr
password: test
```