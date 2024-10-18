# ZenVedaSync - E-Learning Website 

## Project Overview
ZenVedaSync is an innovative e-learning platform that merges the ancient wisdom of Indian Vedas with modern technology, specifically designed for the Gen Z audience. The site offers a diverse selection of free and premium courses, featuring secure payment options, user authentication, and comprehensive progress tracking to enhance the learning experience.


**CSE-D** 

## Team Members
- **Meet Mendapara [IU2241230422]**
- **Prince Ghoda [IU2241230392]**

## Table of Contents
1. [Features](#features)
2. [Technology Stack](#technology-stack)
3. [Project Structure](#project-structure)
4. [Setup and Installation](#setup-and-installation)
5. [Usage](#usage)
6. [API Endpoints](#api-endpoints)
7. [Contributing](#contributing)
8. [License](#license)

## Features
- **Home Page**: Displays featured, latest, and popular courses, testimonials, and highlights from the blog.
- **User Authentication**: Secure login/signup process and OAuth integration.
- **Course Pages**: Comprehensive course details including instructor bios, curriculum, and user reviews.
- **User Dashboard**: Manage user profiles, track course progress, view coin balance, and adjust settings.
- **Payment Integration**: Secure system for purchasing premium courses.
- **Progress Tracking**: Monitor learning progress and earn rewards based on achievements.
- **Video Player**: Integrated video player for course content.
- **Support and FAQ**: Sections for user support and frequently asked questions.
- **Blog/News**: Updated blog posts and news articles.
- **Admin Panel**: Tools for managing courses, users, payments, and orders.

## Technology Stack
### Frontend
- **HTML**
- **CSS**: Styled using Tailwind CSS and custom styles
- **JavaScript**: For interactive functionality and dynamic content

### Backend
- **PHP**: Server-side scripting
- **MySQL**: Database management
- **PhpMyAdmin**: Database administration tool

## Project Structure
### Backend Directory (PHP)
```
backend/ 
├── auth/ 
│ ├── forgot-password.php 
│ ├── login.php 
│ ├── logout.php 
│ ├── register.php 
│ └── reset_process.php 
├── payment/ 
│ ├── payment-success.php 
│ └── payment.php 
├── phpmailer/ 
├── config.php 
├── contact.php 
├── course-detail.php 
├── courses.php 
├── dashboard-teacher.php 
├── dashboard.php 
├── edit-course.php 
├── enroll.php 
├── free-courses.php 
├── paid-courses.php 
└── video-player.php
```

## Frontend Directory

```
frontend/ 
├── Pages/ 
│ ├── Auth/ 
│ │ ├── Forgot-Password.html 
│ │ ├── Login.html 
│ │ └── SignUp.html 
│ ├── Courses/ 
│ │ ├── course-details.html 
│ │ ├── free-courses.html 
│ │ └── paid-course.html 
│ ├── Progress-Tracking/ 
│ │ ├── Progress-Tracking.css 
│ │ ├── Progress-Tracking.html 
│ │ └── Progress-Tracking.js 
│ ├── Support-FAQ/ 
│ │ ├── FAQ.html 
│ │ └── Support.html 
│ ├── Video-Player/ 
│ │ ├── Video-Player.css 
│ │ ├── Video-Player.html 
│ │ └── Video-Player.js 
│ ├── blogs/ 
│ │ ├── blog-post-1.html 
│ │ ├── blog-post-2.html 
│ │ ├── blog-post-3.html 
│ │ └── blog.html 
│ ├── Payment.html 
│ ├── Privacy-Policy.html 
│ ├── Testimonial.html 
│ ├── about-us.html 
│ ├── apply.html 
│ ├── careers.html 
│ ├── contact-us.html 
│ ├── dashboard-teacher.html 
│ ├── dashboard.html 
│ ├── edit-course.html 
│ ├── help-center.html 
│ ├── job-details.html 
│ ├── know-us.html 
│ ├── press.html 
│ ├── submit-a-ticket.html 
│ ├── terms-and-conditions.html 
│ ├── tutorials.html 
├── Scripts/ 
│ ├── script.js 
│ └── validPaths.json 
├── Styles/ 
│ ├── Styles.css 
│ ├── header-footer.css 
├── images/ 
│ ├── 404.html 
│ ├── footer.html 
│ ├── header.html 
│ ├── index.html 
├── .gitignore 
├── README.md 
└── package.json
```

## Setup and Installation

### Prerequisites
- PHP
- MySQL
- PhpMyAdmin

## Backend (PHP) Setup

### 1. Clone the repository:
   ```
   git clone https://github.com/Meetmendapara09/Web_Technology.git
   cd Web_Technology/BackEnd
   ```
### 2. Set up the database:
```
Create a database named course_website.
Import backend/config/db.sql into your MySQL database.
Update database configuration in backend/config/db.php.
```

### 3. Start the PHP server:
```
php -S localhost:8000
```

### 4. Frontend Setup
Navigate to the frontend directory:
```
cd ../frontend
```
Open index.html in a web browser to view the site.

## Usage

Access the frontend at 
```
http://localhost:8000/
```
The backend is available at 
```
http://localhost:3307/

```

## Running the Backend with XAMPP
- **Install XAMPP**: Download and install XAMPP from Apache Friends.

- **Start XAMPP:** Open the XAMPP Control Panel and start Apache and MySQL.

- **Clone the Repository**:

Go to the htdocs folder in your XAMPP installation 
```
(usually C:\xampp\htdocs).
```
- **Clone the repository**:
```
git clone https://github.com/Meetmendapara09/Web_Technology.git
```

- **Set Up the Database**:

Open your web browser and go to 
```
http://localhost/phpmyadmin.
```
- Create a new database named course_website.
- Import the SQL file (if available) to set up tables.
- Configure Database Connection:
Open the config.php file in the backend folder.
Update the database details:
```
$servername = "localhost";
$username = "root"; // Default XAMPP username
$password = ""; // Default XAMPP password is empty
$dbname = "ZenVedaSync";
```

Access the Backend:

Open your browser and go to:
```
http://localhost/Web_technology/BackEnd
```
Test: Check different functionalities like login and registration.


### Payment Integration and Deployment
To set up payment processing and integration, please visit the following website to obtain your keys:

For more details, refer to the documentation:
- **Gmail SMTP Documentation**: [Gmail SMTP Settings](https://support.google.com/a/answer/176600?hl=en)
- **Razorpay API Documentation**: [Razorpay API Documentation](https://razorpay.com/docs/api/)

```
SMTP_HOST=         # Your SMTP host (e.g., smtp.example.com)
SMTP_PORT=         # SMTP port (e.g., 587 for TLS)
SMTP_USERNAME=     # Your SMTP username
SMTP_PASSWORD=     # Your SMTP password
SMTP_SECURE=       # Security protocol (e.g., tls or ssl)
(Razorpay API Credentials)
API_KEY=           # Your Razorpay API Key
API_SECRET=        # Your Razorpay API Secret
```


## Contributing
Contributions are welcome! Please fork this repository and submit a pull request.

## License
This project is licensed under the MIT License. See [LICENSE](LICENSE) for details.
