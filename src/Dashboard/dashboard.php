<?php

session_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../Login/login.php');
    exit();
}

$username = $_SESSION['username'];

$config = parse_ini_file('../../private/config.ini');
define('DB_hostname', 'localhost');

$connection = mysqli_connect(DB_hostname, $config['username'], $config['password'], $config['dbname']);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $messageText = $_POST['messageText'] ?? '';
    $messageTitle = $_POST['title'] ?? '';
    $dt = date('Y-m-d H:i:s');

    $stmt = $connection->prepare("SELECT * FROM users WHERE board_username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $userid = $user['userid'];

    $stmt->close();

    $sql_in = "INSERT INTO post (title, body, userid, date_time) VALUES (?, ?, ?, ?)";
    $stmt_in = $connection->prepare($sql_in);
    $stmt_in->bind_param("ssis", $messageTitle, $messageText, $userid, $dt);
    $stmt_in->execute();
    $stmt_in->close();
} else {
    $sql = "SELECT board_username, post.title, post.body, post.date_time FROM users INNER JOIN post ON users.userid = post.userid";
    $response = $connection->query($sql);

    if ($response->num_rows > 0) {
        while ($row = $response->fetch_assoc()) {
            echo "<script>console.log(" . json_encode($row) . ")</script>";
        }
        
    }
}

$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&family=Open+Sans&display=swap">
</head>
<body>
    <div class="main">
        <div class="header">
            <div class="header-title"><h2>Message Board</h2></div>
            <div class="header-username"><img src="../../images/avatar.svg" /><h3><?php echo $username; ?></h3></div>
        </div>
        <div class="dashboard-header"><h1><?php echo $username . "'s Dashboard" ; ?></h1></div>
        <div class="form-container">
            <form action="dashboard.php" method="POST">
                <input type="text" id="title" name="title" placeholder="Title" required />
                <textarea id="messageText" name="messageText" placeholder="Start typing..." required></textarea>
                <input type="submit" value="Post" />
            </form>
        </div>
        <div class="content">
            
        </div>
    </div>

    <script>
        const textarea = document.querySelector("textarea");
        textarea.addEventListener("keyup", e => {
            textarea.style.height = "64px";
            let height = e.target.scrollHeight;
            textarea.style.height = `${height}px`;
        })
    </script>
    
</body>
</html>