document.getElementById('reservationForm').addEventListener('submit', function(event) {
    var dateDebut = new Date(document.getElementById('dateDebut').value);
    var dateFin = new Date(document.getElementById('dateFin').value);
  
    if (dateFin <= dateDebut) {
      event.preventDefault();
      alert('La date de fin doit être supérieure à la date de début.');
    }
  });
  