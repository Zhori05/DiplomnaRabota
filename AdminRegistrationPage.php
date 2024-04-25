<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	$database = "mCarService";

	try {
		$connection = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
	} catch(PDOException $e) {
		echo "Connection failed: " . $e->getMessage();
	}

	if ( isset( $_POST['submit'] ) ) {
	
		// записване на данните от полетата в променливи за по-удобно
	
		$Name = $_POST['Name'];
		$Email = $_POST['Email'];
        $AdminId = $_POST['AdminId'];
		$Password = $_POST['Password'];
        $Hashed_Password = password_hash($Password, PASSWORD_DEFAULT);
        $PhoneNumber = $_POST['PhoneNumber'];

		
		// заявка към базата, с която се записват полетата

		$sql = "INSERT INTO AdminUser ( Name, Email,AdminId, Password, PhoneNumber) VALUES (?,?,?,?,?)";
		$connection->prepare($sql)->execute([$Name, $Email,$AdminId ,$Hashed_Password, $PhoneNumber]);
	}
     ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <title>Admin registration</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap v5.1.3 CDNs -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <!-- CSS File -->
    <link rel="stylesheet" href="style.css">

</head>

<style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {

    background-image: linear-gradient(rgba(0,0,0,0.75), rgba(0,0,0,0.75)), url(mph-club-a.jpg);
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

        <h4 class="text-center">Направи нова регистрация!</h4>
        
        <form method = "post" class="needs-validation">
          <div class="form-group was-validated">
            <label class="form-label" for="Name">Въведи имената си</label>
                <input class="form-control" type="text" name="Name" required>
          </div>
            <div class="form-group was-validated">
                <label class="form-label" for="Email">Имейл адрес</label>
                <input class="form-control" type="Email" name="Email" required>
                <div class="invalid-feedback">
                    Моля, въведи имейла си
                </div>
            </div>
            <div class="form-group was-validated">
                <label class="form-label" for="Password">Парола</label>
                <input class="form-control" type="text" name="Password" required>
                <div class="invalid-feedback">
                    Моля, въведи паролата си
                </div>
            </div>
            <div class="form-group was-validated">
                <label class="form-label" for="AdminId">AdminId</label>
                <input class="form-control" type="text" name="AdminId" required>
                <div class="invalid-feedback">
                    Моля, въведи своето, AdminId
                </div>
            </div>
            <div class="form-group was-validated">
              <label class="form-label" for="PhoneNumber">Телефон</label>
              <input class="form-control" type="text" name="PhoneNumber" required>
              <div>
                <button type="submit" name = "submit" value="Register" class="btn1 mt-4">Регистрирай се</button>
            </div> 
              <p>Вече имаш акаунт? <a href = "AdminLoginPage.php">Влез тук!</a></p>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>  
</body>
</html>