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