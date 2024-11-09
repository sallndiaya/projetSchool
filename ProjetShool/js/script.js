const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const snap = document.getElementById('snap');
const photoData = document.getElementById('photo_data');
const ctx = canvas.getContext('2d');

// Vérification de l'API getUserMedia
if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
    alert("L'API getUserMedia() n'est pas supportée par ce navigateur.");
} else {
    console.log("API getUserMedia() détectée.");
    startCamera();
}

// Fonction pour démarrer la caméra
async function startCamera() {
    try {
        const stream = await navigator.mediaDevices.getUserMedia({ video: true });
        video.srcObject = stream;
        video.play();
    } catch (error) {
        console.error("Erreur lors de l'accès à la caméra :", error);
        alert("Erreur : " + error.message);
    }
}

// Gestion du clic sur "Prendre Photo"
snap.addEventListener('click', () => {
    console.log("Bouton 'Prendre Photo' cliqué.");
    if (video.readyState === video.HAVE_ENOUGH_DATA) {
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        ctx.drawImage(video, 0, 0);

        // Convertir en Base64 et stocker dans le champ caché
        const dataURL = canvas.toDataURL('image/png');
        photoData.value = dataURL;

        alert("Photo prise avec succès !");
        console.log(dataURL);
    } else {
        alert("Caméra non prête. Réessayez.");
    }
});
