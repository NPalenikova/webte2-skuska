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
      const message = 'Prosím vyplňte všetky informácie.';
      toastBody.textContent = message;
      const bsToast = new bootstrap.Toast(myToast);
      bsToast.show();
      setTimeout(() => {
        bsToast.hide();
      }, 5000);
      return false;
    }
    else if(!(email.endsWith("stuba.sk"))){
      const message = 'Prosím použite univerzitný email.';
      toastBody.textContent = message;
      const bsToast = new bootstrap.Toast(myToast);
      bsToast.show();
      setTimeout(() => {
        bsToast.hide();
      }, 5000);
      return false;
    }
    else if(!passwordPattern.test(password)){
      const message = 'Prosím zadajte valídne heslo.';
      toastBody.textContent = message;
      const bsToast = new bootstrap.Toast(myToast);
      bsToast.show();
      setTimeout(() => {
        bsToast.hide();
      }, 5000);
      return false;
    }
    else if (password !== repeatPassword){
      const message = "Heslá sa nezhodujú.";
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