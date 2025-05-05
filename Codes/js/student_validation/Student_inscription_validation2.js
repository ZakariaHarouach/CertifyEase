document.addEventListener("DOMContentLoaded", function () {
  const birthday = document.getElementById("birthday");
  const phone = document.getElementById("phone");
  const email = document.getElementById("email");
  const password = document.getElementById("password");
  const submitButton = document.getElementById("submitButton");

  // Live Validation for each input

  birthday.addEventListener("input", function () {
    if (birthday.value.trim() !== "") {
      birthday.style.border = "2px solid green";
    } else {
      birthday.style.border = "2px solid rgb(255, 0, 98)";
    }
  });

  phone.addEventListener("input", function () {
    const phoneRegex = /^(?:\+212|0)([5-7])[0-9]{8}$/;
    if (phoneRegex.test(phone.value.trim())) {
      phone.style.border = "2px solid green";
    } else {
      phone.style.border = "2px solid rgb(255, 0, 98)";
    }
  });

  email.addEventListener("input", function () {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (emailRegex.test(email.value.trim())) {
      email.style.border = "2px solid green";
    } else {
      email.style.border = "2px solid rgb(255, 0, 98)";
    }
  });

  password.addEventListener("input", function () {
    if (password.value.trim().length >= 6) {
      password.style.border = "2px solid green";
    } else {
      password.style.border = "2px solid rgb(255, 0, 98)";
    }
  });

  // On form submission
  submitButton.addEventListener("click", function (e) {
    if (!validateSecondForm()) {
      e.preventDefault(); // Stop submission if invalid
    }
  });

  function validateSecondForm() {
    let isValid = true;

    if (birthday.value.trim() === "") {
      birthday.style.border = "2px solid rgb(255, 0, 98)";
      alert("Please enter your birthday.");
      isValid = false;
    }

    const phoneRegex = /^(?:\+212|0)([5-7])[0-9]{8}$/;
    if (!phoneRegex.test(phone.value.trim())) {
      phone.style.border = "2px solid rgb(255, 0, 98)";
      alert("Please enter a valid Moroccan phone number.");
      isValid = false;
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email.value.trim())) {
      email.style.border = "2px solid rgb(255, 0, 98)";
      alert("Please enter a valid email address.");
      isValid = false;
    }

    if (password.value.trim().length < 6) {
      password.style.border = "2px solid rgb(255, 0, 98)";
      alert("Password must be at least 6 characters long.");
      isValid = false;
    }

    return isValid;
  }
});
