INSERT INTO users (first_name, last_name, email, password, role, reset_token, token_expires) VALUES
('Anna', 'Kowalska', 'anna.kowalska@example.com', 'hashed_pw', 'user', NULL, NULL),
('Jan', 'Nowak', 'jan.nowak@example.com', 'hashed_pw', 'user', NULL, NULL),
('Kasia', 'Wiśniewska', 'kasia.wisniewska@example.com', 'hashed_pw', 'admin', NULL, NULL),
('Piotr', 'Zieliński', 'piotr.zielinski@example.com', 'hashed_pw', 'user', NULL, NULL),
('Tomasz', 'Dąbrowski', 'tomasz.dabrowski@example.com', 'hashed_pw', 'user', NULL, NULL),
('Maria', 'Lewandowska', 'maria.lewandowska@example.com', 'hashed_pw', 'user', NULL, NULL),
('Michał', 'Wójcik', 'michal.wojcik@example.com', 'hashed_pw', 'admin', NULL, NULL),
('Alicja', 'Kamińska', 'alicja.kaminska@example.com', 'hashed_pw', 'user', NULL, NULL),
('Bartek', 'Krawczyk', 'bartek.krawczyk@example.com', 'hashed_pw', 'user', NULL, NULL),
('Joanna', 'Mazur', 'joanna.mazur@example.com', 'hashed_pw', 'user', NULL, NULL),
('Krzysztof', 'Wojciechowski', 'krzysztof.wojciechowski@example.com', 'hashed_pw', 'user', NULL, NULL),
('Natalia', 'Kaczmarek', 'natalia.kaczmarek@example.com', 'hashed_pw', 'user', NULL, NULL),
('Paweł', 'Piotrowski', 'pawel.piotrowski@example.com', 'hashed_pw', 'user', NULL, NULL),
('Ewa', 'Grabowska', 'ewa.grabowska@example.com', 'hashed_pw', 'user', NULL, NULL),
('Łukasz', 'Zając', 'lukasz.zajac@example.com', 'hashed_pw', 'user', NULL, NULL),
('Agnieszka', 'Król', 'agnieszka.krol@example.com', 'hashed_pw', 'user', NULL, NULL),
('Mateusz', 'Wieczorek', 'mateusz.wieczorek@example.com', 'hashed_pw', 'user', NULL, NULL),
('Monika', 'Jankowska', 'monika.jankowska@example.com', 'hashed_pw', 'user', NULL, NULL),
('Adrian', 'Zawadzki', 'adrian.zawadzki@example.com', 'hashed_pw', 'user', NULL, NULL),
('Julia', 'Bąk', 'julia.bak@example.com', 'hashed_pw', 'user', NULL, NULL);




INSERT INTO shipping_address (street, building_number, apartment_number, city, postal_code, country) VALUES
('Długa', '12', '5', 'Warszawa', '00-001', 'Polska'),
('Krótka', '3', NULL, 'Kraków', '30-002', 'Polska'),
('Łąkowa', '7', '11', 'Gdańsk', '80-003', 'Polska'),
('Polna', '1A', '2B', 'Wrocław', '50-004', 'Polska'),
('Leśna', '15', NULL, 'Poznań', '60-005', 'Polska'),
('Zielona', '4', '9', 'Lublin', '20-006', 'Polska'),
('Słoneczna', '10', NULL, 'Szczecin', '70-007', 'Polska'),
('Cicha', '2', '1', 'Katowice', '40-008', 'Polska'),
('Wesoła', '8', '6', 'Rzeszów', '35-009', 'Polska'),
('Nowa', '9', NULL, 'Łódź', '90-010', 'Polska'),
('Piękna', '6', '3', 'Opole', '45-011', 'Polska'),
('Stawowa', '13', '2', 'Zielona Góra', '65-012', 'Polska'),
('Ogrodowa', '20', NULL, 'Białystok', '15-013', 'Polska'),
('Jasna', '7', '4', 'Bydgoszcz', '85-014', 'Polska'),
('Morelowa', '14', NULL, 'Toruń', '87-015', 'Polska'),
('Jagodowa', '22', '1', 'Gorzów', '66-016', 'Polska'),
('Brzozowa', '11', NULL, 'Elbląg', '82-017', 'Polska'),
('Topolowa', '16', NULL, 'Sopot', '81-018', 'Polska'),
('Akacjowa', '5', '2', 'Gliwice', '44-019', 'Polska'),
('Wrzosowa', '3', NULL, 'Radom', '26-020', 'Polska');



