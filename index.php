<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web shop</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-5">
        <h2>List of Clients</h2>
        <a class="btn btn-primary" href="/crud/create.php" role="button">New Client</a>
        <br>
        <table class="table">
            <thead>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Created At</th>
                <th>Action</th>
            </thead>
        <tbody>
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "marx";
            $database = "web_shop";

            //connection with the database
            $connection = new mysqli($servername, $username, $password, $database);

            //check if connection is established correctly or not
            if ($connection -> connect_error){
                die("Connection failed: " . $connection -> connect_error);
            }

            //otherwise we can read the data from the client table
            $sql = "SELECT * FROM clients";
            $result = $connection -> query ($sql);

            //if the query has been executed correctly or not
            if(!$result){
                die("Invalid query: " . $connection -> error);
            }

            //otherwise we can read data from this object 'result' using a while loop
            while ($row = $result -> fetch_assoc()){
                echo "
            <tr>
                <td>$row[id]</td>
                <td>$row[name]</td>
                <td>$row[email]</td>
                <td>$row[phone]</td>
                <td>$row[address]</td>
                <td>$row[created_at]</td>
                <td>
                    <a class='btn btn-primary btn-sm' href='/crud/edit.php?id=$row[id]'>Edit</a>
                    <a class='btn btn-danger btn-sm' href='/crud/delete.php?id=$row[id]'>Delete</a>
                </td>
            </tr>
            ";
            }
        ?>
            
        </tbody>
        </table>
    </div>
</body>
</html>