# Bookshop Demo

This project started as part of a college project in a Secure Software Development course.

More recently, in addition to its original purpose, this project has also been used as a sandbox for LAMP stack
development testing.

## Development

The project was originally written in PHP 5.6. Some functionality has recently been tested in PHP 8.0. Installing PHP
and running `php -S localhost:8080` will run the project on a local server.

A MySQL database connection is required. The project originally used MySQL 5.1. Some functionality has recently been
tested using MySQL 5.7. In order to run the application. The file `schema.sql` contains the necessary schema and data
that the MySQL database will need. Once ready, make a copy of `config.php.template.php` and name the new
file `config.php`. Fill out values for the three empty fields at the end of the file.

| Constant name | Description                                                                             |
|---------------|-----------------------------------------------------------------------------------------|
| DB_DSN        | Connection string, in the format: "mysql:dbname={name_of_database};host={host_address}" |
| DB_USERNAME   | Database user name                                                                      |
| DB_PASSWORD   | Database user password                                                                  |

## Security measures

The original goal of this project was to consider common security issues with applications such as these. Here is a list
of security concerns and how they were addressed in this project.

### SQL Injection attack

The application was protected against SQL Injection by using the PHP PDO (PHP Data Object) prepared statement structure.

#### Tautology attempt

This can be tested by trying to log in with a username of `' or 1=1 --`. Because this is successfully handled, this
results in an "Incorrect Username/Password" error.

#### UNION attempt

This can be tested by typing the following in the address bar:
`localhost:8080/book.php?id=0%20UNION%20SELECT%201,2,3,4,5,6,7,8`

What should occur is that an empty item detail page is displayed.

#### Piggyback attempt

Similar to the tautology attempt, test logging in with any username but a password of `'; drop table user --`. Again,
the expected result is to be told that an invalid username or password was entered.

### XSS attacks

Cross-site scripting (XSS) attacks were prevented by using the PHP functions `stripslashes()` and `strip_tags()` on any
input variable that may be used to query or insert to a database. This can be tested by trying to access the following
URL and checking if an alert is displayed:
`http://localhost/bookshop/book.php?id=3<script type=”text/javascript”>alert(“test”);</script>`

### Checking password strength

Passwords need to be at least 8 characters with a mix containing at least one upper case letter, at least one upper case
letter, and at least one number. The string length check was simple enough and the rest was checked by using a custom
regular expression.

### Enforcing password expiry

Every time the user changes their password, the database table will be updated with a time value from PHP using the
`time()` function (the number of seconds since January 1, 1970). When logging in, this value will be selected and the
login procedure will look at a new instance of `time()` and subtract from it the time listed in the table and then
divide that number by `(60*60*24*30)` to return a value for the months that have passed since the user has changed their
password. If this value is greater than 1, then the user will be redirected to a new page to reset their password, but
otherwise, the user will eventually be redirected to the main home page after setting the session and corresponding
cookie.

### Stored password in hashed form

All passwords and credit card numbers were stored in a hashed form. This was accomplished by using the `hash()` function
in PHP using sha256 on the input password as well as an arbitrary “salt” value.
