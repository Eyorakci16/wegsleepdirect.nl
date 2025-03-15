# Contact Form with Database and Email Notification

This repository contains a complete solution for a contact form with the following features:
- **HTML Form**: A simple form for users to submit their contact information.
- **CSS Styling**: Styles for the form and responsive navigation.
- **JavaScript**: Scripts for real-time form validation, mobile menu toggle, and dropdowns.
- **PHP**: PHP backend to handle form submission, database storage, and email notification.
- **MySQL**: SQL script for creating a database and table to store submitted messages.

## Features

- **Input Validation**: Ensures required fields are filled and validates email and phone formats.
- **Database Storage**: Saves user messages into a MySQL database.
- **Email Notification**: Sends an email to the site admin with the contact details when a new message is submitted.
- **Real-time Validation**: The form validates inputs as the user types.
- **Mobile and Desktop Responsive**: A navigation menu that is mobile-friendly and adjusts based on the screen size.

---

## Requirements

- **PHP** version 7.0 or higher
- **MySQL** database
- Web server (e.g., Apache, Nginx)
- Access to an SMTP server for sending emails

---

## Installation

### Step 1: Set up the MySQL Database

Create a MySQL database and table using the following SQL script:

```sql
-- Create a new database named 'wegsleepdirect'
CREATE DATABASE wegsleepdirect;
USE wegsleepdirect;

-- Create the 'contact_messages' table to store form submissions
CREATE TABLE contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,  -- Unique ID for each message
    name VARCHAR(255) NOT NULL,         -- User's name (Required)
    email VARCHAR(255) NOT NULL,        -- User's email (Required)
    phone VARCHAR(50) NOT NULL,         -- User's phone number (Required)
    subject VARCHAR(255) NOT NULL,      -- Subject of the message (Required)
    message TEXT NOT NULL,              -- User's message (Required)
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Timestamp of submission
);
