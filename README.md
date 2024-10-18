# ZenVedaSync - Course Website Project

## Project Overview
ZenVedaSync is a cutting-edge course website designed to blend the ancient wisdom of Indian Vedas with modern technology, catering to the Gen Z audience. This platform offers a range of free and premium courses, featuring coin-based rewards, secure payment options, user authentication, and detailed progress tracking.

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
├── api/
│   ├── courses/
│   ├── auth/
│   ├── users/
│   ├── payments/
│   ├── coins/
│   ├── config/
│   └── index.php
```

### Frontend Directory
```
frontend/
├── css/
│   ├── tailwind.css
│   ├── main.css
├── js/
│   ├── script.js
├── images/
├── index.html
├── home.html
├── login.html
├── register.html
├── courses.html
├── course-detail.html
├── dashboard.html
├── payment.html
├── support.html
├── faq.html
├── contact.html
├── terms.html
├── privacy.html
├── about.html
├── blog.html
├── press.html
├── apply.html
├── job-details.html
├── submit-ticket.html
├── tutorials.html
├── career.html
└── know-us.html
```

## Setup and Installation

### Prerequisites
- PHP
- MySQL
- PhpMyAdmin

### Backend (PHP) Setup
1. Clone the repository:
   ```bash
   git clone https://github.com/Meetmendapara09/WT-Try.git
   cd course-website/backend
   ```

2. Set up the database:
   - Create a database named `course_website`.
   - Import `backend/config/db.sql` into your MySQL database.

3. Update database configuration in `backend/config/db.php`.

4. Start the PHP server:
   ```bash
   php -S localhost:8000
   ```

### Frontend Setup
1. Navigate to the frontend directory:
   ```bash
   cd ../frontend
   ```

2. Open `index.html` in a web browser to view the site.

## Usage
- Access the frontend at `http://localhost:8000`.
- The backend API is available at `http://localhost:8000/api`.

## API Endpoints
### Authentication
- `POST /api/auth/login`: User login
- `POST /api/auth/register`: User registration
- `POST /api/auth/passwordRecovery`: Password recovery

### Courses
- `GET /api/courses/getCourses`: List courses
- `GET /api/courses/getCourseDetails`: Course details
- `POST /api/courses/addCourse`: Add a course
- `PUT /api/courses/updateCourse`: Update a course
- `DELETE /api/courses/deleteCourse`: Delete a course

### Users
- `GET /api/users/getUser`: Get user details
- `PUT /api/users/updateUser`: Update user info
- `DELETE /api/users/deleteUser`: Delete a user

### Payments
- `POST /api/payments/processPayment`: Process payment
- `GET /api/payments/getPaymentHistory`: Payment history

## Contributing
Contributions are welcome! Please fork this repository and submit a pull request.

## License
This project is licensed under the MIT License. See [LICENSE](LICENSE) for details.

