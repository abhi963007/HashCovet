# User Authentication System

A modern and secure user authentication system using PHP backend API with JWT authentication and an interactive HTML/CSS/JavaScript frontend.

## Features

* User Registration with Email Verification
* User Login with JWT Authentication
* Protected Routes and Dashboard
* Secure Password Handling
* Modern UI with Interactive Elements:
  * Dark/Light Theme Support
  * Interactive Particle Background
  * Lottie Animations
  * Responsive Design
  * Glass-morphism Effects
* Frontend Integration with Backend API
* Theme Persistence using LocalStorage

## Project Structure
```
/
├── backend/
│   ├── config/
│   │   └── database.php
│   ├── middleware/
│   │   └── auth.php
│   ├── api/
│   │   ├── register.php
│   │   ├── login.php
│   │   └── protected.php
│   └── utils/
│       └── jwt.php
├── frontend/
│   ├── css/
│   │   └── style.css
│   ├── js/
│   │   └── auth.js
│   ├── index.html
│   ├── login.html
│   └── register.html
└── README.md
```

## Technologies Used

* Frontend:
  * HTML5, CSS3, JavaScript
  * Particles.js for interactive backgrounds
  * Lottie for vector animations
  * FontAwesome for icons
  * Modern CSS features (Glass-morphism, CSS Variables)
* Backend:
  * PHP 7.4+
  * JWT for authentication
  * MySQL database
  * PDO for database operations

## Setup Instructions

1. Set up a local PHP development server (e.g., XAMPP)
2. Create a MySQL database named `auth_system`
3. Update database credentials in `backend/config/database.php`
4. Place the project in your web server's root directory
5. Open the frontend in a web browser

## Usage

1. Register a new account with username, email, and password
2. Login with your credentials
3. Access the protected dashboard
4. Toggle between dark and light themes
5. Enjoy the interactive particle effects and animations

## Security Features

* JWT-based authentication
* Password hashing
* Protected API endpoints
* Secure session handling
* XSS protection
* CSRF protection

## Browser Support

* Chrome (latest)
* Firefox (latest)
* Safari (latest)
* Edge (latest)

## Contributing

Feel free to submit issues and enhancement requests. 