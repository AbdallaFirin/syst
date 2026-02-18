# Fire Safety Management System

A comprehensive web-based application designed to manage fire safety incidents, chemicals, and safety protocols for organizations.

## Key Features

- **Dashboard**: Real-time overview of incidents and safety metrics.
- **Incident Management**: Log and track fire incidents, causes, and resolutions.
- **Chemical Management**: Track hazardous chemicals, their locations, and expiration dates.
- **Location Management**: Manage places/locations within the organization.
- **Organization & Staff**: Manage organizational structure and staff members.
- **Reports**: Generate detailed reports on incidents and safety status.

## Technology Stack

- **Backend**: [Laravel 12](https://laravel.com)
- **Frontend**: [Vue.js 3](https://vuejs.org) with [Inertia.js](https://inertiajs.com)
- **Styling**: [Tailwind CSS](https://tailwindcss.com)

## Installation & Setup

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd syst
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment Setup**
   Copy the example environment file and configure your database settings:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   
4. **Database Migration**
   Run the database migrations to set up the schema:
   ```bash
   php artisan migrate
   ```

5. **Run the Application**
   Start the development server:
   ```bash
   npm run dev
   ```
   In a separate terminal, start the Laravel server:
   ```bash
   php artisan serve
   ```

## License

This software is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## For Your Presentation

This project is the Fire Safety Management System — a modular web application for logging and managing fire incidents, hazardous chemicals, places, staff, vehicles, and safety policies. The following notes and suggested walkthrough will help you present the system clearly and confidently.

- **Goal**: Explain how the system reduces risk by centralizing incident data, chemical inventories, and safety processes so organizations can quickly respond, learn, and improve safety.

- **High-level Architecture**: Laravel backend (API + web controllers) with Inertia.js + Vue 3 frontend and Tailwind CSS for UI. Core data models live in `app/Models` and are exposed via controllers under `app/Http/Controllers`.

- **Core Modules**:
   - **Incidents**: `FireIncident`, `IncidentCause`, `IncidentImage` — logging, investigation, and reporting.
   - **Chemicals**: `Chemical` — inventory, storage location, expiry tracking, and SDS references.
   - **Places & Categories**: `Place`, `PlaceCategory` — map organizational locations for faster response.
   - **Staff & Vehicles**: `Staff`, `Vehicle` — assign responsibilities and assets to incidents.
   - **Reports & Recommendations**: `Report`, `ReportRecommendation`, `ReportSection` — generate insights and follow-ups.

- **Quick Demo Script (5–7 minutes)**:
   1. Show the **Dashboard** — highlight real-time incident counts and critical metrics.
   2. Create a sample **Incident** (log cause, attach image, assign staff).
   3. Add a **Chemical** entry and show location/expiry alerts.
 4. Generate a **Report** for the incident and demonstrate exporting or sharing recommendations.

- **Setup Quick Commands** (run locally before demo):

   ```bash
   git clone <repo>
   cd Firesfty
   composer install
   npm install
   cp .env.example .env
   php artisan key:generate
   php artisan migrate --seed
   npm run dev
   php artisan serve --host=127.0.0.1 --port=8000
   ```

- **Presentation Slide Suggestions**:
   - Slide 1: Problem statement — why centralized fire safety matters.
   - Slide 2: Solution overview — the Fire Safety Management System (with architecture diagram).
   - Slide 3: Live demo — Dashboard → create incident → chemical → report.
   - Slide 4: Impact & metrics — reduced response time, improved compliance (sample KPIs).
   - Slide 5: Roadmap & next steps — integrations, mobile app, advanced analytics.

- **Talking Points (short)**:
   - Centralized repository of incidents and chemicals reduces duplication.
   - Structured reports turn incidents into actionable recommendations.
   - Role-based staff assignments speed up incident response.

- **Assets & Placeholders**:
   - Add screenshots to `resources/images/presentations/` and reference them in slides.
   - Consider recording a 2–3 minute screen capture of the demo to embed in slides.

- **FAQ (prepare answers)**:
   - "How is data exported?" — Reports can be generated and exported; show the report UI during demo.
   - "How do you manage sensitive chemical data?" — Explain access controls and policy records.
   - "Can this integrate with emergency dispatch?" — Discuss webhook or API extension points in Laravel.

- **Contacts & Next Steps**:
   - Add your presenter name and contact details to the slides and the `README.md` if desired.

If you want, I can also generate a slide deck (PowerPoint or PDF) with these slides and the demo script. Tell me which format you prefer and any branding or logos to include.
