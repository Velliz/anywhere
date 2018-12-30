## Anywhere

Anywhere is Output as-a Service (OAAS) platform to simplify your output and reduce your effort in coding. 
Anywhere basic concept is by using HTML and CSS for layouting the output and you supply it later with JSON 
to display data and Anywhere generating the output for you.
Until the BETA version, supported feature of **Anywhere** is:

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
php puko serve 9000
```

### Documentation

Visit `gh-pages` to see [the docs](http://velliz.github.io/anywhere/)

### About

Anywhere is build on top [puko framework](https://github.com/Velliz/pukoframework)

### Contributing

If you want to join to this project fill free to contact me at **diditvelliz@gmail.com**
