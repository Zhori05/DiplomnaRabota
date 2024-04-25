<?php

session_start();

// Проверка дали потребителят е влезнал в системата
if (!$_SESSION['user']) {
    header("location: LoginPage.php");
    exit;
}

$user_id = $_SESSION['user']['iduser'];
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

    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $year = $_POST['year'];
    $color = $_POST['color'];
    $licensePlate = $_POST['registration'];
    $kilometers = $_POST['kilometers'];

    // зареждаме качената снимка
    $file = $_FILES['Img'];
    $file_name = $_FILES['Img']['name'];
    $file_temp = $_FILES['Img']['tmp_name'];
    $file_type = $_FILES['Img']['type'];

    $error = false;
    if (!$brand) {
        echo "<center style='color:red;'>Попълнете бранд</center>";
        $error = true;
    }

    // изписване на грешка ако не е попълнен модел
    if (!$model) {
        echo "<center style='color:red;'>Попълнете модел</center>";
        $error = true;
    }

    // изписване на грешка ако не е попълнено описание
    if (!$year) {
        echo "<center style='color:red;'>Попълнете година</center>";
        $error = true;
    }

    // изписване на грешка ако не е попълнена цена
    if (!$color) {
        echo "<center style='color:red;'>Попълнете цвят</center>";
        $error = true;
    }

    // ако е качен файл, който не е jpeg или png, се спира upload-а
    if ($file_type != "image/jpeg" && $file_type != "image/png") {
        echo "<center style='color:red;'>Качете jpeg или png снимка</center>";
        $error = true;
    } else {
        // завършване на upload-а и записване на качения файл в папка images
        echo move_uploaded_file( $file_temp, "images/".$file_name );
        
    }

    if (!$error) {

        $user_id = $_SESSION['user']['iduser'];
       
        // INSERT заявка към базата, с която се записват полетата
        $sql = "INSERT INTO cars (user_id, brand, model, year, color, license_plate, kilometers, Img) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $result = $connection->prepare($sql)->execute([$user_id, $brand, $model, $year, $color, $licensePlate, $kilometers, $file_name]);

        // изписва съобщение, че всичко е минало успешно
        if ($result) {
            echo "<center style='color:green;'>Колата е добавена успешно</center>";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/addCarStyle.css">
    <title>AddCar</title>
</head>
<body>
    <div class = "container">
    <form method="POST" enctype="multipart/form-data">
    <div class = "row">
      <div class = "col-25">
          <label for = "brand"></i>Марка</label>
      </div>
      <div class = "col-75">
          <select id="brand" name="brand"  data-addcar required>
              <option value="BMW">BMW</option>
              <option value="Mini">Mini</option>
              <option value ="Rolce Roys">Rolce Roys</option>
            </select>
      </div>
  </div>
  <div class = "row">
      <div class = "col-25">
          <label for = "model"></i>Модел</label>
      </div>
      <div class = "col-75">
          <input type="text" id="model" name="model" data-addcar placeholder="Модел.." required>
      </div>
  </div>
  <div class = "row">
      <div class = "col-25">
          <label for = "year"></i>Година</label>
      </div>
      <div class = "col-75">
          <input type="number" id="year" name="year" data-addcar placeholder="Година.."required>
      </div>
  </div>
  <div class = "row">
      <div class = "col-25">
          <label for = "color"></i>Цвят</label>
      </div>
      <div class = "col-75">
          <input type="text" id="color" name="color" placeholder="Цвят.." data-addcar required>
      </div>
  </div>
  <div class = "row">
      <div class = "col-25">
          <label for = "registration"></i>Регистрационен номер</label>
      </div>
      <div class = "col-75">
          <input type="text" id="registration" name="registration" placeholder="Регистрационен номер.." data-addcar required>
      </div>
  </div>
  <div class = "row">
      <div class = "col-25">
          <label for = "kilometers"></i>Пробег</label>
      </div>
      <div class = "col-75">
          <input type="number" id="kilometers" name="kilometers" placeholder="Пробег.." data-addcar required>
      </div>
  </div>
  <div class = "row">
      <div class = "col-25">
          <label for = "picture"></i>Снимка</label>
      </div>
      <div class = "col-75">
          <input type="file" name="Img" data-addcar >
      </div>
  </div>
  <div class = "row">
      <div class = "col-25">
          <label for = "picture"></i>Бутон</label>
      </div>
      <div class = "col-75">
      <button type="submit" class="btn1 mt-4" name="submit" value="addUserCar">Добави</button>
      </div>
  </div>
  </div>
</form>
 </div> 
</body>
</html>