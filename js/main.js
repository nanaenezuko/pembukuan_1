var page_title = document.getElementsByTagName("title")[0].text;

if (page_title == "PEMBUKUAN MASUK") {
  btn_simpanan_anggota = document.getElementById("btn_simpanan_anggota");
  btn_pembayaran_pinjam = document.getElementById("btn_pembayaran_pinjam");
  btn_lainnya = document.getElementById("btn_lainnya");

  btn_simpanan_anggota.addEventListener("click", function(){
    click_redirect_keanggotaan_to("pembukuan_masuk/simpanan_anggota");
  });
  btn_pembayaran_pinjam.addEventListener("click", function(){
    click_redirect_keanggotaan_to("pembukuan_masuk/pembayaran_pinjam");
  });
  btn_lainnya.addEventListener("click", function(){
    click_redirect_keanggotaan_to("pembukuan_masuk/pembayaran_lainnya");
  });
}

if (page_title == "KEANGGOTAAN") {
  btn_anggota_masuk = document.getElementById("btn_anggota_masuk");
  btn_anggota_keluar = document.getElementById("btn_anggota_keluar");
  btn_rekap_anggota = document.getElementById("btn_rekap_anggota");

  btn_anggota_masuk.addEventListener("click", function(){
    click_redirect_keanggotaan_to("keanggotaan/anggota_masuk");
  });
  btn_anggota_keluar.addEventListener("click", function(){
    click_redirect_keanggotaan_to("keanggotaan/anggota_keluar");
  });
  btn_rekap_anggota.addEventListener("click", function(){
    click_redirect_keanggotaan_to("keanggotaan/rekap_anggota");
  });
}

if (page_title == "PEMBUKUAN KELUAR") {
  btn_pembayaran_pinjaman_anggota = document.getElementById("btn_pembayaran_pinjaman_anggota");
  btn_pembayaran_pajak = document.getElementById("btn_pembayaran_pajak");
  btn_pembayaran_anggota_keluar = document.getElementById("btn_pembayaran_anggota_keluar");
  btn_belanja_operasional = document.getElementById("btn_belanja_operasional");

  btn_pembayaran_pinjaman_anggota.addEventListener("click", function(){
    click_redirect_keanggotaan_to("pembukuan_keluar/pembayaran_pinjaman_anggota");
  });
  btn_pembayaran_pajak.addEventListener("click", function(){
    click_redirect_keanggotaan_to("pembukuan_keluar/pembayaran_pajak");
  });
  btn_pembayaran_anggota_keluar.addEventListener("click", function(){
    click_redirect_keanggotaan_to("pembukuan_keluar/pembayaran_anggota_keluar");
  });
  btn_belanja_operasional.addEventListener("click", function(){
    click_redirect_keanggotaan_to("pembukuan_keluar/belanja_operasional");
  });
}

if (page_title == "MAIN MENU") {
  btn_keanggotaan = document.getElementById("btn_keanggotaan");
  btn_pembukuan_masuk = document.getElementById("btn_pembukuan_masuk");
  btn_pembukuan_keluar = document.getElementById("btn_pembukuan_keluar");

  btn_keanggotaan.addEventListener("click", function(){
    click_redirect_keanggotaan_to("keanggotaan");
  });
  btn_pembukuan_masuk.addEventListener("click", function(){
    click_redirect_keanggotaan_to("pembukuan_masuk");
  });
  btn_pembukuan_keluar.addEventListener("click", function(){
    click_redirect_keanggotaan_to("pembukuan_keluar");
  });
}

if (document.getElementById("btn_print")) {
  document.getElementById("btn_print").addEventListener('click', function(){
    printDiv("printArea");
  });
}

function click_redirect_keanggotaan_to(link){
  window.location.href = '/pembukuan/'+link;
}

function EditFile(btnEditfile,btnFile,uploadFile){
  var btn_file = document.getElementById(btnFile);
  var upload_file = document.getElementById(uploadFile);
  var btn_edit = document.getElementById(btnEditfile);

  if (upload_file.getAttribute("hidden") === null) {
    btn_edit.innerHTML = "Edit";
    btn_file.removeAttribute("hidden");
    upload_file.setAttribute("hidden", true);
  } else {
    btn_edit.innerHTML = "Cancel";
    btn_file.setAttribute("hidden", true);
    upload_file.removeAttribute("hidden");
  }
}

function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;

     console.log("FUCK YOU");
}

function test(){
  console.log("I want pussy");
}
