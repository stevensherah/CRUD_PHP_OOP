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

Notice that we put an if statement ```if($person->category_id == $id)``` inside the while loop. This is to pre-select the option of the current record. The Category Option are going to call getAll() function from class file "category.php".

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

##### **update() function**

If we do not include the following code into user.php, the update function, which is implemented in the if statement (edit.php), will disable to work.

```php
function update()
{
    $sql = "UPDATE " . $this->table_name . " SET firstname = :firstname, lastname = :lastname, email = :email, mobile = :mobile, category_id  = :category_id  WHERE id = :id";
    // prepare query
    $prep_state = $this->db_conn->prepare($sql);


    $prep_state->bindParam(':firstname', $this->firstname);
    $prep_state->bindParam(':lastname', $this->lastname);
    $prep_state->bindParam(':email', $this->email);
    $prep_state->bindParam(':mobile', $this->mobile);
    $prep_state->bindParam(':category_id', $this->category_id);
    $prep_state->bindParam(':id', $this->id);

    // execute the query
    if ($prep_state->execute()) {
        return true;
    } else {
        return false;
    }
}

```
##### **countAll() function**
The countAll() method here provides the all row numbers of database by means of SQL statement. It is located within the file pagination.php
```php
public function countAll()
{
    $sql = "SELECT id FROM " . $this->table_name . "";

    $prep_state = $this->db_conn->prepare($sql);
    $prep_state->execute();

    $num = $prep_state->rowCount(); //Returns the number of rows affected by the last SQL statement
    return $num;
}
```
##### **getAllUsers() function**

gelAllUsers()Method is located within user.php but it is obtained from index.php. It means that it retrieves all information about user into the first opened page.

```php
function getAllUsers($from_record_num, $records_per_page)
{
    $sql = "SELECT id, firstname, lastname, email, mobile, category_id FROM " . $this->table_name . " ORDER BY firstname ASC LIMIT ?, ?";


    $prep_state = $this->db_conn->prepare($sql);


    $prep_state->bindParam(1, $from_record_num, PDO::PARAM_INT); //Represents the SQL INTEGER data type.
    $prep_state->bindParam(2, $records_per_page, PDO::PARAM_INT);


    $prep_state->execute();

    return $prep_state;
    $db_conn = NULL;
}
```
##### **getUser() function**

getUser()Method is for recalling one choosed User Information, which is based on the Given ID. Besides, this function is applied in edit.php and can not work without the following code inside.

```php
function getUser()
{
    $sql = "SELECT firstname, lastname, email, mobile, category_id FROM " . $this->table_name . " WHERE id = :id";

    $prep_state = $this->db_conn->prepare($sql);
    $prep_state->bindParam(':id', $this->id);
    $prep_state->execute();

    $row = $prep_state->fetch(PDO::FETCH_ASSOC);

    $this->firstname = $row['firstname'];
    $this->lastname = $row['lastname'];
    $this->email = $row['email'];
    $this->mobile = $row['mobile'];
    $this->category_id = $row['category_id'];
}
```
##### **delete() function**

This is the delete() method inside the user object class used by delete.php
```php
function delete($id)
{
    $sql = "DELETE FROM " . $this->table_name . " WHERE id = :id ";

    $prep_state = $this->db_conn->prepare($sql);
    $prep_state->bindParam(':id', $this->id);

    if ($prep_state->execute(array(":id" => $_GET['id']))) {
        return true;
    } else {
        return false;
    }
}
```
***
##  **category.php**

##### **getALL() function**
The create.php and category.php  above cannot work without the category class. This class is named as category.php and put inside objects.

getAll() function is used to select category drop-down list.
```php
function getAll()
{
    //select all data
    $sql = "SELECT id, name FROM " . $this->table_name . "  ORDER BY name";

    $prep_state = $this->db_conn->prepare($sql);
    $prep_state->execute();

    return $prep_state;
}
```
##### **getName() function**

getName() function, which is used in index.php, retrieves the category name into the category column.

```php
    function getName()
    {

        $sql = "SELECT name FROM " . $this->table_name . " WHERE id = ? limit 0,1";

        $prep_state = $this->db_conn->prepare($sql);
        $prep_state->bindParam(1, $this->id); 
        $prep_state->execute();

        $row = $prep_state->fetch(PDO::FETCH_ASSOC);

        $this->name = $row['name'];
    }
}
```

