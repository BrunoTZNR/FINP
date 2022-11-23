/* MODAL CONFIRM DELETE */
const openModalButton = document.querySelector("#confirm");
const closeModalButton = document.querySelector("#close");
const redirectModalButton = document.querySelector("#delete");
const modal = document.querySelector("#modal");
const fade = document.querySelector("#fade");

redirectModalButton.addEventListener("click", () =>{
  window.location.href = "./profile_delete.php";
});

const toggleModal = () => {
  [modal, fade].forEach((elemento) => elemento.classList.toggle("hide"));
}

[openModalButton, closeModalButton, fade].forEach((elemento) => {
  elemento.addEventListener("click", () => toggleModal());
});

// MASCARAS PARA OS CAMPOS
const field = document.querySelectorAll('.mascara');
// 0-> cpf, 1-> cnpj, 2-> telefone, 3-> cep
let i;
if(!field[0].innerHTML == ''){
  let cpf = [field[0].innerHTML.split(''), ''];
  for(i = 0; i < 11; i++){
    if(cpf[1].length == 0){
      cpf[1] = cpf[0][i];
    } else if(cpf[1].length == 2) {
      cpf[1] += cpf[0][i] + '.';
    } else if(cpf[1].length == 6) {
      cpf[1] += cpf[0][i] + '.';
    } else if(cpf[1].length == 10) {
      cpf[1] += cpf[0][i] + '-';
    } else {
      cpf[1] += cpf[0][i];
    }
  }
  field[0].innerHTML = cpf[1];
}

if(!field[1].innerHTML == ''){
  let cnpj = [field[1].innerHTML.split(''), ''];
  for(i = 0; i < 14; i++){
    if(cnpj[1].length == 0){
      cnpj[1] = cnpj[0][i];
    } else if(cnpj[1].length == 1) {
      cnpj[1] += cnpj[0][i] + '.';
    } else if(cnpj[1].length == 5) {
      cnpj[1] += cnpj[0][i] + '.';
    } else if(cnpj[1].length == 9) {
      cnpj[1] += cnpj[0][i] + '/';
    } else if(cnpj[1].length == 14) {
      cnpj[1] += cnpj[0][i] + '-';
    } else {
      cnpj[1] += cnpj[0][i];
    }
  }
  field[1].innerHTML = cnpj[1];
}

if(!field[2].innerHTML == ''){
  let tel = [field[2].innerHTML.split(''), ''];
  for(i = 0; i < 11; i++){
    if(tel[1].length == 0){
      tel[1] = '(' + tel[0][i];
    } else if(tel[1].length == 3) {
      tel[1] += ')' + tel[0][i];
    } else if(tel[1].length == 9) {
      tel[1] += tel[0][i] + '-';
    } else {
      tel[1] += tel[0][i];
    }
  }
  field[2].innerHTML = tel[1];
}

if(!field[3].innerHTML == ''){
  let cep = [field[3].innerHTML.split(''), ''];
  for(i = 0; i < 8; i++){
    if(cep[1].length == 0){
      cep[1] = cep[0][i];
    } else if(cep[1].length == 4) {
      cep[1] += cep[0][i] + '-';
    } else {
      cep[1] += cep[0][i];
    }
  }
  field[3].innerHTML = cep[1];
}