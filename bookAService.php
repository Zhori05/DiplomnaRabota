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
    // Form submission logic
    $dateTime = $_POST['datetime'];
    $dayOfWeek = (new DateTime($dateTime))->format('w');
    $hour = (new DateTime($dateTime))->format('H');

    if ($dayOfWeek == 0 || $hour < 9 || $hour >= 18) {
        echo "Грешка: Работното време на сервиза е понеделник-събота от 9:00 до 18:00. Опитваш да запишеш час извън работно време";
        exit();
       
    }

    // Останалата част от вашата логика
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
            echo "Грешка: Избраните ден, час, услуга и механик са заети. Моля, изберете други.";
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
        echo "Appointment added successfully!";
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
    <script src= "./js/bookAService.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Document</title>
</head>
<body>
    
        <div class="container">
            
            <form method = "post" id = "myForm" enctype="multipart/form-data">
                <div class = "tab">
                <div class = "row">
                    <div class = "col-25">
                        <label for = "car"></i>Кола</label>
                    </div>
                    <div class = "col-75">
                        <select id="car" name="car">
                        <?php foreach ($user_cars as $car) : ?>
                            <option value="<?php echo $car['car_id']; ?>">
                            <?php echo $car['brand'] . ' ' . $car['model'] . ' (' . $car['license_plate'] . ')'; ?>
                            
                        </option>
                        <?php endforeach; ?>
                          </select>
                    </div>
                </div>
               
                  <div class = "row">
                    <p>Ако не си ползвал нашите услуги и нямаш коли в списъка можеш да си добавиш</p>
                    <a href="addCar.php">Добави колата си</a>
                  </div>
                        </div>
                  
      <div class = "tab">
      <div class="row">
    <div class="col-25">
        <label for="serviceName"><i class="fa-solid fa-wrench"></i> Услуга</label>
    </div>
    <div class="col-75">
    <select id="service" name="service" required>
        <?php foreach ($services as $service) : ?>
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
<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-..." crossorigin="anonymous"></script>

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


                <div class = "row">
                    <div class = "col-25">
                        <label for = "mechanicName"><i class="fa-solid fa-people-group"></i> Механик</label>
                    </div>

                    <div class = "col-75">

                    <select id="mechanic" name="mechanicName">
        
    </select>
                    </div>
                </div>
                <div class = "row">
                    <div class = "col-25">
                        <label for = "datetime"><i class="fa-regular fa-calendar-days"></i> Дата и час</label>
                    </div>
                    <div class = "col-75">
                        <input type="datetime-local" name="datetime" id = "datetime" required>
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
                  <div class = "row">
                    <button type="submit" id="pickAService">Направи запитване</button>
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

<script src="./js/multiStepForm2.js"></script>
            
</body>
</html>