<?php
session_start();


if (!isset($_SESSION['admin_id'])) {
    header("Location: adminLogin.php");
    exit();
}


if (isset($_POST['logout'])) {
   
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
            width: 600px;
            height: 300px;
            margin-left: auto;
            margin-right: auto;
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
                        <a class="nav-link" href="posts.php">Posts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Requests.php">Requests</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="CompletedTask.php">Tasks</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-10 content">
               
                <?php
                
                $mysqli = new mysqli('localhost', 'root', '', 'rc');

                
                if ($mysqli->connect_errno) {
                    echo 'Failed to connect to MySQL: ' . $mysqli->connect_error;
                    exit();
                }

                
                $resultPosts = $mysqli->query('SELECT users.name, COUNT(posts.id) AS post_count FROM posts INNER JOIN users ON posts.user_id = users.uid GROUP BY users.uid');
                $resultComments = $mysqli->query('SELECT politicians.name, COUNT(politician_comments.id) AS comment_count FROM politician_comments INNER JOIN politicians ON politician_comments.politician_id = politicians.id GROUP BY politicians.id');
                $dataPosts = array();
                $labelsPosts = array();
                $dataComments = array();
                $labelsComments = array();
                while ($row = $resultPosts->fetch_assoc()) {
                    $labelsPosts[] = $row['name'];
                    $dataPosts[] = $row['post_count'];
                }
                while ($row = $resultComments->fetch_assoc()) {
                    $labelsComments[] = $row['name'];
                    $dataComments[] = $row['comment_count'];
                }

                
                $mysqli->close();
                ?>
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">Statistics</div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5 class="card-title">Posts Distribution</h5>
                                        <p class="card-text">Number of posts by users:</p>
                                        <div class="chart-card">
                                            <canvas id="postChart"></canvas>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h5 class="card-title">Comments Distribution</h5>
                                        <p class="card-text">Number of comments by politicians:</p>
                                        <div class="chart-card">
                                            <canvas id="commentChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
       
        var ctxPosts = document.getElementById('postChart').getContext('2d');
        var postChart = new Chart(ctxPosts, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($labelsPosts); ?>,
                datasets: [{
                    data: <?php echo json_encode($dataPosts); ?>,
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

        
        var ctxComments = document.getElementById('commentChart').getContext('2d');
        var commentChart = new Chart(ctxComments, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($labelsComments); ?>,
                datasets: [{
                    data: <?php echo json_encode($dataComments); ?>,
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
                            return value + ' comments';
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
