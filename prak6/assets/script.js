function validateForm() {
  let name = document.getElementById("name").value;
  let username = document.getElementById("username").value;
  let email = document.getElementById("email").value;
  let password = document.getElementById("password").value;
  let confirmPassword = document.getElementById("confirmPassword").value;
  let phone = document.getElementById("phone").value;
  let gender = document.getElementById("gender").value;
  let website = document.getElementById("website").value;
  let termsCheckbox = document.getElementById("termsCheckbox").checked;

  let nameError = document.getElementById("nameError");
  let usernameError = document.getElementById("usernameError");
  let emailError = document.getElementById("emailError");
  let passwordError = document.getElementById("passwordError");
  let confirmPasswordError = document.getElementById("confirmPasswordError");
  let phoneError = document.getElementById("phoneError");
  let genderError = document.getElementById("genderError");
  let websiteError = document.getElementById("websiteError");
  let termsCheckboxError = document.getElementById("termsCheckboxError");

  let isValid = true;

  if (name == "") {
    nameError.textContent = " Nama harus diisi";
    isValid = false;
  } else {
    nameError.textContent = "";
  }

  if (username == "") {
    usernameError.textContent = " Username harus diisi";
    isValid = false;
  } else {
    usernameError.textContent = "";
  }

  if (email == "") {
    emailError.textContent = " Email harus diisi";
    isValid = false;
  } else if (!validateEmail(email)) {
    emailError.textContent = " Format email tidak valid";
    isValid = false;
  } else {
    emailError.textContent = "";
  }

  if (password == "") {
    passwordError.textContent = " Password harus diisi";
    isValid = false;
  } else {
    passwordError.textContent = "";
  }

  if (confirmPassword == "") {
    confirmPasswordError.textContent = " Konfirmasi password harus diisi";
    isValid = false;
  } else if (password !== confirmPassword) {
    confirmPasswordError.textContent = " Password tidak cocok";
    isValid = false;
  } else {
    confirmPasswordError.textContent = "";
  }

  if (phone == "") {
    phoneError.textContent = " Nomor telepon harus diisi";
    isValid = false;
  } else if (!validatePhone(phone)) {
    phoneError.textContent = " Nomor telepon harus berupa angka";
    isValid = false;
  } else {
    phoneError.textContent = "";
  }

  if (!gender) {
    genderError.textContent = " Jenis kelamin harus dipilih";
    isValid = false;
  } else {
    genderError.textContent = "";
  }

  if (website == "") {
    websiteError.textContent = " Alamat website harus diisi";
    isValid = false;
  } else if (!validateWebsite(website)) {
    websiteError.textContent = " Format alamat website tidak valid";
    isValid = false;
  } else {
    websiteError.textContent = "";
  }

  if (!termsCheckbox) {
    termsCheckboxError.textContent =
      " Anda harus menyetujui syarat dan ketentuan";
    isValid = false;
  } else {
    termsCheckboxError.textContent = "";
  }

  if (isValid) {
    alert("Registrasi berhasil!");
  }

  return isValid;
}

function validateEmail(email) {
  const re = /\S+@\S+\.\S+/;
  return re.test(email);
}

const togglePassword = document.querySelectorAll("#togglePassword");
togglePassword.forEach(function (toggle) {
  toggle.addEventListener("click", function (e) {
    const targetInputId = this.getAttribute("data-target");
    const targetInput = document.getElementById(targetInputId);

    // Toggle the type attribute
    const type =
      targetInput.getAttribute("type") === "password" ? "text" : "password";
    targetInput.setAttribute("type", type);

    // Toggle the eye icon
    this.classList.toggle("fa-eye-slash");
  });
});

function validatePhone(phone) {
  const re = /^\d+$/;
  return re.test(phone);
}

function validateWebsite(website) {
  const re =
    /^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?[a-zA-Z0-9]+([-.][a-zA-Z0-9]+)*\.[a-zA-Z]{2,}(:[0-9]{1,5})?(\/.*)?$/;
  return re.test(website);
}
