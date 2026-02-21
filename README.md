<div align="center">
  <h1 align="center">🌟 Smart Talib 🌟</h1>
  <p align="center">
    <strong>An Enterprise-Grade, Multi-Role Academic Project Management Ecosystem</strong>
  </p>
  <p align="center">
    <img src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP" />
    <img src="https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL" />
    <img src="https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white" alt="HTML5" />
    <img src="https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white" alt="CSS3" />
    <img src="https://img.shields.io/badge/License-MIT-green.svg?style=for-the-badge" alt="License" />
  </p>
</div>

<br />

## 📖 Prologue

Welcome to **Smart Talib**, a highly robust, secure, and scalable academic project management platform engineered specifically for the ENSAK (École Nationale des Sciences Appliquées de Kénitra) administration and student body. 

In modern academic environments, overseeing end-of-year projects, managing student-supervisor (encadrant) interactions, and maintaining an organized repository of academic achievements is exceptionally complex. **Smart Talib** resolves this by introducing a rigorously constructed Model-View-Controller (MVC) architecture that seamlessly orchestrates multi-tiered role-based access control (RBAC), real-time project validation protocols, and automated cryptographic certificate generation.

This is not just a portal—it is a comprehensive, state-of-the-art solution designed to handle high concurrency, ensure data integrity, and streamline the academic lifecycle.

---

## 🚀 Core Functionalities & Technical Offerings

The application is heavily compartmentalized to provide absolute security and dedicated workflows for three primary user classes: **Students (Étudiants)**, **Supervisors (Encadrants)**, and **Administrators (Admins)**.

### 🔐 1. Advanced Role-Based Authentication Engine
- **Multi-Entity Login & Registration:** Secure portal distinguishing between students, supervisors, and admins.
- **Cryptographic Password Hashing:** Utilizes modern `password_hash` capabilities for optimal data security against brute-force attacks.
- **Session Fortification:** Maintains persistent, isolated sessions (`session_start()`) ensuring unauthorized lateral movement across the application is strictly denied.

### 📚 2. Lifecycle Project Management (CRUD)
- **Project Submission (`ajouter_projet.php`):** Students can securely upload detailed project proposals, complete with metadata and abstract documentation.
- **Project Interaction & Analytics (`like_projet.php`):** A qualitative engagement metric allowing peers or faculty to upvote/like projects, fostering an environment of academic excellence.
- **Rigorous Validation Pipeline (`valider_refuser_projet.php`):** Supervisors and admins wield the authority to review, approve, or reject submissions via a secure state-machine transition.

### 💬 3. Interactive Feedback Mechanisms
- **Direct Academic Mentoring (`ajouter_remarque.php`):** Enables supervisors to append detailed, context-aware remarks to student projects, facilitating real-time asynchronous mentoring and feedback loops.

### 📜 4. Automated Certificate Generation
- **Dynamic Certification Issuance (`generer_certificat.php`):** Upon project completion and validation, the application dynamically generates cryptographically verifiable, personalized achievement certificates for students.

---

## 🧬 Architectural Tree & Codebase Topology

The repository follows a strict, enterprise-standard MVC paradigm to enforce decoupling between the user interface, business logic, and database layer.

```text
├── assets/                  # Static assets (images, global CSS/JS)
├── certificats/             # Secure directory for generated student certificates
├── config/                  # Configuration monolith
│   └── db.php               # PDO MySQL connection stream with Exception handling
├── controllers/             # Core Business Logic & Processors
│   ├── ajouter_projet.php   # Project injection handler
│   ├── ajouter_remarque.php # Feedback processing gateway
│   ├── auth.php             # Unified Authentication dispatcher
│   ├── generer_certificat.php # Certificate generation engine
│   ├── inscription.php      # User onboarding and validation
│   ├── like_projet.php      # Engagement metric incrementor
│   ├── logout.php           # Secure session destruction
│   └── valider_refuser_projet.php # Administrative state controller
├── libs/                    # 3rd-party dependencies and internal core libraries
├── models/                  # Data access layer and advanced ORM logic
├── uploads/                 # Highly secure, sanitized upload directory for project files
└── views/                   # Presentation Layer (UI/UX)
    ├── admin/               # Restricted Administrator interfaces
    ├── encadrant/           # Dedicated Supervisor dashboards
    ├── etudiant/            # Dynamic Student portals
    ├── index.php            # Global application entrypoint
    ├── inscription.php      # Front-end registration interface
    ├── login.php            # Front-end authentication interface
    └── auth.php             # Local view auth processor
```

---

## 🛠️ Technological Stack

The application harnesses a lightweight yet immensely powerful stack, chosen for bare-metal performance and rapid execution:

- **Backend:** `PHP 8.x` - Utilized for its robust server-side processing and seamless dynamic rendering capabilities.
- **Database:** `MySQL` / `MariaDB` - Structured relational data storage, interfaced securely via PHP Data Objects (`PDO`) to completely neutralize SQL injection vectors.
- **Frontend / Client-Side:** `HTML5`, `CSS3` - Hand-crafted, responsive UI ensuring accessibility and a premium UX across all devices without the bloat of heavy JS frameworks.

---

## ⚙️ Deployment & Execution Protocol

To launch this application in a local or production environment, follow these rigorous steps:

1. **Clone the Repository:**
   ```bash
   git clone https://github.com/malak-maziane/smart-talib.git
   cd smart-talib
   ```

2. **Database Provisioning:**
   - Launch your MariaDB/MySQL server.
   - Create a database named `projets_ensak`.
   - Import the corresponding `.sql` dump (ensure all `etudiant`, `encadrant`, and `admin` tables are generated).

3. **Configure Environment:**
   - Navigate to `config/db.php`.
   - Ensure the PDO DSN `mysql:host=localhost;dbname=projets_ensak` aligns with your database credentials (default: `root` with no password).

4. **Launch Server:**
   - Deploy via Apache/Nginx or utilize PHP's built-in rapid development server:
   ```bash
   php -S localhost:8000
   ```
   - Access the platform securely at `http://localhost:8000/views/index.php`.

---

## ⚖️ License

Distributed under the MIT License. See `LICENSE` for more information.

<div align="center">
  <i>Architected with precision for the future of academic management.</i>
</div>
