<?php
// set page headers
$page_title = "Edit User";
include_once "header.php";

// read user button
echo "<div class='right-button-margin'>";
    echo "<a href='index.php' class='btn btn-info pull-right'>";
        echo "<span class='glyphicon glyphicon-list-alt'></span> Read Users ";
    echo "</a>";
echo "</div>";

// isset() is a PHP function used to verify if ID is there or not
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR! ID not found!');

// include database and object user file
include_once 'classes/database.php';
include_once 'classes/user.php';
include_once 'initial.php';

// instantiate user object
$user = new User($db);
$user->id = $id;
$user->getUser();

// check if the form is submitted
if($_POST)
{

    // set user property values
    $user->firstname = htmlentities(trim($_POST['firstname']));
    $user->lastname = htmlentities(trim($_POST['lastname']));
    $user->mobile = htmlentities(trim($_POST['mobile']));
    $user->email = htmlentities(trim($_POST['email']));
    $user->category_id = $_POST['category_id'];

    // Edit user
    if($user->update()){
        echo "<div class=\"alert alert-success alert-dismissable\">";
            echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">
                        &times;
                  </button>";
            echo "Success! User is edited.";
        echo "</div>";
    }

    // if unable to edit user
    else{
        echo "<div class=\"alert alert-danger alert-dismissable\">";
            echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">
                        &times;
                  </button>";
            echo "Error! Unable to edit user.";
        echo "</div>";
    }
}
?>

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


            <tr>
                <td></td>
                <td>
                    <button type="submit" class="btn btn-success" >
                        <span class=""></span> Update
                    </button>
                </td>
            </tr>

        </table>
    </form>

<?php
include_once "footer.php";
?>