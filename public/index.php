<?php
    
    $errors = [];

   if( $_SERVER['REQUEST_METHOD'] === 'POST' ) { 
    // Connect db
    $db = mysqli_connect('localhost', 'root', '', 'php');

    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    // Form Validation
    if( $username == '' ) { array_push($errors, 'სახელი ცარიელია'); }
    if( $password == '' ) { array_push($errors, 'პაროლი ცარიელია'); }
    
    // if no errors
    if( count($errors) == 0 ) {
        
        $query = " SELECT * FROM users WHERE username='$username' AND pass='$password' ";
        $result = mysqli_query($db, $query);
        $user = mysqli_fetch_assoc($result);
        if( $user['username'] == $username && $user['pass'] == $password ) {
            session_start();
            $_SESSION['username'] = $username;
            header('location: /php/main');
        } else {
            array_push($errors, 'სახელი ან პაროლი არასწორია');
        } 
    } else {
        /*
        foreach($errors as $err) {
            echo $err;
        } */
    }
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="./public/css/style.css">
    <title>Document</title>
</head>
<body>

    <form action="" method="POST">
        <h2> ავტორიზაცია </h2>
        <input type="text" name="username" placeholder="სახელი" />
        <input type="password" name="password" placeholder="პაროლი" />
        <button type="submit" name="login">ავტორიზაცია</button>
        <a href="/php/register"> რეგისტრაცია </a>
    </form>

    <div class="errors">
        <?php 
            if( count($errors) > 0 ) {
                foreach( $errors as $err ) { ?>
                     <p> <?php echo $err ?> </p>
               <?php }
            }
        ?>
    </div>


</body>
</html>