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
git clone https://github.com/amirrezasajadiyan/auth-service.git
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
DB_HOST=auth-db
DB_PORT=3306
DB_DATABASE=auth_db
DB_USERNAME=root
DB_PASSWORD="root"

JWT_ALGO=RS256
JWT_PRIVATE_KEY=file:///var/www/html/keys/jwt_private.key
JWT_PUBLIC_KEY=file:///var/www/html/keys/jwt_public.key
```

### 4. Run with Docker Compose


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



## 📁 Suggested Project Structure

```
microservices-root/
├── auth-service/
│ ├── Dockerfile
│ ├── docker-compose.auth.yml
│ └── ...
├── upload-service/
│ ├── Dockerfile
│ ├── docker-compose.upload.yml
│ └── ...
├── docker-compose.yml ← connects both services together
```

## 🐳 Root `docker-compose.yml`

```yaml
services:
  auth-service:
    build:
      context: ./auth-service
    container_name: auth-service
    ports:
      - "8000:8000"
    volumes:
      - ./auth-service:/var/www/html
    depends_on:
      - auth-db
    networks:
      - microservice

  upload-service:
    build:
      context: ./upload-service
    container_name: upload-service
    ports:
      - "8001:8001"
    volumes:
      - ./upload-service:/var/www/html
    depends_on:
      - auth-service
    networks:
      - microservice

  auth-db:
    image: mysql:8
    container_name: auth-db
    environment:
      MYSQL_ROOT_PASSWORD: root
      MYSQL_DATABASE: auth_db
    ports:
      - "3307:3306"
    networks:
      - microservice

networks:
  microservice:
    driver: bridge
```



# Build and start all services
docker-compose up --build -d

# Watch logs (optional)
docker-compose logs -f

This will:

    Start auth-service (port 8000)
    Start upload-service (port 8001)
    Start MySQL DB (port 3307)

🧪 2. Run Tests

docker-compose exec auth-service php artisan test
docker-compose exec upload-service php artisan test

🧱 3. Access Containers (for debugging)

docker-compose exec auth-service bash
docker-compose exec upload-service bash

4. Database Setup (Auth Service)
# Access auth-service container
docker-compose exec auth-service bash

# Run Laravel migrations
php artisan migrate --seed

Use tools like Postman , curl , or Thunder Client  to test:
Auth Service (port 8000):

    Register : POST /api/register
    Login : POST /api/login → returns JWT token


Upload Service (port 8001):

    Upload Image : POST /api/upload
    Add Authorization: Bearer <your-jwt-token> header
    Send a multipart/form-data image file in the request body.


6. Rebuild or Restart
   If you make changes to code:

# Rebuild services
docker-compose build

# Restart specific service
docker-compose restart auth-service
docker-compose restart upload-service

7. Clean Up
# Stop all services
docker-compose down

# Stop and remove volumes (e.g., database data)
docker-compose down -v
