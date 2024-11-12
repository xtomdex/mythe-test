# MyTheresa Promotions API

## 1. Description

This project is a RESTful API built with Symfony, designed using Domain-Driven Design (DDD) principles and Hexagonal Architecture. Although the project currently has a single entity (`Product`) and a single endpoint (`/products`), it follows best practices for scalable, maintainable architecture. This design allows new features and entities to be added easily in the future with minimal refactoring.

### Project Structure

The application structure follows DDD principles, with a clear separation of concerns across different layers. Here’s a high-level overview of the folder structure:

```
src/
├── Shop/
│   ├── Application/        # Use cases
│   ├── Domain/             # Core business logic
│   ├── Infrastructure/     # Entities mapping and services implementation
│   ├── Test/               # Tests
│   └── UI/                 # Controllers
```

This architecture ensures that each layer is isolated, testable, and follows the Single Responsibility Principle. Business rules are encapsulated within the `Domain` layer, while the `Application` layer handles use cases. The `Infrastructure` layer provides implementations for external dependencies, and the `UI` layer manages HTTP requests and responses.

## 2. Requirements

To run this project, ensure you have the following tools installed:

- `make` (for simplified command execution)
- `docker` and `docker-compose` (for containerized environment)

## 3. Installation

To get started with the project, you can use a single command to set up and initialize the environment:

```bash
make init
```

### What 'make init' Does
The make init command will:

- Start the Docker containers for the application (docker-init).
- Run Composer to install dependencies (app-composer-install).
- Run database migrations for both development and test environments (app-migrations).
- Load initial fixture data for development (app-fixtures).
- Run the complete test suite with test data to verify the setup (app-test).
- Once make init is complete, the application will be running, and you can access it on http://localhost:8888.

### Additional Make Commands

#### Start and Stop the Application:
- **make up**: Start the Docker containers.
- **make down**: Stop the Docker containers without clearing volumes.
- **make restart**: Restart the Docker containers.
- **make docker-init**: Initialize Docker by stopping, clearing, pulling images, and starting containers.
#### Database and Migrations:
- **make app-migrations**: Run database migrations for both dev and test environments.
- **make app-fixtures**: Load data fixtures for the development environment.
- **make app-test-fixtures**: Load data fixtures specifically for the test environment.
#### Running Tests:
- **make app-test-all**: Run the entire test suite.
- **make app-test-unit**: Run only unit tests.

## 4. `/products` Endpoint

### Endpoint Description

The `/products` endpoint provides a list of products, optionally filtered by category or maximum price. Discounts are applied to the products based on specific rules:
- Products in the `boots` category receive a 30% discount.
- The product with SKU `000003` receives a 15% discount.
- If multiple discounts apply, the highest discount is used.

### Endpoint Details

- **URL**: `/products`
- **Method**: `GET`

### Query Parameters

- **`category`** (optional): Filters products by the specified category.
- **`priceLessThan`** (optional): Filters products with an original price less than or equal to the specified amount (in cents).

### Example Request

```http
GET /products?category=boots&priceLessThan=80000
```

### Response Structure

The response is a JSON object containing an array of products, each with a price structure that includes any discounts applied.

#### Example Response

```json
{
    "products": [
        {
            "sku": "000001",
            "name": "BV Lean leather ankle boots",
            "category": "boots",
            "price": {
                "original": 89000,
                "final": 62300,
                "discount_percentage": "30%",
                "currency": "EUR"
            }
        },
        {
            "sku": "000003",
            "name": "Ashlington leather ankle boots",
            "category": "boots",
            "price": {
                "original": 71000,
                "final": 60350,
                "discount_percentage": "15%",
                "currency": "EUR"
            }
        }
    ]
}
```

### Response Fields

- **`sku`**: Product SKU (unique identifier).
- **`name`**: Name of the product.
- **`category`**: Category of the product.
- **`price`**:
    - **`original`**: Original price in cents (before discounts).
    - **`final`**: Final price after applying the highest applicable discount.
    - **`discount_percentage`**: Discount percentage applied (if any), as a string with a `%` symbol.
    - **`currency`**: Currency of the price, always `EUR`.