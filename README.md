# Lenkov Luxury Hotel Booking System

## Project Overview

A comprehensive hotel booking management system integrated with M-Pesa payment gateway for seamless online transactions. This system enables customers to browse available rooms, make bookings, and complete payments through M-Pesa.

## Technologies Used

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

- User Registration and Authentication
- Room Browsing and Selection
- Online Booking System
- M-Pesa Payment Integration
- Booking Management
- Check-in and Check-out Functionality
- Responsive Design for Mobile Devices

## Installation Guide

### Prerequisites

- XAMPP / WAMP / LAMP server
- PHP 7.0 or higher
- MySQL 5.6 or higher
- Git (optional)

### Step-by-Step Installation

1. Clone the repository
```bash
git clone https://github.com/YOUR_USERNAME/LenkovLuxuryHotel.git

Copy the project to your web server directory

For XAMPP: C:/xampp/htdocs/

For WAMP: C:/wamp/www/

For LAMP: /var/www/html/

Configure Database

Open phpMyAdmin

Create a new database named hotel_booking_system

Import the database_schema.sql file

Configure Database Connection

Copy db.example.php to db.php

Update database credentials in db.php

Configure M-Pesa Integration

Copy mpesa.example.php to mpesaPayment.php

Add your M-Pesa API credentials from Daraja portal

Start the web server and MySQL service

Access the application

Open browser and navigate to: http://localhost/LenkovLuxuryHotel/

### Project Structure

LenkovLuxuryHotel/
├── index.html              # Home page
├── about.html              # About us page
├── rooms.html              # Rooms listing page
├── contact.html            # Contact information
├── login.html              # User login page
├── register.html           # User registration page
├── bookings.html           # User bookings page
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
├── database_schema.sql     # Database structure
└── rooms images/           # Room images directory

## Environment Variables Required
The following files need to be configured with your local credentials:

db.php - Database connection settings

mpesaPayment.php - M-Pesa API credentials

## Security Considerations
Database credentials are excluded from version control

M-Pesa API keys are excluded from version control

Passwords are hashed using PHP's password_hash function

Session management for authenticated routes

Prepared statements used for database queries

## Usage Guide
Register a new account using the registration page

Login with your credentials

Browse available rooms

Select a room and click Book Now

Enter your phone number and check-in/out dates

Complete M-Pesa payment when prompted

View your bookings in the bookings page

# Troubleshooting
## Common Issues
### Database Connection Error

Verify MySQL service is running

Check credentials in db.php

M-Pesa Payment Failed

Confirm API credentials are correct

Ensure sufficient funds in M-Pesa account

Check internet connection

Login Issues

Verify registration was successful

Check email and password case sensitivity