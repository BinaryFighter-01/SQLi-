# Mini Project 2: SQL Injection Vulnerability Demo

## Overview
This mini project demonstrates how an SQL Injection vulnerability can be used to bypass authentication and reveal all product details on a website. By exploiting an insecure login form, an attacker can use the payload `' OR 1=1 -- ` to gain unauthorized access and display every product in the database.

## Purpose
This project is created for educational use, showing how improper input handling leads to SQL Injection attacks and why secure coding practices are essential.

## Project Structure
- `login.php` – Vulnerable login form  
- `products.php` – Displays all products after login  
- `db_connect.php` – Database connection  
- `create_tables.sql` – Database schema  
- `insert_data.sql` – Sample users and product records  

## How to Run
1. Install XAMPP and start **Apache** and **MySQL**.  
2. Copy the project to: `C:\xampp\htdocs\sql_injection_demo`.  
3. Create a database in phpMyAdmin and import the SQL files.  
4. Open the login page:  


[http://localhost/sql_injection_demo/login.php](http://localhost/sql_injection_demo/login.php)


5. Test SQL Injection using:  
- Username: `' OR 1=1 -- `  
- Password: any value  

## Important Note
This project is intentionally vulnerable and should be used **only for learning and demonstration purposes**. Do not deploy it in a production environment.
