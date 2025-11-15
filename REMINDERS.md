# Task Reminder System

This document explains the task reminder system implemented in the application.

## Overview

The task reminder system allows users to receive notifications about upcoming due dates and overdue tasks. Users can customize their reminder preferences, including when they want to be notified and at what time.

## Features

### 1. User Reminder Preferences

Users can configure their reminder preferences in their profile:

- **Enable/Disable Reminders**: Toggle all reminders on or off
- **Reminder Intervals**:
  - 1 day before due date
  - 3 days before due date
  - 1 week before due date
  - Overdue task reminders
- **Reminder Time**: Set the time of day when reminders are sent (default: 09:00)

### 2. Task-Level Reminder Control

Each task can have its own reminder setting:
- Enable or disable reminders for specific tasks
- This allows users to customize which tasks they want to be reminded about

### 3. Automated Notifications

The system automatically sends reminders based on:
- Scheduled console commands that run daily
- User preferences for reminder intervals
- Task due dates and completion status

## Implementation Details

### Database Schema

#### Users Table
New columns added to the users table:
- `reminder_enabled` (boolean): Global toggle for reminders
- `reminder_1_day` (boolean): Enable 1-day reminders
- `reminder_3_days` (boolean): Enable 3-day reminders
- `reminder_1_week` (boolean): Enable 1-week reminders
- `reminder_overdue` (boolean): Enable overdue reminders
- `reminder_time` (time): Time of day to send reminders

#### Tasks Table
New column added to the tasks table:
- `reminders_enabled` (boolean): Enable reminders for this specific task

### Console Commands

The `SendTaskReminders` command handles sending reminders:
- Runs daily at 09:00 for upcoming due dates
- Runs daily at 09:30 for overdue tasks
- Respects user preferences for reminder intervals

### Notification Service

The `NotificationService` class handles:
- Filtering tasks based on user preferences
- Sending notifications via email and database
- Logging reminder activity

### Notification Types

#### TaskDueReminder
Sent for:
- Tasks due in 1, 3, or 7 days
- Overdue tasks

Includes information:
- Task title and description
- Due date
- Priority level
- Days until due (or overdue)

## Scheduling

The reminder system uses Laravel's task scheduler:

```php
// Daily at 9:00 AM - Send task reminders for tasks due tomorrow
$schedule->command('tasks:send-reminders --days=1')->dailyAt('09:00');

// Daily at 9:00 AM - Send task reminders for tasks due in 3 days
$schedule->command('tasks:send-reminders --days=3')->dailyAt('09:00');

// Daily at 9:00 AM - Send task reminders for tasks due in 1 week
$schedule->command('tasks:send-reminders --days=7')->dailyAt('09:00');

// Daily at 9:30 AM - Send overdue task reminders
$schedule->command('tasks:send-reminders')->dailyAt('09:30');
```

## API Endpoints

### Get Reminder Settings
```
GET /reminders
```

Returns the current user's reminder settings.

### Update Reminder Settings
```
PATCH /reminders
```

Updates the current user's reminder settings.

Parameters:
- `reminder_enabled` (boolean)
- `reminder_1_day` (boolean)
- `reminder_3_days` (boolean)
- `reminder_1_week` (boolean)
- `reminder_overdue` (boolean)
- `reminder_time` (time, format: HH:MM)

## Frontend Components

### Profile Reminder Settings
Located in `resources/views/profile/partials/reminder-settings.blade.php`
- Toggle switches for all reminder preferences
- Time picker for reminder time
- AJAX form submission

### Task Form
Updated to include reminder toggle:
- Checkbox to enable/disable reminders for new tasks

### Task Card
Updated to show reminder status:
- Badge indicating if reminders are enabled for the task

### Edit Task Modal
Updated to include reminder toggle:
- Checkbox to enable/disable reminders for existing tasks

## Testing

The system includes comprehensive tests in `tests/Feature/TaskReminderTest.php`:

- Sending reminders for tasks due tomorrow
- Respecting user preference to disable reminders
- Respecting task-level reminder settings
- Sending overdue task reminders

## Future Improvements

Possible enhancements:
- Custom reminder intervals
- Different notification channels (SMS, push notifications)
- Reminder snooze functionality
- Recurring task reminders
- Integration with calendar applications