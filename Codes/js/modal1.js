document.addEventListener("DOMContentLoaded", function () {
    const actionModal = document.getElementById("actionModal");
    const certificateIdInput = document.getElementById("certificateIdInput");
    const actionInput = document.getElementById("actionInput");
    const actionTypeSpan = document.getElementById("actionType");

    actionModal.addEventListener("show.bs.modal", function (event) {
        const button = event.relatedTarget; 
        const certificateId = button.getAttribute("data-id");
        const action = button.getAttribute("data-action");


        certificateIdInput.value = certificateId;
        actionInput.value = action;

        actionTypeSpan.textContent = action === "accept" ? "accept" : "reject";
    });

    const form = actionModal.querySelector("form");
    form.addEventListener("submit", function (event) {
        event.preventDefault();

        const formData = new ààFormData(form);

        fetch("mange_attestation_scolariter.php", {
            method: "POST",
            body: formData,
        })
            .then(response => response.json())
            .then(data => {
                console.log("Response Data:", data); // Debugging
                if (data.success) {
                    const row = document.getElementById(`row-${data.demandId}`);
                    if (row) {
                        row.remove();
                    } else {
                    }
                    const modalInstance = bootstrap.Modal.getInstance(actionModal);
                    modalInstance.hide();
                } else {
                    console.error("Error:", data.error);
                }
            })
            .catch(error => {
                console.error("Error:", error);
            });
    });
});
