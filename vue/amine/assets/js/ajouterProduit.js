document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector("#ajoutForm");
    const errorContainer = document.createElement('div');
    errorContainer.style.color = 'red';
    form.prepend(errorContainer);

    form.addEventListener('submit', (event) => {
        const name = document.getElementById('productName').value.trim();
        const description = document.getElementById('productDescription').value.trim();
        const price = document.getElementById('productPrice').value;
        const stock = document.getElementById('productStock').value.trim();
        const date = document.getElementById('productDate').value;
        const category = document.getElementById('productCategory').value;
        const image = document.getElementById('productImage').files[0];
        console.log("fr");
        let isValid = true;
        let errorMsg = '';
        
        if (name.length < 3) {
            errorMsg += "le nom du produit doit avoir au moins 3 caractères.<br>";
            isValid = false;
        }
        if (description.length < 3) {
            errorMsg += "le description du produit doit avoir au moins 3 caractères.<br>";
            isValid = false;
        }
        if (isNaN(price) || price <= 0) {
            errorMsg += "veuillez entrer un prix valide et positif.<br>";
            isValid = false;
        }
        if (isNaN(stock) || stock <= 0) {
            errorMsg += "veuillez entrer un stock valide et positif.<br>";
            isValid = false;
        }
        if (!date) {
            errorMsg += "veuillez sélectionner une date valide.<br>";
            isValid = false;
        } else {
            const selectedDate = new Date(date);
            const currentDate = new Date();
            if (selectedDate < currentDate) {
                errorMsg += "la date ne peut pas être dans le passé.<br>";
                isValid = false;
            }
        }
        if (!category) {
            errorMsg += "veuillez sélectionner une catégorie.<br>";
            isValid = false;
        }
        if (!image) {
            errorMsg += "veuillez télécharger une image.<br>";
            isValid = false;
        } else {
            const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!allowedTypes.includes(image.type)) {
                errorMsg += "seules les images JPEG, PNG ou GIF sont autorisées.<br>";
                isValid = false;
            }
        }
        if (!isValid) {
            errorContainer.innerHTML = errorMsg;
            event.preventDefault();
        } else {
            errorContainer.innerHTML = ''; 
        }
    });
});
