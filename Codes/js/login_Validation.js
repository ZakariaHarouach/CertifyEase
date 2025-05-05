document.addEventListener("DOMContentLoaded", function () {
  const email = document.getElementById("email");
  const password = document.getElementById("password");

  email.addEventListener("input", function () {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (email.value.trim() === "") {
      email.style.border = "2px solid rgb(255, 0, 98)";
    } else if (emailRegex.test(email.value.trim())) {
      email.style.border = "2px solid green";
    } else {
      email.style.border = "2px solid rgb(255, 0, 98)";
    }
  });

  password.addEventListener("input", function () {
    if (password.value.trim() === "") {
      password.style.border = "2px solid rgb(255, 0, 98)";
    } else if (password.value.trim().length >= 6) {
      password.style.border = "2px solid green";
    } else {
      password.style.border = "2px solid rgb(255, 0, 98)";
    }
  });
});

function validateLoginForm() {
  const email = document.getElementById("email");
  const password = document.getElementById("password");

  let isValid = true;

  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (email.value.trim() === "") {
    alert("Email cannot be empty.");
    email.style.border = "2px solid rgb(255, 0, 98)";
    isValid = false;
  } else if (!emailRegex.test(email.value.trim())) {
    alert("Please enter a valid email address.");
    email.style.border = "2px solid rgb(255, 0, 98)";
    isValid = false;
  }

  if (password.value.trim() === "") {
    alert("Password cannot be empty.");
    password.style.border = "2px solid rgb(255, 0, 98)";
    isValid = false;
  } else if (password.value.trim().length < 6) {
    alert("Password must be at least 6 characters long.");
    password.style.border = "2px solid rgb(255, 0, 98)";
    isValid = false;
  }

  return isValid;
}