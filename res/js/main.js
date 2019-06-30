$(document).ready(function() {

})

function isValidPassword(pass) {
  if (pass.length == 0) {
    return false;
  }

  return true;
}

function validateInputs(inputClass) {
  var forms = document.getElementsByClassName(inputClass);

  var validation = Array.prototype.filter.call(forms, function(form) {
      
      form.checkValidity();
     
      form.classList.add('was-validated');
  });

  return true;
}

function request(url, data, callback) {

}

function set(key, val) {
  sessionStorage.setItem(key, val);
}

function get(key) {
  return sessionStorage.getItem(key);
}