## Anywhere

Anywhere is an Output as-a Service (OAAS) platform that simplifies your output and reduces your coding effort. 
With Anywhere, you can use HTML and CSS to design the layout of the output and then supply it with JSON data. 
Anywhere will generate the output for you automatically.

### Features

* PDF generator with Dompdf
* Spreadsheet generator with Php-spreadsheet
* Email via SMTP with PhpMailer
* Digital Signing (*Self signed)
* Images
* QRCode

### Requirement

* PHP >= 7.3
* gnu-libiconv (extensions)
* ext-fileinfo (extensions)
* ext-gd (extensions)
* ext-mbstring (extensions)
* Mysql or MariaDB

### Install

* from source

```bash
git clone https://github.com/Velliz/anywhere.git
cd anywhere

composer install
npm install

php puko generate db
php puko serve 4000
```

Don't forget to set up `config/app.php` `config/database.php` `config/encryption.php` as your local machine settings.

Then open `http://localhost:4000`

* docker-compose

```xaml
anywhere:
    image: diditvelliz/anywhere
    ports:
        - '80:80'
    environment:
        ENCRYPTION_KEY: <RANDOM_STRING_HERE>
        HOOK: <CUSTOM_HOOKS_HERE>
        HOOK_ACTIVE: false
        SLACK: <CUSTOM_SLACK_HOOKS>
        SLACK_ACTIVE: false
        DB_HOST: 172.0.0.1
        DB_USER: root
        DB_PASS: root
        DB_NAME: master
        DB_PORT: 3306
        INSTALLED: true
        LIMITATIONS: 100
        ENVIRONMENT: PROD
        MEMCACHED_IP: localhost
    networks:
        - services
```

### Documentation

Read the docs at: [the docs](https://velliz.github.io/anydocs/)

### About

Anywhere is build on top [puko framework](https://github.com/Velliz/pukoframework)

### Contributing

If you want to join to develop this project, free to open a issue or pull request.

Made with <3 from Bandung, Indonesia.
