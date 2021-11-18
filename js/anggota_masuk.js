var btn_ok_redirect = document.getElementById("btn_ok_redirect");
var btn_cancel_delete = document.getElementById("btn_cancel_delete");

var page_title = document.getElementsByTagName("title")[0].text;
if (page_title == "Input Anggota Masuk") {

  var input_no_anggota = document.getElementById("input_no_anggota");
  var input_nama_anggota = document.getElementById("input_nama_anggota");
  var input_nik = document.getElementById("input_nik");
  var input_npwp = document.getElementById("input_npwp");
  var input_tanggal_lahir = document.getElementById("input_tanggal_lahir");
  var input_agama = document.getElementById("input_agama");
  var input_unit = document.getElementById("input_unit");
  var input_alamat = document.getElementById("input_alamat");

  input_text_validation(input_no_anggota);
  input_text_validation(input_nama_anggota);
  input_text_length_validation(input_nik, 16);
  input_text_length_validation(input_npwp, 15);
  input_text_validation(input_tanggal_lahir);
  input_text_validation(input_agama);
  input_text_validation(input_unit);
  input_text_validation(input_alamat);
}

if (page_title == "Edit Data") {

  var input_nama_anggota = document.getElementById("input_nama_anggota");
  var input_nik = document.getElementById("input_nik");
  var input_npwp = document.getElementById("input_npwp");
  var input_tanggal_lahir = document.getElementById("input_tanggal_lahir");
  var input_agama = document.getElementById("input_agama");
  var input_unit = document.getElementById("input_unit");
  var input_alamat = document.getElementById("input_alamat");

  input_text_validation(input_nama_anggota);
  input_text_length_validation(input_nik, 16);
  input_text_length_validation(input_npwp, 15);
  input_text_validation(input_tanggal_lahir);
  input_text_validation(input_agama);
  input_text_validation(input_unit);
  input_text_validation(input_alamat);
}

if (page_title == "Anggota Masuk") {
  var active = "";
  var btn_25 = document.getElementById("btn_25");
  var btn_50 = document.getElementById("btn_50");
  var btn_75 = document.getElementById("btn_75");
  var btn_100 = document.getElementById("btn_100");

  if (active == "") {
    for (var i = 0; i < 25; i++) {
      if (document.getElementById("list_no_" + (i + 1))) {
        document.getElementById("list_no_" + (i + 1)).removeAttribute("hidden");
      }
    }
    for (var i = 25; i < 100; i++) {
      if (document.getElementById("list_no_" + (i + 1))) {
        document.getElementById("list_no_" + (i + 1)).setAttribute("hidden", true);
      }
    }
    active = "25";
  }

  btn_25.addEventListener("click", function (){
    btn_activity_list(btn_25, btn_75, btn_50, btn_100)
    if (active != "25") {
      for (var i = 0; i < 25; i++) {
        if (document.getElementById("list_no_" + (i + 1))) {
          document.getElementById("list_no_" + (i + 1)).removeAttribute("hidden");
        }
      }
      for (var i = 25; i < 100; i++) {
        if (document.getElementById("list_no_" + (i + 1))) {
          document.getElementById("list_no_" + (i + 1)).setAttribute("hidden", true);
        }
      }
      active = "25";
    };
  });
  btn_50.addEventListener("click", function (){
    btn_activity_list(btn_50, btn_75, btn_25, btn_100);
    if (active != "50") {
      for (var i = 0; i < 50; i++) {
        if (document.getElementById("list_no_" + (i + 1))) {
          document.getElementById("list_no_" + (i + 1)).removeAttribute("hidden");
        }
      }
      for (var i = 50; i < 100; i++) {
        if (document.getElementById("list_no_" + (i + 1))) {
          document.getElementById("list_no_" + (i + 1)).setAttribute("hidden", true);
        }
      }
      active = "50";
    }
  });
  btn_75.addEventListener("click", function (){
    btn_activity_list(btn_75, btn_25, btn_50, btn_100);
    if (active != "75") {
      for (var i = 0; i < 75; i++) {
        if (document.getElementById("list_no_" + (i + 1))) {
          document.getElementById("list_no_" + (i + 1)).removeAttribute("hidden");
        }
      }
      for (var i = 75; i < 100; i++) {
        if (document.getElementById("list_no_" + (i + 1))) {
          document.getElementById("list_no_" + (i + 1)).setAttribute("hidden", true);
        }
      }
      active = "75";
    }
  });
  btn_100.addEventListener("click", function (){
    btn_activity_list(btn_100, btn_75, btn_50, btn_25);
    if (active != "100") {
      for (var i = 0; i < 100; i++) {
        if (document.getElementById("list_no_" + (i + 1))) {
          document.getElementById("list_no_" + (i + 1)).removeAttribute("hidden");
        }
      }
      active = "100";
    }
  });
}

if (btn_ok_redirect) {
  btn_ok_redirect.addEventListener("click", function (){
    click_redirect_to()
  });
}

if (btn_cancel_delete) {
  btn_cancel_delete.addEventListener("click", function (){
    click_redirect_to()
  });
}

function click_redirect_to(){
  window.location.href = '/pembukuan/keanggotaan/anggota_masuk/index.php';
}

function input_text_validation(input){
  input.addEventListener("input", function(){
    var value = input.value;
    if (value == "") {
      input.classList.add("is-invalid");
      input.classList.remove("is-valid");
    } else {
      input.classList.add("is-valid");
      input.classList.remove("is-invalid");
    }
  });
}

function input_text_length_validation(input, length){
  input.addEventListener("input", function(){
    var value = input.value;
    if (value == "" || value.length < length) {
      input.classList.add("is-invalid");
      input.classList.remove("is-valid");
      return false;
    } else {
      input.classList.add("is-valid");
      input.classList.remove("is-invalid");
      return true;
    }
  });
}

function btn_activity_list(btn1,btn2,btn3,btn4){
  btn1.classList.add("active");
  btn2.classList.remove("active");
  btn3.classList.remove("active");
  btn4.classList.remove("active");
}
