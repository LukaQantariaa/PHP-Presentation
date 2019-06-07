<?php

    session_start();
    if( isset($_SESSION['username']) ) {
        //User is logIn.
    } else {
        header("location: /php");
    }

    if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
        if( isset( $_POST['logout'] ) ) {
            session_destroy();
            unset($_SESSION['username']);
            header("location: /php");
        }
        if( isset($_POST['delete']) ) {
            $conn = mysqli_connect('localhost', 'root', '', 'php');
            $postid = mysqli_real_escape_string($conn, $_POST['delete']);
            $sql = "DELETE FROM posts WHERE postid='$postid'";
            mysqli_query($conn, $sql);
        }
    }


    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profile</title>
    <link rel="stylesheet" type="text/css" href="./public/css/profile.css">
</head>
<body>
    <header>
        <a href="/php/main" class="logo"> საიტის სახელი </a>
        <div class="header-right">
            <form action="" method="post">
                <button type="submit" name="logout">გამოსვლა</button>
            </form>
        </div>
    </header>
    <main>
        <div class="userInfo">
            <h1>მომხმარებლის ინფორმაცია</h1>
            <div class="info">
                <?php 
                    $conn = mysqli_connect('localhost', 'root', '', 'php');
                    $username = mysqli_real_escape_string($conn, $_SESSION['username']);
                    $sql = "SELECT * FROM users WHERE username = '$username' ";
                    $result = $conn->query($sql);
                    $user = mysqli_fetch_assoc($result);
                ?>
                <p>სახელი: <?php echo $user['username'] ?> </p>
                <p>მეილი: <?php echo $user['email'] ?> </p>
                <p>ასაკი: <?php echo $user['age'] ?> </p-->
            </div>
        </div>

        <div class="admin">
            <?php if($_SESSION['username'] == 'admin') {
                $conn = mysqli_connect('localhost', 'root', '', 'php');
                $sql = "SELECT * FROM posts ";
                $result = $conn->query($sql); ?>
                <h1> ადმინ პანელი </h1>
                <form action="" method="POST"> <?php
                if($result->num_rows > 0) { 
                    while($row = $result->fetch_assoc()) { ?>
                        <h1 class="idbody" name="postid"> <?php echo $row['postid'] . ': ' .$row['body'] ?> </h1>
                        <button name="delete" value="<?php echo $row['postid'] ?>">წაშლა</button>
                   <?php }
                } ?> </form> <?php
            }?>
        </div>

    </main>
</body>
</html>