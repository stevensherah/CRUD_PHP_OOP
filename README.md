## **PHP CRUD Example using OOP with Bootstrap**

In this instruction, keeping in mind Bootstrap framework CRUD Example, I will examine a simple database application with a PHP Object Oriented concept. In order to do that, I have applied here Bootstrap framework for front-end design and the MySQL database operations. The aim of this instruction is to provide the best PHP Object Oriented CRUD Example for beginners. 

The CRUD grid makes possible for users to create/read/update/delete data. Normally data is stored in MySQL Database. PHP will act as the server-side language, which enables to establish the contact with backend MySQL Database and control MySQL Database tables to support front-end users power to perform CRUD actions.

The following chapters will be included in PHP and MySQL instruction.


***

### **Creating a Database table Users and Categories**

I will deal with a simple Database table that you can see below. By taking this Database table as an example, you can generate CRUD on your database and implement this in your phpMyAdmin.

```mysql
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(30) CHARACTER SET utf8 NOT NULL,
  `category_id` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;
```
As categories, I will take „Students“, „Pensioners“, „Employees“ and „Unemployed“  in the example.

```mysql
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
```
oopcrudproject.sql file includes the databes table structure and sample data, which is applied within this project. You will be able to import this file after building your database in phpMyAdmin.

***

### **Connecting to Database**

The file 'database.php' is used in order to provide connection and configuration of database and includes a PHP class called  'Database'.  Without this class it is not possible to get a database connection. Throughout this application, Database contains all the stuff related to database connections, such as connecting.
As you can see, we are using PDO for database access. Set the credentials for the database and make a new PDO connection if the connection fails display the error.
 
In order to use this class, you need to supply correct values for $host , $db_name, $username , $password.

*   $host is database host, this is normally "localhost".
*   $db_name is database name, which you use to store 'users' and 'categories' table in phpMyAdmin.
*   $username is database username.
*   $password is database user's password.

getConnection() is the main function of this class. It uses singleton pattern to make sure only one PDO connection exist across the whole application.

```php
<?php

class Database
{

    // used to connect to the database
    private $host = "localhost";
    private $db_name = "oopcrudproject";
    private $username = "root";
    private $password = "";
    public $db_conn;

    // get the database connection
    public function getConnection()
    {
        $this->db_conn = null;

        try {
            $this->db_conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
        } catch (PDOException $exception) {
            echo "Database Connection Error: " . $exception->getMessage();
        }
        return $this->db_conn;
    }
}
```
### **Header and Footer Layouts**

I will create the following template files in order to remove some mess from the code: header.php and footer.php. Template files involve the main content of the Web pages.

At the beginning of some of our core files, this header.php will be included. In this way, I will not have to keep re-writing the same header codes every-time. 

```php
<?php

ini_set('display_errors', 1); // see an error when they pop up
error_reporting(E_ALL); // report all php errors
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title><?php echo $page_title; ?></title>

        <!-- Bootstrap CSS -->
        <link href="library/css/bootstrap.css" rel="stylesheet" media="screen" />
        <link href="library/css/bootstrap.min.css" rel="stylesheet">
        <script src="library/js/bootstrap.min.js"></script>

        <!-- some custom CSS -->
        <style>
            .left-margin{
                margin:0 .5em 0 0;
            }

            .right-button-margin{
                margin: 0 0 1em 0;
                overflow: hidden;
            }
        </style>
    </head>

    <body>

        <!-- container -->
        <div class="container">
            <?php
                 // show page header
                 echo "<div class='page-header'>";
                 echo "<h1>{$page_title}</h1>";
                 echo "</div>";
            ?>

         <!-- For the following code look at footer.php -->
```
The following footer.php file below will be added to the files at the end so that i will not have to repead the same footer codes every- time.
```html
</div>
<!-- /container -->

</body>
</html>
```
***
