document.addEventListener('DOMContentLoaded', function() {
    const uploadForm = document.querySelector('form[enctype="multipart/form-data"]');
    if (uploadForm) {
        uploadForm.addEventListener('submit', function() {
            alert('Fichier en cours d\'upload...');
        });
    }
    console.log('Bienvenue sur la plateforme de partage de fichiers !');
});
