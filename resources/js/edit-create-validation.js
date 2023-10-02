
const inputsForm = document.getElementById('Form');


const titleField = document.getElementById('title');
const titleUl = document.getElementById('titleUl');

const descriptionField = document.getElementById('description');
const descriptionUl = document.getElementById('descriptionUl');

const roomsField = document.getElementById('rooms');
const roomsUl = document.getElementById('roomsUl');
// const beds = document.getElementById('beds');
// const bathrooms = document.getElementById('bathrooms');
// const meters = document.getElementById('mq');
// const price = document.getElementById('price');
const services = document.querySelectorAll('.service');
const servicesUl = document.getElementById('servicesUl');


function validateNumberField(field, min, max, errorMessage, errorsBag) {
  const fieldValue = field.value;
  const numberValue = Number(fieldValue);

  if (isNaN(numberValue) || numberValue < min || numberValue > max) {
    const errors = [errorMessage];
    errorsBag.push(errors);
    return errors;
  }

  return [];
}


const roomsErrors = validateNumberField(roomsField, 1, 254, 'Il numero delle stanze deve essere compreso tra 1 e 254.', errorsBag);




inputsForm.addEventListener('submit', event => {
  event.preventDefault();
  const errorsBag = [];

  const titleErrors = [];
  const descriptionErrors = [];
  const roomsErrors = [];
  const servicesChecked = [];
  titleUl.innerHTML = "";
  descriptionUl.innerHTML = "";
  roomsUl.innerHTML = "";
  servicesUl.innerHTML = "";


  // Title Validation
  const title = titleField.value;

  if (!title) {
    const titleLengthError = 'Il titole è obbligatorio.'
    titleErrors.push(titleLengthError);
    errorsBag.push(titleErrors);
  }
  if (title.length > 50) {
    const titleLengthError = 'Il titole deve essere lungo max 50 carattari.';
    titleErrors.push(titleLengthError);
    errorsBag.push(titleErrors);
  }

  titleErrors.forEach(error => {
    const listItem = document.createElement("li");
    listItem.innerText = error;
    titleUl.appendChild(listItem);
  })

  // Description Validation
  const description = descriptionField.value;

  if (description.length > 50) {
    const descriptionLengthError = 'La descrizione deve essere lunga max 300 carattari.';
    descriptionErrors.push(descriptionLengthError);
    errorsBag.push(descriptionErrors);
    const listItem = document.createElement("li");
    listItem.innerText = descriptionErrors;
    descriptionUl.appendChild(listItem);
  }


  // Rooms Validation
  const rooms = roomsField.value;
  if (!rooms) {
    const roomsLengthError = 'Il numero delle stanze è obbligatorio.'
    roomsErrors.push(roomsLengthError);
    errorsBag.push(roomsErrors);
  }
  if (Number(rooms) < 1 || Number(rooms) > 254) {
    const roomsLengthError = 'Il numero delle stanze deve essere compreso tra 1 e 254.';
    roomsErrors.push(roomsLengthError);
    errorsBag.push(roomsErrors);
  }
  roomsErrors.forEach(error => {
    const listItem = document.createElement("li");
    listItem.innerText = error;
    roomsUl.appendChild(listItem);
  })

  // Services Validation
  services.forEach(service => {
    if (service.checked) {
      servicesChecked.push('YES');
    }
  });

  if (servicesChecked.length === 0) {
    const servicesLengthError = 'L\'annuncio deve contenere almeno un servizio';
    errorsBag.push([servicesLengthError]);
    const listItem = document.createElement("li");
    listItem.innerText = servicesLengthError;
    servicesUl.appendChild(listItem);
  }

  if (!errorsBag.length) inputsForm.submit();
});