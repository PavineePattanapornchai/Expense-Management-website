<?php
include('connect.php');
include('functions.php');
$loginError = '';
if(isset($_POST['login'])){
    // Get username from the form
    $username = checkvalue($_POST['username']);
    $password = checkvalue($_POST['password']);

    // Query to fetch the hashed password for the provided username
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password_from_db = $row['password'];

        // Verify the entered password with the hashed password from the database
        if (password_verify($password, $hashed_password_from_db)) {
            // Passwords match, set session or allow access
            $_SESSION['UID'] = $row['user_id'];
            $_SESSION['UNAME'] = $row['username'];
            $_SESSION['ROLEID'] = $row['role_id'];

            if ($_SESSION['ROLEID'] == 2) {
                header("Location: dashboard.php");
                exit();
            } else {
                header("Location: category.php");
                exit();
            }
        } else {
            // Passwords don't match
            $loginError = "Invalid username or password";
        }
    } else {
        // Username not found
        $loginError = "Invalid username or password";
    }
		
}  elseif (isset($_POST['signup'])) {
    $signup_username = checkvalue($_POST['signup_username']);
    $signup_password = checkvalue($_POST['signup_password']);
	
	$budget_amount = 0;

    // Perform necessary validations before inserting data into the database

    // For instance, you might hash the password for better security
    $hashed_password = password_hash($signup_password, PASSWORD_DEFAULT);

    // Query to insert new user into the database
    $insert_sql = "INSERT INTO users (username, password, role_id) VALUES ('$signup_username', '$hashed_password', 2)";
    
	
    if ($con->query($insert_sql) === TRUE) {
        // Retrieve the newly inserted user's details
        $newUserId = $con->insert_id;
        $getUserSql = "SELECT * FROM users WHERE user_id = '$newUserId'";
        $result = $con->query($getUserSql);
		
		$insert_budget_sql = "INSERT INTO budget (user_id, amount) VALUES ('$newUserId', '$budget_amount')";
		mysqli_query($con, $insert_budget_sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['UID'] = $row['user_id'];
            $_SESSION['UNAME'] = $row['username'];
            $_SESSION['ROLEID'] = $row['role_id'];

            if ($_SESSION['ROLEID'] == 2) {
                header("Location: dashboard.php");
                exit();
            } else {
                header("Location: category.php");
                exit();
            }
        } else {
            $loginError = "Error fetching user details";
        }
    } else {
        echo "Error: " . $insert_sql . "<br>" . $con->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="loginsignupstyle.css">
</head>
<body>
  <div class="container">
   <div class="form-container">
      <form action="" method="POST" >
        <h2>Login</h2>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login" >Login</button>
	  </form>
	  <?php
		if (isset($loginError)) {
			echo "<p style='color: red;'>$loginError</p>";
		} else { echo " ";}
		?>
	  <form action="" method="POST">
	  <h2>Sign Up</h2>
        <input type="text" name="signup_username" placeholder="Username" required>
        <input type="password" name="signup_password" placeholder="Password" required>	
		<!-- <input type="password" name="signup_cfpassword" placeholder="Confirm Password" required> -->
        <button type="submit" name="signup">Sign Up</button>
      </form>
  </div>
</body>
</html>
