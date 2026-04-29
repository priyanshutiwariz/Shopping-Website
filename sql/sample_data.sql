-- Sample data for TechStore

-- Insert sample users (admin + 2 users)
INSERT INTO users (username, email, password, is_admin) VALUES
('admin', 'admin@techstore.com', '$2y$10$exampleadminhash', 1),
('johndoe', 'john@example.com', '$2y$10$exampleuserhash', 0),
('janedoe', 'jane@example.com', '$2y$10$exampleuserhash2', 0);

-- Insert 15 sample products (tech/gadgets theme, placeholder images)
INSERT INTO products (name, price, description, image, category) VALUES
('Wireless Earbuds', 59.99, 'High-quality wireless earbuds with noise cancellation.', 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?auto=format&fit=crop&w=400&q=80', 'Audio'),
('Smart Watch', 129.99, 'Track your fitness and notifications with this sleek smart watch.', 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&w=400&q=80', 'Wearables'),
('Bluetooth Speaker', 39.99, 'Portable Bluetooth speaker with deep bass.', 'https://images.unsplash.com/photo-1465101046530-73398c7f28ca?auto=format&fit=crop&w=400&q=80', 'Audio'),
('Gaming Mouse', 49.99, 'Ergonomic gaming mouse with RGB lighting.', 'https://images.unsplash.com/photo-1519125323398-675f0ddb6308?auto=format&fit=crop&w=400&q=80', 'Accessories'),
('Mechanical Keyboard', 89.99, 'Tactile mechanical keyboard for fast typing.', 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?auto=format&fit=crop&w=400&q=80', 'Accessories'),
('4K Monitor', 299.99, 'Ultra HD 4K monitor for stunning visuals.', 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=crop&w=400&q=80', 'Displays'),
('VR Headset', 399.99, 'Immersive VR headset for gaming and experiences.', 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=400&q=80', 'Wearables'),
('Portable SSD', 109.99, 'Fast and compact portable SSD (1TB).', 'https://images.unsplash.com/photo-1519125323398-675f0ddb6308?auto=format&fit=crop&w=400&q=80', 'Storage'),
('Drone Camera', 499.99, 'Capture stunning aerial shots with this drone.', 'https://images.unsplash.com/photo-1465101046530-73398c7f28ca?auto=format&fit=crop&w=400&q=80', 'Cameras'),
('Smartphone Gimbal', 89.99, 'Stabilize your smartphone videos.', 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&w=400&q=80', 'Accessories'),
('Wireless Charger', 29.99, 'Fast wireless charging pad.', 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?auto=format&fit=crop&w=400&q=80', 'Accessories'),
('Action Camera', 199.99, 'Rugged action camera for adventures.', 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=400&q=80', 'Cameras'),
('Laptop Stand', 34.99, 'Aluminum laptop stand for better ergonomics.', 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=crop&w=400&q=80', 'Accessories'),
('Noise Cancelling Headphones', 149.99, 'Over-ear headphones with active noise cancellation.', 'https://images.unsplash.com/photo-1519125323398-675f0ddb6308?auto=format&fit=crop&w=400&q=80', 'Audio'),
('Smart Home Hub', 79.99, 'Control your smart devices with this hub.', 'https://images.unsplash.com/photo-1465101046530-73398c7f28ca?auto=format&fit=crop&w=400&q=80', 'Smart Home');

-- Create example admin user via registration page or insert manually if you prefer
