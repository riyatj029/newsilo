<?php
    session_start();
    if(isset($_SESSION['username'])){
        header("Location: welcome.php");
    }
?>
<?php
    $login = false;
    include('connection.php');
    if (isset($_POST['submit'])) {
        $username = $_POST['user'];
        $password = $_POST['pass'];
        
        $sql = "select * from users where username = '$username' or email = '$username'";  
        $result = mysqli_query($conn, $sql);  
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
        $count = mysqli_num_rows($result);  
        
        if($row){  
            if(password_verify($password, $row["password"])){
                $login=true;
                session_start();

                $sql = "select username from users where username = '$username' or email = '$username'";     
                $r = mysqli_fetch_array(mysqli_query($conn, $sql), MYSQLI_ASSOC);  

                $_SESSION['username']= $r['username'];
                $_SESSION['loggedin'] = true;
                header("Location: welcome.php");
            }
            else {
                echo  '<script>
                            alert("Login failed. Invalid password!!")
                            window.location.href = "login.php";
                        </script>';
            }
        }  
        else{  
            echo  '<script>
                        alert("Login failed. Invalid username or email!!")
                        window.location.href = "login.php";
                    </script>';
        }     
    }
?>
    
<html>
    <head>
        <title>Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    </head>
    <body class="bg">
        <h1>LOG IN TO NEWSILO</h1>
        <br>
        <div id="form">
            <form name="form" action="login.php" method="POST" required>
                <label>Enter Username/Email: </label>
                <input type="text" id="user" name="user" required></br></br>
                <label>Password: </label>
                <div class="password-container">
                    <input type="password" id="pass" name="pass" required>
                    <span class="password-toggle" onclick="togglePasswordVisibility()">
                        <i class="fas fa-eye" id="togglePassword"></i>
                    </span>
                </div>
                <a href="forgot-password.php" class="forgot-password">Forgot Password?</a>
                </br></br>
                <input type="submit" id="btn" value="Login" name="submit"/>
                <p class="dot"><b>----------or----------</b></p>
                <div class="icons">
                    <i class="fab fa-google"></i>
                    <i class="fab fa-facebook"></i>
                    <i class="fab fa-instagram"></i>
                </div>
                <div class="links">
                    <p>Don't have an account yet?</p>
                    <a href="signup.php" id="signUpButton" class="btnSign">SignUp</a>
                </div>
            </form>
        </div>
        <script>
            function togglePasswordVisibility() {
                var passwordInput = document.getElementById('pass');
                var toggleIcon = document.getElementById('togglePassword');
                
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    toggleIcon.classList.remove('fa-eye');
                    toggleIcon.classList.add('fa-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    toggleIcon.classList.remove('fa-eye-slash');
                    toggleIcon.classList.add('fa-eye');
                }
            }

            function isvalid(){
                var user = document.form.user.value;
                if(user.length==""){
                    alert(" Enter username or email id!");
                    return false;
                }
            }
        </script>
    </body>
</html>