# CookGenius Technical Documentation

## Table of Contents
- [Overview](#overview)
- [Technical Architecture](#technical-architecture)
- [Installation and Setup](#installation-and-setup)
- [API and Routes](#api-and-routes)
- [Database Structure](#database-structure)
- [Security](#security)
- [Testing](#testing)
- [Deployment](#deployment)
- [Maintenance](#maintenance)
- [Contributing](#contributing)
- [Support](#support)
- [License](#license)

## Overview

CookGenius is a web-based recipe management application developed in PHP. The application allows users to search, view, and manage cooking recipes through an intuitive interface while integrating with the Spoonacular API for recipe data.

## Technical Architecture

### Frontend Structure

Technologies used:
- HTML5
- CSS3 with modern features including CSS variables and Flexbox/Grid
- Vanilla JavaScript
- PHP templates for view rendering

Directory structure:
```
/public
  /css
	- styles.css
	- normalize.css
  /js
	- main.js
	- search.js
  /images
/templates
  - base.php
  - details.php
  - search.php
```

### Backend Structure

Technologies used:
- PHP 7.4+
- Composer for dependency management
- PostgreSQL database
- Spoonacular API integration

Directory structure:
```
/src
  /Controllers
	- RecipeController.php
	- UserController.php
  /Models
	- User.php
	- Recipe.php
	- SpoonacularAPI.php
  /Services
	- AuthenticationService.php
	- ViewManager.php
/config
  - routes.yaml
  - database.php
/core
  - Router.php
  - Kernel.php
/public
  - index.php
/vendor
```

## Installation and Setup

### Prerequisites
- PHP >= 7.4
- Composer
- PostgreSQL
- Web server (Apache/Nginx)
- Spoonacular API key

### Installation Steps

1. Clone the repository:
```bash
git clone https://github.com/YourUsername/CookGenius.git
cd CookGenius
```

2. Install dependencies:
```bash
composer install
```

3. Configure environment variables:
```bash
cp .env.example .env
# Edit .env with your database and API credentials
```

4. Set up the database:
```bash
# Using the provided SQL schema
psql -U your_username -d your_database < schema.sql
```

5. Start the development server:
```bash
php -S localhost:8000 -t public
```

## API and Routes

### Authentication Routes
- `GET /login` - Display login form
- `POST /login` - Process login
- `GET /register` - Display registration form
- `POST /register` - Process registration
- `GET /logout` - Log out user

### Recipe Routes
- `GET /` - Homepage with featured recipes
- `GET /recette/recherche` - Search recipes
- `GET /recette/{id}` - View recipe details
- `GET /user/favorites` - View user's favorite recipes
- `POST /recette/favorite/{id}` - Add recipe to favorites
- `DELETE /recette/favorite/{id}` - Remove recipe from favorites

### API Integration
The application integrates with the Spoonacular API using the following endpoints:
- Recipe search
- Recipe details
- Random recipes
- Complex recipe filtering

## Database Structure

### Tables

#### users
```sql
CREATE TABLE users (
	id SERIAL PRIMARY KEY,
	email VARCHAR(255) UNIQUE NOT NULL,
	password VARCHAR(255) NOT NULL,
	confirmation_token VARCHAR(64),
	is_confirmed BOOLEAN DEFAULT false,
	reset_token VARCHAR(64),
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

#### favorite_recipes
```sql
CREATE TABLE favorite_recipes (
	user_id INTEGER REFERENCES users(id),
	recipe_id INTEGER NOT NULL,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (user_id, recipe_id)
);
```

## Security

### Implemented Security Measures
- Password hashing using bcrypt
- Session-based authentication
- CSRF token protection
- SQL injection prevention using prepared statements
- XSS protection through output escaping
- Email verification for new accounts
- Rate limiting on API endpoints

### Authentication Flow
1. User registration with email verification
2. Secure password reset mechanism
3. Session management with secure cookie handling
4. Token-based API authentication

## Testing

### Test Structure
```
/tests
  /Unit
	- UserTest.php
	- RecipeTest.php
  /Integration
	- AuthenticationTest.php
	- RecipeControllerTest.php
  /Functional
	- SearchFlowTest.php
	- UserJourneyTest.php
```

### Running Tests
```bash
# Run all tests
./vendor/bin/phpunit

# Run specific test suite
./vendor/bin/phpunit --testsuite unit
```

## Deployment

### Production Server Requirements
- PHP 7.4+
- PostgreSQL 12+
- Nginx/Apache
- SSL certificate
- 2GB RAM minimum

### Deployment Steps
1. Set up production environment variables
2. Run database migrations
3. Optimize autoloader:
   ```bash
   composer install --optimize-autoloader --no-dev
   ```
4. Configure web server
5. Set up SSL
6. Configure caching

### Performance Optimization
- Implement page caching
- Configure OPcache
- Set up CDN for static assets
- Database query optimization

## Maintenance

### Regular Tasks
- Database backups (daily)
- Log rotation
- Security updates
- Performance monitoring

### Monitoring
- Error logging
- API usage tracking
- User activity monitoring
- Server resource monitoring

## Contributing

### Development Workflow
1. Fork the repository
2. Create a feature branch:
   ```bash
   git checkout -b feature/your-feature-name
   ```
3. Commit changes:
   ```bash
   git commit -m "Description of changes"
   ```
4. Push to your fork:
   ```bash
   git push origin feature/your-feature-name
   ```
5. Create a Pull Request

### Coding Standards
- PSR-12 coding style
- PHPDoc comments for all classes and methods
- Unit tests for new features
- Meaningful commit messages

## Support

### Documentation
- API documentation available at `/docs/api`
- User guide at `/docs/user-guide`
- Developer documentation at `/docs/dev`

### Getting Help
- GitHub Issues for bug reports
- Technical support via email: support@cookgenius.com
- Community forum: forum.cookgenius.com

## License

CookGenius is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

---

*Last updated: February 20, 2025*