***

## **delete.php**

Delete button, which is activated from the first page and coded in index.php, retrieves delete.php and the id information, which are recorded in the databese table. Since we do not know which data we should delete, id plays a significant role for the identification of these datas. 

As seen in the following example [http://localhost63342/crud/delete.php?id=](http://localhost63342/crud/delete.php?id=) If the variable that we want to delete, exists, then we automatically see on the screen the question of 'Are you sure to delete?'

If we click the button yes, the variable, its id is detected, will be deleted through delete() function in user.php and the message 'Success! User is deleted' shows up on the screen.

```php
<?php

//set page headers
$page_title = "Delete User";
include_once "header.php";
include_once 'classes/database.php';
include_once 'classes/user.php';
include_once 'initial.php';
// get database connection

$user = new User($db);

// check if the submit button yes was clicked
if (isset($_POST['del-btn']))
{
    $id = $_GET['id'];
    $user->delete();
    header("Location: delete.php?deleted");
}
      // check if the user was deleted
      if(isset($_GET['deleted'])){
        echo "<div class=\"alert alert-success alert-dismissable\">";
        echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">
                    &times;
              </button>";
        echo "Success! User is deleted.";
        echo "</div>";
      }
?>
<!-- Bootstrap Form for deleting a user -->
<?php
    if (isset($_GET['id'])) {
        echo "<form method='post'>";
            echo "<table class='table table-hover table-responsive table-bordered'>";
                echo "<input type='hidden' name='id' value='id' />";
                    echo"<div class='alert alert-warning'>";
                        echo"Are you sure to delete?";
                    echo"</div>";
                echo"<button type='submit' class='btn btn-danger' name='del-btn'>";
                    echo"Yes";
                echo"</button>";
                    echo str_repeat('&nbsp;', 2);
                echo"<a href='index.php' class='btn btn-default' role='button'>";
                    echo" No";
                echo"</a>";
            echo"</table>";
        echo"</form>";
    }
else {  // Back to the first page
        echo"<a href='index.php' class='btn btn-large btn-success'><span class='glyphicon glyphicon-backward'></span> Home </a>";
     }
?>

<?php
include_once "footer.php";
?>
```

***

##  **pagination.php**

The last section is about the process of pagination. Pagination is essentially for collecting a range of results and then spreading them out over pages to hinder them to cover all the screen. Through the process of pagination, we make a set of results easier to be viewed. As it can be seen from codes, we can figure out total number of pages in two steps. First, we calculate the overall row number in user.php by means of the countAll() method. Then we divide it  into the number of $records_per_page, that we detected in one page.
```php
<?php

echo "<ul class=\"pagination\">";

// button for first page
if($page>1){
    echo "<li><a href=' " . htmlspecialchars($_SERVER['PHP_SELF']) . " ' title='Go to the first page.'>";
    echo " << First ";
    echo "</a></li>";
}

// count all rows in the database
$total_rows = $user->countAll();

// Returns the next highest integer value by rounding up value if necessary. 18/5=3,6 ~ 4
$total_pages = ceil($total_rows / $records_per_page); //ceil — Round fractions up

// range of num of links to show
$range = 2;

// display number of link to 'range of pages' and wrap around 'current page'
$initial_num = $page - $range;
$condition_limit_num = ($page + $range) + 1;


for ($x=$initial_num; $x<$condition_limit_num; $x++) {

    // setting the current page
    if (($x > 0) && ($x <= $total_pages)) {

        // display current page
        if ($x == $page) {
            echo "<li class='active'><a href=\"#\">$x <span class=\"sr-only\">(current)</span></a></li>";
        }

        // not current page
        else {
            echo "<li><a href='" . htmlspecialchars($_SERVER['PHP_SELF']) . "?page=$x'>$x</a></li>";
        }
    }
}

// button for last page
if($page<$total_pages){
    echo "<li><a href='" . htmlspecialchars($_SERVER['PHP_SELF']) . "?page={$total_pages}' title='Last page is {$total_pages}.'>";
    echo "Last >> ";
    echo "</a></li>";
}

echo "</ul>";
```




