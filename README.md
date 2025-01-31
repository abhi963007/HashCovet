# User Authentication System

A secure user authentication system using PHP backend API with JWT authentication and HTML/CSS/JavaScript frontend.

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

## Setup Instructions

1. Set up a local PHP development server
2. Create a MySQL database named `auth_system`
3. Update database credentials in `backend/config/database.php`
4. Start the PHP server
5. Open the frontend in a web browser

## Features

- User Registration
- User Login with JWT Authentication
- Protected Routes
- Secure Password Handling
- Frontend Integration with Backend API 