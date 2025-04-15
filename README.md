# 🛠️ API - Daptee Test

Esta es una API RESTful desarrollada con Laravel 12

---

## ✅ Requisitos

Asegurate de tener instaladas las siguientes versiones:

-   **PHP**: 8.4
-   **Composer**: 2.8.8
-   **Laravel**: 12
-   **MySQL**: Cualquier versión compatible

---

## ⚙️ Configuración inicial

### 1. Clonar el proyecto

```bash
git clone <repositorio>
cd <carpeta-del-proyecto>
```

### 2. Instalar dependencias

```bash
composer install
```

### 3. Configurar entorno

Copiá el contenido del archivo .env.example a .env.

Editá el archivo .env con tus credenciales de base de datos:

```bash
DB_DATABASE=daptee_test
DB_USERNAME=root
DB_PASSWORD=
```

Descomentar las siguientes lineas:

```bash
DB_HOST=127.0.0.1
DB_PORT=3306
```

### 4. Habilitar PDO en PHP

En el archivo php.ini, descomentá la siguiente línea (quitando el ;):

```bash
extension=pdo_mysql
```

### 🗃️ Base de datos

### 1. Crear base de datos

En tu cliente MySQL, creá una base de datos llamada:

```bash
CREATE DATABASE daptee_test;
```

### 2. Ejecutar migraciones y seeders

Esto va a crear las tablas necesarias y poblar algunos datos de ejemplo.

```bash
php artisan migrate
php artisan db:seed
```

### ▶️ Levantar el servidor

```bash
php artisan serve
```

Accedé a la API desde:
http://127.0.0.1:8000/api

### 📬 Documentación de la API

Podés ver y probar todos los endpoints desde la colección de Postman:

👉 [Documentación completa Postman](https://documenter.getpostman.com/view/44085084/2sB2cbZdXS)

Ademas se encuentra un archivo Daptee-test.postman_collection.json, para poder importarlo en Postman
