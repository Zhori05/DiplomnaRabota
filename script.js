document.addEventListener("DOMContentLoaded", function() {

  let servicesBtn = document.getElementById("servicesBtn");
  servicesBtn.addEventListener("click",displayServices);
  function displayServices() {
    let serviceContainer = document.getElementById("serviceContainer");
    serviceContainer.style.display = (serviceContainer.style.display === 'none' || serviceContainer.style.display === '') ? 'block' : 'none';
  }

  let mechanicsBtn = document.getElementById("mechanicsBtn");
  mechanicsBtn.addEventListener("click",displayMechanics);
  function displayMechanics(){
    let mechanicsContainer = document.getElementById("mechanicsContainer")
    mechanicsContainer.style.display = (mechanicsContainer.style.display === 'none' || mechanicsContainer.style.display === '') ? 'block' : 'none';
  }
let appointmetsBtn = document.getElementById("appointmentsBtn");
appointmetsBtn.addEventListener("click", displayAppointments);

function displayAppointments() {
  let appointmentsContainer = document.getElementById("appointmentsContainer");
  appointmentsContainer.style.display = (appointmentsContainer.style.display === 'none' || appointmentsContainer.style.display === '') ? 'block' : 'none';
}


  let addBtn = document.getElementById("addBtn");
  addBtn.addEventListener("click", displayContainer);
  let container = document.getElementById("container");
  function displayContainer() {
    
    container.style.display = "block";
    addBtn.style.display = "none";

  }
  let addMechanicBtn = document.getElementById("addMechanicBtn");
  addMechanicBtn.addEventListener("click",displayMechanicContainer);
  let mechanicContainer = document.getElementById("containerForMechanic");
  function displayMechanicContainer(){
    mechanicContainer.style.display="block";
    addMechanicBtn.style.display = "none";
  }


  let editBtns = document.getElementsByClassName("editBtn");
for (let i = 0; i < editBtns.length; i++) {
    editBtns[i].addEventListener("click", editService);
}

function editService(event) {
  event.preventDefault();
  container.style.display = "block";

  let nameField = document.getElementById("serviceName");
  let minsField = document.getElementById("timeForExecution");

  let row = event.target.closest("tr");
  let id = row.querySelector("th").textContent;
  let nameDB = row.querySelector(".nameDB").textContent;
  let timeDB = row.querySelector(".timeDB").textContent;

  nameField.value = nameDB;
  minsField.value = timeDB.replace(/\D/g, '');

}
  let editMechanicBtns = document.getElementsByClassName("editMechanicBtn");
  for (let i = 0; i < editMechanicBtns.length; i++) {
    editMechanicBtns[i].addEventListener("click", editMechanic);
  }

  function editMechanic(event) {
    event.preventDefault();

    // Извличане на информацията от реда на таблицата
    let row = event.target.closest("tr");
    let idMechanic = row.querySelector("th").textContent;
    let nameDB = row.querySelector(".nameDB").textContent;
    let emailDB = row.querySelector(".emailDB").textContent;
    let specializedInDB = row.querySelector(".specializedInDB").textContent;

    // Запълване на формата за добавяне на механик с извлечената информация
    let mechanicNameField = document.getElementById("mechanicName");
    let emailField = document.getElementById("email");
    let specializedInField = document.getElementById("specializedIn");

    mechanicNameField.value = nameDB;
    emailField.value = emailDB;
    specializedInField.value = specializedInDB;

   
  }




});