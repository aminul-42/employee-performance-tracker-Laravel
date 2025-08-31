# Employee Perfomance Tracker
A Laravel-based application for managing employee details, attendance, and work logs. This system is designed for administrators to track employee presence, task progress, and generate reports, with a user-friendly dashboard for insights.
# Features

## Employee Management:

CRUD operations for employee details (name, email, role, status, profile picture, phone number, salary, join date).
View employee list with pagination and status indicators.


## Attendance Tracking:

Log daily attendance (check-in/out, status: Present, Absent, Late, Half-day).
Calculate worked hours automatically.
Filter attendance by employee and date range.
Export attendance reports to Excel or PDF.


## Work Logs:

Record tasks with descriptions, hours spent, and progress (Not Started, In Progress, Completed).
Link work logs to attendance records (optional).
Filter work logs by employee and date range.


# Admin Dashboard:

Visualize employee details, overall work progress, and attendance metrics.
Highlight the best employee (most worked hours/completed tasks) and least active employee (most absences).
Display charts for attendance (total worked hours) and work log distribution (status breakdown).


# Security:

Admin-only access to all features via admin.auth middleware.
Authentication for admin login/logout.



# Tech Stack

Backend: Laravel 11
Frontend: Blade templates, Tailwind CSS, Chart.js
Database: MySQL (configurable for other databases supported by Laravel)
Dependencies:
maatwebsite/excel for Excel exports
barryvdh/laravel-dompdf for PDF exports


# Screenshots

<picture>
  <source srcset="screenshots/ss1.png" media="(min-width: 800px)">
    <img src="path-to-your-image-fallback.jpg" alt="Fallback image">
</picture>

<picture>
  <source srcset="screenshots/ss2.png" media="(min-width: 800px)">
    <img src="path-to-your-image-fallback.jpg" alt="Fallback image">
</picture>
<picture>
  <source srcset="screenshots/ss3.png" media="(min-width: 800px)">
    <img src="path-to-your-image-fallback.jpg" alt="Fallback image">
</picture>
<picture>
  <source srcset="screenshots/ss4.png" media="(min-width: 800px)">
    <img src="path-to-your-image-fallback.jpg" alt="Fallback image">
</picture>
<picture>
  <source srcset="screenshots/ss5.png" media="(min-width: 800px)">
    <img src="path-to-your-image-fallback.jpg" alt="Fallback image">
</picture>
<picture>
  <source srcset="screenshots/ss6.png" media="(min-width: 800px)">
    <img src="path-to-your-image-fallback.jpg" alt="Fallback image">
</picture>
   



For questions or support, contact aminulislamnur42@gmail.com or open an issue on GitHub.
