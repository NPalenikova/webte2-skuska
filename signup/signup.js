function validateForm() {
  var name = document.forms["signupForm"]["name"].value;
  var surname = document.forms["signupForm"]["surname"].value;
  var email = document.forms["signupForm"]["email"].value;
  var password = document.forms["signupForm"]["password"].value;
  var repeatPassword = document.forms["signupForm"]["repeatPassword"].value;


  const myToast = document.getElementById('myToast');
  const toastBody = myToast.querySelector('.toast-body');

  const passwordPattern = /^[a-zA-Z0-9]{8,20}$/;

  if (name == "" || surname == "" || email == "" || password == "" || repeatPassword == "") {
    const message = 'Please fill out all information.';
    toastBody.textContent = message;
    const bsToast = new bootstrap.Toast(myToast);
    bsToast.show();
    setTimeout(() => {
      bsToast.hide();
    }, 5000);
    return false;
  }
  else if(!(email.endsWith("stuba.sk"))){
    const message = 'Please use university email.';
    toastBody.textContent = message;
    const bsToast = new bootstrap.Toast(myToast);
    bsToast.show();
    setTimeout(() => {
      bsToast.hide();
    }, 5000);
    return false;
  }
  else if(!passwordPattern.test(password)){
    const message = 'Please enter a valid password.';
    toastBody.textContent = message;
    const bsToast = new bootstrap.Toast(myToast);
    bsToast.show();
    setTimeout(() => {
      bsToast.hide();
    }, 5000);
    return false;
  }
  else if (password !== repeatPassword){
    const message = "Passwords don't match.";
    toastBody.textContent = message;
    const bsToast = new bootstrap.Toast(myToast);
    bsToast.show();
    setTimeout(() => {
      bsToast.hide();
    }, 5000);
    return false;
  }
  else{
    if (email.toLowerCase().startsWith("x")) {
      document.getElementById("userType").value = "student";
    } else {
      document.getElementById("userType").value = "teacher";
    }
  }
}