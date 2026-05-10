# TravelLoop Backend API

All endpoints return JSON and expect POST (for create/update/delete) or GET (for list/read/search) requests.

## Auth

- `backend/auth.php?action=register`
  - POST JSON: `full_name`, `email`, `password`

- `backend/auth.php?action=login`
  - POST JSON: `email`, `password`

- `backend/auth.php?action=logout`

- `backend/auth.php?action=status`

## Trips

- `backend/trips.php?action=create`
  - POST JSON: `name`, `destination`, `start_date`, `end_date`, `travelers`, `budget`, `description`, `cover_photo`, `status`

- `backend/trips.php?action=list`

- `backend/trips.php?action=get&trip_id={id}`

- `backend/trips.php?action=update`
  - POST JSON: `trip_id`, `name`, `destination`, `start_date`, `end_date`, `travelers`, `budget`, `description`, `cover_photo`, `status`

- `backend/trips.php?action=delete`
  - POST JSON: `trip_id`

## Profile

- `backend/profile.php?action=load`
- `backend/profile.php?action=update`
  - POST JSON: `full_name`, `phone`, `language`, `bio`, `public_profile`, `email_notifications`, `dark_mode`
- `backend/profile.php?action=delete`

## Notes

- `backend/notes.php?action=create`
  - POST JSON: `title`, `body`, `tag`, `trip_id`

- `backend/notes.php?action=list`
- `backend/notes.php?action=get&note_id={id}`
- `backend/notes.php?action=update`
  - POST JSON: `note_id`, `title`, `body`, `tag`
- `backend/notes.php?action=delete`
  - POST JSON: `note_id`

## Itinerary

- `backend/itinerary.php?action=save`
  - POST JSON: `trip_id`, `title`, `summary`, `stops`
  - `stops` format: array of objects containing `city`, `arrival_date`, `departure_date`, and `activities`

- `backend/itinerary.php?action=load&itinerary_id={id}`
- `backend/itinerary.php?action=share&token={public_token}`

## Budget

- `backend/budget.php?action=save`
  - POST JSON: `trip_id`, `total_budget`, `spent_amount`, `notes`

- `backend/budget.php?action=get&trip_id={id}`

## Search

- `backend/search.php?q={query}`

## Admin

- `backend/admin.php`

## Setup

1. Import `TravelLoop.sql` into phpMyAdmin.
2. Put this project in `xampp/htdocs`.
3. Visit `http://localhost/OdooHackathon/index.html`.
4. Update database credentials in `backend/config.php` if needed.
