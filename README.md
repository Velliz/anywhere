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

### Install

* Clone this repository

* Setup the mysql/mariadb database from `bootstrap/anywhere.sql`

* Configure the database connection under `config/database.php`

* Run it:

```text
php puko serve <port_number>
```

### Docker-compose

```xaml
anywhere:
    build: ./anywhere
    container_name: anywhere
    ports:
        - '80:80'
        - '4000:443'
    environment:
        SECRET_KEY: RANDOM_STRING_HERE
        HOOK: http://10.15.104.99/notify/gateway
        SLACK: https://hooks.slack.com/services/T029KSKLQ/BDQJL0JS1/000000000
        DB_TYPE: mysql
        DB_HOST: 172.17.0.1
        DB_USER: root
        DB_PASS: root
        DB_NAME: master
        DB_PORT: 3306
        DB_CACHE: 'false'
        INSTALLED: false
        LIMITATIONS: 100
    volumes:
        - /home/anywhere:/var/www/html
    networks:
        - services
```

### Documentation

Visit [the docs](https://velliz.github.io/anydocs/)

### About

Anywhere is build on top [puko framework](https://github.com/Velliz/pukoframework)

### Contributing

If you want to join to this project fill free to contact me at **diditvelliz@gmail.com**
