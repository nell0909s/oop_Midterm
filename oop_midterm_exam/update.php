<?php
require_once('database.php');


if(!isset($_GET['id']) && !isset($_POST['id'])){
    header('Location: home.php');
    exit;
}


if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $id = (int)$_POST['id'];
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if($username === '' || $password === ''){
        $error = 'Please fill all fields.';
    } else {
        $updated = $users->update('user', ['username' => $username, 'password' => $password], $id);
        header('Location: home.php');
        exit;
    }
}


$id = (int)($_GET['id'] ?? $_POST['id']);
$user = $users->find('user', ['id' => $id]);
if(!$user){
    header('Location: home.php');
    exit;
}
?>

<?php if(!empty($error)) echo '<p style="color:red">'.htmlspecialchars($error).'</p>'; ?>
<form action="" method="POST">
    <input type="hidden" name="id" value="<?php echo (int)$user['id']; ?>">
    <label for="username">Username: </label>
    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>">
    <br>
    <label for="password">Password: </label>
    <input type="text" id="password" name="password" value="<?php echo htmlspecialchars($user['password']); ?>">
    <br>
    <button type="submit">Update User</button>
</form>

