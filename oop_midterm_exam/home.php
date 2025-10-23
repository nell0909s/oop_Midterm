<?php 
require_once('database.php');
session_start();


if(!isset($_SESSION['user_id'])){
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    <?php 
        
        $data = $users->show_all('user');
    ?>
    <table border="1">
        <thead>
            <tr>
                <td>Name</td>
                <td>Section</td>
                <td>Action</td>
            </tr>
        </thead>
        <tbody>
            <?php 
                foreach ($data as $key => $value) {
                    $id = $value['id'] ?? $value['user_id'] ?? $value['userId'] ?? '';
                    $uname = htmlspecialchars($value['username'] ?? $value['name'] ?? '');
                    echo    "<tr>
                                <td>".$uname."</td>
                                <td></td>
                                <td>
                                    <a href='delete.php?id=".$id."' onclick=\"return confirm('Delete this user?');\">Delete</a>
                                    &nbsp;|&nbsp;
                                    <a href='update.php?id=".$id."'>Update</a>
                                </td>
                            </tr>";
                }
            ?>
        </tbody>
    </table>
</body>
</html>