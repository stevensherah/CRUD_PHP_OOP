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
***
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
### **index.php**

A navigation button leading to „Create User“ and a button to edit as well as delete users are important for the start.

'index.php' is about the records from the mysql database. It shows this record with pagination feature. In the codes you check if more than 0 record found or if there are any users to display you can retrieve users from Database. The table applied in this file are created under bootstrap data table with  class 'table table-hover table-responsive table-bordered'.

##### **Create User Button** 

It is important to provide this code before the HTML form. When user will click the create (submit) button after entering the values in the HTML form, then values will be sent via POST request and following code below will record it in the database.
```php
// create user button
echo "<div class='right-button-margin'>";
echo "<a href='create.php' class='btn btn-primary pull-right'>";
echo "<span class='glyphicon glyphicon-plus'></span> Create User";
echo "</a>";
echo "</div>";
```
Now the "index.php" file's code should look like below:
```php
<?php

// include database and object files
include_once 'classes/database.php';
include_once 'classes/user.php';
include_once 'classes/category.php';
include_once 'initial.php';

// for pagination purposes
$page = isset($_GET['page']) ? $_GET['page'] : 1; // page is the current page, if there's nothing set, default is page 1
$records_per_page = 5; // set records or rows of data per page
$from_record_num = ($records_per_page * $page) - $records_per_page; // calculate for the query limit clause

// instantiate database and user object
$user = new User($db);
$category = new Category($db);

// include header file
$page_title = "Users";
include_once "header.php";

// create user button
echo "<div class='right-button-margin'>";
echo "<a href='create.php' class='btn btn-primary pull-right'>";
echo "<span class='glyphicon glyphicon-plus'></span> Create User";
echo "</a>";
echo "</div>";

// select all users
$prep_state = $user->getAllUsers($from_record_num, $records_per_page); //Name of the PHP variable to bind to the SQL statement parameter.
$num = $prep_state->rowCount();

// check if more than 0 record found
if($num>=0){

    echo "<table class='table table-hover table-responsive table-bordered'>";
    echo "<tr>";
    echo "<th>First Name</th>";
    echo "<th>Last Name</th>";
    echo "<th>E-Mail</th>";
    echo "<th>Mobile</th>";
    echo "<th>Category</th>";
    echo "<th>Actions</th>";
    echo "</tr>";

    while ($row = $prep_state->fetch(PDO::FETCH_ASSOC)){

        extract($row); //Import variables into the current symbol table from an array

        echo "<tr>";

        echo "<td>$row[firstname]</td>";
        echo "<td>$row[lastname]</td>";
        echo "<td>$row[email]</td>";
        echo "<td>$row[mobile]</td>";

        echo "<td>";
                    $category->id = $category_id;
               $category->getName();
               echo $category->name;
        echo "</td>";

        echo "<td>";
        // edit user button
        echo "<a href='edit.php?id=" . $id . "' class='btn btn-warning left-margin'>";
        echo "<span class='glyphicon glyphicon-edit'></span> Edit";
        echo "</a>";

        // delete user button
        echo "<a href='delete.php?id=" . $id . "' class='btn btn-danger delete-object'>";
        echo "<span class='glyphicon glyphicon-remove'></span> Delete";
        echo "</a>";

        echo "</td>";
        echo "</tr>";
    }

    echo "</table>";

    // include pagination file
    include_once 'pagination.php';
}

// if there are no user
else{
    echo "<div> No User found. </div>";
    }
?>

<?php
include_once "footer.php";
?>
```
***
### **create.php**

Here what should be done is to generate a file and to identify it as 'create.php' so that it will be possible to get data from users and to save in mysql database. Through this file, some appropriate message are provided about data are insert or not with bootstrap label.  Create() function given in 'user.php' class file completes the create operation. 

##### **Create a "Read Users" Button**

This will be put in between the header and footer. Under the "Create User" and "Edit User" header.

```php
// read user button
echo "<div class='right-button-margin'>";
    echo "<a href='index.php' class='btn btn-info pull-right'>";
        echo "<span class='glyphicon glyphicon-list-alt'></span> Read Users ";
    echo "</a>";
echo "</div>";
```
As you will notice, what should be done first is to verify whether there is form submit by checking $_POST variable. If we see that there is, then we check each entries to make sure that they pass validation rules. It renewes database by applying $_POST data.

