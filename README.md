## Anywhere

Anywhere is Output as-a Service (OAAS) platform to simplify your output and reduce your effort in coding. 
Anywhere basic concept is by using HTML and CSS for layouting the output and you supply it later with JSON 
to display data and Anywhere generating the output for you.

### Features

* PDF output
* MAIL output
* QR code output
* Image processing output

And another feature on going listed on `TODO.md` files.

### Requirement

* PHP >= 7.0
* MariaDB
* gnu-libiconv (extensions)
* gd (extensions)
* mbstring (extensions)

### Install

* from source

```bash
git clone https://github.com/Velliz/anywhere.git
cd anywhere
php puko generate db
php puko serve 4000
```

> if you want installing local, don't forget to import MariaDB/MySQL database from **bootstrap/anywhere.sql**

Setup `config/app.php` `config/database.php` `config/encryption.php` as your local machine settings and open: `http://localhost:4000/`

* docker-compose

```xaml
anywhere:
    image: diditvelliz/anywhere
    ports:
        - '80:80'
        - '4000:443'
    environment:
        SECRET_KEY: <RANDOM_STRING_HERE>
        HOOK: <CUSTOM_HOOKS_HERE>
        SLACK: <CUSTOM_SLACK_HOOKS>
        SLACK_ACTIVE: false
        HOOK_ACTIVE: false
        DB_TYPE: mysql
        DB_HOST: 172.17.0.1
        DB_USER: root
        DB_PASS: root
        DB_NAME: master
        DB_PORT: 3306
        INSTALLED: true
        LIMITATIONS: 100
        ENVIRONMENT: PROD
    networks:
        - services
```

> don't forget to import MariaDB/MySQL database from **bootstrap/anywhere.sql**

### Documentation

Read the docs at: [the docs](https://velliz.github.io/anydocs/)

### About

Anywhere is build on top [puko framework](https://github.com/Velliz/pukoframework)

### Contributing

If you want to join to develop this project, free to open a issue or pull request.
