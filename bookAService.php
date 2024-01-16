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
                    <a href="addCar.html">Добави колата си</a>
                  </div>
                        </div>
                  
      <div class = "tab">
                <div class = "row">
                    <div class = "col-25">
                        <label for = "serviceName"><i class="fa-solid fa-wrench"></i> Услуга</label>
                    </div>
                    <div class = "col-75">
                        <select id="service" name="service" required>
                        <?php foreach ($services as $service) : ?>
                            <option value="<?php echo $service['id']; ?>" data-range="<?php echo $service['range']; ?>">
                    <?php echo $service['name']; echo $service['range']; ?>
                </option>
            <?php endforeach; ?>
                          </select>
                          <input type="range" id="serviceRange" name="serviceRange" min="0" max="100" step="1" value="0" disabled>
                    </div>
                </div>
                <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-..." crossorigin="anonymous"></script>

<script>
$(document).ready(function() {
    $('#service').change(function() {
        var selectedService = $('option:selected', this);
        var rangeValue = selectedService.data('range');
        $('#serviceRange').val(rangeValue);

        // Изпращане на AJAX заявка за зареждане на механици
        $.ajax({
            url: 'getMechanics.php',
            type: 'GET',
            data: { rangeValue: rangeValue },
            success: function(data) {
                // Обновяване на списъка с механици
                $('#mechanic').html(data);
            }
        });
    });
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
                    <button type="button" id="pickAService">Направи запитване</button>
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

        <script>
    document.getElementById('service').addEventListener('change', function() {
        var selectedService = this.options[this.selectedIndex];
        var rangeValue = selectedService.getAttribute('data-range');
        document.getElementById('serviceRange').value = rangeValue;

        // Променяме стойността на rangeValue, която ще бъде използвана в PHP кода
        <?php echo "var rangeValue = $rangeValue;"; ?>
    });
</script>



<script src="./js/multiStepForm2.js"></script>
            
</body>
</html>     