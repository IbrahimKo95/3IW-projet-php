document.addEventListener("DOMContentLoaded", function () {
    function openModal(modal) {
        if (modal) {
            modal.classList.add("modal--visible");
        }
    }

    function closeModal(modal) {
        if (modal) {
            modal.classList.remove("modal--visible");
        }
    }

    document.querySelectorAll("[data-modal-target]").forEach(button => {
        button.addEventListener("click", function (e) {
            e.preventDefault();
            const modalId = this.getAttribute("data-modal-target");
            const modal = document.getElementById(modalId);
            openModal(modal);
        });
    });

    document.querySelectorAll(".modal").forEach(modal => {
        modal.addEventListener("click", function (e) {
            if (e.target.classList.contains("modal") || e.target.classList.contains("modal__close-btn") || e.target.classList.contains("cancel-modal-btn")) {
                closeModal(modal);
            }
        });
    });

    window.addEventListener("keydown", function (e) {
        if (e.key === "Escape") {
            document.querySelectorAll(".modal.modal--visible").forEach(modal => {
                closeModal(modal);
            });
        }
    });
});
