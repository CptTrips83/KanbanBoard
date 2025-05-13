# KanbanBoard Development Guidelines

This document provides guidelines and instructions for developing and testing the KanbanBoard application.

## Build and Configuration Instructions

### Environment Setup

1. **PHP Requirements**:
   - PHP 7.2.5 or higher
   - Required extensions: ctype, iconv

2. **Docker Setup**:
   - The project includes Docker configuration for development
   - Run `docker-compose up -d` to start the MariaDB database and phpMyAdmin
   - Database credentials are configured in `compose.yaml`

3. **Database Configuration**:
   - The application uses MariaDB in development
   - Database connection is configured in `config/packages/doctrine.yaml`
   - Environment variables for database connection are defined in `.env` or Docker environment

4. **Frontend Setup**:
   - The frontend is built with Vue.js 3, Vue Router, and Vuex
   - Bootstrap 5 is used for styling

### Installation

1. **Clone the repository**:
   ```bash
   git clone <repository-url>
   cd KanbanBoard
   ```

2. **Install PHP dependencies**:
   ```bash
   composer install
   ```

3. **Install JavaScript dependencies**:
   ```bash
   npm install
   ```

4. **Build the frontend assets**:
   ```bash
   npm run build
   ```

5. **Start the development server**:
   ```bash
   symfony server:start
   ```

## Testing Information

### Test Configuration

1. **PHPUnit Setup**:
   - Tests are configured in `phpunit.xml.dist`
   - Tests use an in-memory SQLite database by default
   - The DAMA Doctrine Test Bundle is used to wrap tests in transactions

2. **Test Environment**:
   - The test environment is configured in `.env.test`
   - Required environment variables for testing:
     ```
     DATABASE_URL="sqlite:///:memory:"
     MYSQL_DATABASE=test_db
     MYSQL_HOST=localhost
     MYSQL_USER=test_user
     MYSQL_PASSWORD=test_password
     MYSQL_PORT=3306
     ```

### Running Tests

1. **Run all tests**:
   ```bash
   vendor/bin/phpunit
   ```

2. **Run a specific test file**:
   ```bash
   vendor/bin/phpunit tests/path/to/TestFile.php
   ```

3. **Run tests with coverage report**:
   ```bash
   vendor/bin/phpunit --coverage-html coverage
   ```

### Writing Tests

1. **Test Structure**:
   - Tests are organized in the `tests` directory
   - API tests are in `tests/api`
   - System tests are in `tests/system`

2. **Base Test Classes**:
   - Extend `App\Tools\AbstractKernelTestCase` for tests that need database access
   - The base class sets up the entity manager and primes the database

3. **Example Test**:
   ```php
   <?php

   namespace system;

   use App\Entity\User;
   use App\Tools\AbstractKernelTestCase;

   class UserTest extends AbstractKernelTestCase
   {
       public function testUserCreation(): void
       {
           // Create a new user
           $user = new User();
           $user->setUsername('testuser');
           $user->setPassword('testpassword');
           $user->setApiToken('testapitoken');
           
           // Persist the user to the database
           $this->entityManager->persist($user);
           $this->entityManager->flush();
           
           // Retrieve the user from the database
           $retrievedUser = $this->entityManager->getRepository(User::class)->findOneBy(['username' => 'testuser']);
           
           // Assert that the user was created correctly
           $this->assertNotNull($retrievedUser);
           $this->assertEquals('testuser', $retrievedUser->getUsername());
           $this->assertEquals('testpassword', $retrievedUser->getPassword());
           $this->assertEquals('testapitoken', $retrievedUser->getApiToken());
           $this->assertContains('ROLE_USER', $retrievedUser->getRoles());
       }
   }
   ```

## Development Information

### Code Style and Quality

1. **Static Analysis**:
   - PHPStan is configured at level 6
   - Run static analysis with:
     ```bash
     vendor/bin/phpstan analyse
     ```

2. **Code Style**:
   - The project uses PHP-CS-Fixer for code style
   - Follow PSR-12 coding standards

### Project Structure

1. **Backend**:
   - Symfony 5.4 framework
   - Doctrine ORM for database access
   - Entity classes in `src/Entity`
   - Controllers in `src/Controller`
   - Services in `src/Service`

2. **Frontend**:
   - Vue.js 3 with Vue Router and Vuex
   - Components in `assets/components`
   - Pages in `assets/pages`
   - Layouts in `assets/layouts`
   - Webpack Encore for asset management

### Security

1. **Authentication**:
   - The application uses Symfony Security for authentication
   - Form login and API key authentication are supported
   - User entity implements `UserInterface` and `PasswordAuthenticatedUserInterface`

### API Development

1. **API Structure**:
   - The application provides a REST API
   - API endpoints are defined in controllers
   - The `ApiHelper` class provides utilities for converting entities to arrays and JSON
   - Builder classes are available for creating and modifying entities