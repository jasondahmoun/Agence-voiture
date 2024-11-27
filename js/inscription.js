document.getElementById('inscriptionForm').addEventListener('submit', function(event) {
  // Récupération des valeurs des champs
  var login = document.getElementById('login').value.trim();
  var password = document.getElementById('password').value.trim();
  var email = document.getElementById('email').value.trim();

  var erreurs = [];

  // Vérification des champs obligatoires
  if (login === '') {
    erreurs.push('Le champ "Login" est obligatoire.');
  }
  if (password === '') {
    erreurs.push('Le champ "Mot de passe" est obligatoire.');
  }
  if (email === '') {
    erreurs.push('Le champ "Email" est obligatoire.');
  }

  // Vérification du login et du mot de passe
  var espaceRegex = /\s/;
  if (espaceRegex.test(login)) {
    erreurs.push('Le login ne doit pas contenir d\'espaces.');
  }
  if (espaceRegex.test(password)) {
    erreurs.push('Le mot de passe ne doit pas contenir d\'espaces.');
  }
  if (login.length < 4) {
    erreurs.push('Le login doit contenir au moins 4 caractères.');
  }
  if (password.length < 4) {
    erreurs.push('Le mot de passe doit contenir au moins 4 caractères.');
  }

  // Affichage des erreurs et annulation de l'envoi si nécessaire
  if (erreurs.length > 0) {
    event.preventDefault();
    alert(erreurs.join('\n'));
  }
});
