-- usuawnie wszytskich rekordów
DELETE FROM cart_items;
DELETE FROM carts;
DELETE FROM orders;
DELETE FROM products;
DELETE FROM shipping_address;
DELETE FROM users;

-- inserty
INSERT INTO users (user_id, first_name, last_name, email, password, role, reset_token, token_expires) VALUES
   (1, 'Anna', 'Kowalska', 'anna.kowalska@example.com', 'hashed_pw', 'user', NULL, NULL),
   (2, 'Jan', 'Nowak', 'jan.nowak@example.com', 'hashed_pw', 'user', NULL, NULL),
   (3, 'Kasia', 'Wiśniewska', 'kasia.wisniewska@example.com', 'hashed_pw', 'admin', NULL, NULL),
   (4, 'Piotr', 'Zieliński', 'piotr.zielinski@example.com', 'hashed_pw', 'user', NULL, NULL),
   (5, 'Tomasz', 'Dąbrowski', 'tomasz.dabrowski@example.com', 'hashed_pw', 'user', NULL, NULL),
   (6, 'Maria', 'Lewandowska', 'maria.lewandowska@example.com', 'hashed_pw', 'user', NULL, NULL),
   (7, 'Michał', 'Wójcik', 'michal.wojcik@example.com', 'hashed_pw', 'admin', NULL, NULL),
   (8, 'Alicja', 'Kamińska', 'alicja.kaminska@example.com', 'hashed_pw', 'user', NULL, NULL),
   (9, 'Bartek', 'Krawczyk', 'bartek.krawczyk@example.com', 'hashed_pw', 'user', NULL, NULL),
   (10, 'Joanna', 'Mazur', 'joanna.mazur@example.com', 'hashed_pw', 'user', NULL, NULL),
   (11, 'Krzysztof', 'Wojciechowski', 'krzysztof.wojciechowski@example.com', 'hashed_pw', 'user', NULL, NULL),
   (12, 'Natalia', 'Kaczmarek', 'natalia.kaczmarek@example.com', 'hashed_pw', 'user', NULL, NULL),
   (13, 'Paweł', 'Piotrowski', 'pawel.piotrowski@example.com', 'hashed_pw', 'user', NULL, NULL),
   (14, 'Ewa', 'Grabowska', 'ewa.grabowska@example.com', 'hashed_pw', 'user', NULL, NULL),
   (15, 'Łukasz', 'Zając', 'lukasz.zajac@example.com', 'hashed_pw', 'user', NULL, NULL),
   (16, 'Agnieszka', 'Król', 'agnieszka.krol@example.com', 'hashed_pw', 'user', NULL, NULL),
   (17, 'Mateusz', 'Wieczorek', 'mateusz.wieczorek@example.com', 'hashed_pw', 'user', NULL, NULL),
   (18, 'Monika', 'Jankowska', 'monika.jankowska@example.com', 'hashed_pw', 'user', NULL, NULL),
   (19, 'Adrian', 'Zawadzki', 'adrian.zawadzki@example.com', 'hashed_pw', 'user', NULL, NULL),
   (20, 'Julia', 'Bąk', 'julia.bak@example.com', 'hashed_pw', 'user', NULL, NULL);




INSERT INTO shipping_address (shipping_address_id, street, building_number, apartment_number, city, postal_code, country) VALUES
   (1, 'Długa', '12', '5', 'Warszawa', '00-001', 'Polska'),
   (2, 'Krótka', '3', NULL, 'Kraków', '30-002', 'Polska'),
   (3, 'Łąkowa', '7', '11', 'Gdańsk', '80-003', 'Polska'),
   (4, 'Polna', '1A', '2B', 'Wrocław', '50-004', 'Polska'),
   (5, 'Leśna', '15', NULL, 'Poznań', '60-005', 'Polska'),
   (6, 'Zielona', '4', '9', 'Lublin', '20-006', 'Polska'),
   (7, 'Słoneczna', '10', NULL, 'Szczecin', '70-007', 'Polska'),
   (8, 'Cicha', '2', '1', 'Katowice', '40-008', 'Polska'),
   (9, 'Wesoła', '8', '6', 'Rzeszów', '35-009', 'Polska'),
   (10, 'Nowa', '9', NULL, 'Łódź', '90-010', 'Polska'),
   (11, 'Piękna', '6', '3', 'Opole', '45-011', 'Polska'),
   (12, 'Stawowa', '13', '2', 'Zielona Góra', '65-012', 'Polska'),
   (13, 'Ogrodowa', '20', NULL, 'Białystok', '15-013', 'Polska'),
   (14, 'Jasna', '7', '4', 'Bydgoszcz', '85-014', 'Polska'),
   (15, 'Morelowa', '14', NULL, 'Toruń', '87-015', 'Polska'),
   (16, 'Jagodowa', '22', '1', 'Gorzów', '66-016', 'Polska'),
   (17, 'Brzozowa', '11', NULL, 'Elbląg', '82-017', 'Polska'),
   (18, 'Topolowa', '16', NULL, 'Sopot', '81-018', 'Polska'),
   (19, 'Akacjowa', '5', '2', 'Gliwice', '44-019', 'Polska'),
   (20, 'Wrzosowa', '3', NULL, 'Radom', '26-020', 'Polska');



