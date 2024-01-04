<?php
include('connect_admin.php');
include('functions.php');

$msg="";
$category="";
$label = "Add";
if(isset($_GET['id']) && $_GET['id']>0){
   	$label="Edit";
	$id=checkvalue($_GET['id']);
	$result=mysqli_query($con,"select * from category where category_id='$id'");
	$row = mysqli_fetch_assoc($result);
	$category = $row['name'];
 }

if(isset($_POST['submit'])){
	$name=checkvalue($_POST['name']);
	
	$result=mysqli_query($con,"select * from category where name='$name'");
	if ($result->num_rows >0) {
		$msg = "Category already exists";
	}else{
		if(isset($_GET['id']) && $_GET['id']>0){
		mysqli_query($con, "update category set name='$name' where category_id=$id");
		header("Location: category.php");
		}else{
		mysqli_query($con, "insert into category(name) values('$name')");
		header("Location: category.php");
		}
	}
	
		
	
}
	
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Expense Tracker Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Add the custom styles for the submit button */
        .submit-button {
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            background-color: #001a33; /* Dark loyal blue background */
            color: #fff; /* White text color */
            font-size: 14px; /* Font size 14px */
            cursor: pointer;
            transition: background-color 0.3s;
        }
    </style>
</head>

<body>
    <header>
        <h1>Expense Tracker</h1><br />
        <nav>
            <ul>
                <li><a href="category.php">Category</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="form-container" style="margin: 20px auto; max-width: 400px;">
            <h2 ><?php echo $label ?> Category</h2>
            <a class="addex" href="category.php">Back</a><br/>

            <form action="" method="POST" style="display: flex; flex-direction: column; align-items: center;">
                <table>
                    <tr>
                        <td class="budget-label">Category</td>
                        <td style="padding-left: 20px;"><input type="text" name="name" required value="<?php echo $category ?>"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" name="submit" value="Submit" class="custom-submit-button"></td>
                    </tr>
                </table>
            </form>

            <?php echo $msg; ?>
        </div>
    </main>

    <footer>
        <p>CSS326</p>
    </footer>
</body>

</html>
