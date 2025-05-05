function RedirectToNextPage(Page) {
  switch (Page) {
      case 1: // Professor
          window.location.href = 'inscription_prof2.html';
          break;
      case 2: // Admin
          window.location.href = 'inscription_admin2.html';
          break;
      default:
          alert("Invalid page selection.");
          break;
  }
}

function CommunValidation() {
  const Name = document.getElementById("FullName");
  const Phone = document.getElementById("Phone");
  const BirthDay = document.getElementById("birthday");

  let isValid = true;

  // Reset borders
  Name.style.border = "";
  Phone.style.border = "";
  BirthDay.style.border = "";

  // Validate Full Name
  if (Name.value.trim().length <= 8) {
      alert("Full Name must be longer than 8 characters.");
      Name.style.border = "2px solid rgb(255, 0, 98)";
      isValid = false;
  } else {
      Name.style.border = "2px solid green";
  }

  // Validate Phone
  const phoneRegex = /^[0-9]{10}$/;
  if (Phone.value.trim() === "") {
      alert("Phone number cannot be empty.");
      Phone.style.border = "2px solid rgb(255, 0, 98)";
      isValid = false;
  } else if (!phoneRegex.test(Phone.value.trim())) {
      alert("Please enter a valid 10-digit phone number.");
      Phone.style.border = "2px solid rgb(255, 0, 98)";
      isValid = false;
  } else {
      Phone.style.border = "2px solid green";
  }

  // Validate Birthday
  if (BirthDay.value.trim() === "") {
      alert("Birthday cannot be empty.");
      BirthDay.style.border = "2px solid rgb(255, 0, 98)";
      isValid = false;
  } else {
      BirthDay.style.border = "2px solid green";
  }

  return isValid;
}

function ValidateProfAdminAuthentication(Page) {
  if (CommunValidation()) {
      RedirectToNextPage(Page);
  }
}

document.addEventListener("DOMContentLoaded", function () {
  const Name = document.getElementById("FullName");
  const Phone = document.getElementById("Phone");
  const BirthDay = document.getElementById("birthday");

  // Full Name validation
  Name.addEventListener("input", function () {
      if (Name.value.trim().length <= 8 || Name.value.trim() === "") {
          Name.style.border = "2px solid rgb(255, 0, 98)";
      } else {
          Name.style.border = "2px solid green";
      }
  });

  // Phone validation
  Phone.addEventListener("input", function () {
      const phoneRegex = /^[0-9]{10}$/;
      if (Phone.value.trim() === "" || !phoneRegex.test(Phone.value.trim())) {
          Phone.style.border = "2px solid rgb(255, 0, 98)";
      } else {
          Phone.style.border = "2px solid green";
      }
  });

  // Birthday validation
  BirthDay.addEventListener("input", function () {
      if (BirthDay.value.trim() === "") {
          BirthDay.style.border = "2px solid rgb(255, 0, 98)";
      } else {
          BirthDay.style.border = "2px solid green";
      }
  });
});

document.addEventListener("DOMContentLoaded", function () {
  const email = document.getElementById("email");
  const password = document.getElementById("password");

  // Email validation on input
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

  // Password validation on input
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

function validateProfAdminSecondForm() {
  const email = document.getElementById("email");
  const password = document.getElementById("password");

  let isValid = true;

  email.style.border = "";
  password.style.border = "";

  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (email.value.trim() === "") {
      alert("Email cannot be empty.");
      email.style.border = "2px solid rgb(255, 0, 98)";
      isValid = false;
  } else if (!emailRegex.test(email.value.trim())) {
      alert("Please enter a valid email address.");
      email.style.border = "2px solid rgb(255, 0, 98)";
      isValid = false;
  } else {
      email.style.border = "2px solid green";
  }

  if (password.value.trim() === "") {
      alert("Password cannot be empty.");
      password.style.border = "2px solid rgb(255, 0, 98)";
      isValid = false;
  } else if (password.value.trim().length < 6) {
      alert("Password must be at least 6 characters long.");
      password.style.border = "2px solid rgb(255, 0, 98)";
      isValid = false;
  } else {
      password.style.border = "2px solid green";
  }

  return isValid;
}