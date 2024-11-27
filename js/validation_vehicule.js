document.getElementById('vehiculeForm').addEventListener('submit', function(event) {
    var prixJournalier = parseFloat(document.getElementById('prixJournalier').value.trim());
    var typeVehicule = document.getElementById('typeVehicule').value;
  
    var erreurs = [];
  
    // Vérification du prix journalier
    if (isNaN(prixJournalier) || prixJournalier < 100 || prixJournalier > 350) {
      erreurs.push('Le prix journalier doit être compris entre 100 et 350.');
    }
  
    // Vérification du type de véhicule
    var typesValides = ['voiture', 'camion', '2 roues'];
    if (!typesValides.includes(typeVehicule)) {
      erreurs.push('Veuillez sélectionner un type de véhicule valide.');
    }
  
    // Affichage des erreurs et annulation de l'envoi si nécessaire
    if (erreurs.length > 0) {
      event.preventDefault();
      alert(erreurs.join('\n'));
    }
  });
  