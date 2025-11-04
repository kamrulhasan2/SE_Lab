# Simple PHP Login and CRUD App

This is a simple PHP application that demonstrates user registration, login, and a basic Create, Read, Update, Delete (CRUD) functionality for a to-do list.

## Prerequisites

To run this application, you will need a local web server environment with PHP and a MySQL-compatible database. A standard XAMPP or WAMP installation is recommended.

-   Apache Web Server
-   PHP
-   MySQL or MariaDB

## Setup Instructions

### 1. Clone the Repository

First, clone this repository to a directory on your local machine. It's best to clone it directly into your web server's document root (e.g., `C:\xampp\htdocs`).

```bash
git clone https://github.com/your-username/learn-php.git
cd learn-php
```

### 2. Database Setup

You need to set up the database for the application to work.

1.  **Create the Database:** Using a tool like phpMyAdmin (usually found at `http://localhost/phpmyadmin`), create a new database named `first_db`.

2.  **Create Tables:** Import the following SQL files into your `first_db` database in order:
    1.  `database.sql` (This will create the `users` and initial `list` tables).
    2.  `update_table.sql` (This will add the necessary timestamp columns to the `list` table).

### 3. Run the Application

Once the files are in your web server's document root and the database is set up, you can access the application by navigating to `http://localhost/learn-php` in your web browser.

## Development

### Switching Branches

This repository may have multiple branches for different features or versions.

**To see all available branches:**
```bash
git branch -a
```

**To switch to an existing branch:**
Replace `<branch-name>` with the name of the branch you want to switch to.
```bash
git checkout <branch-name>
```
Ex:
```bash
git checkout project-system
```

**To create a new branch and switch to it:**
This is useful when you want to start working on a new feature.
```bash
git checkout -b <new-feature-branch-name>
```
