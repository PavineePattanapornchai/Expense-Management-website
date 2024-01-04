<?php
include('connect_admin.php');
include('functions.php');
include('adminheader.php');

if(isset($_GET['type']) && $_GET['type']=='delete' && isset($_GET['category_id']) && $_GET['category_id']>0){
   $category_id=checkvalue($_GET['category_id']);
   mysqli_query($con,"delete from category where category_id=$category_id");
   echo "<br/>Data deleted<br/>";
   }

$result=mysqli_query($con,"select * from category order by category_id asc");
?>

<!DOCTYPE html>

    <main>
        <h2>Category</h2>
        <a class="addex" href="addedit_category.php"><em>Add Category</em></a>
        
        <div class="table-box">
            <div class="table-row table-head">
                <div class="table-cell">ID</div>
                <div class="table-cell">Name</div>
                <div class="table-cell">Actions</div>
            </div>

            <?php
            while($row=mysqli_fetch_assoc($result)) {
            ?>
            <div class="table-row">
                <div class="table-cell"><?php echo $row['category_id'];?></div>
                <div class="table-cell"><?php echo $row['name']?></div>
                <div class="table-cell">
                    <a href="addedit_category.php?id=<?php echo $row['category_id'];?>">Edit</a>&nbsp;
                    <a href="?type=delete&category_id=<?php echo $row['category_id'];?>">Delete</a>
                </div>
            </div>
            <?php
            }
            ?>
        </div>
        
    </main>

    <footer>
        <p>CSS326</p>
    </footer>
</body>
</html>
