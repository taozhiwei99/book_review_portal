
function checkPassword() {
  const password = document.getElementById("create_password1");

  const confirm = document.getElementById("create_password2");
  console.log(confirm.value == password.value)

  if (confirm.value == password.value) {
    confirm.setCustomValidity('');
  } else {
    confirm.setCustomValidity('Passwords do not match');
  }
}

function EditCheckPassword() {
  const password = document.getElementById("edit_password1");

  const confirm = document.getElementById("edit_password2");
  console.log(confirm.value == password.value)

  if (confirm.value == password.value) {
    confirm.setCustomValidity('');
  } else {
    confirm.setCustomValidity('Passwords do not match');
  }
}

function UpdateCheckOldPassword() {
  const password = document.getElementById("update_password1");

  const confirm = document.getElementById("update_password2");
  console.log(confirm.value == password.value)

  if (confirm.value == password.value) {
    confirm.setCustomValidity('');
  } else {
    confirm.setCustomValidity('Passwords do not match');
  }
}

function UpdateCheckNewPassword() {
  const password = document.getElementById("update_password3");

  const confirm = document.getElementById("update_password4");
  console.log(confirm.value == password.value)

  if (confirm.value == password.value) {
    confirm.setCustomValidity('');
  } else {
    confirm.setCustomValidity('Passwords do not match');
  }
}


