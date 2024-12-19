document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('#updateForm'); 
    const errorContainer = document.createElement('div');
    errorContainer.style.color = 'red';
    form.prepend(errorContainer);

    form.addEventListener('submit', function (event) {
        event.preventDefault();

        const name = document.getElementById('productName').value.trim();
        const description = document.getElementById('productDescription').value.trim();
        const price = document.getElementById('productPrice').value;
        const stock = document.getElementById('productStock').value.trim();
        const date = document.getElementById('productDate').value;
        let isValid = true;
        let errorMsg = '';
        if (productName.length < 3) {
            errorMsg += "Le nom du produit doit avoir au moins 3 caractères.<br>";
            isValid = false;
        }

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

        if (!isValid) {
            errorContainer.innerHTML = errorMsg;
        } else {
            errorContainer.innerHTML = ''; 
            form.submit(); 
        }
    });
});
