const input = document.getElementById('address');
const autocomplete = document.getElementById('autocomplete');

// Pick searched address input after 3 char
input.addEventListener('input', function (e) {
    const query = e.target.value;
    if (query.length < 10) {
        autocomplete.innerHTML = '';
        return;
    }

    // Pick endpoint from backend
    const endpoint = `/proxy/${query}`;

    // AXIOS API Call
    axios.get(endpoint)
        .then(response => {
            const results = response.data.results;
            autocomplete.innerHTML = '';

            results.forEach(element => {
                const div = document.createElement('div');
                div.textContent = element.address.freeformAddress;
                autocomplete.classList.remove('d-none');

                div.addEventListener('click', function () {
                    input.value = element.address.freeformAddress;
                    autocomplete.innerHTML = '';
                    autocomplete.classList.add('d-none');
                    input.setAttribute("readonly", "readonly");
                });
                autocomplete.appendChild(div);
            });

        }).catch(err => {
            console.error(err)
        })
});