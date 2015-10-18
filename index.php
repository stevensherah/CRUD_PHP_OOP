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