<?php

session_start();

// Проверка за логнат потребител
if (!isset($_SESSION['user'])) {
  header("location: LoginPage.php");
  exit();
}

// Достъп до информацията за логнатия потребител
$user = $_SESSION['user'];

// Изписване на информацията
echo "Добре дошъл, " . $user['Name'] . "!";

$user_id = $_SESSION['user']['iduser'];
$servername = "localhost";
$username = "root";
$password = "";
$database = "mCarService";

try {
  $connection = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
  $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo "Connected successfully";
  $user_id = $_SESSION['user']['iduser'];
  $stmt = $connection->prepare("SELECT * FROM cars WHERE user_id = :user_id");
  $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
  $stmt->execute();

  $user_cars = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $stmt_services = $connection->query("SELECT * FROM Services");
  $services = $stmt_services->fetchAll(PDO::FETCH_ASSOC);

  $stmt_mechanics = $connection->query("SELECT * FROM mechanics");
  $mechanics = $stmt_mechanics->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
  echo "Грешка при връзка с базата данни: " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
 
  $dateTime = $_POST['datetime'];
  $dayOfWeek = (new DateTime($dateTime))->format('w');
  $hour = (new DateTime($dateTime))->format('H');

  if ($dayOfWeek == 0 || $hour < 9 || $hour >= 18) {
    header("location: warningMessage2.html");
    exit();

  }

 
  $idcar = $_POST['car'];
  $serviceName = $_POST['service'];
  $mechanicName = $_POST['mechanicName'];
  $moreInfo = $_POST['more'];

  // Проверка на наличие на запис за съответния ден и час, услуга и механик
  $stmt_service_time = $connection->prepare("SELECT timeForExecution FROM Services WHERE name = :service_name");
  $stmt_service_time->bindParam(':service_name', $serviceName);
  $stmt_service_time->execute();
  $serviceTimeForExecution = $stmt_service_time->fetchColumn();

  if (!$serviceTimeForExecution) {
    var_dump($serviceName);
    echo "Грешка: Невалидно име на услуга.";
    exit();
  }

  // Проверка на наличие на запис за съответния ден и час, услуга и механик
  try {
    $endDateTime = (new DateTime($dateTime))->add(new DateInterval('PT' . $serviceTimeForExecution . 'M'))->add(new DateInterval('PT45M'));

    $stmt_check = $connection->prepare("SELECT * FROM apointments WHERE 
        ((dateTime > :start_time AND endDateTime < :end_time) OR 
        (dateTime < :start_time AND endDateTime > :start_time) OR
        (dateTime < :end_time AND endDateTime > :end_time)) 
        AND mechanicName = :mechanic");

    $stmt_check->bindParam(':start_time', $dateTime);
    $stmt_check->bindParam(':end_time', $endDateTime->format('Y-m-d H:i:s'));
    $stmt_check->bindParam(':mechanic', $mechanicName);
    $stmt_check->execute();

    $existing_appointments = $stmt_check->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($existing_appointments)) {
      header("location: warningMessage.html");
      exit();
    }
  } catch (PDOException $e) {
    echo "Грешка при проверка за наличие на запис: " . $e->getMessage();
    exit();
  }

  // Вмъкване на данните в таблицата "appointments"
  try {
    $sql = "INSERT INTO apointments (idCarOwner, idcar, ServiceName, mechanicName, dateTime, moreInfo, endDateTime) VALUES (?,?,?,?,?,?,?)";
    $connection->prepare($sql)->execute([$user_id, $idcar, $serviceName, $mechanicName, $dateTime, $moreInfo, $endDateTime->format('Y-m-d H:i:s')]);
    var_dump($user_id, $idcar, $serviceName, $mechanicName, $dateTime, $moreInfo, $endDateTime->format('Y-m-d H:i:s'));
    header("location: successfullyAdded.html");
  } catch (PDOException $e) {
    echo "Error adding appointment: " . $e->getMessage();
  }
}

?>






<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="styles/bookAService.css">
  <script src="./js/multiStepForm2.js"></script>
  <script src="./js/bookAService.js"></script>
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="styles/mechanicPage2.0.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

  <title>Document</title>
</head>

