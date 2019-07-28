<?php

//check existence of id parameter before processing further

if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
	//include config file for connection

	require_once "config.php";

	//prepare a select statement

	$sql = "SELECT * FROM employees WHERE id = ?";

	if($stmt = mysqli_prepare($link, $sql)){
		//bind variables to the prepared statement as parameters
		mysqli_stmt_bind_param($stmt, "i", $param_id);

		//set parametes
		$param_id = trim($_GET["id"]);

		//Attempt to execute the prepared statement

		if(mysqli_stmt_execute($stmt)){
			$result = mysqli_stmt_get_result($stmt);

			if(mysqli_num_rows($result) == 1){
				/*Fetch result row as san associative array. Since the result set contains only one row, we don't need to use while loop*/
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

				//Retrieve individual field value
				$name = $row["name"];
				$address = $row["address"];
				$salary = $row["salary"]; 

			} else{
				//URL dosen't contain valid id parameter, Redirect to error page
				header("location:error.php");
				exit();
			}
		}
		else{
			echo "Oops! Something went wrong . Please try again later.";

		}
	}

	//close statement
	mysqli_stmt_close($stmt);

	//close connection
	mysqli_close($link);
}
else
{
	//url dosen't contain id parameter. Redirect to error page
	header("location: error.php");
	exit(); 
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h1>View Record</h1>
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <p class="form-control-static"><?php echo $row["name"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <p class="form-control-static"><?php echo $row["address"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Salary</label>
                        <p class="form-control-static"><?php echo $row["salary"]; ?></p>
                    </div>
                    <p><a href="index.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>