# Errors Fixed

- [x] Created missing UserController.php with login, register, logout, and dashboard methods.
- [x] Added 'isAdmin' gate in AuthServiceProvider to check user role for admin middleware.
- [x] Fixed class name in AdminEventController.php from EventController to AdminEventController to avoid naming conflict.
- [x] Added Auth::check() conditions in navigation.blade.php to prevent accessing user properties on null.

# Verification
- [x] Ran `php artisan route:list` successfully without errors.
