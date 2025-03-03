# EAV

---

## Architecture Overview

The project follows a modular architecture with separation of concerns to ensure maintainability and flexibility. It
consists of the following components:

1. **Domains**:
    - `User`: Manages users data (first name, last name, email, password).
    - `Project`: Manages projects data (name, status) and supports dynamic attributes via EAV.
    - `Timesheet`: Manages timesheets data (task name, date, hours) linked to users and projects.
    - `Attribute` and `AttributeValue`: Manage dynamic attributes system for projects.

2. **Controllers**: Handle API requests and interact with application services.

3. **Contracts**: Contracts illustrates database repository interactions.
4. **Repositories**: Concrete implementation of repository blueprints.
5. **Filters**: Responsible for mapping Http query into DB eloquent query.
6. **Model**: Core Domain Object and Database Entity representation.
7. **Request**: Responsible to separate application input data validation from Controllers.
8. **Resources**: Transformation layer that sits between domain and presentation layer

---

## Requirements

- PHP 8.3 or higher
- [Composer](https://getcomposer.org/) for dependency management
- MySQL or MariaDB
- Docker (for containerized development)

---

## Installation

### With Docker (Recommended)

1. Clone the repository:
    ```bash
    git clone https://github.com/mahmmoudmohammed/EAV.git
    ```

2. Navigate to the project directory:
    ```bash
    cd EAV
    ```

3. Run Project and update the database credentials:
    ```bash
    make install
    ```

4. Now copy generated keys, open `.env` file past keys `PASSPORT_PERSONAL_ACCESS_CLIENT_ID`
   `PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET`

5. Start the Docker containers:
    ```bash
    make up
    ```

6. Access the application at:
    ```
    http://localhost:8090/
    ```

---

## API Documentation

### Authentication

#### Register a New User

- **Endpoint**: `POST /api/register`
- **Request**:
    ```json
    {
        "first_name": "John",
        "last_name": "Doe",
        "email": "john.doe@example.com",
        "password": "password@123"
    }
    ```
- **Response**:
    ```json
    {
        "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9...",
        "data": {
            "id": 1,
            "first_name": "John",
            "last_name": "Doe",
            "email": "john.doe@example.com",
            "created_at": "john.doe@example.com",
            "updated_at": "john.doe@example.com"
        }
    }
    ```

#### Login

- **Endpoint**: `POST /api/login`
- **Request**:
    ```json
    {
        "email": "john.doe@example.com",
        "password": "password@123"
    }
    ```
- **Response**:
    ```json
    {
        "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9...",
        "data": {
            "id": 1,
            "first_name": "John",
            "last_name": "Doe",
            "email": "john.doe@example.com"
        }
    }
    ```

#### Logout

- **Endpoint**: `POST /api/logout`
- **Response**:
    ```json
    {
        "message": "Logged out successfully"
    }
    ```

---

### Projects

#### Filter Projects by Attributes

- **Endpoint**: `GET /api/projects?filters[department]=IT&filters[start_date]=2023-10-01`
- **Response**:
    ```json
    [
        {
            "id": 1,
            "name": "New Project",
            "status": "active",
            "attributes": [
                {
                    "name": "department",
                    "value": "IT"
                },
                {
                    "name": "start_date",
                    "value": "2023-10-01"
                }
            ]
        }
    ]
    ```

---

## License

This project is open-source and available under the GNU License.

---
