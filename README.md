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
