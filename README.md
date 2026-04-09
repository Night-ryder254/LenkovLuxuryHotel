# Lenkov Luxury Hotel Booking System

## Overview
Lenkov Luxury Hotel Booking System is a comprehensive web-based application designed to streamline hotel reservations and payment processing. The system integrates with the M-Pesa payment gateway via the Daraja API, enabling customers to browse available rooms, make bookings, and complete secure online transactions.

## Technologies

### Frontend
- HTML5  
- CSS3  
- JavaScript (ES6)  

### Backend
- PHP 7.x or higher  

### Database
- MySQL  

### APIs
- Daraja API (M-Pesa Integration)  

## Features
- User registration and authentication  
- Room browsing and selection  
- Online booking and reservation management  
- Integrated M-Pesa payment processing  
- Check-in and check-out functionality  
- Responsive design optimized for mobile devices  

## Installation Guide

### Prerequisites
- XAMPP / WAMP / LAMP server  
- PHP 7.0 or higher  
- MySQL 5.6 or higher  
- Git (optional)  

### Steps
1. **Clone the repository**
   ```bash
   git clone https://github.com/YOUR_USERNAME/LenkovLuxuryHotel.git
   ```
2. **Copy project files** to your web server directory:  
   - XAMPP: `C:/xampp/htdocs/`  
   - WAMP: `C:/wamp/www/`  
   - LAMP: `/var/www/html/`  

3. **Configure the database**  
   - Open phpMyAdmin  
   - Create a new database named `hotel_booking_system`  
   - Import `database_schema.sql`  

4. **Set up database connection**  
   - Copy `db.example.php` → `db.php`  
   - Update credentials in `db.php`  

5. **Configure M-Pesa integration**  
   - Copy `mpesa.example.php` → `mpesaPayment.php`  
   - Add your Daraja API credentials  

6. **Start services**  
   - Launch Apache and MySQL  

7. **Access the application**  
   - Navigate to: `http://localhost/LenkovLuxuryHotel/`  

## Project Structure
```
LenkovLuxuryHotel/
├── index.html              # Home page
├── about.html              # About us page
├── rooms.html              # Rooms listing page
├── contact.html            # Contact page
├── login.html              # User login
├── register.html           # User registration
├── bookings.html           # User bookings
├── app.js                  # Frontend JavaScript
├── hotel-booking-styles.css # Stylesheet
├── db.php                  # Database connection (excluded from git)
├── db.example.php          # Database template
├── mpesaPayment.php        # M-Pesa integration (excluded from git)
├── mpesa.example.php       # M-Pesa template
├── login.php               # Login processor
├── register.php            # Registration processor
├── fetchRooms.php          # API for room data
├── fetchBookings.php       # API for booking data
├── bookRoom.php            # Booking processor
├── checkIn.php             # Check-in processor
├── checkOut.php            # Check-out processor
├── logout.php              # Logout processor
├── database_schema.sql     # Database schema
└── rooms images/           # Room images
```

## Environment Variables
- **db.php** → Database connection settings  
- **mpesaPayment.php** → M-Pesa API credentials  

## Security Considerations
- Database credentials excluded from version control  
- M-Pesa API keys excluded from version control  
- Passwords hashed using `password_hash()`  
- Session management for authenticated routes  
- Prepared statements used for database queries  

## Usage
1. Register a new account  
2. Login with your credentials  
3. Browse available rooms  
4. Select a room and click **Book Now**  
5. Enter phone number and check-in/out dates  
6. Complete payment via M-Pesa  
7. View bookings on the **Bookings** page  

## Troubleshooting

### Database Connection Error
- Ensure MySQL service is running  
- Verify credentials in `db.php`  

### M-Pesa Payment Failure
- Confirm API credentials are correct  
- Ensure sufficient funds in M-Pesa account  
- Check internet connection  

### Login Issues
- Verify registration was successful  
- Check email and password case sensitivity  

---