<body>
  <nav class="navbar">
    <div class="logo">
      <i class="bx bx-menu" id="sidebarOpen"></i>
      M Car Service
    </div>
  </nav>
  <nav class="sidebar">
    <div class="mechanic">
      <p class="mechanicName">
        <?php echo "Добре дошъл, " . $user['Name'] . " !"; ?>
      </p>
    </div>
    <div class="menu_content">
      <ul class="menu_items">
        <li class="menu_item" style="background-color:white;">
          <a href="home.html" class="nav_link">
            <span class="navlink_icon">
              <i class="bx bx-home"></i>
            </span>
            <span class="navlink">Начало</span>
          </a>
        </li>
        <li class="menu_item">
          <a href="#" class="nav_link add-appointment-link">
            <span class="navlink_icon">
              <i class='bx bx-calendar-plus'></i>
            </span>
            <span class="navlink">Запази час</span>
          </a>
        </li>
        <li class="menu_item">
          <a href="#" class="nav_link history-link">
            <span class="navlink_icon">
              <i class='bx bx-calendar-check'></i>
            </span>
            <span class="navlink">Сервизна книжка</span>
          </a>
        </li>

      </ul>
      <div class="collapse_content">
        <div class="collapse expand_sidebar">
          <span> Expand</span>
          <i class="bx bx-chevron-right"></i>
        </div>
        <div class="collapse collapse_sidebar">
          <span> Collapse</span>
          <i class="bx bx-chevron-left"></i>
        </div>
      </div>
    </div>
  </nav>

  <div class="main-content">
    <div class="container">

      <form method="post" id="myForm" enctype="multipart/form-data">
        <div class="tab">
          <div class="row">
            <div class="col-25">
              <label for="car"></i>Кола</label>
            </div>
            <div class="col-75">
              <select id="car" name="car">
                <?php foreach ($user_cars as $car): ?>
                  <option value="<?php echo $car['car_id']; ?>">
                    <?php echo $car['brand'] . ' ' . $car['model'] . ' (' . $car['license_plate'] . ')'; ?>

                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <div class="row">
            <p class="ifAdd">Ако не си ползвал нашите услуги и нямаш коли в списъка можеш да си добавиш</p>
            <a class="addCarBtn" href="addCar.php">Добави колата си</a>
          </div>
        </div>

        <div class="tab">
          <div class="row">
            <div class="col-25">
              <label for="serviceName"><i class="fa-solid fa-wrench"></i> Услуга</label>
            </div>
            <div class="col-75">
              <select id="service" name="service" required>
                <?php foreach ($services as $service): ?>
                  <?php
                  $service_id = $_GET['id'];

                  // Заявка към базата данни, за да вземете името на услугата
                  $stmt_service_name = $connection->prepare("SELECT name FROM Services WHERE id = :service_id");
                  $stmt_service_name->bindParam(':service_id', $service_id, PDO::PARAM_INT);
                  $stmt_service_name->execute();
                  $service_name = $stmt_service_name->fetchColumn();

                  // След като извлечете името на услугата, можете да го използвате, където е необходимо
                  echo "Име на услугата: " . $service_name;

                  // Примерно използване за сравнение с името на услугата от POST заявката
                  $selected = ($service['name'] == $service_name) ? 'selected' : '';
                  ?>
                  <option value="<?php echo $service['name']; ?>" data-range="<?php echo $service['range']; ?>" <?php echo $selected; ?>>
                    <?php echo $service['name']; ?>
                  </option>
                <?php endforeach; ?>
              </select>

            </div>
          </div>
          <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-..."
            crossorigin="anonymous"></script>

          <script>
            $(document).ready(function () {
              $('#service').change(function () {
                var selectedService = $('option:selected', this);
                var rangeValue = selectedService.data('range');
                $('#serviceRange').val(rangeValue);

                // Изпращане на AJAX заявка за зареждане на механици
                $.ajax({
                  url: 'getMechanics.php',
                  type: 'GET',
                  data: { rangeValue: rangeValue },
                  success: function (data) {
                    // Обновяване на списъка с механици
                    $('#mechanic').html(data);
                  }
                });
              });

              // Извикване на събитието 'change' след първоначалното зареждане на страницата
              $('#service').trigger('change');
            });
          </script>


          <div class="row">
            <div class="col-25">
              <label for="mechanicName"><i class="fa-solid fa-people-group"></i> Механик</label>
            </div>

            <div class="col-75">

              <select id="mechanic" name="mechanicName">

              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-25">
              <label for="datetime"><i class="fa-regular fa-calendar-days"></i> Дата и час</label>
            </div>
            <div class="col-75">
              <input type="datetime-local" name="datetime" id="datetime" required>
            </div>
          </div>
          <div class="row">
            <div class="col-25">
              <label for="more"><i class="fa-solid fa-file-pen"></i> Допълнителна информация</label>
            </div>
            <div class="col-75">
              <textarea id="more" name="more" placeholder="Напиши тук: " style="height:200px"></textarea>
            </div>
          </div>
         

        </div>
        <button type="button" id="prevBtn">Предишна страница</button>
        <button type="button" id="nextBtn">Напред</button>

        <div style="text-align:center;margin-top:40px;">
          <span class="step"></span>
          <span class="step"></span>
        </div>
      </form>
    </div>

    <div class="Your_cars">
      <form method="post" id="myForm" enctype="multipart/form-data">
        <div class="tab1" style="display: block;">
          <div class="row">
            <div class="col-25">
              <label for="car"></i>Кола</label>
            </div>
            <div class="col-75">
              <select id="car_select" name="car">
                <?php foreach ($user_cars as $car): ?>
                  <option value="<?php echo $car['car_id']; ?>">
                    <?php echo $car['brand'] . ' ' . $car['model'] . ' (' . $car['license_plate'] . ')'; ?>

                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <div class="row1">
            <p class="ifAdd">Ако не си ползвал нашите услуги и нямаш коли в списъка можеш да си добавиш</p>
            <div class="carButtons">
              <a class="addCarBtn" href="addCar.php">Добави колата си</a>
              <button type="button" id="ViewCarInfo">Информация за автомобила</button>
            </div>
        
          </div>
          <div id="carInfoContainer">
            
          </div>
          
      </form>
      
    </div>

    

  </div>
 
  <script>
