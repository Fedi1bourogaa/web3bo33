// Données simulées pour tester sans backend
let users = [
    { id: 1, nom: "Mohamed Ali", email: "mohamed@example.com", role: "Admin" },
    { id: 2, nom: "Sofia Ben", email: "sofia@example.com", role: "Utilisateur" },
    { id: 3, nom: "Khaled Nasri", email: "khaled@example.com", role: "Contributeur" }
];

// Fonction pour récupérer et afficher les utilisateurs
function getUsers() {
    const tableBody = document.querySelector('#userTableBody');
    tableBody.innerHTML = '';  // Vide la table avant de la remplir

    users.forEach(user => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${user.id}</td>
            <td>${user.nom}</td>
            <td>${user.email}</td>
            <td>${user.role}</td>
            <td>
                <a href="admin_edit_user.html?id=${user.id}">Modifier</a> |
                <a href="#" onclick="deleteUser(${user.id})">Supprimer</a>
            </td>
        `;
        tableBody.appendChild(row);
    });
}

// Fonction pour créer un utilisateur
function createUser(nom, prenom, email, role, motDePasse) {
    const id = users.length + 1;  // Création d'un ID unique
    const newUser = { id, nom, prenom, email, role };
    users.push(newUser);  // Ajoute le nouvel utilisateur à la liste simulée

    alert('Utilisateur créé avec succès');
    window.location.href = 'admin_manage_users.html'; // Redirige après la création
}

// Fonction pour charger les données d'un utilisateur à modifier
function loadUserData(id) {
    const user = users.find(user => user.id == id);
    
    if (user) {
        document.getElementById('userId').value = user.id;
        document.getElementById('nom').value = user.nom;
        document.getElementById('prenom').value = user.prenom || '';
        document.getElementById('email').value = user.email;
        document.getElementById('role').value = user.role;
    } else {
        alert('Utilisateur non trouvé');
    }
}

// Fonction pour mettre à jour un utilisateur
function updateUser(id, nom, prenom, email, role, motDePasse) {
    const user = users.find(user => user.id == id);
    
    if (user) {
        user.nom = nom;
        user.prenom = prenom;
        user.email = email;
        user.role = role;

        alert('Utilisateur mis à jour avec succès');
        window.location.href = 'admin_manage_users.html'; // Redirige après la mise à jour
    } else {
        alert('Utilisateur non trouvé');
    }
}

// Fonction pour supprimer un utilisateur
function deleteUser(id) {
    const confirmation = confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');
    if (!confirmation) return;

    users = users.filter(user => user.id != id);  // Supprime l'utilisateur de la liste simulée

    alert('Utilisateur supprimé avec succès');
    getUsers(); // Rafraîchit la liste des utilisateurs
}

// Gestion de l'événement pour le formulaire de création
document.getElementById('createUserForm')?.addEventListener('submit', function(event) {
    event.preventDefault();

    const nom = document.getElementById('nom').value;
    const prenom = document.getElementById('prenom').value;
    const email = document.getElementById('email').value;
    const role = document.getElementById('role').value;
    const motDePasse = document.getElementById('motDePasse').value;

    createUser(nom, prenom, email, role, motDePasse);
});

// Gestion de l'événement pour le formulaire de modification
document.getElementById('editUserForm')?.addEventListener('submit', function(event) {
    event.preventDefault();

    const id = document.getElementById('userId').value;
    const nom = document.getElementById('nom').value;
    const prenom = document.getElementById('prenom').value;
    const email = document.getElementById('email').value;
    const role = document.getElementById('role').value;
    const motDePasse = document.getElementById('motDePasse').value;

    updateUser(id, nom, prenom, email, role, motDePasse);
});

// Appeler la fonction pour charger les utilisateurs quand la page admin_manage_users.html est chargée
if (document.getElementById('userTableBody')) {
    getUsers();
}

// Charger les données de l'utilisateur si on est sur la page de modification
const userId = new URLSearchParams(window.location.search).get('id');
if (userId && document.getElementById('userId')) {
    loadUserData(userId);
}
