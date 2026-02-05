# 🏥 e-SAS Care

**Electronic Self-Assessment System for Anxiety Care**

A web-based anxiety screening and management system using the clinically validated **Zung Self-Rating Anxiety Scale (SAS)** to help individuals assess their anxiety levels and receive personalized recommendations.

[![PHP](https://img.shields.io/badge/PHP-7.4+-777BB4?style=flat&logo=php&logoColor=white)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-5.7+-4479A1?style=flat&logo=mysql&logoColor=white)](https://www.mysql.com/)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

---

## 📋 Overview

e-SAS Care is a mental health assessment platform that provides:
- **Self-assessment tools** using standardized Zung SAS methodology
- **Automated anxiety level classification** (Normal, Mild, Moderate, Severe)
- **Personalized recommendations** based on assessment results
- **Educational articles** about anxiety and mental health
- **Consultation history tracking** with printable PDF reports
- **Admin panel** for content and recommendation management

---

## ✨ Features

### For Users:
- 🔐 **Secure Authentication** - User registration and login system
- 📋 **Zung SAS Assessment** - 20-question standardized anxiety screening
- 📊 **Instant Results** - Automatic calculation of anxiety index and categorization
- 💡 **Personalized Recommendations** - Tailored advice based on anxiety severity
- 🖨️ **Printable Reports** - Professional PDF-ready consultation results
- 📚 **Educational Content** - Access to anxiety-related articles
- 📈 **History Tracking** - View all past assessments and progress
- 👤 **Profile Management** - Update personal information and settings

### For Administrators:
- 📊 **Dashboard Analytics** - Overview of users, consultations, and content
- 📝 **Article Management** - Create, edit, and delete educational articles
- 💡 **Recommendation Management** - Customize recommendations for each anxiety level
- 👥 **User Management** - View and manage registered users
- 🔄 **Reorderable Content** - Organize recommendations by priority

---

## 🛠️ Technologies

### Backend:
- **PHP 7.4+** - Server-side scripting
- **MySQL/MariaDB** - Database management
- **Session-based Authentication** - Secure user sessions

### Frontend:
- **HTML5 & CSS3** - Structure and styling
- **JavaScript** - Interactive elements
- **Poppins Font (Google Fonts)** - Modern typography

---

## 📦 Installation

### Prerequisites:
- **XAMPP** / **WAMP** / **LAMP** (Apache, PHP 7.4+, MySQL)
- Web browser (Chrome, Firefox, Edge, Safari)
- Text editor (VS Code, Sublime Text, etc.)

### Step 1: Clone or Download
```bash
# Using Git
git clone https://github.com/yourusername/e-sas-care.git

# Or download ZIP and extract
```

### Step 2: Move to Web Server Directory
```bash
# For XAMPP (Windows/Mac/Linux)
Move folder to: C:\xampp\htdocs\e-sas-care

# For WAMP (Windows)
Move folder to: C:\wamp64\www\e-sas-care

# For LAMP (Linux)
Move folder to: /var/www/html/e-sas-care

# For Laragon (Windows)
Move folder to: \laragon\www\e-sas-care
```

### Step 3: Create Database
1. Open **phpMyAdmin**: `http://localhost/phpmyadmin`
2. Create new database named: `e-sas-care` (use dash, not underscore)
3. Import database file:
   - Click on `e-sas-care` database
   - Go to **Import** tab
   - Choose file: `e-sas-care.sql`
   - Click **Go**

### Step 4: Configure Database Connection
Edit `config/database.php` if **needed**:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');      // Your MySQL password
define('DB_NAME', 'e-sas-care');
```

### Step 5: Start Apache & MySQL
- Open **XAMPP Control Panel**
- Start **Apache** and **MySQL** modules

### Step 6: Access the Application
```
User Interface:  http://localhost/e-sas-care/
Admin Panel:     http://localhost/e-sas-care/admin/
```

---

## 👤 Default Login Credentials

### Admin Account:
- **Email:** `admin@esascare.com`
- **Password:** `admin123`

### Test User Account:
- **Email:** `jean@esascare.com`
- **Password:** `123456`

Or

Register a new account through the registration page.

---

## 📖 Usage Guide

### For Users:

1. **Register Account**
   - Go to registration page
   - Fill in personal information
   - Submit and login

2. **Take Anxiety Assessment**
   - Navigate to "Deteksi Kecemasan"
   - Answer all 20 Zung SAS questions honestly
   - Rate each statement from 1-4 (Never to Always)
   - Submit for instant results

3. **View Results**
   - See your total score and Zung index
   - Read anxiety level classification
   - Get personalized recommendations
   - Print or save results as PDF

4. **Track History**
   - View all past assessments
   - Compare progress over time
   - Reprint previous results

### For Administrators:

1. **Login to Admin Panel**
   - Access: `http://localhost/e-sas-care/login.php`
   - Use admin credentials

2. **Manage Articles**
   - Create educational content
   - Edit existing articles
   - Delete outdated content

3. **Customize Recommendations**
   - Select anxiety level (Normal/Mild/Moderate/Severe)
   - Add/edit/delete recommendations
   - Reorder by priority using ⬆️ ⬇️ buttons

4. **Monitor Users**
   - View registered users
   - Check consultation statistics
   - Remove inactive accounts

---

## 🏗️ Project Structure

```
e-sas-care/
├── admin/                      # Admin panel
│   ├── dashboard_adm.php       # Admin dashboard
│   ├── articles_adm.php        # Article management
│   ├── reccs_adm.php          # Recommendation management
│   ├── user_adm.php           # User management
│   └── sidebar_adm.php        # Admin navigation
│
├── classes/                    # Business logic
│   └── functions.php          # Core functions class
│
├── config/                     # Configuration
│   └── database.php           # Database connection
│
├── css/                        # Stylesheets
│   └── style.css              # Main CSS file
│
├── includes/                   # Reusable components
│   ├── header.php             # Common header
│   ├── sidebar.php            # User navigation
│   └── footer.php             # Common footer
│
├── index.php                  # User dashboard
├── login.php                  # Login page
├── register.php               # Registration page
├── detection.php              # Assessment info page
├── detection_form.php         # Zung SAS questionnaire
├── result.php                 # Assessment results (web view)
├── print_result.php           # Printable PDF version
├── history.php                # Consultation history
├── article.php                # Article listing
├── article_detail.php         # Article reader
├── profile.php                # User profile
├── e-sas-care.sql               # Database structure & data
└── README.md                  # This file
```

---

## 🎯 Zung SAS Methodology

The application uses the **Zung Self-Rating Anxiety Scale**, a validated clinical tool:

### Scoring System:
- **20 questions** rated 1-4 each
- **Total Score:** 20-80
- **Zung Index:** (Total Score ÷ 80) × 100

### Classification:
| Zung Index | Category | Recommendation |
|------------|----------|----------------|
| < 45 | Normal | Maintain healthy lifestyle |
| 45-59 | Mild Anxiety | Self-help techniques |
| 60-74 | Moderate Anxiety | Professional consultation recommended |
| ≥ 75 | Severe Anxiety | Immediate professional help required |

---

## 🔒 Security Features

- ✅ **Password Hashing** - Using PHP `password_hash()` with bcrypt
- ✅ **Role-based Access Control** - Admin vs User permissions
- ✅ **Input Validation** - Server-side validation

---

## 📊 Database Schema

### Main Tables:

**user** - User accounts
```sql
- id_user (INT, PRIMARY KEY)
- role (ENUM: '0'=User, '1'=Admin)
- nama (VARCHAR)
- email (VARCHAR, UNIQUE)
- password (VARCHAR, HASHED)
- jenis_kelamin (ENUM: '0'=Female, '1'=Male)
- tgl_lahir (DATE)
- created_at, updated_at (TIMESTAMP)
```

**konsultasi** - Assessment results
```sql
- id_konsultasi (INT, PRIMARY KEY)
- id_user (INT, FOREIGN KEY)
- q1-q20 (INT 1-4)
- total_score (INT 20-80)
- index_score (DECIMAL)
- kategori_kecemasan (VARCHAR)
- tanggal_konsultasi (TIMESTAMP)
```

**artikel** - Educational content
```sql
- id_artikel (INT, PRIMARY KEY)
- judul (VARCHAR)
- konten (TEXT, HTML)
- ringkasan (TEXT)
- penulis (VARCHAR)
- tanggal_publikasi (TIMESTAMP)
- views (INT)
```

**rekomendasi** - Customizable recommendations
```sql
- id_rekomendasi (INT, PRIMARY KEY)
- kategori_kecemasan (VARCHAR: Normal/Ringan/Sedang/Berat)
- rekomendasi (TEXT)
- urutan (INT, for ordering)
- created_at (TIMESTAMP)
```

---

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

---

## 📄 License

This project is licensed under the MIT License - see the LICENSE file for details.

---

## 👨‍💻 Author

**Your Name**
- GitHub: [@satrioagnag](https://github.com/satrioagnag)
- Email: satriogemintang@gmail.com

---

## 🙏 Acknowledgments

- **Zung Self-Rating Anxiety Scale** - Dr. William W.K. Zung
- **Mental Health Hotline Indonesia** - 119 ext 8, 500-454
- **Poppins Font** - Google Fonts
- **PHP Community** - For excellent documentation

---


## ⚠️ Disclaimer

This application is for **screening purposes only** and does not replace professional mental health diagnosis or treatment. If experiencing severe anxiety symptoms, please consult with a qualified healthcare provider immediately.

---

<div align="center">
  
**Made with ❤️ for mental health awareness**

⭐ Star this repo if you find it helpful!

</div>
