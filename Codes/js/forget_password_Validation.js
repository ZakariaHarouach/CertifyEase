document.addEventListener("DOMContentLoaded", function () {
  const emailInput = document.getElementById("email");
  if (emailInput) {
    emailInput.addEventListener("input", function () {
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (emailInput.value.trim() === "") {
        emailInput.style.border = "2px solid rgb(255, 0, 98)";
      } else if (emailRegex.test(emailInput.value.trim())) {
        emailInput.style.border = "2px solid green";
      } else {
        emailInput.style.border = "2px solid rgb(255, 0, 98)";
      }
    });
  }

  const codeInput = document.getElementById("code");
  const passwordInput = document.getElementById("password");
  const confirmPasswordInput = document.getElementById("confirmPassword");

  if (codeInput) {
    codeInput.addEventListener("input", function () {
      const codeRegex = /^\d{6}$/;
      if (codeInput.value.trim().length > 6) {
        codeInput.value = codeInput.value.slice(0, 6);
      }
      if (codeInput.value.trim() === "") {
        codeInput.style.border = "2px solid rgb(255, 0, 98)";
      } else if (codeRegex.test(codeInput.value.trim())) {
        codeInput.style.border = "2px solid green";
      } else {
        codeInput.style.border = "2px solid rgb(255, 0, 98)";
      }
    });
  }

  if (passwordInput) {
    passwordInput.addEventListener("input", function () {
      if (passwordInput.value.trim() === "") {
        passwordInput.style.border = "2px solid rgb(255, 0, 98)";
      } else if (passwordInput.value.trim().length >= 6) {
        passwordInput.style.border = "2px solid green";
      } else {
        passwordInput.style.border = "2px solid rgb(255, 0, 98)";
      }
    });
  }

  if (confirmPasswordInput) {
    confirmPasswordInput.addEventListener("input", function () {
      if (confirmPasswordInput.value.trim() === "") {
        confirmPasswordInput.style.border = "2px solid rgb(255, 0, 98)";
      } else if (confirmPasswordInput.value.trim() === passwordInput.value.trim()) {
        confirmPasswordInput.style.border = "2px solid green";
      } else {
        confirmPasswordInput.style.border = "2px solid rgb(255, 0, 98)";
      }
    });
  }
});

function validateForgetPasswordForm() {
  const emailInput = document.getElementById("email");
  const codeInput = document.getElementById("code");
  const passwordInput = document.getElementById("password");
  const confirmPasswordInput = document.getElementById("confirmPassword");

  let isValid = true;

  if (emailInput) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (emailInput.value.trim() === "") {
      alert("Email cannot be empty.");
      emailInput.style.border = "2px solid rgb(255, 0, 98)";
      isValid = false;
    } else if (!emailRegex.test(emailInput.value.trim())) {
      alert("Please enter a valid email address.");
      emailInput.style.border = "2px solid rgb(255, 0, 98)";
      isValid = false;
    }
  }

  if (codeInput) {
    const codeRegex = /^\d{6}$/;
    if (codeInput.value.trim() === "") {
      alert("Code cannot be empty.");
      codeInput.style.border = "2px solid rgb(255, 0, 98)";
      isValid = false;
    } else if (!codeRegex.test(codeInput.value.trim())) {
      alert("Code must be exactly 6 digits.");
      codeInput.style.border = "2px solid rgb(255, 0, 98)";
      isValid = false;
    }
  }

  if (passwordInput) {
    if (passwordInput.value.trim() === "") {
      alert("Password cannot be empty.");
      passwordInput.style.border = "2px solid rgb(255, 0, 98)";
      isValid = false;
    } else if (passwordInput.value.trim().length < 6) {
      alert("Password must be at least 6 characters long.");
      passwordInput.style.border = "2px solid rgb(255, 0, 98)";
      isValid = false;
    }
  }

  if (confirmPasswordInput) {
    if (confirmPasswordInput.value.trim() === "") {
      alert("Confirm Password cannot be empty.");
      confirmPasswordInput.style.border = "2px solid rgb(255, 0, 98)";
      isValid = false;
    } else if (confirmPasswordInput.value.trim() !== passwordInput.value.trim()) {
      alert("Passwords do not match.");
      confirmPasswordInput.style.border = "2px solid rgb(255, 0, 98)";
      isValid = false;
    }
  }

  return isValid;
}