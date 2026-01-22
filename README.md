#  Cat Shop – Dynamic eShop

A dynamic eShop web application developed using **PHP, MySQL, HTML, CSS and JavaScript**.  
The project was created as a semester project for a postgraduate program at the University of Western Attica, focusing on dynamic content generation, user authentication and shopping cart functionality.

---

##  Features

- Product browsing for all visitors
- User authentication (Register / Login / Logout)
- Products organized by categories
- Category filter with dropdown menu
- Add to cart (only for logged-in users)
- Shopping cart:
  - Increase / decrease quantity
  - Remove products
- Checkout process:
  - Cart conversion to orders
  - Order items storage
  - Simulated card payment form
- Session-based cart handling
- Responsive layout with CSS
- Data stored in a relational MySQL database

---

## Technologies Used

- **Backend:** PHP (PDO)
- **Database:** MySQL
- **Frontend:** HTML, CSS, JavaScript
- **Icons:** Font Awesome & Heroicons (SVG)
- **Server:** XAMPP

---

##  Database Structure

- `users`
- `categories`
- `products`
- `orders`
- `order_items`

---

##  Authentication Rules

- Visitors can browse products and categories
- Only authenticated users can:
  - Add products to cart
  - Access the cart
  - Complete checkout

---

##  How to Run the Project

1. Install **XAMPP**
2. Clone the repository into: C:\xampp\htdocs\
3.  Import the database `.sql` file into **phpMyAdmin**
4.  Update database credentials in: includes/db.php
5.  Start **Apache** and **MySQL**
6. Open the browser and go to: http://localhost/eshop

7. ##  Notes

- Payment process is simulated (no real transactions)
- The project focuses on functionality and structure rather than real-world security
