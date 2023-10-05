document.addEventListener('DOMContentLoaded', function () {
    // Get the modal and the modalMessage element
    const modal = document.getElementById('myModal');
    const modalMessage = modal.querySelector('#modalMessage');
    const dropBtn = modal.querySelector('#confirmDropBtn');
    const btnClose = modal.querySelector('.btn-close');
    const modalTitle = modal.querySelector('.modal-title');

    // Add event listener to show data when modal is about to be shown
    modal.addEventListener('show.bs.modal', function (event) {
        // Button (or div in this case) that triggered the modal
        const button = event.relatedTarget;

        // Extract the data from the div's data-* attributes
        const name = button.getAttribute('data-name');
        const email = button.getAttribute('data-email');
        const text = button.getAttribute('data-text');
        const title = button.getAttribute('data-title');
        const created_at = button.getAttribute('data-data');

        // Update the modal's content
        modalMessage.innerHTML = `
            <ul class="mb-0">
                <li><strong>Annuncio: </strong>${title}</li>
                <li><strong>Nome: </strong>${name}</li>
                <li><strong>Email: </strong>${email}</li>
                <li><strong>Data: </strong>${created_at}</li>
                <li><strong>Testo: </strong>${text}</li>
            </ul>
        `;
        modalTitle.innerText = `Messaggio da: ${name}`;
        dropBtn.classList.add('d-none');
        btnClose.classList.add('d-none');
    });
});