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

The application is heavily compartmentalized to provide absolute security and highly specialized, dedicated workflows for three intrinsic user classes: **Students (Étudiants)**, **Supervisors (Encadrants)**, and **Administrators (Admins)**. Every class possesses strictly defined digital boundaries and capabilities.

### 🎓 1. The Student Portal (Espace Étudiant)
The student ecosystem is built for seamless academic submission, engagement, and gamification:
- **Project Submission Engine (`ajouter_projet.php`):** Students can securely upload detailed project proposals, specifying metadata such as Title, Description, Category, and Type (Internship/module), along with secure file binary uploads.
- **Personal Dashboard (`mes_projets.php`):** Real-time monitoring of project states (Pending, Validated, Refused), allowing students to track their academic trajectory instantly.
- **Advanced Query System (`recherche_projets.php`):** A robust, multi-parameter search engine enabling students to mine the project database using complex filters (Year, Module, Keyword, Type).
- **Gamified Academic Engagement:** A qualitative engagement metric allowing peers to **Like (❤️)** projects, fostering a highly interactive academic community and surfacing exceptional work.
- **Automated Certificate Issuance (`generer_certificat.php`):** Upon project validation, the platform dynamically synthesizes and provisions cryptographically secure, downloadable PDF certificates proving project completion.

### 🔬 2. The Supervisor Interface (Espace Encadrant)
Supervisors act as the gatekeepers of academic quality, provided with powerful curation tools:
- **Centralized Oversight Dashboard:** Immediate visibility into all assigned projects, alongside an unassigned pool, presenting a unified queue of pending academic work.
- **Deep Inspection & Assessment (`voir_projet.php`):** Supervisors dissect project details, download source files, and review comprehensive student abstracts.
- **Rigorous Validation Protocol:** Supervisors possess the authority to execute binary state-machine transitions: **Validate (Approve)** or **Refuse** submissions dynamically.
- **Granular Mentoring Engine (`ajouter_remarque.php`):** Supervisors can inject contextual, qualitative remarks/feedback directly into projects, while concurrently assigning a strict quantitative grade (Note out of 20).

### � 3. The Administrator Command Center (Espace Admin)
Administrators orchestrate the entire platform from a high-level analytics dashboard:
- **Global Telemetry & Analytics:** Real-time extraction and visualization of platform health metrics, tracking the absolute volume of incoming projects, registered students, and active supervisors.
- **Project State Tracking:** Macro-level monitoring of the academic pipeline, visualizing the distribution of Validated, Pending, and Refused projects across the entire institution.
- **Leaderboard Integration:** Continuous aggregation of the **Top 5 Most Liked Projects**, providing administrators pristine insight into trending analytical topics and student excellence.

### 🔐 4. Advanced Role-Based Authentication Engine
- **Multi-Entity Login & Registration:** Secure portal distinguishing between the three core roles at entry.
- **Cryptographic Password Hashing:** Utilizes modern `password_hash` capabilities for optimal baseline security.
- **Strict Session Fortification:** Maintains persistent, isolated sessions (`session_start()`) ensuring unauthorized lateral movement across role boundaries is rigorously denied.

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
