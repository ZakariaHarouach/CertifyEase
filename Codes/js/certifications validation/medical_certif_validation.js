document.addEventListener("DOMContentLoaded", function () {
    const fileInput = document.getElementById("certificate");
    const fileNameSpan = document.getElementById("fileName");
    const startDateInput = document.querySelectorAll("input[type='date']")[0];
    const endDateInput = document.querySelectorAll("input[type='date']")[1];

    fileInput.addEventListener("change", function () {
        if (fileInput.files.length > 0) {
            fileNameSpan.textContent = fileInput.files[0].name;
        } else {
            fileNameSpan.textContent = "Add your certificate here";
        }
    });

    window.validateCertificateForm = function () {
        let isValid = true;

        fileInput.style.border = "";
        startDateInput.style.border = "";
        endDateInput.style.border = "";

        // File validation
        if (fileInput.files.length === 0) {
            alert("Please upload your medical certificate.");
            fileInput.style.border = "2px solid rgb(255, 0, 98)";
            isValid = false;
        } else {
            const allowedExtensions = ["pdf", "jpg", "jpeg", "png"];
            const fileName = fileInput.files[0].name;
            const fileExtension = fileName.split(".").pop().toLowerCase();
            const fileSize = fileInput.files[0].size / 1024 / 1024; // Size in MB

            if (!allowedExtensions.includes(fileExtension)) {
                alert("The file must be a PDF or an image (jpg, jpeg, png).");
                fileInput.style.border = "2px solid rgb(255, 0, 98)";
                isValid = false;
            } else if (fileSize > 2) {
                alert("The file size must not exceed 2 MB.");
                fileInput.style.border = "2px solid rgb(255, 0, 98)";
                isValid = false;
            }
        }

        // Start date validation
        if (startDateInput.value.trim() === "") {
            alert("Please select the start date of your medical certificate.");
            startDateInput.style.border = "2px solid rgb(255, 0, 98)";
            isValid = false;
        } else {
            const startDate = new Date(startDateInput.value);
            const currentDate = new Date();
            const twoDaysBefore = new Date();
            twoDaysBefore.setDate(currentDate.getDate() - 2);

            if (startDate > currentDate) {
                alert("The start date cannot be later than the current date.");
                startDateInput.style.border = "2px solid rgb(255, 0, 98)";
                isValid = false;
            } else if (startDate < twoDaysBefore) {
                alert("The start date cannot be earlier than 2 days before the current date.");
                startDateInput.style.border = "2px solid rgb(255, 0, 98)";
                isValid = false;
            }
        }

        // End date validation
        if (endDateInput.value.trim() === "") {
            alert("Please select the end date of your medical certificate.");
            endDateInput.style.border = "2px solid rgb(255, 0, 98)";
            isValid = false;
        }

        // Date difference validation
        if (startDateInput.value && endDateInput.value) {
            const startDate = new Date(startDateInput.value);
            const endDate = new Date(endDateInput.value);

            if (startDate > endDate) {
                alert("The start date cannot be later than the end date.");
                startDateInput.style.border = "2px solid rgb(255, 0, 98)";
                endDateInput.style.border = "2px solid rgb(255, 0, 98)";
                isValid = false;
            } else {
                const dateDifference = (endDate - startDate) / (1000 * 60 * 60 * 24); // Difference in days
                if (dateDifference > 7) {
                    alert("The difference between the start and end dates cannot exceed 7 days.");
                    startDateInput.style.border = "2px solid rgb(255, 0, 98)";
                    endDateInput.style.border = "2px solid rgb(255, 0, 98)";
                    isValid = false;
                }
            }
        }

        return isValid;
    };
});