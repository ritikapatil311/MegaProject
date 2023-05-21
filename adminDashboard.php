<?php
session_start();

// Check if the admin is not logged in, redirect to login page
if (!isset($_SESSION['admin_id'])) {
    header("Location: adminLogin.php");
    exit();
}

// Check if logout request is submitted
if (isset($_POST['logout'])) {
    // Destroy the session and redirect to login page
    session_destroy();
    header("Location: adminLogin.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .navbar {
            background-color: #333;
            color: #fff;
        }
        .navbar-brand {
            color: #fff;
        }
        .sidebar {
            background-color: #f8f9fa;
            height: 100vh;
        }
        .content {
            margin-top: 20px;
        }
        .chart-card {
            margin-top: 20px;
            width: 300px;
            height: 300px;
            margin-left: auto;
            margin-right: 20px;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <span class="navbar-brand">Admin Dashboard</span>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <form method="post">
                    <button type="submit" class="btn btn-link nav-link" name="logout">Logout</button>
                </form>
            </li>
        </ul>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 sidebar">
               <!-- Sidebar content here -->
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="admin.php">Manage Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="adminUsers.php">Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="display.php">Posts</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-10 content">
                <!-- Content here -->
                <?php
                // Database connection
                $mysqli = new mysqli('localhost', 'root', '', 'rc');

                // Check if the connection was successful
                if ($mysqli->connect_errno) {
                    echo 'Failed to connect to MySQL: ' . $mysqli->connect_error;
                    exit();
                }

                // Fetch post statistics
                $result = $mysqli->query('SELECT users.name, COUNT(posts.id) AS post_count FROM posts INNER JOIN users ON posts.user_id = users.uid GROUP BY users.uid');
                $data = array();
                $labels = array();
                while ($row = $result->fetch_assoc()) {
                    $labels[] = $row['name'];
                    $data[] = $row['post_count'];
                }

                // Close database connection
                $mysqli->close();
                ?>
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">Post Statistics</div>
                            <div class="card-body">
                                <h5 class="card-title">Posts Distribution</h5>
                                <p class="card-text">Number of posts by users:</p>
                                <div class="chart-card">
                                    <canvas id="postChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Chart configuration
        var ctx = document.getElementById('postChart').getContext('2d');
        var postChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    data: <?php echo json_encode($data); ?>,
                    backgroundColor: ['#007bff', '#28a745', '#dc3545', '#ffc107', '#17a2b8'],
                }]
            },
            options: {
                responsive: true,
                legend: {
                    position: 'right',
                },
                layout: {
                    padding: 10,
                },
                plugins: {
                    datalabels: {
                        color: '#fff',
                        backgroundColor: function(context) {
                            return context.dataset.backgroundColor;
                        },
                        borderRadius: 4,
                        font: {
                            weight: 'bold'
                        },
                        formatter: function(value, context) {
                            return value + ' posts';
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
