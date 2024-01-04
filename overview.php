<?php
include('connect_user.php');
include('header.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Expense Category Distribution</title>
	<link rel="stylesheet" href="styles.css">
    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div id="chart-container">
        <canvas id="myChart"></canvas>
    </div>

    <?php
    

    // Fetch data from expense table
    $sql = "SELECT c.name AS category_name, SUM(e.price) as total_price 
			FROM expense e
			INNER JOIN category c ON e.category_id = c.category_id
			WHERE e.user_id = '".$_SESSION['UID']."'
			GROUP BY e.category_id";
	$result = $con->query($sql);

	$categories = [];
	$totalPrices = [];

	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			$categories[] = $row['category_name'];
			$totalPrices[] = $row['total_price'];
		}
	}

    $con->close();
    ?>

    <script>
    // PHP to JavaScript array conversion
    var categories = <?php echo json_encode($categories); ?>;
    var data = <?php echo json_encode($totalPrices); ?>;

    // Create pie chart
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: categories,
            datasets: [{
                label: 'Expense Category Distribution',
                data: data,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(153, 102, 255, 0.7)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                position: 'bottom',
            },
            title: {
                display: true,
                text: 'Expense Category Distribution'
            }
        }
    });
    </script>

<footer>
    <p>CSS326</p>
  </footer>
</body>
</html>
