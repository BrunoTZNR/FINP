function alertView(){
  const alert = document.querySelector('.alert');

  if(!alert.querySelector('p').innerHTML == ''){
    alert.style.opacity = '1';
  }

  setTimeout(() => {
    alert.style.transform = 'translateX(100%)';
  }, 5750)
}

const row_table = document.querySelectorAll('table tbody tr#id');

row_table.forEach((e) => {
  let content = e.className.split(' ');
  let card = content[1];
  let id = content[0];

  e.addEventListener('click', () => {
    // console.log(`./view.php?card=${card}&id=${id}`);
    window.location.href = `./view.php?card=${card}&id=${id}`;
  });
});