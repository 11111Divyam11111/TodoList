
<!-- Connecting PHP to MySql -->
<?php

    $server = '127.0.0.1';
    $username = 'root';
    $password = '';
    $database = 'todo_master';
    
    $conn = mysqli_connect($server,$username,$password,$database);

    // checking for the error
    if($conn->connect_errno){ 
        die("connection to mysql failed : ".$conn->connect_error);
    }

    // create a todo item
    if(isset($_POST['add'])){
        $item = $_POST['item'];
        if(!empty($item)){
            $query = "INSERT INTO todo (name) VALUE ('$item')";
            
            // execute the query
            if(mysqli_query($conn,$query)){
                echo'
                <center>
                    <div class="alert alert-success" role="alert">
                        Task added successfully!
                    </div>
                </center>
                ';
            }
            else{
                echo mysqli_error($conn);
            }
        }
    }


     // mark as done a todo item
    if(isset($_GET['action'])){
        $itemId = $_GET['item'];
        if(isset($_GET['action']) =='done'){
            $query = "UPDATE todo SET status = 1 WHERE id = '$itemId'";
            
            // execute the query
            if(mysqli_query($conn,$query)){
                echo'
                <center>
                    <div class="alert alert-info" role="alert">
                        Task done successfully!
                    </div>
                </center>
                ';
            }
            else{
                echo mysqli_error($conn);
            }
        }
        if($_GET['action']=='delete'){
            $query = "DELETE FROM todo WHERE id = '$itemId'";
            if(mysqli_query($conn,$query)){
                echo'
                <center>
                    <div class="alert alert-danger" role="alert">
                        Task deleted successfully!
                    </div>
                </center>
                ';
            }
            else{
                echo mysqli_error($conn);
            }
        }
    }




?>
    <!-- Website -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To do List</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>
    <main>                   
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-12">
                    <div class="card border-dark mb-3">
                        <div class="card-header">
                            <h3 id="todo">Todo List</h3>
                        </div>
                        <div class="card-body">
                            <form method="post" action="<?= $_SERVER['PHP_SELF']?>">
                                <div class="body-text">
                                    <input  type="text" class="form-control" name="item" placeholder=" Add a task">                            
                                </div>                        
                                <input  type="submit" class="btn btn-light" name="add" value="Add item">
                            </form>
                            <div>                                
                                <?php
                                    $query = "SELECT * FROM todo";
                                    // executing the query
                                    $result = mysqli_query($conn,$query); 
                                    if($result->num_rows > 0){
                                        $i=1;
                                        while($row = $result->fetch_assoc()){
                                            $done = $row['status'] == 1 ? "done" : "";
                                            echo '
                                                <div class="row" id="row">                                                    
                                                    <div class="col-md-1 col-1"><h5>'.$i.'</h5></div> 
                                                    <div class="col-md-7 col-6"><h5 class="'.$done.'">'.$row['name'].'</h5></div>
                                                    <div class="col-md-4 col-5">
                                                        <a href="?action=done&item='.$row['id'].'" class="btn btn-primary">Done</a>
                                                        <a href="?action=delete&item='.$row['id'].'" class="btn btn-warning">Delete</a>
            
                                                    </div>
                                                </div>
                                            ';
                                            $i++;
                                        }
                                    }
                                    else{
                                        echo'
                                            <center>
                                                <img class="bore-img" src="bore-2.png" alt="somethings missing">
                                                <p> Something is missing!</p>
                                            </center>
                                        ';
                                    }                                
                                ?>                                
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>        
    </main>    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){
        $(".alert").fadeTo(5000,500).slideUp(500,function(){
            $('.alert').slideUp(500);
        });
    })
</script>
</body>
</html>