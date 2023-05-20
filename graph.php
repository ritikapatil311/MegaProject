<!DOCTYPE html>
<html>
<head>
    <title>Pie Chart Example</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .card {
            width: 400px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="card">
        <h2>Pie Chart Example</h2>
        <canvas id="pieChart"></canvas>
    </div>

    <?php
    // Establish database connection
    $mysqli = new mysqli('localhost', 'root', '', 'rc');

    // Check connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Retrieve data from the posts table
    $sql = "SELECT COUNT(*) AS count, user_id FROM posts GROUP BY user_id";
    $result = $mysqli->query($sql);

    // Prepare the data for the chart
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row['count'];
    }

    // Close the database connection
    $mysqli->close();

    // Convert the data to JSON format
    $data_json = json_encode($data);
    ?>

    <script>
        var chartData = <?php echo $data_json; ?>;

        // Get the canvas element
        var ctx = document.getElementById('pieChart').getContext('2d');

        // Create the chart
        var chart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['User 1', 'User 2', 'User 3'], // Replace with your actual labels
                datasets: [{
                    label: 'Number of Posts',
                    data: chartData,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 206, 86, 0.6)'
                    ]
                }]
            },
            options: {
                responsive: true
            }
        });
    </script>
</body>
</html>
