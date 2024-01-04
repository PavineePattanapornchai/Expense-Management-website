<?php
include('connect_user.php');
include('functions.php');
include('header.php');
checkUser(); 
userArea();
$msg=" ";

if(isset($_GET['type']) && $_GET['type']=='delete' && isset($_GET['id']) && $_GET['id']>0){
   $id=checkvalue($_GET['id']);
   mysqli_query($con,"delete from expense where id=$id");
   $msg = "<br/>Data deleted<br/>";
   }

$result=mysqli_query($con,"select expense.*,category.name from expense,category where expense.category_id=category.category_id and expense.user_id='".$_SESSION['UID']."'");

?>


<!DOCTYPE html>


  <main>
  <h2 class="expense-heading">Expense</h2> 
  <a class="addex" href="addedit_expense.php" class="add-expense-link"><em>Add Expense</em></a>
  <?php if(mysqli_num_rows($result)>0){ ?>
    <div class="table-box">
      <div class="table-row table-head">
        <div class="table-cell">ID</div>
        <div class="table-cell">Category</div>
        <div class="table-cell">Item</div>
        <div class="table-cell">Price</div>
        <div class="table-cell">Details</div>
        <div class="table-cell">Date</div>
        <div class="table-cell last-cell">Actions</div>
      </div>

      <?php while($row=mysqli_fetch_assoc($result)): ?>
        <div class="table-row">
          <div class="table-cell"><?php echo $row['id'];?></div>
          <div class="table-cell"><?php echo $row['name']?></div>
          <div class="table-cell"><?php echo $row['item']?></div>
          <div class="table-cell"><?php echo $row['price']?></div>
          <div class="table-cell"><?php echo $row['details']?></div>
          <div class="table-cell"><?php echo $row['expense_date']?></div>
          <div class="table-cell last-cell">
            <a href="addedit_expense.php?id=<?php echo $row['id'];?>">Edit</a>&nbsp;
            <a href="?type=delete&id=<?php echo $row['id'];?>">Delete</a>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  <?php }else {echo "<p class='no-data'>No data found</p>";}?>


  <?php echo $msg;?>
</main>



  <footer>
    <p>CSS326</p>
  </footer>
</body>
</html>
