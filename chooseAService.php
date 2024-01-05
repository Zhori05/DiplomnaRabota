<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "mCarService";

try {
  $connection = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
  $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   echo "Connected successfully";
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
if (isset($_POST['serviceName']) && isset($_POST['timeForExecution']) && isset($_POST['price'])) {


  $Name = $_POST['serviceName'];
  $Mins = $_POST['timeForExecution'];
  $Price = $_POST['price'];
  
   // заявка към базата, с която се записват полетата
   $sql = "INSERT INTO Services (name, timeForExecution,price) VALUES (?,?,?)";
   $connection->prepare($sql)->execute([$Name, $Mins, $Price]);
   echo "<b style='color:green;'>Успешно добавихте услуга.</b><br><br>";
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BMW repair</title>
    <link rel="stylesheet" href="styles/navbar-style.css">
    <link rel="stylesheet" href="styles/chooseAservice-style.css">
    <link rel="stylesheet" href="styles/responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src = "scriptForServices.js"></script>
    <style>
       .hero .hero-image{
    background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url("images/bmw-service-inklusive-bmw-service-inklsuive-pakete-slide-01\ \(1\).jpg");
  }
    </style>
</head>
<body>
  <header>
  <nav>
    <div class="wrapper">
      <div class="logo"><a href="#">M car Service</a></div>
      <input type="radio" name="slider" id="menu-btn">
      <input type="radio" name="slider" id="close-btn">
      <ul class="nav-links">
        <label for="close-btn" class="btn close-btn"><i class="fas fa-times"></i></label>
        <li><a href="a-c_service.html">Начало</a></li>
        <li><a href="#">За нас</a></li>
        <li>
          <a href="#" class="desktop-item">Dropdown Menu</a>
          <input type="checkbox" id="showDrop">
          <label for="showDrop" class="mobile-item">Dropdown Menu</label>
          <ul class="drop-menu">
            <li><a href="#"></a></li>
            <li><a href="#">Drop menu 2</a></li>
            <li><a href="#">Drop menu 3</a></li>
            <li><a href="#">Drop menu 4</a></li>
          </ul>
        </li>
        <li>
          <a href="#" class="desktop-item">Услуги</a>
          <input type="checkbox" id="showMega">
          <label for="showMega" class="mobile-item">Услуги</label>
          <div class="mega-box">
            <div class="content">
              <div class="row">
                <img src="images/service-main.jpg" alt="">
              </div>
              <div class="row">
                <header>Често извършвани услуги</header>
                <ul class="mega-links">
                  <li><a href="#">Смяна на масла и филтри</a></li>
                  <li><a href="#">Спирачки</a></li>
                  <li><a href="#">Обслужване по график</a></li>
                  <li><a href="a-c_service.html">Обслужване на климатици</a></li>
                </ul>
              </div>
              <div class="row">
                <header>Други</header>
                <ul class="mega-links">
                  <li><a href="#">Обслужване на трансмисия</a></li>
                  <li><a href="#">Охладителна система</a></li>
                  <li><a href="#">Електроника</a></li>
                  <li><a href="#">Компютърна диагностика</a></li>
                  <li><a href="#">Оценка на състоянието на автомобили</a></li>
                  <li><a href="#">Обслужване на ходовата част</a></li>
                  <li><a href="#">Обслужване на двигателя</a></li>
                  <li><a href="#">Горивна система</a></li>
                </ul>
              </div>
              <div class="row">
                <header>Услуги с доп. запитване</header>
                <ul class="mega-links">
                  <li><a href="#">Генерации</a></li>
                  <li><a href="#">Силов и визуален тунинг</a></li>
                  <li><a href="#">Боядисване</a></li>
                  <li><a href="#">Софтуер</a></li>
                </ul>
              </div>
            </div>
          </div>
        </li>
        <li><a href="#">Контакти</a></li>
      </ul>
      <label for="menu-btn" class="btn menu-btn"><i class="fas fa-bars"></i></label>
    </div>
  </nav>
  <div class = "hero">
    <div class ="hero-image">
    <div class = "hero-text">
    <h1>Bmw сервизни услуги от M car Service</h1>
    <a class = "choose" href="" >Избери услуга</a>
  </div>
  </div>
</div>
<div class = "info-container">
  <div class = "info">
    <div class = "info-image">
      <img src="./images/bmw-service-hub-wt-otv.jpg" alt="">
    </div>
    <div class = "info-text">
      <h2>РЕЗЕРВИРАЙТЕ ОНЛАЙН ЧАС ЗА ОБСЛУЖВАНЕ - БЪРЗО И ЛЕСНО.</h2>
      <p>Доброто обслужване започва онлайн - бързо, лесно и по всяко време. Независимо дали става дума за сервиз на спирачки, смяна на масло или друга услуга, с нашата система за запазване на часове можете да запазите час за когато ви е най-удобно. В крайна сметка никой не познава по-добре автомобила ви от нашите специалисти. Просто изберете желаната от вас услуга и след това изберете час от свободните. </p>
      <a href="">Запази час</a>
    </div>
  </div>
</div>
<div class = "info-container">
  <div class = "info">
    <div class = "info-text">
      <h2>ВЗЕМИ КОЛА НА ЛЮБИМАТА СИ МАРКА ПОД НАЕМ ДОКАТО НИЕ СЕ ПОГРИЖИМ ЗА ТВОЯТА</h2>
      <p>При нас можеш можеш да си наемеш автомобил доката твоят е в сервиза и така да не усетиш липсата на автомобил. Разполагаме с голям избор от автомобили на марката BMW, от лусксозни лимузини до спортни купета. Не се колебай, а наеми автомобила, от който имаш нужда.</p>
      <a href="" style = "float: left;">Наеми</a>
    </div>
    <div class = "info-image">
      <img src="./images/bmw-rent.jpg "alt="">
    </div>
  </div>
</div>


</header>
<div class = "tableContainer">
<div class = "tableContainerContent">
  <table class="table table-striped table-hover" >
    <thead class="table-dark">
      <tr>
        <th scope="col">#</th>
        <th scope="col">Име на услугата</th>
        <th scope="col">Време за изпълнение</th>
        <th scope="col">Цена</th>
        <th scope="col"></th>
      </tr> 
    </thead>
    <tbody>
    <?php
  $sql = "Select * from `Services`";
  $result = $connection->query($sql);
  if ($result) {
      while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
          $id = $row['id'];
          $name = $row['name'];
          $timeForExecution = $row['timeForExecution'];
          $price = $row['price'];
          echo '<tr>
          <th scope="row">' . $id . '</th>
          <td class="nameDB">' . $name . '</td>
          <td class="timeDB">' . $timeForExecution. ' мин</td>
          <td class="nameDB">' . $price . 'лв</td>
          <td>
          
          <button class="btn btn-primary" id>
          <a href="delete.php?deleteid='.$id.'" class="text-light">
          </a>
          <div class="editTextArea">Избери</div>
          </button>
        </tr>';
    
      }
  }
  ?>
  
    
     
    </tbody>
  </table>
  </div>
</body>