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

/* MODAL CONFIRM DELETE */
const openModalButton = document.querySelector("#confirm");
const closeModalButton = document.querySelector("#close");
const redirectModalButton = document.querySelector("#delete");
const modal = document.querySelector("#modal");
const fade = document.querySelector("#fade");

// redirectModalButton.addEventListener("click", () =>{
//   // window.location.href = "./profile_delete.php";
//   console.log(modal.querySelector('article h5').className);
// });

const toggleModal = () => {
  [modal, fade].forEach((elemento) => elemento.classList.toggle("hide"));
}

[openModalButton, closeModalButton, fade].forEach((elemento) => {
  elemento.addEventListener("click", () => toggleModal());
});