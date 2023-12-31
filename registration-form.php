<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "mCarService";

try {
    $connection = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

if (isset($_POST['submit'])) {
    // записване на данните от полетата в променливи за по-удобно
    $Name = $_POST['Name'];
    $Email = $_POST['Email'];
    $Password = $_POST['Password'];
    $Hashed_Password = password_hash($Password, PASSWORD_DEFAULT);
    $PhoneNumber = $_POST['PhoneNumber'];

    // проверка за уникалност на имейла
    $checkEmailQuery = "SELECT * FROM users WHERE Email = ?";
    $stmt = $connection->prepare($checkEmailQuery);
    $stmt->execute([$Email]);
    $existingUser = $stmt->fetch();

    if ($existingUser) {
        echo "<b style='color:red;'>Имейлът вече съществува. Моля, използвайте друг.</b><br><br>";
    } else {
        // заявка към базата, с която се записват полетата
        $sql = "INSERT INTO users (Name, Email, Password, PhoneNumber) VALUES (?,?,?,?)";
        $connection->prepare($sql)->execute([$Name, $Email, $Hashed_Password, $PhoneNumber]);
        echo "<b style='color:green;'>Регистрацията е успешна.</b><br><br>";

        header("Location: LoginPage.php");
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <title>Registration</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap v5.1.3 CDNs -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <!-- CSS File -->
    <link rel="stylesheet" href="style.css">
    <script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js" defer></script>
    <script src="/js/validation.js"defer></script>

</head>

<style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {

    background-image: linear-gradient(rgba(0,0,0,0.75), rgba(0,0,0,0.75)), url("images/introduction-fast-lane-service.jpg");
    font-size: 25px;
    background-position: center;
    background-size: cover;
    background-attachment: fixed;
  
    position: relative;
    height: 90vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

.login {
    width: 520px;
    height: min-content;
    padding: 20px;
    border-radius: 12px;
    background: #ffffff;
}

.login h1 {
    font-size: 36px;
    margin-bottom: 25px;
}

.login form {
    font-size: 20px;
}

.login form .form-group {
    margin-bottom: 12px;
}

.btn1{
  border: none;
  outline: none;
  height: 50px;
  width: 100%;
  background-color: black;
  color: white;
  border-radius: 4px;
  font-weight: bold;
}
.btn1:hover{
  background: white;
  border:1px solid;
  color: black;
}

</style>

<body>

<div class="login">
    <h4 class="text-center">Make a new Registration!</h4>
    
    <form method="post" class="needs-validation" id="signup" onsubmit="return validateForm()">
        <div class="form-group was-validated">
            <label class="form-label" for="Name">Enter your names</label>
            <input class="form-control" type="text" name="Name" id = "name" required>
        </div>
        <div class="form-group was-validated">
            <label class="form-label" for="Email">Email Address</label>
            <input class="form-control" type="Email" name="Email" required>
            <div class="invalid-feedback">
                Моля въведи имейл адрес
            </div>
        </div>
        <div class="form-group was-validated">
            <label class="form-label" for="Password">Password</label>
            <input class="form-control" type="password" name="Password" id="password" required>
            <div class="invalid-feedback" id="password-feedback">
                Моля въведи парола, която е поне 8 символа
            </div>
        </div>
        <div class="form-group was-validated">
            <label class="form-label" for="PhoneNumber">Phone Number</label>
            <input class="form-control" type="text" name="PhoneNumber" required>
        </div>
        <div>
            <button type="submit" name="submit" value="Register" class="btn1 mt-4">Register</button>
        </div> 
        <p>Already have an account? <a href="LoginPage.php"> Login here!</a></p>
    </form>

    <script>
        function validateForm() {
            var passwordInput = document.getElementById('password');
            var passwordFeedback = document.getElementById('password-feedback');

            if (passwordInput.value.length < 8) {
                passwordFeedback.style.display = 'block';
                return false;
            } else {
                passwordFeedback.style.display = 'none';
                return true;
            }
        }
    </script>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>  
</body>
</html>