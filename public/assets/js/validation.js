//Creating the object for userValidity class
regObj = new UserValidity();

/**
 * checkFname is responsible for checking the validations of user's first name feild.
 * When user entered their first name then onblur this function will be execute.
 * First it will fetch the what user entered and then call a function for checking
 * the validations of entered value.
 * If user entered valid then ok otherwise it will show a error message.
 */
function checkFname() {
  var userName = document.getElementById('first_name').value;
  var status = regObj.checkName(userName);
  if(status) {
    document.getElementById("invalid_fname").innerHTML = `Enter only alphabets`;
    document.getElementById("submitBtn").disabled = true;
  }
  else {
    document.getElementById("invalid_fname").innerHTML = '';
    document.getElementById("submitBtn").disabled = false;
  }
}

function checkMname() {
  var userName = document.getElementById('middle_name').value;
  if(userName!="") {
    var status = regObj.checkName(userName);
    if(status) {
      document.getElementById("invalid_mname").innerHTML = `Enter only alphabets`;
      document.getElementById("submitBtn").disabled = true;
    }
    else {
      document.getElementById("invalid_mname").innerHTML = '';
      document.getElementById("submitBtn").disabled = false;
    }
  }
}

/**
 * checkLname is responsible for checking the validations of user's last name feild.
 * When user entered their last name then onblur this function will be execute.
 * First it will fetch the what user entered and then call a function for checking
 * the validations of entered value.
 * If user entered valid then ok otherwise it will show a error message.
 */
function checkLname() {
  var userName = document.getElementById('last_name').value;
  var status = regObj.checkName(userName);
  if(status) {
    document.getElementById("invalid_lname").innerHTML = `Enter only alphabets`;
    document.getElementById("submitBtn").disabled = true;
  }
  else {
    document.getElementById("invalid_lname").innerHTML = '';
    document.getElementById("submitBtn").disabled = false;
  }
}

/**
 * checkPhoneNo is responsible for checking the validations of user's mobile number feild.
 * When user entered their mobile number then onblur this function will be execute.
 * First it will fetch the what user entered and then call a function for checking
 * the validations of entered value.
 * If user entered valid then ok otherwise it will show a error message.
 */
function checkPhoneNo() {
  var userMobile = document.getElementById('mobile').value;
  var status = regObj.checkPhone(userMobile);
  if(status) {
    document.getElementById("invalid_mobile").innerText = `Enter valid mobile number`;
    document.getElementById("submitBtn").disabled = true;
  }
  else {
    document.getElementById("invalid_mobile").innerText = '';
    document.getElementById("submitBtn").disabled = false;
  }
}

/**
 * checkEmailStatus is responsible for checking the validations of user's email feild.
 * When user entered their email then onblur this function will be execute.
 * First it will fetch the what user entered and then call a function for checking
 * the validations of entered value.
 * If user entered valid then show a success otherwise it will show a error message.
 */
function checkEmailStatus() {
  var userEmail = document.getElementById('email').value;
  var status = regObj.checkEmail(userEmail);
  if(status) {
    document.getElementById("email_success").innerText = ``;
    document.getElementById("email_status").innerText = `Enter valid email`;
    document.getElementById("submitBtn").disabled = true;
  }
  else {
    document.getElementById("email_status").innerText = ``;
    document.getElementById("email_success").innerText = `Valid email`;
    document.getElementById("submitBtn").disabled = false;
  }
}

function checkOldPasswordStatus() {
  var userPwd = document.getElementById('oldPwd').value;
  var status = regObj.checkPasswords(userPwd);
  if(status) {
    document.getElementById("oldPwd_success").innerText = ``;
    document.getElementById("oldPwd_status").innerText = `Enter valid password`;
    document.getElementById("submitBtn").disabled = true;
  }
  else {
    document.getElementById("oldPwd_status").innerText = ``;
    document.getElementById("oldPwd_success").innerText = `Valid password`;
    document.getElementById("submitBtn").disabled = false;
  }
}

/**
 * checkPasswordStatus is responsible for checking the validations of user's password feild.
 * When user entered their password then onblur this function will be execute.
 * First it will fetch what user entered and then call a function for checking
 * the validations of entered value.
 * If user entered valid then show success message otherwise it will show a error message.
 */
function checkPasswordStatus() {
  var userPwd = document.getElementById('pwd').value;
  var status = regObj.checkPasswords(userPwd);
  if(status) {
    document.getElementById("pwd_success").innerText = ``;
    document.getElementById("pwd_status").innerText = `Enter valid password`;
    document.getElementById("submitBtn").disabled = true;
  }
  else {
    document.getElementById("pwd_status").innerText = ``;
    document.getElementById("pwd_success").innerText = `Valid password`;
    document.getElementById("submitBtn").disabled = false;
  }
}

function checkPasswordDiff(){
  var oldPwd = document.getElementById('oldPwd').value;
  var newPwd = document.getElementById('pwd').value;
  var status = regObj.diffPasswords(oldPwd, newPwd);
  if(status) {
    document.getElementById("pwd_status").innerText = ``;
    document.getElementById("submitBtn").disabled = false;
  }
  else {
    document.getElementById("pwd_status").innerText = `Please enter different password`;
    document.getElementById("submitBtn").disabled = true;
  }
}

/**
 * onfirmPassword is responsible for comparing the new and confirm password.
 * When user entered their confirm password then onblur this function will be execute.
 * First it will fetch from both the feild what user entered and then call a
 * function for comapring the values.
 * If user entered valid then ok otherwise it will show a error message.
 */
function confirmPassword() {
  var newPwd = document.getElementById('pwd').value;
  var cnfPwd = document.getElementById('cnfPwd').value;
  var status = regObj.samePasswords(newPwd, cnfPwd);
  if(status) {
    document.getElementById("cnfPwd_status").innerText = ``;
    document.getElementById("submitBtn").disabled = false;
  }
  else {
    document.getElementById("cnfPwd_status").innerText = `Please enter same password`;
    document.getElementById("submitBtn").disabled = true;
  }
}

function checkSub() {
  var sub1 = document.getElementById('sub1');
  var sub2 = document.getElementById('sub2');
  var sub3 = document.getElementById('sub3');
  var sub4 = document.getElementById('sub4');
  var sub5 = document.getElementById('sub5');
  var sub6 = document.getElementById('sub6');
  var sub7 = document.getElementById('sub7');

  if(sub1.checked || sub2.checked || sub3.checked || sub4.checked || sub5.checked || sub6.checked || sub7.checked) {
    document.getElementById("submitBtn").disabled = false;
  }
  else {
    alert("You have to choose atleast one subject!!!");
    document.getElementById("submitBtn").disabled = true;
  }
}

function subChecked() {
  document.getElementById("submitBtn").disabled = false;
}


function selectLoginOption() {
  var option = document.getElementById('loginOption').value;
  if(option === "loginwithname") {
    document.getElementById("loginLable").innerHTML = "Enter your user-name";
  }
  else if (option === "loginwithemail") {
    document.getElementById("loginLable").innerHTML = "Enter your email";
  }
}

function checkAge() {
  var ageFormat = /^(1[59]|[2-9]\d)$/;
  var age = document.getElementById("age").value;
  if(age.match(ageFormat)) {
    document.getElementById("invalid_age").innerText = ``;
    document.getElementById("submitBtn").disabled = false;
  }
  else {
    document.getElementById("invalid_age").innerText = `Please enter valid age[15 to 100]`;
    document.getElementById("submitBtn").disabled = true;
  }
}
