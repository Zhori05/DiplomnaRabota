

<?php
// стартиране на сесия ( ще трябва по-долу )
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "mCarService";

try {
  $connection = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
  $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

if (isset($_POST['submit'])) {
    // записване на данните от полетата в променливи за по-удобно
    $Email = $_POST['Email'];
    $Password = $_POST['Password'];

    // зареждане от базата на потребител с въведените от формата име
    $stmt = $connection->prepare("SELECT * FROM users WHERE Email = ?");
    $stmt->execute([$Email]);
    $user = $stmt->fetch();

    if ($user && password_verify($Password, $user['Password'])) {
        // ако са въведени правилни име и парола се задава масива user в сесията
        $_SESSION['user'] = $user;
        $user_id = $_SESSION['user']['user_id'];

        header("location: bookAService.php");
        exit;
    } else {
        echo "<b style='color:red;'>Невалидни потребителски данни</b><br><br>";
    }
}
?>

	


<!DOCTYPE html>
<html lang="en">


<head>

    <title>Log in</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap v5.1.3 CDNs -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    

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

        <h4 class="text-center">Enter in your account!!</h4>
        
        <form method="post" class="needs-validation">
            <div class="form-group was-validated">
                <label class="form-label" for="email">Email Address</label>
                <input class="form-control" type="email" name="Email" id="email" required>
                <div class="invalid-feedback">
                    Please enter your email address
                </div>
            </div>
            <div class="form-group was-validated">
                <label class="form-label" for="password">Password</label>
                <input class="form-control" type="password" name="Password" id="password" required>
                <div class="invalid-feedback">
                    Please enter your password
                </div>
            </div>
                <button type="submit" class="btn1 mt-4" name="submit" value="login">Login</button>
            <div> 
              <p>Don't have an account? <a href = "registration-form.php">Register here!</a></p>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>  

</body>

</html>