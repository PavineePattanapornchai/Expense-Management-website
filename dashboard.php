<?php 
include('connect_user.php');
include('functions.php');
include('header.php');
checkUser();
userArea();

?>
<!DOCTYPE html>


  <main class="dashboard">
    <div class="box">
      <h2>฿<?php echo calculateExpense('today')?></h2>
      <p>Today's Expense</p>
    </div>
	<div class="box">
      <h2>฿<?php echo calculateExpense('yesterday')?></h2>
      <p>Yesterday's Expense</p>
    </div>
	<div class="box">
      <h2>฿<?php echo calculateExpense('week')?></h2>
      <p>This Week's Expense</p>
    </div>
	<div class="box">
      <h2>฿<?php echo calculateExpense('month')?></h2>
      <p>This Month's Expense</p>
    </div>
	<div class="box">
      <h2>฿<?php echo calculateExpense('year')?></h2>
      <p>This Year's Expense</p>
    </div>
    <div class="box">
      <h2>฿<?php echo calculateExpense('total')?></h2>
      <p>Total's Expense</p>
    </div>
  </main>
  
  <?php if(isset($_POST['submit'])){
$amount = checkvalue($_POST['amount']);
$user_id = $_SESSION['UID'];
$sql = "UPDATE budget SET amount = '$amount' WHERE user_id = '$user_id'";
 if ($con->query($sql) === TRUE) {
//$result = $con->query($sql);
	mysqli_query($con, $sql);
 }else{ $inputerror = "Wrong input!!!";}
}
	
?>

<h2 class="budget-heading"> Budget </h2>
<div class="budgetform-container">
 <h2 class="inserturbud-heading"> Insert Monthly Budget</h2>
<form action="" method="POST">
	<input type="text" name="amount">
	<button type="submit" name="submit" value="Submit" class="submit-button">Submit</button>
</form> 
<label class="budget-label"> Your Monthly Budget: ฿<?php echo getBudgetAmount()?></label>
<br/><br/>
 <div class="boxbud">
      <h2>฿<?php echo getBudgetAmount() - calculateExpense('month')?></h2>
      <p>Remaining Budget</p>
	   <?php
		if (isset($inputerror)) {
			echo "<p style='color: red;'>$inputerror</p>";
		} else { echo " ";}
		?>
    </div>

</div>
	

  <footer>
    <p>CSS326</p>
  </footer>
</body>
</html>
