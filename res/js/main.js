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

function prettyDate(date) {
  var d = new Date(date);

  var day = d.getDate();
  var mon = d.getMonth();
  var year = d.getFullYear();

  var min = d.getMinutes();
  var hour = d.getHours();

  var ampm = "AM";

  if (hour >= 12) {
    ampm = "PM";
    hour = hour - 12;
  }

  return mon + "/" + day + "/" + year + " at " + hour + ":" + min + " " + ampm;
}