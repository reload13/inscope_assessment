# Project Name

## Description

InScope assesment - Project management

## Installation

Follow these steps to set up the project on your local environment using Laravel Sail.

### Prerequisites

Ensure that you have the following installed on your system:
- Docker (for running Laravel Sail)
- Composer
- Node.js & NPM

### Setup

1. **Clone the Repository**

   ```bash
   git clone https://github.com/your-username/your-repository.git
   cd your-repository
    ```

2. **Install Dependencies**

   ```bash
   composer install
   ./vendor/bin/sail composer install
    ```

3. **Copy .env.example to .env**

   ```bash
   cp .env.example .env
    ```
4. **Update .env File**

   ```bash
    DB_CONNECTION=mysql
    DB_HOST=mysql
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=sail
    DB_PASSWORD=password
    ```
5. **Start Sail Containers**

   ```bash
    ./vendor/bin/sail up --build
   ```
   or if it's not the first time running
   ```bash
   ./vendor/bin/sail up
    ```
6. **Generate Application Key**

   ```bash
    ./vendor/bin/sail artisan key:generate
    ```
7. **Run Migrations**

   ```bash
    ./vendor/bin/sail artisan migrate
    ```
8. **Seed the Database**

   ```bash
    ./vendor/bin/sail artisan db:seed
    ```
9. **Install NPM Dependencies**

   ```bash
    sail npm install
    ```
10. **Install NPM Dependencies**

    ```bash
    sail npm run dev
    ```

### After those steps, you can navigate to

```bash
    http://localhost
```

The database seeder creates two users:

1. **Admin User**  
   - **Email:** `admin@example.com`  
   - **Password:** `password`  
   - **Role:** `admin`

2. **Moderator User**  
   - **Email:** `moderator@example.com`  
   - **Password:** `password`  
   - **Role:** `moderator`
