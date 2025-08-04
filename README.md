📝 ToDo List Web Application with User Authentication (PHP + MySQL)

A simple, responsive To-Do List Web App built with PHP and MySQL. This app supports user registration, login/logout, and personal task management. It's perfect for beginners learning web development and PHP backend integration.


🔧 Features

- ✅ User Registration and Login System
- 🔐 Session-based Authentication
- 🗂️ Create, Edit, Delete, and Complete Tasks
- 🧑‍💻 Personal Dashboard for each user
- 📱 Responsive front-end using basic HTML & CSS
- 💾 MySQL database integration
todo-app-auth/
│
├── config/
│ └── db.php # Database connection file
│
├── css/
│ └── style.css # Basic styling
│
├── includes/
│ ├── header.php
│ └── footer.php
│
├── js/
│ └── script.js # (Optional) Client-side interactivity
│
├── login.php # Login page
├── register.php # User registration page
├── logout.php # Logout handler
├── index.php # Main task dashboard
├── add_task.php # Adds a new task
├── update_task.php # Marks task as done or edits
├── delete_task.php # Deletes a task
└── README.md # Project documentation


### 🛠️ Installation Steps

1. **Install XAMPP** (or any Apache + MySQL server).
   - [Download XAMPP](https://www.apachefriends.org/index.html)

2. **Place the Project**
   - Unzip the project into `C:\xampp\htdocs\todo-app-auth`

3. **Start Apache and MySQL** via XAMPP control panel.

4. **Create Database**
   - Visit: [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
   - Create a new database named: `todo_db`
   - Import the `todo_db.sql` file (from project or create the table as below):

```sql
CREATE TABLE `users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `tasks` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `completed` BOOLEAN DEFAULT FALSE,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);
Access the App

Visit: http://localhost/todo-app-auth

Backend: PHP 7+

Database: MySQL

Frontend: HTML5, CSS3, JavaScript (optional)

Server: Apache (via XAMPP)







Ask ChatGPT


