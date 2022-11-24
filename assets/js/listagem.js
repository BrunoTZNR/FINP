const row_table = document.querySelectorAll('table tbody tr');

row_table.forEach((e) => {
  let content = e.className.split(' ');
  let card = content[1];
  let id = content[0];

  e.addEventListener('click', () => {
    // console.log(`./view.php?card=${card}&id=${id_card}`);
    window.location.href = `./view.php?card=${card}&id=${id}`;
  });
});