INSERT INTO products (name, price, photo, stock_quantity) VALUES
('Fikus', 29.99, NULL, 1),
('Monstera', 39.99, NULL, 1),
('Aloes', 19.99, NULL, 1),
('Kaktus', 9.99, NULL, 1),
('Sansewieria', 24.99, NULL, 1),
('Skrzydłokwiat', 34.99, NULL, 1),
('Dracena', 27.99, NULL, 1),
('Paprotka', 17.99, NULL, 1),
('Storczyk', 49.99, NULL, 1),
('Bonsai', 59.99, NULL, 1),
('Zamiokulkas', 32.99, NULL, 1),
('Begonia', 21.99, NULL, 1),
('Kalatea', 37.99, NULL, 1),
('Peperomia', 22.99, NULL, 1),
('Kalanchoe', 14.99, NULL, 1),
('Pilea', 18.99, NULL, 1),
('Maranta', 23.99, NULL, 1),
('Epipremnum', 26.99, NULL, 1),
('Fittonia', 15.99, NULL, 1),
('Sundaville', 44.99, NULL, 1);


INSERT INTO carts (user_id) VALUES
(1),(2),(3),(4),(5),(6),(7),(8),(9),(10),
(11),(12),(13),(14),(15),(16),(17),(18),(19),(20);


INSERT INTO cart_items (product_id, quantity, cart_id) VALUES
(1, 2, 1), (3, 1, 2), (5, 4, 3), (7, 2, 4), (2, 1, 5),
(10, 1, 6), (11, 3, 7), (8, 2, 8), (14, 1, 9), (15, 2, 10),
(6, 1, 11), (9, 3, 12), (12, 1, 13), (13, 2, 14), (16, 1, 15),
(17, 2, 16), (4, 1, 17), (18, 3, 18), (19, 1, 19), (20, 2, 20);


INSERT INTO orders (order_date, status, shipping_address_id, delivery_date, user_id) VALUES
(CURDATE(), 'oplacono', 1, DATE_ADD(CURDATE(), INTERVAL 2 DAY), 1),
(CURDATE(), 'wyslano', 2, DATE_ADD(CURDATE(), INTERVAL 3 DAY), 2),
(CURDATE(), 'dostarczono', 3, CURDATE(), 3),
(CURDATE(), 'oplacono', 4, DATE_ADD(CURDATE(), INTERVAL 4 DAY), 4),
(CURDATE(), 'wyslano', 5, DATE_ADD(CURDATE(), INTERVAL 2 DAY), 5),
(CURDATE(), 'oplacono', 6, DATE_ADD(CURDATE(), INTERVAL 2 DAY), 6),
(CURDATE(), 'dostarczono', 7, CURDATE(), 7),
(CURDATE(), 'wyslano', 8, DATE_ADD(CURDATE(), INTERVAL 3 DAY), 8),
(CURDATE(), 'oplacono', 9, DATE_ADD(CURDATE(), INTERVAL 1 DAY), 9),
(CURDATE(), 'dostarczono', 10, CURDATE(), 10),
(CURDATE(), 'oplacono', 11, DATE_ADD(CURDATE(), INTERVAL 2 DAY), 11),
(CURDATE(), 'wyslano', 12, DATE_ADD(CURDATE(), INTERVAL 3 DAY), 12),
(CURDATE(), 'dostarczono', 13, CURDATE(), 13),
(CURDATE(), 'oplacono', 14, DATE_ADD(CURDATE(), INTERVAL 1 DAY), 14),
(CURDATE(), 'wyslano', 15, DATE_ADD(CURDATE(), INTERVAL 2 DAY), 15),
(CURDATE(), 'dostarczono', 16, CURDATE(), 16),
(CURDATE(), 'oplacono', 17, DATE_ADD(CURDATE(), INTERVAL 2 DAY), 17),
(CURDATE(), 'wyslano', 18, DATE_ADD(CURDATE(), INTERVAL 3 DAY), 18),
(CURDATE(), 'dostarczono', 19, CURDATE(), 19),
(CURDATE(), 'oplacono', 20, DATE_ADD(CURDATE(), INTERVAL 1 DAY), 20);
