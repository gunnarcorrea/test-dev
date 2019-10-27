"use strict"

fillYear();
resetForm();
getAll();
//Events
document.getElementById("frmCarro").addEventListener("submit", function(event){
  var obj = {
    marca : document.getElementById("txtMarca").value,
    modelo : document.getElementById("txtModelo").value,
    ano: document.getElementById("slAno").value,
    id: document.getElementById("txtId").value
  };

  if(validate(obj)){
    if(obj.id == 0){
      create(obj);
    }else{
      update(obj);
    }
  }
  event.preventDefault();
});

//AJAX JQUERY
function create(obj){
  $.ajax({
    url : "api/carros",
    data : obj,
    type : "POST",
    dataType : "JSON",
    success : function(data){
      console.log(data);
      if(data.result == "ok"){
        getAll();
        $('#modalCar').modal('hide');
      }else{
        document.getElementById("dvAlert").innerHTML = "Houve um erro ao tentar cadastro seu carro.";
      }
    },
    error : function(error){
      console.log(error);
    }
  });
}

function update(obj){
  console.log(obj);
  $.ajax({
    url : "api/carros/" + obj.id,
    data : obj,
    type : "PUT",
    dataType : "JSON",
    success : function(data){
      console.log(data);
      if(data.result == "ok"){
        getAll();
        $('#modalCar').modal('hide');
      }else{
        document.getElementById("dvAlert").innerHTML = "Houve um erro ao tentar cadastro seu carro.";
      }
    },
    error : function(error){
      console.log(error);
    }
  });
}

function editCar(carId){
  $.ajax({
    url : "api/carros/" + carId,
    data : {},
    type : "GET",
    dataType : "JSON",
    success : function(data){
      console.log(data);
      if(typeof data != undefined && data != null){
        document.getElementById("txtMarca").value = data.Marca;
        document.getElementById("txtModelo").value = data.Modelo;
        document.getElementById("slAno").value = data.Ano;
        document.getElementById("txtId").value = data.Id;
        openModal(false);
      }
    },
    error : function(error){
      console.log(error);
    }
  });
}

function deleteCar(id){
  if(!confirm("Deseja realmente remover?"))
  return;

  $.ajax({
    url : "api/carros/"+id,
    data : {},
    type : "DELETE",
    dataType : "JSON",
    success : function(data){
      console.log(data);
      if(data.result == "ok"){
        getAll();
      }else{
        document.getElementById("dvAlert").innerHTML = "Houve um erro ao tentar remover o carro.";
      }
    },
    error : function(error){
      console.log(error);
    }
  });
}

function getAll(){
  $.ajax({
    url : "api/carros",
    data : {},
    type : "GET",
    dataType : "JSON",
    success : function(data){

      if(typeof data != undefined && data != null){
        var tbody = document.getElementById("tbody");
        tbody.innerHTML = "";

        for(var i = 0; i < data.length; i++){
          var tr = "<tr>"+
          "<td>#"+data[i].Id+"</td>"+
          "<td>"+data[i].Marca+"</td>"+
          "<td>"+data[i].Modelo+"</td>"+
          "<td>"+data[i].Ano+"</td>"+
          "<td>"+
          "<a href='#' class='btn btn-outline-warning m-2' onclick='editCar("+data[i].Id+");'><img src='img/icon/edit.png' alt='Edit' class='link-icon'></a>"+
          "<a href='#' class='btn btn-outline-danger  m-2' onclick='deleteCar("+data[i].Id+");'><img src='img/icon/delete.png' alt='Delete' class='link-icon'></a>"+
          "</td>"+
          "</tr>";

          tbody.innerHTML += tr;
        }
      }
    },
    error : function(error){
      console.log(error);
    }
  });
}

//Functions
function openModal(reset = true){
  if(reset)
  resetForm();
  $('#modalCar').modal('show')
}

function validate(obj){
  var msg = "";
  if(obj.marca.length <= 2 || obj.marca.length > 100)
  msg += "<p>- O campo <span class='font-weight-bold text-primary'>marca</span> deve conter entre 3 a 100 caracteres.</p>";

  if(obj.modelo.length <= 2 || obj.modelo.length > 100)
  msg += "<p>- O campo <span class='font-weight-bold text-primary'>modelo</span> deve conter entre 3 a 100 caracteres.</p>";

  var validYear = (new Date().getFullYear() +1);
  if(obj.ano <= 1980 || obj.ano > validYear)
  msg += "<p>- O <span class='font-weight-bold text-primary'>ano</span> deve estar entre 1980 e "+validYear+".</p>";

  if(obj.id < 0)
  msg += "<p>- ID inválido.</p>";

  if(msg != "")
  document.getElementById("dvAlert").innerHTML = msg;

  return msg == "";
}

function fillYear(){
  var slAno = document.getElementById("slAno");
  var year = new Date().getFullYear();

  for(var i = 1980; i <= (year + 1); i++){
    var opt = document.createElement("option");
    opt.value = i;
    opt.innerText = i;
    slAno.appendChild(opt);
  }

  slAno.value = year;
}

function resetForm(){
  document.getElementById("txtMarca").value = "";
  document.getElementById("txtModelo").value = "";
  document.getElementById("slAno").value = new Date().getFullYear();
  document.getElementById("txtId").value = "0";
  document.getElementById("dvAlert").innerHTML = "<p>- Preencha todos os campos.</p>";
}
