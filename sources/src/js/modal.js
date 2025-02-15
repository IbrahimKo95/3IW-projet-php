document.addEventListener('DOMContentLoaded', function () {
    const uploadBtn = document.getElementById('uploadPhotoBtn');
    const modal = document.getElementById('photoUploadModal');
    const modalContent = document.getElementById('modalFormContent');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const cancelModalBtn = document.getElementById('cancelModalBtn');

    if (!uploadBtn) return;

    uploadBtn.addEventListener('click', function (e) {
        e.preventDefault();
        const groupId = this.getAttribute('data-group-id');

        fetch(`/group/${groupId}/addPhotoForm`)
            .then(response => response.text())
            .then(html => {
                modalContent.innerHTML = html;
                modal.classList.add('modal--visible');
            })
            .catch(err => console.error('Erreur lors du chargement du formulaire : ', err));
    });

    function closeModal() {
        modal.classList.remove('modal--visible');
    }

    closeModalBtn.addEventListener('click', closeModal);
    cancelModalBtn.addEventListener('click', closeModal);

    window.addEventListener('click', function (e) {
        if (e.target === modal) {
            closeModal();
        }
    });
});
