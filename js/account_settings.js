
var inputPasswordNew = document.getElementById("InputPasswordNew");
var inputPasswordNew1 = document.getElementById("InputPasswordNew1");
var inputPasswordNewUser = document.getElementById("InputPasswordNewUser");
var inputPasswordNewUser1 = document.getElementById("InputPasswordNewUser1");
var submitButtonPassword = document.getElementById("submit_change_password");
var submitNewUser = document.getElementById("submit_new_user");
var button_ok_redirect = document.getElementById("btn_ok_redirect");
var logout_button = document.getElementById("logout_button");

if (inputPasswordNew) {
  inputPasswordNew1.addEventListener('input', function(){
    var isSame = s1_eq_s2(inputPasswordNew.value, inputPasswordNew1.value);

    if (isSame) {
      submitButtonPassword.removeAttribute("hidden");
    } else {
      submitButtonPassword.setAttribute("hidden", true);
    }
  });

  inputPasswordNew.addEventListener('input', function(){
    var isSame = s1_eq_s2(inputPasswordNew.value, inputPasswordNew1.value);

    if (isSame) {
      submitButtonPassword.removeAttribute("hidden");
    } else {
      submitButtonPassword.setAttribute("hidden", true);
    }
  });

  inputPasswordNewUser1.addEventListener('input', function(){
    var isSame = s1_eq_s2(inputPasswordNewUser.value, inputPasswordNewUser1.value);

    if (isSame) {
      submitNewUser.removeAttribute("hidden");
    } else {
      submitNewUser.setAttribute("hidden", true);
    }
  });

  inputPasswordNewUser.addEventListener('input', function(){
    var isSame = s1_eq_s2(inputPasswordNewUser.value, inputPasswordNewUser1.value);

    if (isSame) {
      submitNewUser.removeAttribute("hidden");
    } else {
      submitNewUser.setAttribute("hidden", true);
    }
  });
  logout_button.addEventListener("click", function() {
    window.location.href = '/pembukuan/account/logout.php';
  });
}

if (button_ok_redirect) {
  button_ok_redirect.addEventListener("click", function() {
    window.location.href = '/pembukuan/account/account_settings.php';
  });
}

function s1_eq_s2(s1, s2){
    if (s1 == s2) {
      return true;
    }
}
