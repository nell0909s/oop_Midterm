<?php 
    require_once('database.php');
?>  

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
        <button type="submit">Create Account</button>
        <br>
        <small>Already have account? Click <a href="login.php"> here </a></small>
    </form>
</body>
</html>



<?php 
    
    if(isset($_GET['username']) && isset($_GET['password'])){
        $username = trim($_GET['username']);
        $password = trim($_GET['password']);

        if($username === '' || $password === ''){
            echo "Please provide username and password.";
        } else {
            
            $existing = $users->find('user', ['username' => $username]);
            if($existing){
                echo "Username already exists.";
            } else {
                $fields = [
                    'username' => $username,
                    'password' => $password
                ];
                $create_user = $users->create('user', $fields);
                if($create_user){
                    echo "Account created successfully. <a href=\"login.php\">Login</a>";
                } else {
                    echo "Failed to create account.";
                }
            }
        }
    }
?>