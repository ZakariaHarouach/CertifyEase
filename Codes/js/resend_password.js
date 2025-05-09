document.addEventListener("DOMContentLoaded", function () {
    const resendLink = document.getElementById("forgotPasswordLink");
    const form = document.querySelector("form");
    const actionInput = document.getElementById("action");

    resendLink.addEventListener("click", function (e) {
        e.preventDefault(); // Prevent the default action (link click)

        // Set the action input to 'resend'
        actionInput.value = "resend";

        // Submit the form
        form.submit();
    });
});
