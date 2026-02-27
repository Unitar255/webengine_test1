/*SEED SQL*/

-- Seed services
INSERT INTO services (name, price, duration_minutes) VALUES
('Basic Service', 120.00, 60),
('Engine Diagnostics', 150.00, 60),
('Brake Inspection', 80.00, 45),
('Aircond Service', 180.00, 90),
('Tyre Replacement (per tyre)', 90.00, 30);

-- (Optional) Create a demo customer with a placeholder hash
-- Use register page instead for real accounts.
-- Example of setting admin after registration:
-- UPDATE users SET role='admin' WHERE email='your_admin_email@example.com';