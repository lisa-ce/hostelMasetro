# 🍽️ NUST Hostel Menu Predictor

A full-stack web application that helps students view hostel meal schedules and stay updated on daily menu changes.

---

## 📌 Overview
Students in university hostels often rely on WhatsApp groups to find out what meals are being served. This project provides a centralized and reliable platform that:

- Displays the weekly rotating hostel menu
- Shows today’s and upcoming meals
- Allows real-time updates when meals change due to ingredient availability

### 🔄 Menu Rotation Cycle

The system follows a 3-week rotating cycle:

- **Week 1 → Nicolleth**
- **Week 2 → Rosy**
- **Week 3 → Meriam**

---

## 🚀 Features
### 👨‍🎓 Student Features
- View today’s menu
- View the next 3 days of meals
- Browse weekly menu
- See labels like:
  - “Today’s Menu”
  - “Tomorrow’s Menu”

### 🔧 Admin Features (Planned)
- Admin login
- Update meals for specific dates
- Override default menu when changes occur
- Add reasons for changes

---

## 🧱 Tech Stack

### Frontend
- HTML
- CSS
- JavaScript

### Backend
- Java
- Spring Boot
- REST API

### Database
- Microsoft SQL Server

---

## 🗄️ Database Design

**Tables:**
- `menu_cycle` → stores the 3-week rotation  
- `menu_item` → stores meals for each day  
- `menu_override` → stores real-time meal changes  
- `admin_user` → stores admin credentials  

---

