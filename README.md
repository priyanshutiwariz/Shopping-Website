# TechStore — Modern E-Commerce Website

A complete, production-ready full-stack shopping website built with PHP, MySQL, HTML5, CSS3, and Vanilla JavaScript. Features a modern, Apple-like UI with dark/light mode, responsive design, and secure authentication.

## 🚀 Features

### Core Functionality
- **Secure Authentication**: User registration/login with password hashing, prepared statements, and session management
- **Product Management**: Admin CRUD operations (add/edit/delete products with categories and images)
- **Shopping Cart**: Session-based cart with add/update/remove items, dynamic totals
- **Checkout System**: Order processing with DB storage and order summaries
- **Search & Filter**: Real-time product search and category filtering
- **Contact System**: Customer inquiries stored in database

### UI/UX Excellence
- **Modern Design**: Clean, minimal aesthetic inspired by Apple products
- **Dark/Light Mode**: Toggle with localStorage persistence
- **Responsive Layout**: Mobile-first design with smooth animations
- **Interactive Elements**: Hover effects, toast notifications, loading animations
- **Typography**: Inter font for professional look

### Technical Stack
- **Frontend**: HTML5, CSS3 (custom properties, flexbox, grid), Vanilla JavaScript
- **Backend**: PHP 7+ (procedural with modular structure)
- **Database**: MySQL (InfinityFree compatible)
- **Security**: Prepared statements, input escaping, CSRF protection via sessions

## 📁 Project Structure

```
TechStore/
├── index.php          # Homepage with hero and featured products
├── products.php       # Product catalog with search/filter
├── product_add.php    # Admin: Add new products
├── product_edit.php   # Admin: Edit existing products
├── product_delete.php # Admin: Delete products
├── admin.php          # Admin dashboard
├── cart.php           # Shopping cart
├── checkout.php       # Order checkout
├── login.php          # User login
├── register.php       # User registration
├── logout.php         # Session logout
├── about.php          # About page
├── contact.php        # Contact form
├── db.php             # Database connection module
├── assets/
│   ├── style.css      # Modern CSS with themes
│   └── script.js      # Interactive JavaScript
├── sql/
│   ├── schema.sql     # Database schema
│   └── sample_data.sql # Sample users and products
└── uploads/           # Product image uploads (future)
```

## 🛠 Installation & Setup

### Local Development
1. **Clone/Download** the project to your local machine
2. **Start PHP Server**:
   ```bash
   cd /path/to/TechStore
   php -S localhost:8000
   ```
3. **Database Setup**:
   - Install MySQL (via Homebrew: `brew install mysql`)
   - Create database: `CREATE DATABASE techstore;`
   - Import schema: `mysql techstore < sql/schema.sql`
   - Import sample data: `mysql techstore < sql/sample_data.sql`
4. **Update Credentials**: Edit `db.php` with your local DB details
5. **Visit**: http://localhost:8000

### InfinityFree Deployment
1. **Create Account**: Sign up at InfinityFree.net
2. **Create Database**: Use control panel to create MySQL database
3. **Upload Files**: FTP all project files to `htdocs/` directory
4. **Configure Database**: Edit `db.php` with InfinityFree DB credentials
5. **Import SQL**: Use phpMyAdmin to run `schema.sql` and `sample_data.sql`
6. **Set Permissions**: Ensure `uploads/` is writable (chmod 755)
7. **Launch**: Your site is live!

## 👤 Default Accounts

- **Admin**: admin@techstore.com (login to access admin panel)
- **Test User**: johndoe@example.com or janedoe@example.com

## 🎨 Customization

### Themes
- Toggle dark/light mode via the 🌙 button in navbar
- Customize colors in `assets/style.css` using CSS custom properties

### Products
- Add/edit products via admin panel
- Images use Unsplash URLs (replace with your own upload system if needed)

### Database
- Modify schema in `sql/schema.sql`
- Add more sample data in `sql/sample_data.sql`

## 🔒 Security Features

- **SQL Injection Protection**: All queries use prepared statements
- **Password Security**: bcrypt hashing with `password_hash()`
- **Session Management**: Secure PHP sessions
- **Input Validation**: Server-side validation on all forms
- **XSS Prevention**: `htmlspecialchars()` on all outputs

## 📱 Responsive Design

- Mobile-first approach
- Breakpoints: 768px, 1024px
- Touch-friendly interactions
- Optimized for all screen sizes

## 🚀 Performance

- Lightweight vanilla JavaScript (no frameworks)
- Minimal CSS (no preprocessors)
- Efficient PHP/MySQL queries
- Image optimization via Unsplash CDN

## 🤝 Contributing

This is a complete project, but feel free to:
- Add payment integration (Stripe, PayPal)
- Implement user profiles
- Add product reviews/ratings
- Enhance admin features

## 📄 License

This project is for educational purposes. Use responsibly.

---

**Built with ❤️ for modern web development**


Notes
- This project uses plain PHP and mysqli for portability on free hosts.
- For security hardening (production), add CSRF tokens and restrict admin endpoints.
