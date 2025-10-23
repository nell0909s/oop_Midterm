<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <br>
    <form action="" method="GET">
        <label for="username">Username:    </label>
        <input type="text" id="username" name="username">
        <br>
        
        <label for="password">Password: </label>
        <input type="text" id="password" name="password">

        <br>
        <button type="submit">Login</button>
        <br>
        <small>Dont have an account? Click <a href="index.php"> here </a></small>
    </form>
</body>
</html>

<?php
    include_once('database.php');
    session_start();

    if(isset($_GET['username']) && isset($_GET['password'])){
        $username = trim($_GET['username']);
        $password = trim($_GET['password']);

        if($username === '' || $password === ''){
            echo "Please provide username and password.";
        } else {
            $user = $users->find('user', ['username' => $username, 'password' => $password]);
            if($user){
                $_SESSION['user_id'] = $user['id'] ?? $user['user_id'] ?? $user['username'];
                header('Location: home.php');
                exit;
            } else {
                echo "Invalid credentials.";
            }
        }
    }

?>