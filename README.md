# CSC574 Project

Web Dynamic

## Instructions

1. Clone this project to your local machine:

2. Import the database:

- Locate the file `config/gg.sql` in the cloned project.
- Import `gg.sql` into your database management system.

3. Copy the connection configuration file:

- In the project directory, run the following command to create a copy of the connection configuration file:
  ```
  cp config/connection.example.php config/connection.php
  ```

## Important Note

Ensure that you add `../` for each page inside their own folder to avoid errors when navigating between pages.

Example:

- To access the profile page: `../pages/profile.php`
- To access the login page: `../login.php`
