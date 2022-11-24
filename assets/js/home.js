//PEGA O TAMANHO DO CONTAINER
const carrossel_container = - +document.querySelector('.meta_carrosel').clientWidth;
//SELECIONA A ROLETA DO CARROSSEL
const carrossel_content = document.querySelector('.meta_carrosel_limit');

const carrosel_content_div = document.querySelectorAll('.meta_content');
carrosel_content_div.forEach((e) => {
  e.style.width = - carrossel_container + 'px';
})

//PEGA O TAMANHO TOTAL DA CLASS CARROSSEL_CONTENT
const teste = carrossel_container * carrosel_content_div.length;

//SETAS PARA AVANÇAR OU VOLTAR
const left = document.querySelector('.e');
const right = document.querySelector('.d');

let anda = carrossel_container;

left.addEventListener('click', () => {
  if (anda === carrossel_container) {
    console.log('mínimo');
  } else {
    anda -= carrossel_container;
    carrossel_content.style.transform = 'translateX(' + (anda + -carrossel_container) + 'px)';
  }
});

right.addEventListener('click', () => {
  if (teste === anda) {
    console.log('máximo');
  } else {
    carrossel_content.style.transform = 'translateX(' + anda + 'px)';
    anda += carrossel_container;
  }
});