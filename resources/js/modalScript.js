const deleteForm = document.querySelectorAll('.deleteForm');
const modalMessage = document.getElementById('modalMessage');
const confirmDropBtn = document.getElementById('confirmDropBtn');

let activeForm = null;

deleteForm.forEach(form => {
    form.addEventListener('submit', event => {
        event.preventDefault();
        const title = form.dataset.name;

        let question;

        if (form.classList.contains('trashEstate'))
        {
            question = `Do you want to move '${title}' estate into Trash Can?`;
        } else if (form.classList.contains('dropEstate'))
        {
            question = `Do you really want to erase '${title}' estate?\nThis action will be irreversible!`;
        } else if (form.classList.contains('dropAllEstates'))
        {
            question = `Do you really want to erase all these estates?\nThis action will be irreversible!`;
        }

        modalMessage.innerText = question;
        activeForm = form;
    });
});

confirmDropBtn.addEventListener('click', () => {
    if (activeForm) activeForm.submit();
});

modalMessage.addEventListener('hidden-bs-modal', () => {
    activeForm = null;
});
