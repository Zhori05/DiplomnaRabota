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
if (isset($_POST['serviceName']) && isset($_POST['timeForExecution'])) {


  $Name = $_POST['serviceName'];
  $Mins = $_POST['timeForExecution'];
  
   // заявка към базата, с която се записват полетата
   $sql = "INSERT INTO Services (name, timeForExecution) VALUES (?,?)";
   $connection->prepare($sql)->execute([$Name, $Mins]);
   echo "<b style='color:green;'>Успешно добавихте услуга.</b><br><br>";
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin panel</title>
  <link rel="stylesheet" href="adminStyle.css">
  <script src="script.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>
  <div class = "container" id = "container">
  <h3>Добавяне на услуга</h3>
  <div class = "form">
    <form method="post">
      <div class = "form-group">
        <label for="serviceName">Име на услугата:</label>
        <input type="text"id="serviceName" name="serviceName" required>
      </div>
      <div class = "form-group">
        <label for="timeForExecution">Време за изпълнение (в минути):</label>
         <input type="number" id="timeForExecution" name="timeForExecution" required>
      </div>
      <div class = "buttonContainer">
         <button  type="submit" class = "insertBtn" id = "insertBtn">Добави услуга</button>
      </div>
    </form>
    
  </div>
  </div>
  <div style="width: 25%; margin: 0 auto;" >
    <button type="button" class = "btn btn-primary" id="addBtn">Добави услуга</button>
</div>
<br>
<br>
<div class = "tableContainer">
<table class="table table-striped table-hover" >
  <thead class="table-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Име на услугата</th>
      <th scope="col">Време за изпълнение</th>
      <th scope="col">Операции</th>
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
        echo '<tr>
        <th scope="row">' . $id . '</th>
        <td class="nameDB">' . $name . '</td>
        <td class="timeDB">' . $timeForExecution. ' мин</td>
        <td>
        <button class="btn btn-primary editBtn">
  <a href="" class="text-light">
    <i class="fa-solid fa-pen-to-square"></i>
  </a>
  <div class="editTextArea">Промени</div>
</button>

        <button class="btn btn-danger">
        <a href="delete.php?deleteid='.$id.'" class="text-light">
        <i class="fa-solid fa-trash"></i>
        </a>
        <div class="editTextArea">Изтрий</div>
        </button>
      </tr>';
  
    }
}
?>

  
   
  </tbody>
</table>
</div>
</body>
</html>