$(document).ready(function () {
    $('#ViewCarInfo').click(function () {
        var carId = $('#car_select').val(); // Променено на #car_select

        // Изпращане на AJAX заявка за получаване на информация за автомобила и записи от таблицата endedAppointments
        $.ajax({
            url: 'getCarInfo.php', // Път до PHP скрипта, който ще обработи заявката
            type: 'POST',
            data: { carId: carId }, // Изпращане на идентификатора на автомобила като данни към скрипта
            success: function (data) {
                // Обработка на получената информация за автомобила
                var carInfoParagraphs = data.split("\n");
                var carInfoHTML = '';
                carInfoParagraphs.forEach(function (paragraph) {
                    carInfoHTML += '<p>' + paragraph + '</p>';
                });

                // Извикване на AJAX заявка за получаване на записи от таблицата endedAppointments, в които участва избраната кола
                $.ajax({
                    url: 'getEndedAppointments.php', // Път до PHP скрипта, който ще обработи заявката
                    type: 'POST',
                    data: { carId: carId }, // Изпращане на идентификатора на автомобила като данни към скрипта
                    success: function (appointmentsData) {
                        // Генериране на HTML таблица от получените данни за записи от таблицата endedAppointments
                        var appointmentsHTML = '<div class="tableContainer" id="tableEndedAppointmetsForTheCar"><h1>Извършени услуги върху автомобила</h1><div class="tableContainerContent"><table class="table table-striped table-hover"><thead class="table-dark"><tr><th scope="col">#</th><th scope="col">Номер на записа</th><th scope="col">Собственик</th><th scope="col">Кола</th><th scope="col">Услуга</th><th scope="col">Име на механик</th><th scope="col">Начало</th><th scope="col">Повече информация</th><th scope="col">Край</th><th scope="col">Пробег</th><th scope="col">Информация след сервизиране</th></tr></thead><tbody>';
                        appointmentsData.forEach(function (appointment) {
                            appointmentsHTML += '<tr>';
                            appointmentsHTML += '<th scope="row">' + appointment.id + '</th>';
                            appointmentsHTML += '<td class="nameDB">' + appointment.idAppointment + '</td>';
                            appointmentsHTML += '<td class="nameDB">' + appointment.idCarOwner + '</td>';
                            appointmentsHTML += '<td class="nameDB">' + appointment.idcar + '</td>';
                            appointmentsHTML += '<td class="nameDB">' + appointment.serviceName + '</td>';
                            appointmentsHTML += '<td class="nameDB">' + appointment.mechanicName + '</td>';
                            appointmentsHTML += '<td class="timeDB">' + appointment.dateTime+ ' </td>';
                            appointmentsHTML += '<td class="nameDB">' + appointment.moreInfo + '</td>';
                            appointmentsHTML += '<td class="timeDB">' + appointment.endDateTime + ' </td>';
                            appointmentsHTML += '<td class="nameDB">' + appointment.mileage + '</td>';
                            appointmentsHTML += '<td class="nameDB">' + appointment.infoAfterServicing + '</td>';
                            appointmentsHTML += '</tr>';
                        });
                        appointmentsHTML += '</tbody></table></div></div>';

                        // Обновяване на съдържанието на елемента #carInfoContainer с информация за автомобила и таблицата с записи от таблицата endedAppointments
                        $('#carInfoContainer').html(carInfoHTML + appointmentsHTML);
                    },
                    error: function () {
                        alert('Грешка при заявката за записи от таблицата endedAppointments');
                    }
                });
            },
            error: function () {
                alert('Грешка при заявката за информация за автомобила');
            }
        });
    });
});
</script>

  <script src="./js/multiStepForm2.js"></script>
  <script src="js/clientPage.js"></script>

</body>



</html>