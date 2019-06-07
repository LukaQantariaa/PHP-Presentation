<?php

    $errors = [];

    if( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
        // db
        $db = mysqli_connect('localhost', 'root', '', 'php');

        // User info
        $username = mysqli_real_escape_string($db, $_POST['username']);
        $email = mysqli_real_escape_string($db, $_POST['email']);
        $age = mysqli_real_escape_string($db, $_POST['age']);
        $password1 = mysqli_real_escape_string($db, $_POST['password']);
        $password2 = mysqli_real_escape_string($db, $_POST['check-password']);
        
        // Form validation
        if( $username == '' ) { array_push($errors, 'სახელი ცარიელია'); }
        if( $email == '' ) { 
            array_push($errors, 'მეილი ცარიელია');
        } else {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                array_push($errors, 'არასწორი მეილი');
            }
        }
        if( $age == '' ) { array_push($errors, 'ასაკი ცარიელია'); }
        if( $password1 == '' ) { array_push($errors, 'პაროლი ცარიელია'); }
        if( $password2 == '' ) { array_push($errors, 'პაროლი ცარიელია'); }
        if( $password1 != $password2 ) { array_push($errors, 'პაროლები არ ემთხვევა ერთმანეთს'); };

        // if user exists in db.
        $user_check_query = "SELECT * FROM users WHERE username = '$username' or 'email' = '$email'";
        $result = mysqli_query($db, $user_check_query);
        $user = mysqli_fetch_assoc($result);
        if($user) {
            if( $user['username'] == $username ) { array_push($errors, 'ამ სახელით უკვე არსებობს მომხმარებელი'); }
            if( $user['email'] == $email ) { array_push($errors, 'ამ მეილით უკვე არსებობს მომხმარებელი'); }
        }

        //if no error
        if( count($errors) == 0 ) {
            echo $password1;
            $query = "INSERT INTO users (username, email, age, pass) VALUES ('$username', '$email', '$age', '$password1') ";
            mysqli_query($db, $query); // Insert into db.

            session_start();
            $_SESSION['username'] = $username;
            header('location: /php/main'); 
        } else {
            /*
            foreach($errors as $err) {
                echo $err;
            } */
        }
        mysqli_close($db);    

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
    <form action="" method="post">
        <h2> რეგისტრაცია </h2>
        <input type="text" name="username" placeholder="სახელი" require />
        <input type="text" name="email" placeholder="მეილი" require />
        <input type="number" name="age" placeholder="ასაკი" require />
        <input type="password" name="password" placeholder="პაროლი" require />
        <input type="password" name="check-password" placeholder="გაიმეორე პაროლი" require />
        <button type="submit">რეგისტრაცია</button>
        <a href="/php/"> ავტორიზაცია </a>
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