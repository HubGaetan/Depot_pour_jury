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
  const subscribeButtons = document.querySelectorAll(".subscribeButton");

  subscribeButtons.forEach(subscribeButton => {
    const subscribeIcon = subscribeButton.querySelector(".subscribeIcon");
    const hiddenCheckbox = subscribeButton.querySelector(".hiddenCheckbox");
    const hiddenState = subscribeButton.querySelector(".hiddenState");

    // Créez un nouvel élément span pour le texte d'abonnement
    const subscribeText = document.createElement("span");
    subscribeText.className = "subscribeText";

    // Initialise l'état de la case à cocher en fonction de l'état initial du bouton
    if (hiddenState.value === "on") {
      console.log("Initial state: on");
      subscribeIcon.className = "subscribeIcon bx bx-user-check";
      subscribeText.textContent = "Vous êtes inscrit";
      subscribeButton.classList.add("subscribed");
      hiddenCheckbox.checked = true;
    } else {
      console.log("Initial state: off");
      subscribeIcon.className = "subscribeIcon bx bx-user-x";
      subscribeText.textContent = "Vous êtes désinscrit";
      subscribeButton.classList.remove("subscribed");
      hiddenCheckbox.checked = false;
    }

    // Ajoutez l'élément subscribeText en tant qu'enfant de subscribeButton
    subscribeButton.appendChild(subscribeText);
    subscribeButton.addEventListener("click", function () {
      if (hiddenState.value === "on") {
        console.log("Button clicked, changing state to off");
        subscribeIcon.className = "subscribeIcon bx bx-user-x";
        subscribeText.textContent = "Vous êtes désinscrit";
        subscribeButton.classList.remove("subscribed");
        hiddenState.value = "off";
        hiddenCheckbox.checked = false;
      } else {
        console.log("Button clicked, changing state to on");
        subscribeIcon.className = "subscribeIcon bx bx-user-check";
        subscribeText.textContent = "Vous êtes inscrit";
        subscribeButton.classList.add("subscribed");
        hiddenState.value = "on";
        hiddenCheckbox.checked = true;
      }
      // Ajoutez cette ligne pour mettre à jour la valeur de l'input hidden
      hiddenCheckbox.value = hiddenCheckbox.checked ? 'on' : 'off';
      console.log("Hidden checkbox value:", hiddenCheckbox.value);
    });
  });
});



document.querySelectorAll('.students-toggle').forEach(button => {
  button.addEventListener('click', () => {
      const list = button.nextElementSibling;
      list.classList.toggle('show');
  });
});




document.getElementById('download').addEventListener('click', function(){
  window.print();
});















// document.addEventListener("DOMContentLoaded", function () {
//   const subscribeButtons = document.querySelectorAll(".subscribeButton");

//   subscribeButtons.forEach(subscribeButton => {
//     const subscribeIcon = subscribeButton.querySelector(".subscribeIcon");
//     const subscribeText = subscribeButton.querySelector(".subscribeText");
//     const hiddenCheckbox = subscribeButton.querySelector(".hiddenCheckbox");

//     // Initialise l'état de la case à cocher en fonction de l'état initial du bouton
//     if (hiddenCheckbox.value === "on") {
//       subscribeIcon.className = "subscribeIcon bx bx-user-x";
//       subscribeText.textContent = "Se désinscrire";
//       subscribeButton.classList.add("subscribed");
//     } else {
//       subscribeIcon.className = "subscribeIcon bx bx-user-check";
//       subscribeText.textContent = "S'inscrire";
//       subscribeButton.classList.remove("subscribed");
//     }

//     subscribeButton.addEventListener("click", function () {
//       if (hiddenCheckbox.value === "off") {
//         subscribeIcon.className = "subscribeIcon bx bx-user-x";
//         subscribeText.textContent = "Se désinscrire";
//         subscribeButton.classList.add("subscribed");
//         hiddenCheckbox.value = "on";
//       } else {
//         subscribeIcon.className = "subscribeIcon bx bx-user-check";
//         subscribeText.textContent = "S'inscrire";
//         subscribeButton.classList.remove("subscribed");
//         hiddenCheckbox.value = "off";
//       }
//     });
//   });
// });

