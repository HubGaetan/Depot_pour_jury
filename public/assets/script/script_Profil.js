let menu = document.querySelector('#menu-icon');
let navlist = document.querySelector('.navlist');

menu.onclick = () => {
	menu.classList.toggle('bx-x');
	navlist.classList.toggle('open');
};

window.onscroll = () => {
	menu.classList.remove('bx-x');
	navlist.classList.remove('open');
};


document.addEventListener("DOMContentLoaded", function () {
  const collapseButtons = document.querySelectorAll(".collapse-btn");
  
  collapseButtons.forEach((btn) => {
    btn.addEventListener("click", function () {
      const target = document.querySelector("." + btn.dataset.target);
  
      // Basculer la classe "hidden"
      target.classList.toggle("hidden");
  
      // Basculer l'affichage du contenu
      if (target.style.display === "none") {
        target.style.display = "block";
      } else {
        target.style.display = "none";
      }
    });
  });
  
  // Cachez initialement les éléments cibles
  const targets = document.querySelectorAll(".formation-options, .regime-options, .vegan-options, .porc-options, .allergies-options");
  targets.forEach((element) => {
    element.style.display = "none";
  });
  
  // Bouton pour modifier
  const modifyBtn = document.querySelector("#modifyBtn");
  modifyBtn.addEventListener("click", function() {
    targets.forEach((element) => {
      element.style.display = "none";
    });
  });
});


document.addEventListener('DOMContentLoaded', function () {
  // Récupérer le bouton "Modifier", le bouton "Valider" et le conteneur des options
  const modifyBtn = document.getElementById('modifyBtn');
  const validateBtn = document.querySelector('.button-valider');
  const collapseBtns = document.querySelectorAll('.collapse-btn');

  // Fonction pour basculer la classe "visible" sur les conteneurs des options et le bouton "Valider"
  function toggleVisible() {
    collapseBtns.forEach(function (collapseBtn) {
      collapseBtn.classList.toggle('visible');
    });
    validateBtn.classList.toggle('visible');
  }

  // Ajouter un écouteur d'événement au bouton "Modifier"
  modifyBtn.addEventListener('click', toggleVisible);

  // Ajouter un écouteur d'événement au bouton "Valider"
  validateBtn.addEventListener('click', toggleVisible);
});






document.addEventListener("DOMContentLoaded", function () {
  const radioButtons = document.querySelectorAll("input[type='radio']");

  radioButtons.forEach(radioButton => {
    radioButton.addEventListener("change", function () {
      if (radioButton.checked) {
        console.log("Option sélectionnée:", radioButton.id);
      }
    });
  });
});



// document.addEventListener("DOMContentLoaded", function () {
//   console.log("Le DOM est chargé");
//   const checkboxes = document.querySelectorAll("input[type='checkbox']");

//   checkboxes.forEach(checkbox => {
//     console.log("Traitement d'une case à cocher :", checkbox);
//     const hiddenCheckbox = checkbox.parentElement.querySelector(".hiddenCheckbox");

//     // Initialise l'état de la case à cocher en fonction de l'état initial de l'élément caché
//     if (hiddenCheckbox.value === "on") {
//       console.log("La valeur de la case à cocher cachée est 'on'");
//       checkbox.checked = true;
//     } else {
//       console.log("La valeur de la case à cocher cachée est 'off'");
//       checkbox.checked = false;
//     }

//     // Met à jour la valeur de l'élément caché lorsque l'état de la case à cocher change
//     checkbox.addEventListener("change", function () {
//       console.log("La case à cocher a été modifiée");
//       hiddenCheckbox.value = checkbox.checked ? 'on' : 'off';
//       console.log("La valeur de la case à cocher cachée a été mise à jour :", hiddenCheckbox.value);
//     });
//   });
// });




  