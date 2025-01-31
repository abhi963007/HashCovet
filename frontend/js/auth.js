const API_BASE_URL = 'http://localhost:8000/backend/api';

// Check if user is logged in
function isLoggedIn() {
    return localStorage.getItem('token') !== null;
}

// Redirect if not logged in
function requireAuth() {
    if (!isLoggedIn()) {
        window.location.href = 'login.html';
    }
}

// Redirect if already logged in
function redirectIfLoggedIn() {
    if (isLoggedIn()) {
        window.location.href = 'index.html';
    }
}

// Handle registration
async function register(event) {
    event.preventDefault();
    const username = document.getElementById('username').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const messageDiv = document.getElementById('message');

    try {
        const response = await fetch(`${API_BASE_URL}/register.php`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ username, email, password })
        });

        const data = await response.json();

        if (response.ok) {
            messageDiv.className = 'success';
            messageDiv.textContent = data.message;
            setTimeout(() => {
                window.location.href = 'login.html';
            }, 1500);
        } else {
            messageDiv.className = 'error';
            messageDiv.textContent = data.message;
        }
    } catch (error) {
        messageDiv.className = 'error';
        messageDiv.textContent = 'An error occurred. Please try again.';
    }
}

// Handle login
async function login(event) {
    event.preventDefault();
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    const messageDiv = document.getElementById('message');

    try {
        const response = await fetch(`${API_BASE_URL}/login.php`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ username, password })
        });

        const data = await response.json();

        if (response.ok) {
            localStorage.setItem('token', data.token);
            localStorage.setItem('user', JSON.stringify(data.user));
            messageDiv.className = 'success';
            messageDiv.textContent = data.message;
            setTimeout(() => {
                window.location.href = 'index.html';
            }, 1500);
        } else {
            messageDiv.className = 'error';
            messageDiv.textContent = data.message;
        }
    } catch (error) {
        messageDiv.className = 'error';
        messageDiv.textContent = 'An error occurred. Please try again.';
    }
}

// Fetch protected data
async function fetchProtectedData() {
    const token = localStorage.getItem('token');
    const contentDiv = document.getElementById('protected-content');

    try {
        const response = await fetch(`${API_BASE_URL}/protected.php`, {
            headers: {
                'Authorization': `Bearer ${token}`
            }
        });

        const data = await response.json();

        if (response.ok) {
            contentDiv.innerHTML = `
                <h2>Welcome ${data.data.username}!</h2>
                <p>${data.data.protected_content}</p>
            `;
        } else {
            contentDiv.innerHTML = `<p class="error">${data.message}</p>`;
            if (response.status === 401) {
                logout();
            }
        }
    } catch (error) {
        contentDiv.innerHTML = '<p class="error">An error occurred while fetching protected data.</p>';
    }
}

// Handle logout
function logout() {
    localStorage.removeItem('token');
    localStorage.removeItem('user');
    window.location.href = 'login.html';
} 