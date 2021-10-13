const keyword = document.getElementById('keyword');
const tableContainer = document.querySelector('.table-container');

keyword.addEventListener('keyup', () => {
  //buat object ajax
  // const xhr = new XMLHttpRequest();

  // //cek kesiapan ajaxnya
  // xhr.onreadystatechange = () => {
  //   if (xhr.readyState == 4 && xhr.status == 200) {
  //     tableContainer.innerHTML = xhr.responseText;
  //   }
  // };

  // //eksekusi ajax
  // xhr.open("GET", "ajax/ajax_cari.php?keyword=" + keyword.value);
  // xhr.send();

  fetch('ajax/ajax_cari.php?keyword=' + keyword.value)
    .then((response) => response.text())
    .then((response) => (tableContainer.innerHTML = response));
});

// PREVIEW IMAGE untuk tambah.php dan edit.php
function previewImage(){
  const gambar = document.querySelector('.gambar');
  const imgPreview = document.querySelector('.imgPreview');

  const oFReader = new FileReader();
  oFReader.readAsDataURL(gambar.files[0]);

  oFReader.onload = (oFREvent) => {
    imgPreview.src = oFREvent.target.result;
  } 

};
