// Student_inscription_validation1.js

document.addEventListener("DOMContentLoaded", function () {
  const fullName = document.getElementById("fullName");
  const studentLevel = document.getElementById("Level");
  const group = document.getElementById("gourp");
  const cin = document.getElementById("cin"); // Add CIN input
  const nextButton = document.getElementById("nextButton");

  // Input listeners
  fullName.addEventListener("input", function () {
    fullName.style.border =
      fullName.value.trim() === "" ? "2px solid rgb(255, 0, 98)" : "2px solid green";
  });

  studentLevel.addEventListener("change", function () {
    if (studentLevel.value === "") {
      studentLevel.style.border = "2px solid rgb(255, 0, 98)";
    } else {
      studentLevel.style.border = "2px solid green";
      AddGroups(); // Call from student_group.js
    }
  });

  group.addEventListener("change", function () {
    group.style.border =
      group.value === "" ? "2px solid rgb(255, 0, 98)" : "2px solid green";
  });

  // CIN validation listener
  cin.addEventListener("input", function () {
    const cinRegex = /^[A-Za-z0-9]{6,10}$/; // Example: CIN must be alphanumeric and 6-10 characters long
    cin.style.border = cinRegex.test(cin.value.trim())
      ? "2px solid green"
      : "2px solid rgb(255, 0, 98)";
  });

  // Click listener
  nextButton.addEventListener("click", function () {
    if (validateFirstForm()) {
      window.location.href = "inscription_student2.html";
    }
  });

  function validateFirstForm() {
    let isValid = true;

    fullName.style.border = "";
    studentLevel.style.border = "";
    group.style.border = "";
    cin.style.border = "";

    if (fullName.value.trim() === "" || fullName.value.trim().length < 8) {
      alert("Full Name cannot be empty.");
      fullName.style.border = "2px solid rgb(255, 0, 98)";
      isValid = false;
    }

    if (studentLevel.value === "") {
      alert("Please select your student level.");
      studentLevel.style.border = "2px solid rgb(255, 0, 98)";
      isValid = false;
    }

    if (group.value === "") {
      alert("Please select your group.");
      group.style.border = "2px solid rgb(255, 0, 98)";
      isValid = false;
    }

    const cinRegex = /^[A-Za-z0-9]{6,10}$/; // Example: CIN must be alphanumeric and 6-10 characters long
    if (!cinRegex.test(cin.value.trim())) {
      alert("Please enter a valid CIN (6-10 alphanumeric characters).");
      cin.style.border = "2px solid rgb(255, 0, 98)";
      isValid = false;
    }

    return isValid;
  }
});