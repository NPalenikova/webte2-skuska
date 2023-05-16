function chechLogin() {
    var email = document.forms["loginForm"]["email"].value;
    var password = document.forms["loginForm"]["password"].value;
  
    const myToast = document.getElementById('myToast');
    const toastBody = myToast.querySelector('.toast-body');
  
    if (email == "" || password == "") {
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
    else{
      if (email.toLowerCase().startsWith("x")) {
        document.getElementById("userType").value = "student";
      } else {
        document.getElementById("userType").value = "teacher";
      }
    }
  }