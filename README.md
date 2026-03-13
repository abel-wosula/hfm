# HFM Project – Technical Documentation & Handover Guide

## Project Overview

HFM is a **full-stack web application** built on a decoupled architecture, with the frontend and backend communicating via GraphQL APIs.

The backend is developed using **Laravel**, while the frontend is built using **Vue.js**. The connection between the two layers is handled through **Apollo Client**, which communicates with the backend GraphQL endpoint.

The application also includes an **administration panel built using Filament**, allowing administrators to manage system content and configurations through a graphical interface.

This document provides technical details required for installation, maintenance, and continued development of the system.

---

# Technology Stack

## Backend

* PHP
* Laravel Framework
* GraphQL API
* MySQL Database
* Filament Admin Panel
* Composer

## Frontend

* Vue.js
* Apollo Client
* GraphQL
* JavaScript
* Node.js
* npm

## Development Environment

* XAMPP (Apache + MySQL)
* phpMyAdmin
* Git
* GitHub repository

---

# System Architecture

The system follows a **headless architecture** where the frontend and backend operate independently.

```
Vue.js Frontend
       │
       │ GraphQL Queries/Mutations
       │
Apollo Client
       │
       │
GraphQL API (Laravel)
       │
       │
Laravel Application
       │
       │
MySQL Database
```

## Responsibilities of Each Layer

### Frontend (Vue.js)

Handles:

* User interface rendering
* State management
* API communication through GraphQL
* Form handling
* Data presentation

### Backend (Laravel)

Handles:

* Business logic
* Database access
* Authentication
* GraphQL query resolution
* Data validation
* API security

### Database (MySQL)

Stores:

* users
* configuration settings
* uploaded files
* services and portfolios
* content sections

### Admin Panel (Filament)

Provides administrative interfaces for:

* managing website content
* managing users
* uploading records
* managing settings

---

# Project Directory Structure

## Backend

```
backend/
│
├── app/
├── bootstrap/
├── config/
├── database/
│   ├── migrations/
│   └── seeders/
├── graphql/
├── public/
├── resources/
├── routes/
├── storage/
└── vendor/
```

Key folders:

### app/

Contains core Laravel application code including:

* models
* controllers
* services
* business logic

### graphql/

Contains GraphQL schema definitions, queries, and mutations.

### database/

Contains:

* migrations
* database structure definitions
* seeders (if present)

### routes/

Defines application routing.

---

## Frontend

```
frontend/
│
├── src/
│   ├── components/
│   ├── views/
│   ├── apollo/
│   ├── router/
│   ├── store/
│   └── assets/
│
├── public/
├── package.json
└── vite.config.js
```

### components/

Reusable Vue components.

### views/

Page-level Vue components.

### apollo/

Contains configuration for the Apollo GraphQL client.

### router/

Frontend routing configuration.

---

# Installation Guide

## System Requirements

Backend:

* PHP 8+
* Composer
* Laravel
* MySQL
* XAMPP

Frontend:

* Node.js
* npm

---

# Backend Installation

### 1 Clone repository

```
git clone https://github.com/abel-wosula/hfm.git
```

### 2 Navigate to backend

```
cd studio/backend
```

### 3 Install dependencies

```
composer install
```

### 4 Configure environment

Copy the example environment file.

```
cp .env.example .env
```

Edit database credentials inside `.env`.

Example:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=studio
DB_USERNAME=root
DB_PASSWORD=
```

### 5 Generate application key

```
php artisan key:generate
```

### 6 Run migrations

```
php artisan migrate
```

### 7 Start backend server

```
php artisan serve
```

Default server:

```
http://localhost:8000
```

---

# Frontend Installation

Navigate to frontend directory.

```
cd frontend
```

Install dependencies.

```
npm install
```

Run development server.

```
npm run dev
```

Default frontend URL:

```
http://localhost:5173
```

---

# GraphQL API

The frontend communicates with the backend through **GraphQL**.

### Endpoint

```
http://localhost:8000/graphql
```

### Example Query

```
query {
  users {
    id
    name
    email
  }
}
```

### Example Mutation

```
mutation {
  createUser(name: "John", email: "john@email.com") {
    id
    name
  }
}
```

### GraphQL Responsibilities

* retrieving application data
* performing updates
* executing mutations
* enabling frontend communication

---

# Database Documentation

Database name used during development:

```
studio
```

## Main Tables

From the current development database, the following tables exist:

```
cache
cache_locks
events
homepage_sections
homepage_section_items
migrations
personal_access_tokens
portfolios
services
sessions
settings
teams
uploadrecords
upload_records
users
```

Total tables: **15**

---

## Table Descriptions

### users

Stores system users.

Typical fields:

```
id
name
email
password
created_at
updated_at
```

---

### settings

Stores application configuration values.

Examples may include:

* site configuration
* feature flags
* system options

---

### services

Stores service offerings displayed on the website.

---

### portfolios

Stores portfolio items or projects displayed on the frontend.

---

### homepage_sections

Stores homepage sections for dynamic content management.

---

### homepage_section_items

Stores items belonging to homepage sections.

---

### upload_records / uploadrecords

Stores metadata about uploaded files.

---

### sessions

Handles Laravel session storage.

---

### personal_access_tokens

Used for API authentication tokens.

---

### migrations

Tracks executed database migrations.

---

# Filament Admin Panel

The admin interface is built using **Filament**.

Filament is a Laravel admin panel framework used for building administrative dashboards.

## Purpose

The admin panel allows system administrators to manage:

* users
* services
* portfolio entries
* homepage sections
* system settings
* uploaded records

## Access

Typical route:

```
/admin
```

Example:

```
http://localhost:8000/admin
```

## Filament Components

Filament uses:

* Resources
* Forms
* Tables
* Actions

These are typically located in:

```
app/Filament/
```

---

# Development Workflow

Typical workflow for adding new features.

### Backend

1 Create database migration
2 Create Laravel model
3 Create GraphQL resolver
4 Register query/mutation in schema

### Frontend

1 Create Vue component
2 Create GraphQL query or mutation
3 Connect Apollo client
4 Bind data to UI

---

# Known Issues / Incomplete Areas

The project is being handed over following **contract termination**, therefore the following areas may require further work.

Possible areas requiring completion:

* Additional API optimization
* Extended frontend validation
* Improved error handling in GraphQL
* Further UI improvements
* Production deployment configuration
* Performance tuning

---

# Important Developer Notes

The system architecture relies heavily on the following technologies:

* Laravel framework
* Vue.js
* GraphQL
* Apollo Client

Developers without professional experience in **Laravel or modern JavaScript frameworks** may find extending the system difficult.

Recommended skillset for the next developer:

* Laravel backend development
* Vue.js
* GraphQL APIs
* Apollo Client
* MySQL database design

---

# Handover Notice

This project is being delivered in its **current state following termination of the development contract**.

The system is functional in a development environment but may require additional work before being deployed to a production environment.

This documentation reflects the system as it exists at the time of handover.

Further improvements, testing, or architectural modifications may be required depending on the future requirements of the project.

---

