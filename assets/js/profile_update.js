function alertView(){
  const alert = document.querySelector('.alert');

  if(!alert.querySelector('p').innerHTML == ''){
    alert.style.opacity = '1';
  }

  setTimeout(() => {
    alert.style.transform = 'translateX(100%)';
  }, 5750)
}

// MASCARAS PARA OS CAMPOS
const field = document.querySelectorAll('.mascara');
// 0-> cpf, 1-> cnpj, 2-> telefone, 3-> cep
let i;
if(!field[0].value == ''){
  let cpf = [field[0].value.split(''), ''];
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
  field[0].value = cpf[1];
}

if(!field[1].value == ''){
  let cnpj = [field[1].value.split(''), ''];
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
  field[1].value = cnpj[1];
}

if(!field[2].value == ''){
  let tel = [field[2].value.split(''), ''];
  for(i = 0; i < 11; i++){
    if(tel[1].length == 0){
      tel[1] = '(' + tel[0][i];
    } else if(tel[1].length == 3) {
      tel[1] += ')' + tel[0][i];
    } else if(tel[1].length == 8) {
      tel[1] += tel[0][i] + '-';
    } else {
      tel[1] += tel[0][i];
    }
  }
  field[2].value = tel[1];
}

if(!field[3].value == ''){
  let cep = [field[3].value.split(''), ''];
  for(i = 0; i < 8; i++){
    if(cep[1].length == 0){
      cep[1] = cep[0][i];
    } else if(cep[1].length == 4) {
      cep[1] += cep[0][i] + '-';
    } else {
      cep[1] += cep[0][i];
    }
  }
  field[3].value = cep[1];
}

// MASCARA CPF, CPNJ, TELEFONE E CEP
field[0].addEventListener('keypress', ()=>{
  let cpf_length = field[0].value.length;
  if(cpf_length == 3 || cpf_length == 7){
      field[0].value += '.';
  }else if(cpf_length == 11){
      field[0].value += '-';
  }
});

field[1].addEventListener('keypress', ()=>{
  let cnpj_length = field[1].value.length;
  if(cnpj_length === 2 || cnpj_length === 6){
      field[1].value += '.';
  }else if(cnpj_length === 10){
      field[1].value += '/';
  }else if(cnpj_length === 15){
      field[1].value += '-';
  }
});

field[2].addEventListener('keypress', ()=>{
  let telefone_length = field[2].value.length;
  if(telefone_length === 0){
      field[2].value += '(';
  }else if(telefone_length === 3){
      field[2].value += ')';
  }else if(telefone_length === 9){
      field[2].value += '-';
  }
});

field[3].addEventListener('keypress', ()=>{
  let cep_length = field[3].value.length;
  if(cep_length === 5){
      field[3].value += '-';
  }
});