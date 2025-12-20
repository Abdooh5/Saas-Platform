# Multi-Tenant SaaS API – Laravel

## 📌 Description

This project is a **Multi-Tenant SaaS Backend API** built with **Laravel**, designed to support multiple companies with secure data isolation, role-based authorization, and scalable business rules.

Each company can manage its own users and projects while ensuring strict access control and clean API responses.

---

## 🚀 Features

-   Multi-Tenant Architecture (Company-based isolation)
-   Token Authentication using Laravel Sanctum
-   Authorization using Policies & Gates
-   Role-based access control (Admin / Member)
-   Business rules (Project limits per company)
-   Soft Delete & Restore
-   Clean API Resources
-   Pagination, Search & Sorting
-   RESTful API design

---

## 🏗 Architecture Overview

-   **Company**
    -   Has many Users
    -   Has many Projects
-   **User**
    -   Belongs to Company
    -   Has Role (Admin / Member)
-   **Project**
    -   Belongs to Company
    -   Soft deletable

All API requests are scoped by the authenticated user’s company.

---
## Architecture Diagram

The following diagram shows the multi-tenant SaaS architecture and request flow:

[Architecture Diagram](diagram.png)
---

## 🔐 Authentication

-   Laravel Sanctum (Token-based)
-   Each request must include:

```
Authorization: Bearer {token}
```

---

## 🛡 Authorization

-   Laravel Policies & Gates
-   Ownership and permissions handled centrally
-   Examples:
    -   Only company members can access projects
    -   Only admins can delete projects
    -   Project creation limited per company

---

## 📊 Business Rules

-   Each company has a maximum number of projects
-   Project creation is blocked when the limit is reached
-   Business rules enforced via Policies

---

## 📂 API Endpoints (Sample)

| Method | Endpoint                   | Description             |
| ------ | -------------------------- | ----------------------- |
| POST   | /api/register              | Register user & company |
| POST   | /api/login                 | Login                   |
| GET    | /api/projects              | List projects           |
| POST   | /api/projects              | Create project          |
| PUT    | /api/projects/{id}         | Update project          |
| DELETE | /api/projects/{id}         | Soft delete project     |
| POST   | /api/projects/{id}/restore | Restore project         |

---

## 🧪 Testing

-   Tested using Postman
-   Supports multiple scenarios:
    -   Authorized access
    -   Unauthorized access
    -   Cross-company access prevention

---

## 🛠 Tech Stack

-   Laravel 12
-   PHP 8+
-   MySQL
-   Laravel Sanctum

---

## 📈 Future Enhancements

-   Subscription plans
-   API versioning
-   Audit logs
-   Notifications

---

## 👨‍💻 Author

Abdalsalam Arif barbood
abdoohbarbood@gmail.com
https://www.linkedin.com/in/abdalsalam-barbood-91a759378/
