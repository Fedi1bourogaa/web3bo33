document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('#updateForm');
    const errorContainer = document.createElement('div');
    errorContainer.style.color = 'red';
    form.prepend(errorContainer);

    form.addEventListener('submit', function (event) {
        const categoryName = document.getElementById('categoryName').value.trim();
        const categoryDescription = document.getElementById('categoryDescription').value.trim();

        let isValid = true;
        let errorMsg = '';

        if (categoryName.length < 3) {
            errorMsg += "le nom de la catégorie doit contenir au moins 3 caractères.<br>";
            isValid = false;
        }
        if (categoryDescription.length < 3) {
            errorMsg += "le description de la catégorie doit contenir au moins 3 caractères.<br>";
            isValid = false;
        }

        if (!isValid) {
            errorContainer.innerHTML = errorMsg;
            event.preventDefault();
        } else {
            errorContainer.innerHTML = '';
        }
    });
});
