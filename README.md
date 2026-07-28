# 💊 MediStore - Online Pharmacy Management System

![PHP](https://img.shields.io/badge/PHP-8.2-blue)
![CodeIgniter](https://img.shields.io/badge/CodeIgniter-4.5-red)
![MySQL](https://img.shields.io/badge/MySQL-Database-orange)
![Docker](https://img.shields.io/badge/Docker-Container-blue)
![Render](https://img.shields.io/badge/Deployment-Render-success)
![License](https://img.shields.io/badge/License-MIT-green)

---

## 📖 Overview

MediStore is a modern Online Pharmacy Management System developed using **CodeIgniter 4**. The application allows customers to browse medicines, upload prescriptions, securely place orders, and track purchases through an intuitive web interface.

The project focuses on providing a secure, scalable, and responsive platform that simplifies the medicine ordering process while ensuring an efficient management system for administrators.

---

# 🚀 Features

### 👤 User Management

- User Registration
- Secure Login & Authentication
- User Dashboard
- Profile Management
- Session Handling

---

### 💊 Medicine Management

- Browse Medicines
- Medicine Categories
- Search Medicines
- View Medicine Details
- Stock Availability

---

### 🛒 Shopping Features

- Add to Cart
- Remove from Cart
- Update Cart Quantity
- Checkout Process
- Order Summary

---

### 📄 Prescription Upload

- Upload Doctor Prescription
- File Validation
- Prescription Management
- Secure Storage

---

### 📦 Order Management

- Place Orders
- Order Tracking
- Order History
- Order Status Updates

---

### 📑 PDF Generation

- Generate Order Invoice
- Download PDF Receipt
- DomPDF Integration

---

### 🔒 Security Features

- Session Authentication
- Input Validation
- SQL Injection Protection
- XSS Protection
- CSRF Protection
- Secure Password Handling

---

### 📱 Responsive Design

- Desktop Friendly
- Tablet Responsive
- Mobile Responsive

---

# 🏗️ Project Architecture

```
MediStore
│
├── app
│   ├── Config
│   ├── Controllers
│   ├── Database
│   ├── Filters
│   ├── Helpers
│   ├── Libraries
│   ├── Models
│   ├── Services
│   └── Views
│
├── public
├── writable
├── vendor
├── Dockerfile
├── composer.json
└── .env
```

---

# ⚙️ Technology Stack

| Technology | Version |
|------------|----------|
| PHP | 8.2 |
| CodeIgniter | 4.5 |
| MySQL | Railway MySQL |
| Apache | 2.4 |
| Docker | Latest |
| Composer | 2.x |
| HTML5 | ✓ |
| CSS3 | ✓ |
| JavaScript | ✓ |

---

# 🐳 Docker Deployment

Build Docker Image

```bash
docker build -t medistore .
```

Run Container

```bash
docker run -p 8080:80 medistore
```

---

# ☁️ Cloud Deployment

This project is successfully configured for deployment using:

- Render
- Railway MySQL
- Docker

---

# 🔧 Installation

## Clone Repository

```bash
git clone https://github.com/USERNAME/MediStore.git
```

---

## Navigate to Project

```bash
cd MediStore
```

---

## Install Dependencies

```bash
composer install
```

---

## Configure Environment

Rename

```
env
```

to

```
.env
```

Configure:

```
app.baseURL=

database.default.hostname=

database.default.database=

database.default.username=

database.default.password=

database.default.port=
```

---

## Start Local Server

```bash
php spark serve
```

Open

```
http://localhost:8080
```

---

# 🗄️ Database

Import SQL

```
medistore.sql
```

using

- phpMyAdmin
- Railway MySQL

---

# 📁 Important Directories

| Directory | Purpose |
|------------|----------|
| app/Controllers | Business Logic |
| app/Models | Database Models |
| app/Views | UI Templates |
| app/Config | Application Configuration |
| public | Public Assets |
| writable | Cache, Logs, Sessions |

---

# 🔐 Authentication Flow

```
User

↓

Register

↓

Login

↓

Dashboard

↓

Browse Medicines

↓

Add to Cart

↓

Upload Prescription

↓

Checkout

↓

Place Order

↓

Order Tracking
```

---

# 📦 Main Modules

✅ Authentication

✅ Medicine Catalog

✅ Shopping Cart

✅ Prescription Upload

✅ Order Management

✅ PDF Invoice

✅ User Dashboard

---

# 📈 Future Enhancements

- Payment Gateway Integration
- Email Notifications
- SMS Alerts
- Admin Analytics Dashboard
- Inventory Management
- AI Medicine Recommendation
- Live Chat Support
- OTP Verification
- Multi-language Support
- Dark Mode

---

# 🧪 Testing

Run

```bash
php spark test
```

---

# 📋 Requirements

- PHP 8.2+
- Composer
- Apache
- MySQL
- Docker (Optional)

---

# 👨‍💻 Developer

**Sakshi Bhosale**

GitHub:
https://github.com/sakshibhosale582

---

# 📄 License

This project is licensed under the MIT License.

---

# ⭐ If you like this project

Give this repository a ⭐ on GitHub.

---

## 💡 Project Highlights

- Built using CodeIgniter 4 MVC Architecture
- Dockerized for Cloud Deployment
- Railway Cloud Database Integration
- Render Deployment Ready
- Responsive UI
- Secure Authentication
- Prescription Upload System
- PDF Invoice Generation
- Clean MVC Structure
- Production Ready
