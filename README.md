# 📋 TaskWave: Minimalist Office Management App

TaskWave is a minimalist management app designed for offices, offering essential features to streamline workflow and productivity. It's an all-in-one solution for managing tasks, schedules, and team performance.

[![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=flat&logo=html5&logoColor=white)](https://developer.mozilla.org/en-US/docs/Web/HTML)
[![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=flat&logo=css3&logoColor=white)](https://developer.mozilla.org/en-US/docs/Web/CSS)
[![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=flat&logo=javascript&logoColor=black)](https://developer.mozilla.org/en-US/docs/Web/JavaScript)
[![PHP](https://img.shields.io/badge/PHP-777BB4?style=flat&logo=php&logoColor=white)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=flat&logo=mysql&logoColor=white)](https://www.mysql.com/)

## 🚀 Features

- 📅 **Calendar**: Track important dates, meetings, and deadlines with an intuitive calendar interface.  
- ✅ **To-Do Lists**: Organize and manage tasks efficiently to boost productivity.  
- 📝 **Notes**: Jot down ideas and keep important info accessible within the app.  
- ⏱️ **Check-In/Check-Out**: Monitor attendance with check-in and check-out time tracking.  
- 📊 **Progress Reports**: Visualize work progress through pie charts based on total hours worked.  

## 🛠️ Tech Stack

- **Frontend**: HTML5, CSS3, JavaScript  
- **Backend**: PHP  
- **Database**: MySQL  

## 📦 Installation

### ✅ Prerequisites

Make sure you have the following installed on your system:

- PHP (v7+)
- MySQL or MariaDB
- Apache or any web server (or use PHP’s built-in server)
- A code editor (e.g., VS Code)

## 📥 Setup Steps
1️⃣ Clone the repository or download the ZIP file:
```bash
git clone https://github.com/yourusername/taskwave.git
cd taskwave
```
Or download the ZIP and extract it.

2️⃣ Set Up the MySQL Database
1. Start your MySQL server:

```bash
sudo service mysql start  # Linux/macOS
```
2. Log into MySQL:

```bash
mysql -u root -p
```
3. Create a database:

```bash
CREATE DATABASE taskwave_db;

```
4. Import the database schema (if a .sql file is provided):
```bash
mysql -u root -p taskwave_db < path/to/your/schema.sql
```

3️⃣ Configure Database Connection in PHP
In your PHP files (e.g., Signup.php, Login.php), make sure the DB connection is set correctly:

```bash
$servername = "localhost";
$username = "root"; // or your MySQL user
$password = "";     // or your MySQL password
$database = "taskwave_db";

$conn = mysqli_connect($servername, $username, $password, $database);
```

4️⃣ Start a Local PHP Server
You can use PHP’s built-in development server (no Apache needed):

```bash
php -S localhost:8000
```
Make sure you are in the taskwave project directory when running this command.

5️⃣ Open in Your Browser
Navigate to:
```bash
http://localhost:8000/Signup.html
```
Or whichever page you want to start with (e.g., Login.php, index.html).

## 📜 License
This project is created for learning and educational purposes. Contributions and improvements are welcome!
