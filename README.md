# 🔐 Auth Service (Laravel 12 + JWT + Docker)

This service handles **user authentication** using **Laravel 12** and **JWT with RSA keys**. It provides endpoints for **registration**, **login**, **authenticated user data**, and **public key sharing** for secure communication with other services (e.g., `upload-service`).

---

## 🛠 Tech Stack

- Laravel 12  
- PHP 8.4  
- MySQL 8  
- JWT (with RSA keys)  
- Docker & Docker Compose  
- PHPUnit for automated tests

---

## 🚀 Quick Start

### 1. Clone the project

```bash
git clone https://your-repo-url/auth-service.git
cd auth-service
```

### 2. Generate JWT keys (RSA)

```bash
mkdir keys
openssl genpkey -algorithm RSA -out keys/jwt_private.key -pkeyopt rsa_keygen_bits:2048
openssl rsa -pubout -in keys/jwt_private.key -out keys/jwt_public.key
```

### 3. Create `.env` file

```bash
cp .env.example .env
```

Then configure the `.env` file:

```env
APP_NAME=AuthService
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=auth_db
DB_USERNAME=root
DB_PASSWORD=root

JWT_ALGO=RS256
JWT_PRIVATE_KEY=file:///var/www/html/keys/jwt_private.key
JWT_PUBLIC_KEY=file:///var/www/html/keys/jwt_public.key
```

### 4. Run with Docker Compose

```bash
docker-compose up --build
```

This will:

- Install Composer dependencies  
- Run database migrations  
- Run automated tests  
- Start the Laravel development server on port `8000`

---

## 📡 API Endpoints

| Method | Endpoint          | Middleware   | Description                  |
|--------|-------------------|--------------|------------------------------|
| POST   | `/api/register`   | –            | Register a new user          |
| POST   | `/api/login`      | –            | Login and receive JWT token  |
| GET    | `/api/me`         | `auth:api`   | Get current authenticated user |
| GET    | `/api/public-key` | –            | Get the JWT RSA public key   |

---

## ✅ Run Tests

To manually run the tests inside the container:

```bash
docker-compose exec auth-service php artisan test
```

---

## 🔑 JWT Keys

RSA keys used to sign and verify JWT tokens:

- Keys directory: `keys/`
- `jwt_private.key`: Used to **sign** the JWT
- `jwt_public.key`: Used by other services to **verify** the token signature

---

## 📁 Project Structure (important files)

```
auth-service/
├── app/
│   └── Http/
│       └── Controllers/
│           └── AuthController.php
├── routes/
│   └── api.php
├── keys/
│   ├── jwt_private.key
│   └── jwt_public.key
├── Dockerfile
├── docker-compose.yml
├── tests/
│   └── Feature/
│       └── AuthTest.php
```

---

## 🧪 Development Status

- [x] User registration  
- [x] User login  
- [x] JWT generation with RSA private key  
- [x] Public key sharing  
- [x] Automated tests  
- [x] Integration with `upload-service` 
