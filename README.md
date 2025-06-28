
# How to Run MechanicConnect on  Computer

Follow the steps below to set up and run the MechaniConnect web application on a different computer.

---

## ✅ Prerequisites

- Install [XAMPP](https://www.apachefriends.org/index.html) or any web server stack that includes:
  - Apache
  - PHP (v7 or higher)
  - MySQL

---

## 📁 Step-by-Step Setup

### 1. Copy Project Folder

- Copy the entire `mechanicConnect` project folder from your original machine.
- Paste it into the web root directory of the new computer:
  ```
  C:\xampp\htdocs\mechanicConnect
  ```

---

### 2. Import the Database

- Start **XAMPP** and open **phpMyAdmin**:  
  [http://localhost/phpmyadmin](http://localhost/phpmyadmin)

- Create a new database:
  ```
  mechanicConnect
  ```

- Click on the newly created database, go to the **Import** tab.

- Choose the `.sql` file from your project’s `sql/` directory (e.g., `mechanicConnect.sql`) and import it.

---

### 3. Update Database Configuration

- Open the database configuration file (usually located at `includes/db.php` or similar).

- Ensure the connection settings match the new environment:
  ```php
  $conn = new mysqli('localhost', 'root', '', 'mechanicConnect');
  ```

---

### 4. Start Apache and MySQL

- Open the **XAMPP Control Panel**.
- Start both:
  - Apache
  - MySQL

---

### 5. Run the Application

- Open your browser and navigate to:
  ```
  http://localhost/mechanicConnect
  ```

---

## ✅ Done!

You should now be able to access and use the mechanicConnect web application on the new computer.
