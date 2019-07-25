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

var prettyDate = function(input){
    var d = new Date(Date.parse(input.replace(/-/g, "/")));
    var month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    var date = month[d.getMonth()] + " " + d.getDate()  + ", " + d.getFullYear();
    var time = d.toLocaleTimeString().toLowerCase().replace(/([\d]+:[\d]+):[\d]+(\s\w+)/g, "$1$2");
    return (date + " at " + time);  
};

function set(key, val) {
  sessionStorage.setItem(key, val);
}

function get(key) {
  return sessionStorage.getItem(key);
}