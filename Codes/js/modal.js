document.addEventListener("DOMContentLoaded", function () {
    const confirmActionButton = document.getElementById("confirmAction");

    confirmActionButton.addEventListener("click", function () {
      alert("Action confirmed!");

      const modal = bootstrap.Modal.getInstance(document.getElementById("actionModal"));
      modal.hide();
    });
});