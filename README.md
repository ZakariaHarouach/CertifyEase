# 🌟 CertiEase

CertiEase is a web-based application designed to simplify the management of certifications, including medical certificates, for students, professors, and administrators. The platform provides a user-friendly interface for uploading, validating, and managing certificates while ensuring role-based access control.

---

## ✨ Features

### 🔐 Role-Based Access
- 👨‍🎓 Students, 👨‍🏫 Professors, and 🛡️ Administrators have distinct roles with specific permissions.
- Role detection is handled via session variables.

### 📄 Medical Certificate Management
- Users can upload medical certificates in various formats (PDF, JPG, PNG).
- Certificates are validated and stored in the database with a status (e.g., pending, approved).

### ⚠️ Error Handling
- Custom error pages for invalid login attempts or unauthorized access.
- Debugging outputs for development purposes.

### 📱 Responsive Design
- Built with Bootstrap for a clean and responsive user interface.

### 🔒 Secure File Uploads
- Supports file validation for type and size.
- Uploaded files are stored securely in the uploads directory.

---

## 📂 Folder Structure

CertiEase/
- Codes/
  - html/
    - forgetPassword/
      - forget-pass.html
      - forget-pass2.php
    - error_pages/
      - log_with_adminAcc.html
      - log_with_profAcc.html
      - log_with_studentAcc.html
  - php/
    - cerificat madicale/
      - add_certificate.php
    - login/
      - person_login.php
  - js/
    - certifications validation/
      - medical_certif_validation.js
    - forget_password_Validation.js
- uploads/
  - (Uploaded files are stored here)
- README.md

---

## ⚙️ Installation

### 1️⃣ Clone the Repository
Use the command:
```bash
git clone https://github.com/your-username/CertiEase.git
```

### 2️⃣ Set Up the Database
Import the certieasedb.sql file into your MySQL database.
Ensure the database credentials in db.php are correct.

### 3️⃣ Configure File Uploads
Ensure the uploads/ directory exists and has write permissions.

### 4️⃣ Run the Application
Start your local server (e.g., XAMPP or WAMP).
Place the project in the htdocs directory.
Access the application in your browser at:

---

## 🚀 Usage

### 1️⃣ Login
Users can log in as a student, professor, or administrator.
Invalid login attempts are redirected to custom error pages.

### 2️⃣ Upload Medical Certificates
Navigate to the medical certificate upload page.
Fill in the required fields (start date, end date, and certificate file).
Submit the form to upload the certificate.

### 3️⃣ Error Handling
If a user attempts to access a restricted page, they are redirected to an appropriate error page.

---

## 🛠️ Technologies Used

### Frontend
- HTML5, CSS3, JavaScript
- Bootstrap 5

### Backend
- PHP 8
- MySQL

### Other
- PHPMailer (for email functionality)
- File upload handling with validation

---

## ✅ Validation Rules

### File Upload
- Allowed file types: jpg, jpeg, png, pdf.
- Maximum file size: 2 MB.

### Date Validation
- Start date must not be greater than the current date or earlier than 2 days before.
- The difference between start and end dates must not exceed 7 days.

### Form Validation
- All fields are required.
- Custom JavaScript validation for client-side checks.

---

## ⚠️ Error Pages

### log_with_adminAcc.html:
Displays an error message when a user tries to log in without an admin account.

### log_with_profAcc.html:
Displays an error message when a user tries to log in without a professor account.

### log_with_studentAcc.html:
Displays an error message when a user tries to log in without a student account.

---

## 🐞 Debugging

Debugging outputs are included in add_certificate.php to display missing or invalid fields during development.
Ensure debugging is disabled in production for security purposes.

---

## 🤝 Contribution

1. Fork the repository.
2. Create a new branch.
3. Commit your changes.
4. Push to the branch.
5. Open a pull request.

---

## 📜 License

This project is created by:
- Adam Elmekadem (Team Leader)
- Zakaria Harouach
- Ilyas Dahs
- Abdessamad Tikonab