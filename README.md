# 📅 Appointment Management System - Laravel

This project is a dynamic **Appointment System** developed during my internship at **GASKİ (Gaziantep Water and Sewerage Administration)**. The application is built with the **Laravel** framework and **MySQL**, focusing on efficient scheduling and user management.

---

## 🚀 Key Features

* **User Authentication:** Secure registration and login system for users.
* **Appointment Booking:** Users can easily select services and book appointments.
* **Admin Dashboard:** Specialized panel for administrators to manage, approve, or cancel appointments.
* **Relational Database:** Optimized MySQL schema for users, appointments, and service categories.
* **Responsive UI:** Fully compatible with mobile and desktop screens using Blade and CSS.
* **Data Validation:** Robust server-side validation to ensure system security and data integrity.

---

## 🛠 Tech Stack

* **Framework:** Laravel 10.x / 11.x
* **Language:** PHP 8.x
* **Database:** MySQL
* **Template Engine:** Blade
* **Package Management:** Composer & NPM

---

## ⚙️ Installation & Setup

To run this project on your local machine, follow these steps:

1.  **Clone the Repository:**
    ```bash
    git clone [https://github.com/Leylakirkiz/appointmentssystem.git](https://github.com/Leylakirkiz/appointmentssystem.git)
    cd appointmentssystem
    ```

2.  **Install Dependencies:**
    ```bash
    composer install
    npm install && npm run dev
    ```

3.  **Configure Environment:**
    Copy the example environment file and set your database credentials:
    ```bash
    cp .env.example .env
    ```

4.  **Generate App Key:**
    ```bash
    php artisan key:generate
    ```

5.  **Run Migrations:**
    ```bash
    php artisan migrate
    ```

6.  **Start the Server:**
    ```bash
    php artisan serve
    ```
    Visit `http://127.0.0.1:8000` in your browser.

---

## 📂 Project Architecture

The project strictly follows the **MVC (Model-View-Controller)** pattern:
* **Models:** Managed via Eloquent ORM for seamless database interaction.
* **Controllers:** Contains the business logic for appointment scheduling.
* **Views:** Built with Blade for a dynamic and modular user interface.
* **Migrations:** Database schema is maintained as code for easy deployment.

---

## 👨‍💻 Developer
* **Name:** Leyla Kirkiz Özge Naz Navgasın
* **University:** Near East University - Engineering Department
* **Project Goal:** Practical application of Full-Stack Web Development and Database Management.
