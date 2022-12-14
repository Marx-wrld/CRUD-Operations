<!--we need to write the php code that allows us read the submitted data-->
<?php
//establishing connection with the database
$servername = "localhost";
$username = "root";
$password = "marx";
$database = "web_shop";

//connection with the database
$connection = new mysqli($servername, $username, $password, $database);


//variable initialization
$name = "";
$email = "";
$phone = "";
$address = "";
$errorMessage = "";
$successMessage = "";


//lets check if the data has been transmitted using the post method
if( $_SERVER['REQUEST_METHOD'] == 'POST'){
    //if the data has been transmitted using the post method then we can initialize these variables
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];

    //we then need to check that we dont have any empty fields
    //we can use a while loop that is executed only once
    //using this loop we can exit using the break statement if we have any error
    do{
        if (empty($name) || empty($email) || empty($phone) || empty($address)){
            $errorMessage = "All the fields are required!";
            break;
        }


        //inserting new client to the database
        $sql = "INSERT INTO clients (name, email, phone, address)" . "VALUES ('$name', '$email', '$phone', '$address')";
        $result = $connection -> query($sql);

        if(!$result){
            $errorMessage = "Invalid query: " . $connection -> error;
            break;
        }

        //if we dont have any empty field then we can create a new client
        $name = "";
        $email = "";
        $phone = "";
        $address = "";
        //success message
        $successMessage = "Client added sucessfully!";

        //redirecting the user to the list of clients
        header('location: /crud/index.php');
        exit;

    }while(false);
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
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class="col-sm-3 d-grid">
                <a class="btn btn-outline-primary" href="/crud/index.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>