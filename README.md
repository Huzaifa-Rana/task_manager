# Task Management System

This is a Task Management System built with **Laravel 11**. The application allows users with different roles (Admin, Manager, User) to create, assign, track, and manage tasks. It includes advanced features such as:

-   **Role-Based Authentication & Authorization:**  
    Different access levels and views for Admins, Managers, and Users.
-   **Task Management:**  
    Create, edit, delete, and view tasks with fields like title, description, due date, priority, status, category, assignee, and dependencies.
-   **Advanced Search & Pagination:**  
    Live search functionality with AJAX and pagination (10 tasks per page).
-   **Calendar View:**  
    A visual timeline using FullCalendar to display upcoming tasks.
-   **Task Comments (Optional):**  
    Users can add comments to tasks for collaboration.
-   **Additional Features:**  
    Manage categories, users (with role assignment), and more.

## Features

-   **Responsive Dashboard:**  
    Separate dashboards for Admin, Manager, and User roles, featuring summary cards, quick navigation links, and a calendar preview.
-   **Modern UI:**  
    Built with Bootstrap 5, jQuery, and Font Awesome icons.
-   **AJAX Functionality:**  
    Live search, pagination, and modal confirmation for delete actions without full page reloads.
-   **FullCalendar Integration:**  
    Visual display of tasks on a calendar.

## Requirements

-   PHP >= 8.0
-   Composer
-   Node.js & NPM
-   MySQL

## Setup Instructions

Follow these steps to set up the project locally after cloning the repository:

1. **Clone the Repository:**

    ```bash
    git clone https://github.com/Huzaifa-Rana/task-manager.git
    cd task-manager
    ```

Install PHP Dependencies:

composer install

Install Frontend Dependencies:

npm install

Set Up Environment Variables:

Copy the example environment file to create your own .env file:

cp .env.example .env
Open the .env file and configure your database and other environment-specific settings. For example:

APP_NAME="Task Management System"
APP_ENV=local
APP_KEY= # (this will be generated)
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_manager
DB_USERNAME=root
DB_PASSWORD=yourpassword

Generate Application Key:
php artisan key:generate

Run Database Migrations and Seeders Cuncurently:

Make sure you have created a database (e.g., task_manager), then run:

php artisan migrate --seed

Compile Frontend Assets:

The project uses Vite for asset bundling. Run:

npm run dev
Serve the Application:

Start the Laravel development server:

php artisan serve
Open your browser and navigate to http://127.0.0.1:8000.