```php
// check if the form is submitted
if ($_POST){

    // instantiate user object
    include_once 'classes/user.php';
    $user = new User($db);

    // set user property values
    $user->firstname = htmlentities(trim($_POST['firstname']));
    $user->lastname = htmlentities(trim($_POST['lastname']));
    $user->email = htmlentities(trim($_POST['email']));
    $user->mobile = htmlentities(trim($_POST['mobile']));
    $user->category_id = $_POST['category_id'];


    // if the user able to create
    if($user->create()){
        echo "<div class=\"alert alert-success alert-dismissable\">";
            echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">
                        &times;
                  </button>";
            echo "Success! User is created.";
        echo "</div>";
    }

    // if the user unable to create
    else{
        echo "<div class=\"alert alert-danger alert-dismissable\">";
            echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">
                        &times;
                  </button>";
            echo "Error! Unable to create user.";
        echo "</div>";
    }
}
```
Now we can put the latest values to each form elements.

```php
<!-- Bootstrap Form for creating a user -->
<form action='create.php' role="form" method='post'>

    <table class='table table-hover table-responsive table-bordered'>

        <tr>
            <td>First Name</td>
            <td><input type='text' name='firstname'  class='form-control' placeholder="Enter First Name" required></td>
        </tr>

        <tr>
            <td>Last Name</td>
            <td><input type='text' name='lastname' class='form-control' placeholder="Enter Last Name" required></td>
        </tr>

        <tr>
            <td>Email Address</td>
            <td><input type='email' name='email' class='form-control' placeholder="Enter Email Address " required></td>
        </tr>

        <tr>
            <td>Mobile Number</td>
            <td><input type='number' name='mobile' class='form-control' placeholder="Enter Mobile Number" required></td>
        </tr>
```
***
### **edit.php**

By Generating a data insert form, this file updates the users data. Update() function, which are clarified in 'user.php' class file, enable the update operation to be done.

Create the edit.php file and set the 'Edit User' Headers. Here, a selected record from the database will be  updated and this will be the reponse to the following question: How to update a record with PDO.

Enter the following code in the new update.php file. Therewith we are going to be able to integrate the latest values to each form elements.

```php
<!-- Bootstrap Form for updating a user -->
<form action='edit.php?id=<?php echo $id; ?>' method='post'>

    <table class='table table-hover table-responsive table-bordered'>

        <tr>
            <td>First Name</td>
            <td><input type='text' name='firstname' value='<?php echo $user->firstname;?>' class='form-control' placeholder="Enter First Name" required></td>
        </tr>

        <tr>
            <td>Last Name</td>
            <td><input type='text' name='lastname' value='<?php echo $user->lastname;?>' class='form-control' placeholder="Enter Last Name" required></td>
        </tr>

        <tr>
            <td>Email Address</td>
            <td><input type='email' name='email' value='<?php echo $user->email;?>' class='form-control' placeholder="Enter Email Address" required></td>
        </tr>

        <tr>
            <td>Mobile Number</td>
            <td><input type='number' name='mobile' value='<?php echo $user->mobile;?>' class='form-control' placeholder="Enter Mobile Number" required></td>
        </tr>
```
##### **Loop Through the Categories Records to show as Drop-down**

Notice that we put an if statement if($person->category_id == $id) inside the while loop. This is to pre-select the option of the current record. The Category Option are going to call getAll() function from class file "category.php".

```php
<tr>
          <td>Category</td>
          <td>

              <?php
              // read the user categories from the database
              include_once 'classes/category.php';

              $category = new Category($db);
              $prep_state = $category->getAll();

              // put them in a select drop-down
              echo "<select class='form-control' name='category_id'>";
              echo "<option>--- Select Category ---</option>";

              while ($row_category = $prep_state->fetch(PDO::FETCH_ASSOC)){
                  extract($row_category);

                  // current category of the person must be selected
if($person->category_id == $id){ //if user category_id is equal to category id,
                      echo "<option value='$id' selected>"; //Specifies that an option should be pre-selected when the page loads
                  }else{
                      echo "<option value='$id'>";
                  }

echo "$name </option>";
              }
              echo "</select>";
              ?>
          </td>
      </tr>
```

***

### **user.php**

First of all we should create the Object Class for Users than the methods.

