<?php
//establishing connection with the database
$servername = "localhost";
$username = "root";
$password = "marx";
$database = "web_shop";

//connection with the database
$connection = new mysqli($servername, $username, $password, $database);


//creating the different variables
$id = "";
$name = "";
$email = "";
$phone = "";
$address = "";
$errorMessage = "";
$successMessage = "";

//lets again check if we've received the request using the get or post method

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    //GET method: show client data

    //if id doesnt exist we redirect the user and exit the execution of this file otherwise read the id of the client from the request
    if (!isset($_GET['id'])){
        header('location: /crud/index.php');
        exit;
    }

    $id = $_GET["id"];

    //reading client data from the database
    $sql = "SELECT * FROM clients WHERE id=$id";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();

    //if no data in the database then we have to redirect the user and exit the execution of this file
    if (!$row){
        header("location: /crud/index.php");
        exit;
    }
    //otherwise we can read the data from the database
    $name = $row["name"];
    $email = $row["email"];
    $phone = $row["phone"];
    $address = $row["address"];
}
else{
    //POST method: Update client data
    //reading the data of the form
    $id = $_POST["id"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];

    //then lets check that we dont have any empty fields
    do{
        if(empty($id) || empty ($name) || empty($email) || empty($phone) || empty($address)){
            $errorMessage = "All the fields are required!";
            break;
        }
        //otherwise we execute the sql query which allows us update the data of the client
        $sql = "UPDATE clients " .
               "SET name = '$name', email = '$email', phone = '$phone', address = '$address'" .
               "WHERE id = $id";

        //executing our sql query
        $result = $connection -> query($sql);

        //checking if our query has been executed or not
        if(!$result){
            $errorMessage = "Invalid query: " . $connection -> error;
            break;
        }

        //otherwise we can display the success message
        $successMessage = "Client Updated successfully!";

        //redirecting the user to the index page and end the execution of this file
        header("location: /crud/index.php");
        exit;
        
    }while (true);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web shop</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container my-5">
        <h2>New Client</h2>
        <!--error message if variable not empty-->
        <?php
        if (!empty($errorMessage)){
            echo "
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <strong>$errorMessage</strong>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='close'></button>
            </div>
            ";
        }
        ?>
        <form method="POST">
            <!--adding a hidden input that will store client id-->
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="name" value="<?php echo $name; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="email" value="<?php echo $email; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Phone</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="phone" value="<?php echo $phone; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Address</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="address" value="<?php echo $address; ?>">
                </div>
            </div>


            <!--sucess message if the variable successmessage is not empty-->
            <?php
            if (!empty($successMessage)){
                echo "
                <div class='row mb-3'>
                    <div class='offset-sm-3 col-sm-6'>
                        <div class='alert alert-success alert-dismissible dae-show' role='alert'>
                        <strong>$successMessage</strong>
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label></button>
                     </div>
                    </div>
                </div>
                ";
            }

            ?>
            <div class="row mb-3">
                <button class="offset-sm-3 col-sm-3 d-grid">Submit</button>
                <div class="col-sm-3 d-grid">
                <a class="btn btn-outline-primary" href="/crud/index.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>