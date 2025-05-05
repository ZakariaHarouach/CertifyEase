// Student_inscription_validation1.js

document.addEventListener("DOMContentLoaded", function () {
  const fullName = document.getElementById("fullName");
  const studentLevel = document.getElementById("Level");
  const group = document.getElementById("gourp");
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

    return isValid;
  }
});
