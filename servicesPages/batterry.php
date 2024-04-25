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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Диагностика и поддръжка на батериите</title>
    <link rel="stylesheet" href="../styles/navbar-style.css">
    <link rel="stylesheet" href="../styles/responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../styles/servicePage.css">
    <style>.hero .hero-image{
    background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url("../images/EV-battery.webp");
    }
    </style>
    
</head>
<body>
<nav>
    <div class="wrapper">
      <div class="logo"><a href="#">M car Service</a></div>
      <input type="radio" name="slider" id="menu-btn">
      <input type="radio" name="slider" id="close-btn">
      <ul class="nav-links">
        <label for="close-btn" class="btn close-btn"><i class="fas fa-times"></i></label>
        <li><a href="/mysite/DiplomnaRabota/home.html">Начало</a></li>
        <li><a href="/mysite/DiplomnaRabotacontact-us.html">За нас</a></li>
       
        <li>
          <a href="#" class="desktop-item">Услуги</a>
          <input type="checkbox" id="showMega">
          <label for="showMega" class="mobile-item">Услуги</label>
          <div class="mega-box">
            <div class="content">
              <div class="row">
                <img src="../images/service-main.jpg" alt="">
              </div>
              <div class="row">
                <header>Често извършвани услуги</header>
                <ul class="mega-links">
                  <li><a href="oil_change.php">Смяна на масла и филтри</a></li>
                  <li><a href="padsRotorsChange.php">Смяна на дискове и накладки</a></li>
                  <li><a href="suspensionChange.php">Смяна на консумативи по окачването</a></li>
                  <li><a href="a-c_service.php">Обслужване на климатици</a></li>
                </ul>
              </div>
              <div class="row">
                <header>Услуги за ел. и хибридни автомобили</header>
                <ul class="mega-links">
                  <li><a href="batterry.php">Диагностика и поддръжка на батериите</a></li>
                  <li><a href="еEngineAndSystem.php">Сервиз на електрически двигател и системи за управление</a></li>
                  <li><a href="chargingMaintance.php">Обслужване на системи за зареждане</a></li>        
                  <li><a href="hybridSystemMaintance.php">Проверка на хибридната система</a></li>             
                </ul>
              </div>
              <div class="row">
                <header>Услуги с доп. запитване</header>
                <ul class="mega-links">
                <li><a href="/mysite/DiplomnaRabota/tuningServices/exhaustSystem.html">Генерации</a></li>
                  <li><a href="/mysite/DiplomnaRabota/tuningServices/tuning.html">Силов и визуален тунинг</a></li>
                  <li><a href="/mysite/DiplomnaRabota/tuningServices/painting.html">Боядисване</a></li>
                  <li><a href="/mysite/DiplomnaRabota/tuningServices/software.html">Софтуер</a></li>
                </ul>
              </div>
            </div>
          </div>
        </li>
        <li><a href="/mysite/DiplomnaRabota/for-us.html">Контакти</a></li>
        <li>
          <a href="/mysite/DiplomnaRabota/bookAService.php" class="desktop-item">Твоят профил</a>
        </li>
      </ul>
      <label for="menu-btn" class="btn menu-btn"><i class="fas fa-bars"></i></label>
    </div>
  </nav>

      <div class = "hero">
        <div class ="hero-image">
        <div class = "hero-text">
        <h1>Диагностика и поддръжка на батериите</h1>
      </div>
      </div>
    </div>
    
    
    
    </header>
    
    <main>



    <div class = "aboutICars">
        
        <div class = "about">
            <h1>Електрическите коли и Плъг-ин хибридите обяснени</h1>
            <div class = "aboutIContainer">
                <div class = pContainer>
                <p>Рано или късно, повечето шофьори ще бъдат изправени пред дилемата дали следващият им автомобил да има някакъв вид електрифицирано задвижване. Ползите са очевидни, най-вече за заобикалящата ни среда, тъй като електродвигателите не отделят никакви емисии. Макар и по-скъпи, електрифицираните коли предлагат редица предимства като по-ниски разходи за зареждане и поддръжка, и по-високо удоволствие от шофирането – електродвигателите са способни на изключителна мощ със светкавична реакция, веднага щом подадем газ. Всичко това, при това при пълна тишина, която повишава усещането за лукс и спокойствие – идеални качества за автомобил от премиум клас. Като пионер в електрическата мобилност, BMW Group вече достави половин милион електрифицирани автомобили на клиенти по целия свят към края на 2019 г. Поради технологичният напредък и  непрекъснато разширяващата се гама е лесно потребителят да се обърка. Нашето сравнение отговаря на най-често задаваните въпроси по темата:  </p>
                </div>
            </div>
        </div>
        <div class = "images">
            <div class = card>
            <img src="../images/bobi-1.png" alt="">
            <h3>Електрически автомобил</h3>
            </div>
            <div class = card>
            <img src="../images/bobi-2.png" alt="">
            <h3>Хибрид</h3>
            </div>
        </div>
    </div>

      <div class = "infoLine">
        <h3>Диагностика и поддръжка на батериите</h3>
      </div>

      <div class = "infoContainer">
        <div class = "information">
          <h1>M car Service</h1>
          <div class = "pContainer">
          <p>Диагностика и поддръжка на батериите на електрически и хибридни автомобили включват тестове за капацитет и здраве на батерията, балансиране на зарядът, поддръжка на термалната система, замяна на батерии при нужда, софтуерни актуализации и обучение за собствениците. Тези услуги са от съществено значение за оптималната работа и продължителността на живота на автомобилната батерия.</p>
        </div>
        </div>

        


    </main>
    <div class = "tableContainer" id ="tableContainer">
      <h1>Избери услуга</h1>
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
              
              <button class="btn btn-primary">
              <a href="/mysite/DiplomnaRabota/bookAService.php?id=' . $id . '"> <!-- Променено тук -->
                  <div class="editTextArea">Избери</div>
              </a>
          </button>
            </tr>';
        
          }
      }
      ?>
      
        
         
        </tbody>
      </table>
      </div>
      <footer>
  <div class = "top-footer-container">
  <div class = "footer-content">
    <div class = "foot">
      <h1>Контакти</h1>
      <ul >
        <li><a href ="#"><i class="fa-solid fa-phone"></i> +359 7799 333</a></li>
        <li><a href ="#"><i class="fa-solid fa-envelope"></i> m_car_service@gmail.com</a></li>
        <li><a href ="#"><i class="fa-solid fa-location-dot"></i> гр.София ул.Христо Ботев 3</a></li>
        <li><a href ="#"><i class="fa-regular fa-calendar-days"></i>  Понеделник - Петък: 9:30 - 18:30</a></li>
      </ul>
    </div>
    <div class = "foot">
      <h1>Oще</h1>
      <ul>
        <li><a href ="#">Блог</a></li>
        <li><a href ="#">Рент а кар</a></li>
        <li><a href ="contact-us.html">За нас</a></li>
        
      </ul>
    </div>
    <div class = "foot">
      <h1>Полезни връзки</h1>
      <ul>
        <li><a href ="#">Проекти</a></li>
        <li><a href ="contact-us.html">Общи условия</a></li>
        <li><a href ="for-us.html">Често задавани въпроси</a></li>
      </ul>
    </div>
    <div class = "foot">
      <h1>Социални мрежи</h1>
      <ul>
        <li><a href ="#"><i class="fa-brands fa-instagram"></i> Instagram</a></li>
        <li><a href ="#"><i class="fa-brands fa-facebook"></i> Facebook</a></li>
        <li><a href ="#"><i class="fa-brands fa-youtube"></i></a> Youtube</li>
      </ul>
    </div>
  </div>
  </div>
  <div class = "bottom-footer-container">
    <div class ="bottom-content">
      <p>&copy All rights reserved 2023.</p>
    </div>
  </div>
</footer>
</body>
</html>