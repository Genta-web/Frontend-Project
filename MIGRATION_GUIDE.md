# Employee Database Migration Guide

This document explains the Laravel migration files created based on the `employee_db.sql` schema.

## Migration Files Created

### 1. `2025_07_08_000001_create_employees_table.php`
Creates the main employees table with the following structure:
- `id` - Auto-incrementing primary key
- `employee_code` - Unique employee identifier (nullable)
- `name` - Employee name (nullable)
- `email` - Employee email (nullable)
- `phone` - Employee phone number (nullable)
- `department` - Employee department (nullable)
- `position` - Employee position (nullable)
- `hire_date` - Date of hire (nullable)
- `status` - Employee status (enum: 'active', 'inactive', default: 'active')
- `created_at`, `updated_at` - Laravel timestamps

**Indexes:**
- Primary key on `id`
- Unique index on `employee_code`

### 2. `2025_07_08_000002_create_attendance_table.php`
Creates the attendance tracking table:
- `id` - Auto-incrementing primary key
- `employee_id` - Foreign key to employees table (nullable, cascade on delete)
- `date` - Attendance date (nullable)
- `check_in` - Check-in time (nullable)
- `check_out` - Check-out time (nullable)
- `status` - Attendance status (enum: 'present', 'sick', 'leave', 'absent', default: 'present')
- `notes` - Additional notes (text, nullable)
- `attachment_image` - Image attachment path (nullable)
- `created_at`, `updated_at` - Laravel timestamps

**Indexes:**
- Primary key on `id`
- Index on `employee_id`

**Foreign Keys:**
- `employee_id` references `employees(id)` with CASCADE delete

### 3. `2025_07_08_000003_create_work_logs_table.php`
Creates the work logs table:
- `id` - Auto-incrementing primary key
- `employee_id` - Foreign key to employees table (nullable, cascade on delete)
- `work_date` - Work date (nullable)
- `start_time` - Work start time (nullable)
- `end_time` - Work end time (nullable)
- `task_summary` - Summary of tasks performed (text, nullable)
- `attachment_image` - Image attachment path (nullable)
- `created_at`, `updated_at` - Laravel timestamps

**Indexes:**
- Primary key on `id`
- Index on `employee_id`

**Foreign Keys:**
- `employee_id` references `employees(id)` with CASCADE delete

### 4. `2025_07_08_000004_modify_users_table_for_employee_system.php`
Modifies the default Laravel users table to match the custom employee system:
- `id` - Auto-incrementing primary key
- `employee_id` - Foreign key to employees table (nullable, set null on delete, cascade on update)
- `username` - Unique username
- `password` - Hashed password
- `remember_token` - Laravel remember token (nullable)
- `role` - User role (enum: 'admin', 'hr', 'manager', 'employee', 'system', default: 'employee')
- `last_login` - Last login timestamp (nullable)
- `is_active` - Active status (boolean, default: true)
- `created_at`, `updated_at` - Laravel timestamps

**Indexes:**
- Primary key on `id`
- Index on `employee_id`
- Index on `username`
- Unique index on `username`

**Foreign Keys:**
- `employee_id` references `employees(id)` with SET NULL delete and CASCADE update

## Running the Migrations

### Prerequisites
1. Ensure your database is configured in `.env` file
2. Make sure the database exists (create it manually if using MySQL)

### Commands

1. **Run all migrations:**
   ```bash
   php artisan migrate
   ```

2. **Fresh migration (drops all tables and recreates):**
   ```bash
   php artisan migrate:fresh
   ```

3. **Run migrations with seeding:**
   ```bash
   php artisan migrate:fresh --seed
   ```

4. **Check migration status:**
   ```bash
   php artisan migrate:status
   ```

## Seeder

A seeder file `EmployeeSystemSeeder.php` has been created with sample data from the original SQL file:
- 4 sample employees
- 5 sample users with different roles

To run the seeder:
```bash
php artisan db:seed --class=EmployeeSystemSeeder
```

## Database Schema Verification

After running migrations, you can verify the database structure:

1. **Show all tables:**
   ```bash
   php artisan db:show
   ```

2. **Show specific table structure:**
   ```bash
   php artisan db:table employees
   php artisan db:table attendance
   php artisan db:table work_logs
   php artisan db:table users
   ```

## Migration Dependencies

The migrations are ordered to respect foreign key dependencies:
1. `employees` (no dependencies)
2. `attendance` (depends on employees)
3. `work_logs` (depends on employees)
4. `users` (depends on employees)

## Rollback

To rollback migrations:
```bash
php artisan migrate:rollback
```

To rollback specific number of migration batches:
```bash
php artisan migrate:rollback --step=2
```

## Notes

- All migrations use Laravel's Schema Builder for database-agnostic SQL generation
- Foreign key constraints are properly defined with appropriate cascade actions
- The custom users table replaces Laravel's default users table structure
- All nullable fields from the original SQL are preserved
- Enum values are maintained exactly as in the original schema
- Proper indexing is applied for performance optimization
