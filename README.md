# Shopping Basket Test Exercise

This is a Laravel-based implementation of a shopping basket system that handles product management, delivery rules, and special offers.

## Technologies Used

- **Backend Framework**: Laravel 12.x
- **PHP Version**: 8.3
- **Database**: MySQL 8.0
- **Testing Framework**: Pest PHP
- **Static Analysis**: PHPStan
- **Containerization**: Docker & Docker Compose
- **Web Server**: Apache
- **Package Manager**: Composer
- **Build Tool**: Make

## Features

- Product catalog management
- Shopping basket functionality
- Delivery cost rules based on basket total
- Special offers (e.g., buy one get one half price)
- RESTful API endpoints for basket operations

## Product Catalog

The system supports the following products:
- Red Widget (R01) - £32.95
- Green Widget (G01) - £24.95
- Blue Widget (B01) - £7.95

## Delivery Rules

Delivery charges are calculated based on the basket total:
- Orders under £50: £4.95 delivery charge
- Orders between £50 and £90: £2.95 delivery charge
- Orders over £90: Free delivery

## Special Offers

The system implements the following special offer:
- Buy One Get One Half Price on Red Widgets (R01)

## API Endpoints

1. Initialize Basket
   - `POST /api/basket/init`
   - Initializes the basket with product catalog, delivery rules, and offers

2. Add Product
   - `POST /api/basket/add`
   - Adds a product to the basket by product code

3. Get Total
   - `GET /api/basket/total`
   - Calculates the total cost including delivery and applicable offers

## Development Tools

### Make Commands

The project includes several Make commands for common development tasks:

```bash
# Run tests
make test

# Run PHPStan analysis
make phpstan

# Run both tests and PHPStan
make check
```

### PHPStan

Static analysis is performed using PHPStan. The configuration is set to analyze the `app` directory. Run the analysis with:

```bash
make phpstan
```

## Docker Setup

The project is containerized using Docker and Docker Compose. The setup includes:

- PHP 8.3 with Apache
- MySQL 8.0
- Custom Apache configuration
- Volume mapping for development
- Network configuration

### Docker Services

- **App**: PHP 8.3 + Apache (Port 8001)
- **MySQL**: Database server (Port 3307)

### Docker Commands

```bash
# Start the containers
docker-compose up -d

# Stop the containers
docker-compose down

# Rebuild containers
docker-compose up -d --build
```

## Setup

1. Clone the repository
2. Install dependencies:
   ```bash
   composer install
   npm install
   ```
3. Copy `.env.example` to `.env` and configure your environment
4. Run migrations:
   ```bash
   php artisan migrate
   ```
5. Start the development server:
   ```bash
   php artisan serve
   ```

## Running Tests

The project uses Pest PHP for testing. Run the tests with:

```bash
php artisan test
```

## Test Cases

The test suite covers:
- Basket initialization
- Product addition
- Total calculation with and without offers
- Delivery charge calculations
- Validation of input data

## Requirements

- PHP 8.3 or higher
- Composer
- Node.js and NPM
- MySQL 8.0 or compatible database
- Docker and Docker Compose (for containerized setup)
