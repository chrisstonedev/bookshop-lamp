<?php

// classes
include_once( "class" . "/book.php" );
include_once( "class" . "/books.php" );
include_once( "class" . "/transaction.php" );
include_once( "class" . "/user.php" );

// set off all error for security purposes
error_reporting(0);

// constants
define( "CLS_PATH", "class" );  // the class path of the project
define( "DB_DSN", "" );  // enter connection string here
define( "DB_USERNAME", "" );  // enter database username here
define( "DB_PASSWORD", "" );  // enter database password here
