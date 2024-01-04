<?php
include('connect_user.php');
include('header.php');
include('functions.php');

$msg="";
$category_id ="";
$item="";
$price="";
$details="";
$expense_date="";
$label = "Add";
if(isset($_GET['id']) && $_GET['id']>0){
   	$label="Edit";
	$id=checkvalue($_GET['id']);
	$result=mysqli_query($con,"select * from expense where id='$id'");
	$row = mysqli_fetch_assoc($result);
	$category_id = $row['category_id'];
	$item = $row['item'];
	$price = $row['price'];
	$details = $row['details'];
	$expense_date = $row['expense_date'];
	
	if($row['user_id']!=$_SESSION['UID']){
   		header("Location: expense.php");
   	}
 }

if(isset($_POST['submit'])){
	$category_id=checkvalue($_POST['category_id']);
	$item=checkvalue($_POST['item']);
	$price=checkvalue($_POST['price']);
	$details=checkvalue($_POST['details']);
	$expense_date=checkvalue($_POST['expense_date']);
	
	$type="add";
	$sub_sql="";
	if(isset($_GET['id']) && $_GET['id']>0){
   		$type="edit";
   		$sub_sql="and id!=$id";
   	}
		$user_id=$_SESSION['UID'];
		$sql="insert into expense(category_id,item,price,details,expense_date,user_id ) values('$category_id','$item','$price','$details','$expense_date','$user_id ')";
		
	if(isset($_GET['id']) && $_GET['id']>0){
   		$sql="update expense set category_id='$category_id',item='$item',price='$price',details='$details',expense_date='$expense_date' where id=$id";
   	}
   	mysqli_query($con,$sql);
   	header("Location: expense.php");
	
		
	
}
	
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Expense Tracker Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <main>
        <div class="form-container" style="margin: 20px auto; max-width: 400px;">
 		<a class="addex" href="expense.php" >Back</a>
           <h2 style="margin-bottom: 20px;"><?php echo $label ?> Expense</h2>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <!-- <a class="addex" href="expense.php" style="font-style: italic;">Back</a> -->
            </div>

            <form action="" method="POST" style="display: flex; flex-direction: column; align-items: center;">
                <table>
                    <tr>
                        <td class="budget-label">Category</td>
                        <td style="padding-left: 20px;">
                            <select name="category_id">
                                <?php
                                $categoryq = 'SELECT category_id, name FROM category;';
                                if ($result = $con->query($categoryq)) {
                                    while ($row = $result->fetch_array()) {
                                        echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
                                    }
                                } else {
                                    echo 'Query error: ' . $con->error;
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="budget-label">Item</td>
                        <td><input type="text" name="item" required value="<?php echo $item ?>" style="margin-bottom: 20px;"></td>
                    </tr>
                    <tr>
                        <td class="budget-label">Price</td>
                        <td><input type="text" name="price" required value="<?php echo $price ?>" style="margin-bottom: 20px;"></td>
                    </tr>
                    <tr>
                        <td class="budget-label">Details</td>
                        <td><input type="text" name="details" required value="<?php echo $details ?>" style="margin-bottom: 20px;"></td>
                    </tr>
                    <tr>
                        <td class="budget-label">Date</td>
                        <td><input type="date" name="expense_date" required value="<?php echo $expense_date ?>" style="margin-bottom: 20px;"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="budget-label"><input type="submit" name="submit" value="Submit" class="custom-submit-button"></td>
                    </tr>
                </table>
            </form>
        </div>
    </main>

    <footer>
        <p>CSS326</p>
    </footer>
</body>

</html>
