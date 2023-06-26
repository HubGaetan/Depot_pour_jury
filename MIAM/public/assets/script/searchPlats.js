

async function getPlats() {
  try {
    const response = await fetch('/plats.json');
    const json = await response.json();
    const plats = json.find(item => item.type === 'table' && item.name === 'plats').data;
    return plats;
  } catch (error) {
    console.error(error);
    return [];
  }
}
document.addEventListener('DOMContentLoaded', () => {

  function filterPlats(plats, searchTerm) {
    return plats.filter(plat => {
      if (plat.nom) {
        return plat.nom.toLowerCase().startsWith(searchTerm.toLowerCase());
      }
      return false;
    });
  }



  function addSelectedSuggestion(suggestion, container, inputId) {
    const selectedElement = document.createElement('span');
    selectedElement.className = 'selected-suggestion';
    selectedElement.textContent = suggestion.nom || 'Nom inconnu';
    selectedElement.setAttribute('data-id', suggestion.id || 'null');

    plats[inputId].push(suggestion);

    const removeButton = document.createElement('span');
    removeButton.className = 'remove-suggestion';
    removeButton.style.backgroundColor = 'transparent';
    removeButton.style.border = 'none';
    removeButton.style.cursor = 'pointer';

    const removeIcon = document.createElement('i');
    removeIcon.className = 'bx bx-x';
    removeButton.appendChild(removeIcon);

    const hiddenInput = document.createElement('input');
    hiddenInput.type = 'hidden';
    hiddenInput.name = inputId + '[]';
    //hiddenInput.value = JSON.stringify({ id: suggestion.id, nom: suggestion.nom });
    // if (suggestion.id) {
    // Vérifiez si l'identifiant de la suggestion sélectionnée existe
    hiddenInput.value = 'ID:' + suggestion.id + ':' + suggestion.nom;
    // Ajouter l'identifiant de la suggestion sélectionnée à la valeur de l'élément de formulaire caché 
    // (le format de la valeur doit être "ID:identifiant:nom" pour pouvoir la récupérer correctement au serveur)
    // } else {
    //   hiddenInputElement.value = (suggestion.nom || 'Nom inconnu');
    //   // Ajouter le nom de la suggestion sélectionnée à la valeur de l'élément de formulaire caché ou "Nom inconnu" si le nom n'existe pas
    // }

    const formElement = document.querySelector('form');
    formElement.appendChild(hiddenInput);

    removeButton.addEventListener('click', () => {

      selectedElement.remove();

      const index = plats[inputId].findIndex(plat => plat.id === suggestion.id && plat.nom === suggestion.nom);

      if (index !== -1) {
        plats[inputId].splice(index, 1);
      }
      hiddenInput.remove();
    });

    selectedElement.appendChild(removeButton);
    container.appendChild(selectedElement);
  }

  const inputFields = document.querySelectorAll("input[type='text']");
  const plats = {};

  inputFields.forEach((input) => {
    const id = input.getAttribute("id");
    plats[id] = [];



  });

  console.log(plats);

  function displaySuggestions(suggestions, datalistElement, inputElement, selectedContainer) {
    datalistElement.innerHTML = '';

    suggestions.forEach(suggestion => {
      const option = document.createElement('option');
      option.value = suggestion.nom;
      option.setAttribute('data-id', suggestion.id);
      datalistElement.appendChild(option);
    });

    inputElement.addEventListener('change', () => {
      const selectedOption = Array.from(datalistElement.options).find(option => option.value === inputElement.value);
      if (selectedOption) {
        addSelectedSuggestion({ nom: selectedOption.value, id: selectedOption.getAttribute('data-id') }, selectedContainer, inputElement.id);
        inputElement.value = '';
      }
    });
  }

  function setupAutocomplete(inputElement) {
    const datalistElement = document.getElementById(inputElement.id + '_datalist');

    // Créez un élément 'div' pour contenir les suggestions sélectionnées.
    const selectedContainer = document.createElement('div');
    selectedContainer.className = 'selected-suggestions';
    selectedContainer.id = inputElement.id + '_selected';

    // Insérez le conteneur des suggestions sélectionnées après l'élément input.
    inputElement.parentNode.insertBefore(selectedContainer, inputElement.nextSibling);
    function handleSelection() {
      if (!inputElement.value.trim()) {
        return;
      }

      const selectedOption = Array.from(datalistElement.options).find(option => option.value === inputElement.value);
      if (selectedOption) {
        addSelectedSuggestion({ nom: selectedOption.value, id: selectedOption.getAttribute('data-id') }, selectedContainer, inputElement.id);
      } else {
        addSelectedSuggestion({ nom: inputElement.value, id: null }, selectedContainer, inputElement.id);
      }
      inputElement.value = '';
    }


    inputElement.addEventListener('keydown', event => {
      if (event.key === 'Enter') {
        event.preventDefault();
        handleSelection();
      }
    });

    inputElement.addEventListener('change', () => {
      handleSelection();
    });

    inputElement.addEventListener('input', async event => {
      const searchTerm = event.target.value;
      console.log('Search term:', searchTerm);
      if (searchTerm.length < 1) {
        return;
      }

      const platsList = await getPlats();
      console.log('Plats:', platsList);
      const suggestions = filterPlats(platsList, searchTerm);
      console.log('Suggestions:', suggestions);
      displaySuggestions(suggestions, datalistElement, inputElement, selectedContainer);
    });


  }



  // function loadInitialPlats() {
  //   document.querySelectorAll('.selected-suggestions').forEach(container => {
  //     const inputId = container.getAttribute('id').replace('_selected', '');
  //     const inputElement = document.getElementById(inputId);

  //     container.querySelectorAll('.selected-suggestion').forEach(selectedElement => {
  //       const platId = selectedElement.getAttribute('data-id');
  //       const platNom = selectedElement.textContent.trim();

  //       // Ajoutez la suggestion sélectionnée en utilisant la fonction `addSelectedSuggestion` pour gérer les événements de suppression.
  //       addSelectedSuggestion({ id: platId, nom: platNom }, container, inputId);

  //       // Supprimez les éléments sélectionnés initiaux, car ils seront recréés par la fonction `addSelectedSuggestion`.
  //       selectedElement.remove();
  //     });

  //     // Ne mettez pas à jour la valeur du champ d'entrée. Laissez-le vide.
  //     inputElement.value = '';

  //   });

  // }
  // loadInitialPlats();




  document.querySelectorAll('input[type="text"]').forEach(inputElement => {
    setupAutocomplete(inputElement);
  });



});



// Gestion des boutons "remove" existants
document.querySelectorAll('.remove-suggestion').forEach(removeButton => {
  removeButton.addEventListener('click', () => {
    const selectedSuggestion = removeButton.parentElement;
    selectedSuggestion.previousElementSibling.remove();
    selectedSuggestion.remove();
  });
});