INSERT INTO products (product_id, name, price, photo, stock_quantity) VALUES
   (1, 'Fikus', 29.99, NULL, 1),
   (2, 'Monstera', 39.99, NULL, 1),
   (3, 'Aloes', 19.99, NULL, 1),
   (4, 'Kaktus', 9.99, NULL, 1),
   (5, 'Sansewieria', 24.99, NULL, 1),
   (6, 'Skrzydłokwiat', 34.99, NULL, 1),
   (7, 'Dracena', 27.99, NULL, 1),
   (8, 'Paprotka', 17.99, NULL, 1),
   (9, 'Storczyk', 49.99, NULL, 1),
   (10, 'Bonsai', 59.99, NULL, 1),
   (11, 'Zamiokulkas', 32.99, NULL, 1),
   (12, 'Begonia', 21.99, NULL, 1),
   (13, 'Kalatea', 37.99, NULL, 1),
   (14, 'Peperomia', 22.99, NULL, 1),
   (15, 'Kalanchoe', 14.99, NULL, 1),
   (16, 'Pilea', 18.99, NULL, 1),
   (17, 'Maranta', 23.99, NULL, 1),
   (18, 'Epipremnum', 26.99, NULL, 1),
   (19, 'Fittonia', 15.99, NULL, 1),
   (20, 'Sundaville', 44.99, NULL, 1);


INSERT INTO carts (cart_id, user_id) VALUES
   (1, 1),
   (2, 2),
   (3, 3),
   (4, 4),
   (5, 5),
   (6, 6),
   (7, 7),
   (8, 8),
   (9, 9),
   (10, 10),
   (11, 11),
   (12, 12),
   (13, 13),
   (14, 14),
   (15, 15),
   (16, 16),
   (17, 17),
   (18, 18),
   (19, 19),
   (20, 20);


INSERT INTO cart_items (cart_item_id, product_id, quantity, cart_id) VALUES
   (1, 1, 2, 1),
   (2, 3, 1, 2),
   (3, 5, 4, 3),
   (4, 7, 2, 4),
   (5, 2, 1, 5),
   (6, 10, 1, 6),
   (7, 11, 3, 7),
   (8, 8, 2, 8), 
   (9, 14, 1, 9),
   (10, 15, 2, 10),
   (11, 6, 1, 11), 
   (12, 9, 3, 12), 
   (13, 12, 1, 13), 
   (14, 13, 2, 14), 
   (15, 16, 1, 15),
   (16, 17, 2, 16), 
   (17, 4, 1, 17), 
   (18, 18, 3, 18), 
   (19, 19, 1, 19), 
   (20, 20, 2, 20);


INSERT INTO orders (order_id, order_date, status, shipping_address_id, delivery_date, user_id) VALUES
   (1, CURDATE(), 'oplacono', 1, DATE_ADD(CURDATE(), INTERVAL 2 DAY), 1),
   (2, CURDATE(), 'wyslano', 2, DATE_ADD(CURDATE(), INTERVAL 3 DAY), 2),
   (3, CURDATE(), 'dostarczono', 3, CURDATE(), 3),
   (4, CURDATE(), 'oplacono', 4, DATE_ADD(CURDATE(), INTERVAL 4 DAY), 4),
   (5, CURDATE(), 'wyslano', 5, DATE_ADD(CURDATE(), INTERVAL 2 DAY), 5),
   (6, CURDATE(), 'oplacono', 6, DATE_ADD(CURDATE(), INTERVAL 2 DAY), 6),
   (7, CURDATE(), 'dostarczono', 7, CURDATE(), 7),
   (8, CURDATE(), 'wyslano', 8, DATE_ADD(CURDATE(), INTERVAL 3 DAY), 8),
   (9, CURDATE(), 'oplacono', 9, DATE_ADD(CURDATE(), INTERVAL 1 DAY), 9),
   (10, CURDATE(), 'dostarczono', 10, CURDATE(), 10),
   (11, CURDATE(), 'oplacono', 11, DATE_ADD(CURDATE(), INTERVAL 2 DAY), 11),
   (12, CURDATE(), 'wyslano', 12, DATE_ADD(CURDATE(), INTERVAL 3 DAY), 12),
   (13, CURDATE(), 'dostarczono', 13, CURDATE(), 13),
   (14, CURDATE(), 'oplacono', 14, DATE_ADD(CURDATE(), INTERVAL 1 DAY), 14),
   (15, CURDATE(), 'wyslano', 15, DATE_ADD(CURDATE(), INTERVAL 2 DAY), 15),
   (16, CURDATE(), 'dostarczono', 16, CURDATE(), 16),
   (17, CURDATE(), 'oplacono', 17, DATE_ADD(CURDATE(), INTERVAL 2 DAY), 17),
   (18, CURDATE(), 'wyslano', 18, DATE_ADD(CURDATE(), INTERVAL 3 DAY), 18),
   (19, CURDATE(), 'dostarczono', 19, CURDATE(), 19),
   (20, CURDATE(), 'oplacono', 20, DATE_ADD(CURDATE(), INTERVAL 1 DAY), 20);