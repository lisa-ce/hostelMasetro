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

## ⚙️ How It Works

1. The system determines the current week in the 3-week cycle  
2. It fetches the corresponding menu (**Nicolleth, Rosy, or Meriam**)  
3. It checks for any overrides for the current date  
4. If an override exists → show updated meal  
5. Otherwise → show default menu  

---

## 📡 API Endpoints (Planned)


GET /api/menu/today
GET /api/menu/week
POST /api/overrides
POST /api/auth/login


---

## 🛠️ Setup Instructions

### 1. Clone the repository
```bash
git clone https://github.com/your-username/hostel-menu-predictor.git
2. Set up the database
Open SQL Server
Run the provided SQL script
Ensure database name is: HostelMenuDB
3. Configure backend

In application.properties:

spring.datasource.url=jdbc:sqlserver://localhost:1433;databaseName=HostelMenuDB;encrypt=true;trustServerCertificate=true
spring.datasource.username=YOUR_USERNAME
spring.datasource.password=YOUR_PASSWORD
4. Run the backend

Run the Spring Boot application.

5. Open frontend

Open index.html in your browser.

📷 Screenshots

Add screenshots of your UI here.

🎯 Project Goals
Improve accessibility of hostel meal information
Reduce dependency on WhatsApp communication
Provide a scalable system for future expansion
📈 Future Improvements
Mobile app version
Push notifications for meal changes
Multi-hostel support
Analytics for meal trends
🧾 License

This project is for educational purposes.

#👤 Author

##Lisa Chikovore