# 🌱 E-Waste Management System (Laravel)

A comprehensive web application for managing electronic waste disposal with role-based access control for administrators, collectors, and citizens.

## 📋 Table of Contents
- [Features](#features)
- [Tech Stack](#tech-stack)
- [Installation](#installation)
- [Configuration](#configuration)
- [Database Structure](#database-structure)
- [User Roles](#user-roles)
- [API Documentation](#api-documentation)
- [Screenshots](#screenshots)
- [Testing](#testing)
- [Deployment](#deployment)
- [Contributing](#contributing)
- [License](#license)

## ✨ Features

### 👤 **User (Citizen) Features**
- ✅ Dashboard with request statistics
- ✅ Submit e-waste pickup requests
- ✅ Track request status in real-time
- ✅ View/Edit/Cancel pending requests
- ✅ Awareness & guidelines page
- ✅ Profile management

### 🚛 **Collector Features**
- ✅ Dashboard with assigned pickups
- ✅ View today's pickup schedule
- ✅ Mark requests as collected
- ✅ Add collection remarks
- ✅ View pickup details

### 🛠️ **Admin Features**
- ✅ Comprehensive dashboard with analytics
- ✅ Manage device categories
- ✅ Approve/Reject pickup requests
- ✅ Assign collectors to requests
- ✅ User management (activate/deactivate)
- ✅ Role assignment (User ↔ Collector)
- ✅ Request status updates
- ✅ Reports and insights

### 🔐 **System Features**
- ✅ Role-based authentication (3 roles)
- ✅ Secure password management
- ✅ Email verification (optional)
- ✅ Real-time notifications
- ✅ Flash message system
- ✅ Mobile-responsive design
- ✅ Form validation
- ✅ CSRF protection

## 🛠️ Tech Stack

**Backend:**
- Laravel 10.x
- PHP 8.1+
- MySQL/PostgreSQL

**Frontend:**
- Tailwind CSS 3.x
- Vanilla JavaScript
- Alpine.js for interactivity
- Font Awesome icons

**Development Tools:**
- Composer (PHP dependency management)
- NPM (Frontend dependencies)
- Git (Version control)

## 🚀 Installation

### Prerequisites
- PHP 8.1 or higher
- Composer
- Node.js & NPM
- MySQL 5.7+ or PostgreSQL
- Web server (Apache/Nginx)

### Step-by-Step Installation

1. **Clone the repository**
```bash
git clone https://github.com/yourusername/ewaste-management-system.git
cd ewaste-management-system
```

2. **Install PHP dependencies**
```bash
composer install
```

3. **Install JavaScript dependencies**
```bash
npm install
npm run build
```

4. **Configure environment**
```bash
cp .env.example .env
php artisan key:generate
```

5. **Update .env file**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ewaste_db
DB_USERNAME=root
DB_PASSWORD=

APP_NAME="E-Waste Management"
APP_URL=http://localhost:8000
```

6. **Run migrations and seeders**
```bash
php artisan migrate --seed
```

7. **Start development server**
```bash
php artisan serve
```

Visit `http://localhost:8000` in your browser.

## ⚙️ Configuration

### Default Login Credentials
- **Admin**: `admin@ewaste.com` / `password`
- **Collector**: `collector@ewaste.com` / `password`
- **User**: `user@ewaste.com` / `password`

### Email Configuration (Optional)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@ewaste.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### File Upload (Optional for profile pictures)
```env
FILESYSTEM_DISK=public
```

## 🗄️ Database Structure

### Core Tables
1. **users** - User accounts with roles
2. **roles** - Available roles (admin, collector, user)
3. **role_user** - User-role relationships
4. **categories** - E-waste device categories
5. **ewaste_requests** - Pickup requests
6. **request_status_logs** - Request status history

### Database Schema
```sql
-- Sample schema visualization
users
├── id
├── name
├── email
├── password
├── phone
├── address
├── is_active
├── last_login_at
└── timestamps

roles
├── id
├── name (admin, collector, user)
└── timestamps

ewaste_requests
├── id
├── user_id
├── collector_id (nullable)
├── category_id
├── device_condition
├── quantity
├── pickup_address
├── preferred_pickup_date
├── status (pending, approved, assigned, collected, recycled, rejected)
├── user_note
├── admin_remark
├── collector_remark
└── timestamps
```

## 👥 User Roles

### 1. **Admin**
- Full system access
- Manage all users and roles
- Approve/reject requests
- Assign collectors
- View reports and analytics

### 2. **Collector**
- View assigned pickups
- Update pickup status
- Add collection remarks
- View pickup details
- Cannot delete/edit requests

### 3. **User (Citizen)**
- Submit pickup requests
- Track request status
- View/Edit/Cancel pending requests
- Access awareness materials
- Update profile

## 📊 API Documentation

### Authentication Endpoints
```
POST    /login           - User login
POST    /register        - User registration
POST    /logout          - User logout
POST    /forgot-password - Password reset request
```

### User Endpoints
```
GET     /user/dashboard           - User dashboard
GET     /user/awareness           - Awareness page
GET     /user/requests            - List user requests
POST    /user/requests            - Create new request
GET     /user/requests/{id}       - View request
PUT     /user/requests/{id}       - Update request
DELETE  /user/requests/{id}       - Delete request
GET     /profile                  - Edit profile
PUT     /profile                  - Update profile
PUT     /profile/password         - Change password
```

### Collector Endpoints
```
GET     /collector/dashboard      - Collector dashboard
GET     /collector/requests       - Assigned requests
POST    /collector/requests/{id}/collect - Mark as collected
GET     /collector/requests/{id}/details - Request details
```

### Admin Endpoints
```
GET     /admin/dashboard          - Admin dashboard
GET     /admin/categories         - List categories
POST    /admin/categories         - Create category
PUT     /admin/categories/{id}    - Update category
DELETE  /admin/categories/{id}    - Delete category
GET     /admin/requests           - All requests
GET     /admin/requests/{id}      - Request details
POST    /admin/requests/{id}/assign - Assign collector
POST    /admin/requests/{id}/status - Update status
GET     /admin/users              - List users
PUT     /admin/users/{id}         - Update user
DELETE  /admin/users/{id}         - Delete user
POST    /admin/users/{id}/assign-role - Assign role
```

## 📸 Screenshots

### Dashboard Views
| Admin Dashboard | Collector Dashboard | User Dashboard |
|----------------|-------------------|---------------|
| ![Admin Dashboard](screenshots/admin-dashboard.png) | ![Collector Dashboard](screenshots/collector-dashboard.png) | ![User Dashboard](screenshots/user-dashboard.png) |

### Key Pages
| Login Page | Request Form | User Management |
|-----------|-------------|----------------|
| ![Login](screenshots/login.png) | ![Request Form](screenshots/request-form.png) | ![User Management](screenshots/user-management.png) |

## 🧪 Testing

### Run Tests
```bash
# Unit tests
php artisan test

# Feature tests
php artisan test --testsuite=Feature

# Specific test
php artisan test --filter=UserRegistrationTest
```

### Test Coverage
- Authentication tests
- Role permission tests
- Request flow tests
- Form validation tests
- Database relationship tests

## 🚢 Deployment

### Production Requirements
1. Secure server (HTTPS)
2. Database backups
3. Environment optimization
4. Monitoring setup

### Deployment Steps
```bash
# 1. Clone on server
git clone https://github.com/yourusername/ewaste-management-system.git

# 2. Install dependencies
composer install --optimize-autoloader --no-dev
npm install --production
npm run build

# 3. Set permissions
chmod -R 775 storage bootstrap/cache

# 4. Optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 5. Set up supervisor for queues (if using)
# 6. Configure cron jobs
```

### Environment Variables for Production
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=production_db
DB_USERNAME=secure_user
DB_PASSWORD=strong_password

# Security
SESSION_DRIVER=database
SESSION_LIFETIME=120
```

## 🤝 Contributing

1. **Fork the repository**
2. **Create a feature branch**
```bash
git checkout -b feature/amazing-feature
```
3. **Commit your changes**
```bash
git commit -m 'Add some amazing feature'
```
4. **Push to the branch**
```bash
git push origin feature/amazing-feature
```
5. **Open a Pull Request**

### Development Guidelines
- Follow PSR-12 coding standards
- Write tests for new features
- Update documentation
- Use meaningful commit messages
- Keep code clean and maintainable

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🙏 Acknowledgments

- Laravel Framework
- Tailwind CSS
- Font Awesome
- All contributors

## 📞 Support

For support, email: support@ewaste.com or open an issue in the GitHub repository.

## 🌍 Environmental Impact

This system helps promote proper e-waste disposal, contributing to:
- Reduced environmental pollution
- Conservation of natural resources
- Prevention of toxic material leakage
- Promotion of the circular economy

**Made with ❤️ for a cleaner planet**

*Remember: Every device recycled is a step towards a greener Earth!*
