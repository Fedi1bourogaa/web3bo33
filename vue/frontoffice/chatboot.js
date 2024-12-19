// Fonction pour afficher/masquer le chatbot
function toggleChatbot() {
    const chatbotBox = document.getElementById('chatbot-box');
    if (chatbotBox.style.display === "none" || chatbotBox.style.display === "") {
        chatbotBox.style.display = "flex";
    } else {
        chatbotBox.style.display = "none";
    }
}

// Événement de clic sur l'icône
document.getElementById('chatbot-icon').addEventListener('click', toggleChatbot);

// Événement de clic sur le bouton "Envoyer"
document.getElementById('chatbot-send').addEventListener('click', function() {
    const inputField = document.getElementById('chatbot-input');
    const message = inputField.value.trim();
    
    // Si le message n'est pas vide, ajoute le message au chat
    if (message) {
        addMessageToChat('Vous', message);
        sendMessageToChatbot(message);
        inputField.value = ''; // Réinitialise le champ de saisie
    }
});

// Ajouter un message au chatbot
function addMessageToChat(sender, message) {
    const messagesContainer = document.getElementById('chatbot-messages');
    const messageElement = document.createElement('div');
    messageElement.textContent = `${sender}: ${message}`;
    messagesContainer.appendChild(messageElement);
    messagesContainer.scrollTop = messagesContainer.scrollHeight; // Pour faire défiler le chat
}

// Simuler une réponse du chatbot
function sendMessageToChatbot(message) {
    setTimeout(() => {
        addMessageToChat('Chatbot', "Je suis encore en apprentissage. Merci pour votre question !");
    }, 1000); // Délai de 1 seconde pour simuler la réponse
}
