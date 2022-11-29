function alertView(){
  const alert = document.querySelector('.alert');

  if(!alert.querySelector('p').innerHTML == ''){
    alert.style.opacity = '1';
  } else {
    alert.style.opacity = '0';
  }

  setTimeout(() => {
    alert.style.transform = 'translateX(100%)';
  }, 5750)
}

const mask_valor = document.querySelector('.mascara_valor_text');

// mask_valor.addEventListener('keypress', () => {
//   let valor_length = mask_valor.value.length;
//   if (valor_length === 0){
//     mask_valor.value = '0,0' + mask_valor.value;
//   } if (valor_length === 4) {
//     mask_valor.value = '0,' + mask_valor.value;
//   }
// });