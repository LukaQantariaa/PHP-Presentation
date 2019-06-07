<?php 
    session_start();
    if( isset($_SESSION['username']) ) {
        //User is logIn.
    } else {
        header("location: /php");
    }
    /*if( isset($_GET['logout']) ) {
        session_destroy();
        unset($_SESSION['username']);
    }*/
    if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
        if( isset( $_POST['logout'] ) ) {
            session_destroy();
            unset($_SESSION['username']);
            header("location: /php");
        }
    }

    if( isset( $_POST['textareaBtn'] ) ) {
        $db = mysqli_connect('localhost', 'root', '', 'php');
        $errors = [];
        $body = mysqli_real_escape_string($db, $_POST['textarea']);
        if($body == '') { array_push($errors, 'textarea ცარიელია'); };
        
        if( count($errors) == 0 ) {
            $username = mysqli_real_escape_string($db, $_SESSION['username']);
            $query = " SELECT id FROM users WHERE username='$username' ";
            $result = mysqli_query($db, $query);
            $user = mysqli_fetch_assoc($result);
            $userID = $user['id'];
            $query = "INSERT INTO posts (userid, body) VALUES ('$userID', '$body') ";
            mysqli_query($db, $query);
        } else {
            
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="./public/css/main.css">
    <title>Document</title>
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
        <div class="user">
            <a href="/php/profile" class="name"> მომხმარებელი: <?php echo $_SESSION['username']; ?> </a>
        </div>
        <div class="post-input">
            <form action="" method="POST">
                <textarea name="textarea"></textarea>
                <button type="submit" name="textareaBtn">გაგზავნა</button>    
            </form>
        </div>
        <hr>
        <div class="posts-list">
            <!--div class="post">
                <div class="text">აუიჯსჰდაოუსიჰდნოლაჰნდ0პოქიადოიაჰსდნოაისდას</div>
                <div class="userid">UserID: 14 </div>
            </div-->
            <?php 
                $conn = mysqli_connect('localhost', 'root', '', 'php');
                $sql = "SELECT * FROM posts";
                $result = $conn->query($sql);
                if($result->num_rows > 0) { while($row = $result->fetch_assoc()) {?> <div class="post"> <div class="text"> <?php echo $row['body'] ?> </div> <div class="userid"> UserID: <?php echo $row['userid'] ?> </div> </div> <?php }}
            ?>
                        
        </div>

    </main>
    
</body>
</html>