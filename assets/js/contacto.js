const consulta = document.getElementById("consulta");
const tipoConsulta = document.getElementById('typeContact');

consulta.addEventListener("input", function() {
    if (consulta.value !== "") {
      consulta.classList.add("tiene-contenido");
    } else {
        consulta.classList.remove("tiene-contenido");
      }
  });
  
  tipoConsulta.addEventListener("change", function(){
    if (tipoConsulta.value == ""){
      tipoConsulta.classList.add("tiene-contenido");
    }else{
      tipoConsulta.classList.remove("tiene-contenido");
    }
  })