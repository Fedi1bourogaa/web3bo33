// Function to generate a random string of letters and numbers
function generateCaptcha() {
    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    let captcha = '';
    for (let i = 0; i < 6; i++) {  // Captcha length of 6 characters
        captcha += characters.charAt(Math.floor(Math.random() * characters.length));
    }
    // Display the CAPTCHA
    document.getElementById('captcha').textContent = captcha;
    // Store the generated CAPTCHA in a hidden input for comparison during form submission
    document.getElementById('captcha').setAttribute('data-captcha', captcha);
}

// Function to validate if the user's input matches the generated CAPTCHA
function validateCaptcha(event) {
    const userCaptchaInput = document.getElementById('captchaInput').value;
    const generatedCaptcha = document.getElementById('captcha').getAttribute('data-captcha');
    
    if (userCaptchaInput !== generatedCaptcha) {
        alert("Captcha does not match. Please try again.");
        event.preventDefault();  // Prevent form submission
        return false;  // Return false to prevent form submission
    }

    return true;  // Return true if CAPTCHA matches, allowing form submission
}

// Call the generateCaptcha function when the page loads
window.onload = generateCaptcha;