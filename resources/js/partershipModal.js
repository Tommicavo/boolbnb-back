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

        // Update the modal's content
        modalMessage.innerHTML = `
        <div class=" d-flex row-cols-3 justify-content-center">
        <div class="card col me-2">
            <img src="http://[::1]:5173/public/Silver.png" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Silver</h5>
                <p class="card-text">Metti in evidenza il tuo annuncio per 24 ore!</p>
                <a href="#" class="btn btn-primary">€2,99</a>
            </div>
        </div>
        <div class="card col me-2">
            <img src="http://[::1]:5173/public/Gold.png" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Gold</h5>
                <p class="card-text">Metti in evidenza il tuo annuncio per 72 ore!</p>
                <a href="#" class="btn btn-primary">€5,99</a>
            </div>
        </div>
        <div class="card col">
            <img src="http://[::1]:5173/public/Platinum.png" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Platinum</h5>
                <p class="card-text">Metti in evidenza il tuo annuncio per 144 ore!</p>
                <a href="#" class="btn btn-primary">€9,99</a>
            </div>
        </div>
    </div>
        `;
        modalTitle.innerText = `Promuovi il tuo annuncio!`;
        dropBtn.classList.add('d-none');
        btnClose.classList.add('d-none');
    });
});