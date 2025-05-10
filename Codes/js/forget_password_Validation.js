document.addEventListener("DOMContentLoaded", function () {
  const emailInput = document.getElementById("email");
  const codeInput = document.getElementById("code");
  const passwordInput = document.getElementById("password");
  const confirmPasswordInput = document.getElementById("confirmPassword");
  const submitButton = document.getElementById("loginButton");

  // Input listeners
  emailInput.addEventListener("input", function () {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    emailInput.style.border = emailRegex.test(emailInput.value.trim())
      ? "2px solid green"
      : "2px solid rgb(255, 0, 98)";
  });

  codeInput.addEventListener("input", function () {
    const codeRegex = /^\d{6}$/;
    codeInput.style.border = codeRegex.test(codeInput.value.trim())
      ? "2px solid green"
      : "2px solid rgb(255, 0, 98)";
  });

  passwordInput.addEventListener("input", function () {
    passwordInput.style.border =
      passwordInput.value.trim().length >= 6
        ? "2px solid green"
        : "2px solid rgb(255, 0, 98)";
  });

  confirmPasswordInput.addEventListener("input", function () {
    confirmPasswordInput.style.border =
      confirmPasswordInput.value.trim() === passwordInput.value.trim()
        ? "2px solid green"
        : "2px solid rgb(255, 0, 98)";
  });

  // Click listener for form submission
  submitButton.addEventListener("click", function (event) {
    if (!validateForgetPasswordForm()) {
      event.preventDefault(); // Prevent form submission if validation fails
    }
  });

  function validateForgetPasswordForm() {
    let isValid = true;

    // Reset borders
    emailInput.style.border = "";
    codeInput.style.border = "";
    passwordInput.style.border = "";
    confirmPasswordInput.style.border = "";

    // Validate email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(emailInput.value.trim())) {
      alert("Please enter a valid email address.");
      emailInput.style.border = "2px solid rgb(255, 0, 98)";
      isValid = false;
    }

    // Validate code
    const codeRegex = /^\d{6}$/;
    if (!codeRegex.test(codeInput.value.trim())) {
      alert("Please enter a valid 6-digit code.");
      codeInput.style.border = "2px solid rgb(255, 0, 98)";
      isValid = false;
    }

    if (passwordInput.value.trim().length < 6) {
      alert("Password must be at least 6 characters long.");
      passwordInput.style.border = "2px solid rgb(255, 0, 98)";
      isValid = false;
    }

    if (confirmPasswordInput.value.trim() !== passwordInput.value.trim()) {
      alert("Passwords do not match.");
      confirmPasswordInput.style.border = "2px solid rgb(255, 0, 98)";
      isValid = false;
    }

    return isValid;
  }
});
