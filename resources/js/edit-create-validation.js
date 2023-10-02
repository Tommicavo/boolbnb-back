const inputsForm = document.getElementById('Form');

const title = document.getElementById('title');
const description = document.getElementById('description');
const rooms = document.getElementById('rooms');
const beds = document.getElementById('beds');
const bathrooms = document.getElementById('bathrooms');
const meters = document.getElementById('mq');
const price = document.getElementById('price');
const services = document.querySelectorAll('.form-check-input');


const error = document.getElementById('error')

inputsForm.addEventListener('submit', event => {
  event.preventDefault();


  const titleValue = title.value;

    if (titleValue.length > 50)
    {
      console.log('errore');
        error.innerText = 'Il titolo non deve superare i 50 caratteri';

    }





      if (!error.length) inputsForm.submit()
  });