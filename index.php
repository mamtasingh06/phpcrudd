<?php
    $db_host = "localhost";
    $db_user = "root";
    $db_password = "";
    $db_name = "test";
    $conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);
    // Database Connection
    if(!$conn)
    {
        die('connection failed');
    }
    echo "connected successfully". "<hr>";

    //insert

    if(isset($_REQUEST['submit'])){
        // checking for empty field
        if(($_REQUEST['name'] == "") || ($_REQUEST['email'] == "") || ($_REQUEST['designation'] == "")||
         ($_REQUEST['salary'] == "")
        || ($_REQUEST['date'] == "")){
          echo"<small>Fill all fields..</small><hr>";
        }
        else {
            $name = $_REQUEST['name'];
            $email = $_REQUEST['email'];
            $desig = $_REQUEST['designation'];
            $salary = $_REQUEST['salary'];
            $date = $_REQUEST['date'];
          $sql = "INSERT INTO employee (name, email, designation, salary, date) VALUES ('$name', '$email', '$desig', '$salary', '$date')";
        
          if (mysqli_query($conn, $sql)) {
              echo "New record created successfully <hr>";
          } else {
            echo "Error deleting record: " . mysqli_error($conn);
          }
        }
      }

     // sql to delete a record
if(isset($_REQUEST['delete'])){
    $sql = "DELETE FROM employee WHERE id= {$_REQUEST['id']}";

    if (mysqli_query($conn, $sql)) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}

    // Update
    if(isset($_REQUEST['update']))
    {
        if(($_REQUEST['name'] == "") || ($_REQUEST['email'] == "") || ($_REQUEST['designation'] == ""))
        {
            echo "<small>Fill all fields </small>";
        }
        else{
            $name = $_REQUEST['name'];
            $email = $_REQUEST['email'];
            $desig = $_REQUEST['designation'];
           $salary = $_REQUEST['salary'];
            $date = $_REQUEST['date'];
            $sql = "UPDATE employee SET name = '$name', email = '$email', designation = '$desig', salary = '$salary' WHERE id= {$_REQUEST['id']}";
            if (mysqli_query($conn, $sql))
            
            {
                echo "Updated";
            }
            else{
                echo "Not Updated";
               mysqli_error($conn);
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                
                <?php
                // Data shown in form from database 
                     if(isset($_REQUEST['edit']))
                     {
                         $sql = "Select * From employee Where id = {$_REQUEST['id']}";
                         $result = mysqli_query($conn, $sql);
                         $row = mysqli_fetch_assoc($result);

                     }
                ?>
                <!-- form -->
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id = "name" value="<?php
                        if(isset($row['name'])){
                        echo $row["name"];}
                        ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" name="email" id = "email" value="<?php
                        if(isset($row['email'])){
                        echo $row["email"];}
                        ?>">
                    </div>
                    <div class="form-group">
                        <label for="desig">Designation</label>
                        <input type="text" class="form-control" name="designation" id = "desig" value="<?php
                        if(isset($row['designation'])){
                        echo $row["designation"];}
                        ?>">
                    </div>
                    <div class="form-group">
                        <label for="salary">Salary</label>
                        <input type="text" class="form-control" name="salary" id = "salary" value="<?php
                        if(isset($row['salary'])){
                        echo $row["salary"];}
                        ?>">
                    </div>
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="date" class="form-control" name="date" id = "date" value="<?php
                        if(isset($row['date'])){
                        echo $row["date"];}
                        ?>">
                    </div>
                    <input type="hidden" name="id" value="<?php 
                        echo $row['id']
                    ?>">
                    <button type ="submit" class="btn btn-success mt-3" name = "update" >Update</button>
                    <button type ="submit" class="btn btn-success mt-3" name = "submit" >Submit</button>
                </form>
            </div>
            <div class = "col-sm-6 offset-sm-2">
                 <?php
                    
                     $sql = "Select * From employee";
                     $result = mysqli_query($conn, $sql);
                     if(mysqli_num_rows($result) > 0)
                     {
                         echo '<table class = "table">';
                             echo "<thead>";
                                 echo "<tr>";
                                     echo "<th>ID</th>";
                                     echo "<th>Name</th>";
                                     echo "<th>Email</th>";
                                     echo "<th>Designation</th>";
                                     echo "<th>Salary</th>";
                                     echo "<th>Date</th>";
                                     echo "<th>Edit</th>";
                                     echo "<th>Delete</th>";
                                     
                                 echo "</tr>";
                             echo "</thead>";
                             echo "<tbody>";
                                 while($row = mysqli_fetch_assoc($result))
                                 {
                                     echo "<tr>";
                                         echo "<td>" . $row["id"] . "</td>";
                                         echo "<td>" . $row["name"] . "</td>";
                                         echo "<td>" . $row["email"] . "</td>";
                                         echo "<td>" . $row["designation"] . "</td>";
                                         echo "<td>" . $row["salary"] . "</td>";
                                         echo "<td>" . $row["date"] . "</td>";
                                         echo '<td><form action="" method="POST">
                                          <input type = "hidden" name = "id" value = ' . $row["id"] . '>
                                         <input type = "submit" class = "btn btn-sm btn-danger" name = "edit"
                                          value = "Edit"></form></td>';
                                          echo '<td><form action="" method="POST">
                                          <input type = "hidden" name = "id" value = ' . $row["id"] . '>
                                         <input type = "submit" class = "btn btn-sm btn-danger" name = "delete"
                                          value = "delete"></form></td>';
                                          echo "</tr>";
                                 }
                                 
                             echo "</tbody>";
                         echo '</table>';
                     
                     }
                     else
                     {
                         echo " 0 results";
                     }
                 ?>
                
            </div>
        </div>

    </div>

    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.js"></script>
    <script src="js/popper.js"></script>
</body>
</html>