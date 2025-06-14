-- password: qwerty123!
INSERT INTO users
  (first_name,  last_name,     email,                         password,                                                       is_admin, reset_token, token_expires) VALUES
  ('Anna',      'Kowalska',    'anna.kowalska@example.com',   '$2y$10$7R9M7mew4JshAhLRSHqgGu.ADhnviPqy8fgvxsITPLxRvKJFiqx5e', FALSE,    NULL,        NULL),
  ('Jan',       'Nowak',       'jan.nowak@example.com',       '$2y$10$7R9M7mew4JshAhLRSHqgGu.ADhnviPqy8fgvxsITPLxRvKJFiqx5e', FALSE,    NULL,        NULL),
  ('Maria',     'Wiśniewska',  'maria.w@example.com',         '$2y$10$7R9M7mew4JshAhLRSHqgGu.ADhnviPqy8fgvxsITPLxRvKJFiqx5e', FALSE,    NULL,        NULL),
  ('Piotr',     'Wójcik',      'piotr.wojcik@example.com',    '$2y$10$7R9M7mew4JshAhLRSHqgGu.ADhnviPqy8fgvxsITPLxRvKJFiqx5e', FALSE,    NULL,        NULL),
  ('Kasia',     'Szucka',      'kasia.szucka@example.com',    '$2y$10$7R9M7mew4JshAhLRSHqgGu.ADhnviPqy8fgvxsITPLxRvKJFiqx5e', TRUE,     NULL,        NULL),
  ('Tomasz',    'Mazur',       't.mazur@example.com',         '$2y$10$7R9M7mew4JshAhLRSHqgGu.ADhnviPqy8fgvxsITPLxRvKJFiqx5e', FALSE,    NULL,        NULL),
  ('Magdalena', 'Krawczyk',    'magda.k@example.com',         '$2y$10$7R9M7mew4JshAhLRSHqgGu.ADhnviPqy8fgvxsITPLxRvKJFiqx5e', FALSE,    NULL,        NULL),
  ('Paweł',     'Grabowski',   'pawel.grab@example.com',      '$2y$10$7R9M7mew4JshAhLRSHqgGu.ADhnviPqy8fgvxsITPLxRvKJFiqx5e', FALSE,    NULL,        NULL),
  ('Agnieszka', 'Zielińska',   'agnieszka.z@example.com',     '$2y$10$7R9M7mew4JshAhLRSHqgGu.ADhnviPqy8fgvxsITPLxRvKJFiqx5e', FALSE,    NULL,        NULL),
  ('Marek',     'Szymański',   'marek.s@example.com',         '$2y$10$7R9M7mew4JshAhLRSHqgGu.ADhnviPqy8fgvxsITPLxRvKJFiqx5e', FALSE,    NULL,        NULL),
  ('Joanna',    'Woźniak',     'joanna.woz@example.com',      '$2y$10$7R9M7mew4JshAhLRSHqgGu.ADhnviPqy8fgvxsITPLxRvKJFiqx5e', FALSE,    NULL,        NULL),
  ('Krzysztof', 'Dąbrowski',   'krzysiek.d@example.com',      '$2y$10$7R9M7mew4JshAhLRSHqgGu.ADhnviPqy8fgvxsITPLxRvKJFiqx5e', TRUE,     NULL,        NULL),
  ('Natalia',   'Lewandowska', 'natalia.l@example.com',       '$2y$10$7R9M7mew4JshAhLRSHqgGu.ADhnviPqy8fgvxsITPLxRvKJFiqx5e', FALSE,    NULL,        NULL),
  ('Adam',      'Zając',       'adam.zajac@example.com',      '$2y$10$7R9M7mew4JshAhLRSHqgGu.ADhnviPqy8fgvxsITPLxRvKJFiqx5e', FALSE,    NULL,        NULL),
  ('Ewa',       'Kozłowska',   'ewa.koz@example.com',         '$2y$10$7R9M7mew4JshAhLRSHqgGu.ADhnviPqy8fgvxsITPLxRvKJFiqx5e', FALSE,    NULL,        NULL),
  ('Rafał',     'Jankowski',   'rafal.j@example.com',         '$2y$10$7R9M7mew4JshAhLRSHqgGu.ADhnviPqy8fgvxsITPLxRvKJFiqx5e', FALSE,    NULL,        NULL),
  ('Dorota',    'Witkowska',   'dorota.w@example.com',        '$2y$10$7R9M7mew4JshAhLRSHqgGu.ADhnviPqy8fgvxsITPLxRvKJFiqx5e', FALSE,    NULL,        NULL),
  ('Michał',    'Walczak',     'michal.w@example.com',        '$2y$10$7R9M7mew4JshAhLRSHqgGu.ADhnviPqy8fgvxsITPLxRvKJFiqx5e', FALSE,    NULL,        NULL),
  ('Barbara',   'Nowicka',     'b.nowicka@example.com',       '$2y$10$7R9M7mew4JshAhLRSHqgGu.ADhnviPqy8fgvxsITPLxRvKJFiqx5e', FALSE,    NULL,        NULL),
  ('Andrzej',   'Górski',      'andrzej.g@example.com',       '$2y$10$7R9M7mew4JshAhLRSHqgGu.ADhnviPqy8fgvxsITPLxRvKJFiqx5e', FALSE,    NULL,        NULL);

INSERT INTO categories
  (title) VALUES
  ('Seeds'),
  ('Tools'),
  ('Pots'),
  ('Soil & Peat'),
  ('Ornamental Plants'),
  ('Fertilizers'),
  ('Plant Protection'),
  ('Irrigation'),
  ('Trees & Shrubs');

INSERT INTO products
  (price, title,                 description,                                                                                                                                                                category_id, pictureFile, in_stock) VALUES
  (12.99, 'Carrot Seeds',        'High-yield early variety that produces crisp, sweet roots ideal for salads, juicing, and cooking. Thrives in loose soil and requires moderate sunlight for best results.', 1,           NULL,        TRUE),
  (15.49, 'Garden Shovel',       'Stainless steel with wooden handle that provides durability and comfort. Ideal for digging, transplanting, and other heavy-duty gardening tasks in all soil types.',       2,           NULL,        TRUE),
  (7.99,  'Clay Pot 20cm',       'Durable clay pot for small plants, offering natural breathability and moisture control. Great for herbs, flowers, and decorative indoor arrangements.',                    3,           NULL,        TRUE),
  (18.50, 'Universal Peat Mix',  'Perfect for most garden plants with a rich blend of organic materials. Retains moisture effectively while allowing adequate drainage for strong root development.',        4,           NULL,        TRUE),
  (25.00, 'Rose Bush',           'Red flowering variety, 30-40 cm height, perfect for borders or containers. Produces long-lasting blooms and adds fragrance and elegance to gardens.',                      5,           NULL,        TRUE),
  (9.75,  'Liquid Fertilizer',   'For flowering plants, 1L bottle rich in essential nutrients. Promotes vibrant blooms, healthier foliage, and can be used for indoor or outdoor plants.',                   6,           NULL,        TRUE),
  (13.30, 'Neem Oil Spray',      'Organic pest repellent for leaves, effective against a wide range of garden insects. Safe for edible plants and suitable for routine garden maintenance.',                 7,           NULL,        TRUE),
  (29.99, 'Drip Irrigation Kit', 'Covers up to 20 potted plants and includes adjustable nozzles. Ensures efficient water use and consistent hydration for balcony, greenhouse, or patio gardens.',           8,           NULL,        TRUE),
  (44.00, 'Apple Tree (2 yr)',   'Hardy variety with sweet fruit, suitable for temperate climates. Produces juicy apples and makes a beautiful, fruitful addition to any garden or orchard.',                9,           NULL,        TRUE),
  (11.20, 'Basil Seeds',         'Aromatic herb for cooking, ideal for fresh use or drying. Grows well in pots or garden beds and enhances dishes with its distinct, flavorful fragrance.',                  1,           NULL,        TRUE),
  (8.60,  'Hand Rake',           'Compact rake for flower beds, ideal for loosening soil and removing debris. Features ergonomic grip for comfortable handling and efficient garden tidying.',               2,           NULL,        TRUE),
  (6.49,  'Plastic Pot 15cm',    'Lightweight and durable, suitable for indoor or outdoor use. Resistant to weather and perfect for herbs, succulents, or decorative small flowering plants.',               3,           NULL,        TRUE),
  (22.00, 'Cactus Mix Soil',     'Ideal for succulents and cacti, this mix offers excellent drainage and aeration. Enriched with minerals to promote strong root systems and healthy growth.',               4,           NULL,        TRUE),
  (17.99, 'Lavender Plant',      'Fragrant and drought-tolerant, great for borders and containers. Attracts pollinators, emits calming aroma, and thrives in well-drained, sunny locations.',                5,           NULL,        TRUE),
  (5.99,  'Granular Fertilizer', 'Slow-release nutrients for all plants, promoting steady growth. Ideal for flowers, vegetables, and shrubs, supporting healthy roots and vibrant foliage.',                 6,           NULL,        TRUE),
  (25.5,  'Sunflower Seeds',     'High-quality seeds for home gardening, yielding tall, bright sunflowers. Great for pollinators, cut flower arrangements, and producing edible seeds.',                     1,           NULL,        TRUE),
  (39.03, 'Hand Trowel',         'Made from rust-resistant materials for long-lasting use. Ideal for planting, weeding, and general garden maintenance with a comfortable, firm grip.',                      2,           NULL,        TRUE),
  (47.64, 'Coconut Coir',        'Enhanced with organic matter for better growth, improving soil texture and water retention. Ideal for seed starting and hydroponic or container gardening.',               4,           NULL,        FALSE),
  (31.71, 'Organic Fertilizer',  'Promotes healthy root and leaf development, enhancing soil fertility naturally. Safe for all plant types and supports long-term garden sustainability.',                   6,           NULL,        TRUE),
  (58.19, 'Seaweed Extract',     'Promotes healthy root and leaf development using trace minerals and growth hormones. Supports stress resistance, flowering, and overall plant vitality.',                  6,           NULL,        TRUE),
  (23.76, 'Box Tree',            'Excellent choice for landscaping, offering dense foliage and easy shaping. Perfect for hedges, topiary, or standalone ornamental features in gardens.',                    9,           NULL,        TRUE),
  (26.01, 'Lettuce Seeds',       'High-quality seeds for home gardening that produce tender, crisp leaves. Suitable for container or ground planting with rapid germination and harvest.',                   1,           NULL,        TRUE),
  (17.41, 'Hydrangea',           'Adds a decorative touch to any space with large, colorful blooms. Prefers moist, well-drained soil and provides lasting beauty throughout the growing season.',            5,           NULL,        TRUE),
  (10.73, 'Lettuce Seeds',       'High-quality seeds for home gardening that are reliable and fast-growing. Produce tasty, fresh leaves that are perfect for salads and healthy meals.',                     1,           NULL,        TRUE),
  (33.6,  'Insect Netting',      'Fast-acting and long-lasting effect to shield plants from pests. Made from fine mesh to allow sunlight and water while preventing insect damage naturally.',               7,           NULL,        TRUE),
  (27.27, 'Resin Planter',       'Perfect for indoor and outdoor use, designed with UV-resistant material. Lightweight yet sturdy, suitable for all plant types and modern decor styles.',                   3,           NULL,        TRUE),
  (41.32, 'Fungicide Spray',     'Safe for use on edible plants while effectively combating fungal infections. Helps maintain plant health and appearance without harmful chemical residues.',               7,           NULL,        TRUE),
  (9.11,  'Seaweed Extract',     'Balanced nutrients for all plant types, ideal for boosting overall vigor. Enhances plant metabolism, root growth, and flowering in various garden settings.',              6,           NULL,        TRUE),
  (18.45, 'Tomato Seeds',        'Ensures high germination and strong plants with juicy, flavorful fruit. Suitable for pots or garden beds and offers excellent resistance to common diseases.',             1,           NULL,        TRUE),
  (22.30, 'Garden Fork',         'Durable and ergonomic gardening tool perfect for turning soil and compost. Strong tines penetrate tough ground while reducing strain on the users hands.',                 2,           NULL,        TRUE),
  (19.75, 'Terracotta Pot',      'Stylish and durable plant pot that provides excellent root ventilation. Classic design enhances any plant display, indoors or on a garden patio.',                         3,           NULL,        TRUE),
  (27.80, 'Compost Mix',         'Rich, well-draining soil mix that enhances soil fertility and moisture retention. Contains organic matter ideal for vegetables, flowers, and potted plants.',              4,           NULL,        TRUE),
  (35.50, 'Orchid Plant',        'Beautiful plant to enhance your garden with exotic flowers. Requires indirect sunlight and humidity, making it a unique addition to any home or garden.',                  5,           NULL,        FALSE),
  (12.95, 'Bone Meal',           'Balanced nutrients for all plant types, rich in phosphorus and calcium. Encourages strong root growth and flowering, ideal for bulbs and perennials.',                     6,           NULL,        TRUE),
  (15.20, 'Slug Pellets',        'Protects plants from common pests by forming a safe barrier. Easy to apply and weather-resistant, reducing slug and snail damage significantly.',                          7,           NULL,        TRUE),
  (40.00, 'Sprinkler Head',      'Efficient watering solution for gardens, lawns, or large planters. Adjustable settings provide consistent coverage and help conserve water effectively.',                  8,           NULL,        TRUE),
  (55.10, 'Cherry Sapling',      'Produces beautiful blooms or fruit and thrives in temperate climates. Adds aesthetic and edible value to gardens while growing into a hardy tree.',                        9,           NULL,        TRUE),
  (16.75, 'Sunflower Seeds',     'Perfect for beginners and experienced gardeners seeking bright, tall blooms. These seeds grow into stunning sunflowers that attract birds and bees.',                      1,           NULL,        TRUE),
  (29.99, 'Pruning Shears',      'Durable and ergonomic gardening tool for precise cuts and pruning. Designed to reduce fatigue and maintain healthy plant growth through regular trimming.',                2,           NULL,        TRUE),
  (14.30, 'Hanging Basket',      'Perfect for indoor and outdoor use, this basket enhances vertical space. Ideal for trailing plants and herbs with a strong frame and attractive design.',                  3,           NULL,        TRUE),
  (24.00, 'Potting Soil',        'Ideal for potting and transplanting, containing essential nutrients. Supports root development and water balance for healthier, longer-lasting plants.',                   4,           NULL,        FALSE),
  (38.50, 'Boxwood Shrub',       'Adds a decorative touch to any space and is great for hedging or shaping. Grows well in various soil conditions and provides year-round evergreen color.',                 5,           NULL,        TRUE),
  (10.00, 'Organic Fertilizer',  'Promotes healthy root and leaf development with all-natural ingredients. Suitable for vegetables, flowers, and shrubs, enhancing long-term plant health.',                 6,           NULL,        TRUE),
  (18.40, 'Insect Netting',      'Safe for use on edible plants, blocking pests while allowing air flow. Reusable and lightweight, ideal for garden beds, greenhouses, or containers.',                      7,           NULL,        TRUE),
  (33.25, 'Soaker Hose',         'Saves time and water by providing targeted irrigation directly to roots. Great for raised beds or rows and reduces weed growth and water waste.',                          8,           NULL,        TRUE),
  (45.60, 'Pear Tree',           'Hardy variety suitable for all climates with sweet, juicy fruit. Produces beautiful blossoms and is a rewarding addition to home orchards or yards.',                      9,           NULL,        TRUE),
  (13.75, 'Basil Seeds',         'High-quality seeds for home gardening that grow into aromatic herbs. Great for culinary use, container growing, and attracting pollinators.',                              1,           NULL,        TRUE),
  (28.99, 'Hand Rake',           'Designed for comfortable use during long hours in the garden. Helps break up soil, remove debris, and maintain beds with ease and precision.',                             2,           NULL,        TRUE);

INSERT INTO reviews 
  (rating, description, product_id, user_id, created_at) VALUES
  (3, 'Spełnia swoje zadanie bez problemów.', 1, 10, '2024-07-10'),
  (4, 'Polecam ten produkt znajomym.', 1, 7, '2024-10-16'),
  (5, 'Działa dobrze, bez zastrzeżeń.', 1, 4, '2024-09-06'),
  (5, 'Bardzo dobry produkt, spełnia moje oczekiwania.', 2, 8, '2025-03-29'),
  (2, 'Szybka dostawa i świetna jakość!', 2, 7, '2025-05-21'),
  (3, 'Polecam ten produkt znajomym.', 2, 1, '2025-03-18'),
  (2, 'Polecam ten produkt znajomym.', 3, 8, '2025-04-12'),
  (1, 'Spełnia swoje zadanie bez problemów.', 3, 6, '2025-04-16'),
  (5, 'Polecam ten produkt znajomym.', 3, 1, '2025-02-01'),
  (3, 'Używam od tygodnia i jestem bardzo zadowolony.', 4, 9, '2024-08-09'),
  (5, 'Działa dobrze, bez zastrzeżeń.', 4, 5, '2025-03-12'),
  (4, 'Solidne wykonanie, polecam każdemu ogrodnikowi.', 4, 2, '2025-03-28'),
  (5, 'Trochę mniejsze niż się spodziewałem, ale działa.', 5, 10, '2025-03-11'),
  (5, 'Używam od tygodnia i jestem bardzo zadowolony.', 5, 4, '2025-01-18'),
  (3, 'Bardzo dobry produkt, spełnia moje oczekiwania.', 5, 2, '2025-05-18'),
  (1, 'Działa dobrze, bez zastrzeżeń.', 6, 6, '2025-04-25'),
  (3, 'Bardzo dobry produkt, spełnia moje oczekiwania.', 6, 5, '2025-02-17'),
  (2, 'Spełnia swoje zadanie bez problemów.', 6, 9, '2025-04-07'),
  (5, 'Używam od tygodnia i jestem bardzo zadowolony.', 7, 8, '2024-12-22'),
  (2, 'Działa dobrze, bez zastrzeżeń.', 7, 9, '2025-01-30'),
  (2, 'Szybka dostawa i świetna jakość!', 7, 9, '2024-11-25'),
  (2, 'Solidne wykonanie, polecam każdemu ogrodnikowi.', 8, 2, '2025-01-19'),
  (3, 'Działa dobrze, bez zastrzeżeń.', 8, 9, '2025-01-06'),
  (4, 'Trochę mniejsze niż się spodziewałem, ale działa.', 8, 9, '2025-03-20'),
  (1, 'Solidne wykonanie, polecam każdemu ogrodnikowi.', 9, 2, '2024-10-30'),
  (3, 'Jakość adekwatna do ceny.', 9, 6, '2024-10-01'),
  (1, 'Polecam ten produkt znajomym.', 9, 6, '2024-06-15'),
  (4, 'Nie do końca zadowolony, ale może być.', 10, 10, '2025-03-30'),
  (4, 'Spełnia swoje zadanie bez problemów.', 10, 7, '2024-10-08'),
  (4, 'Działa dobrze, bez zastrzeżeń.', 10, 6, '2024-10-28'),
  (5, 'Solidne wykonanie, polecam każdemu ogrodnikowi.', 11, 6, '2025-01-03'),
  (4, 'Jakość adekwatna do ceny.', 11, 6, '2024-11-29'),
  (2, 'Szybka dostawa i świetna jakość!', 11, 3, '2025-02-19'),
  (1, 'Spełnia swoje zadanie bez problemów.', 12, 2, '2024-07-21'),
  (4, 'Spełnia swoje zadanie bez problemów.', 12, 2, '2024-10-29'),
  (5, 'Bardzo dobry produkt, spełnia moje oczekiwania.', 12, 6, '2025-02-17'),
  (3, 'Bardzo dobry produkt, spełnia moje oczekiwania.', 13, 6, '2025-01-12'),
  (4, 'Trochę mniejsze niż się spodziewałem, ale działa.', 13, 8, '2025-01-04'),
  (4, 'Bardzo dobry produkt, spełnia moje oczekiwania.', 13, 6, '2024-09-22'),
  (5, 'Solidne wykonanie, polecam każdemu ogrodnikowi.', 14, 2, '2025-03-28'),
  (4, 'Spełnia swoje zadanie bez problemów.', 14, 3, '2025-03-21'),
  (4, 'Działa dobrze, bez zastrzeżeń.', 14, 7, '2025-05-30'),
  (4, 'Spełnia swoje zadanie bez problemów.', 15, 2, '2024-07-03'),
  (5, 'Działa dobrze, bez zastrzeżeń.', 15, 4, '2024-08-24'),
  (3, 'Szybka dostawa i świetna jakość!', 15, 2, '2025-01-26'),
  (2, 'Szybka dostawa i świetna jakość!', 16, 6, '2025-04-16'),
  (5, 'Polecam ten produkt znajomym.', 16, 7, '2024-08-08'),
  (5, 'Solidne wykonanie, polecam każdemu ogrodnikowi.', 16, 5, '2025-05-08'),
  (4, 'Używam od tygodnia i jestem bardzo zadowolony.', 17, 5, '2024-08-13'),
  (4, 'Trochę mniejsze niż się spodziewałem, ale działa.', 17, 3, '2024-07-31'),
  (4, 'Działa dobrze, bez zastrzeżeń.', 17, 9, '2024-10-27'),
  (1, 'Solidne wykonanie, polecam każdemu ogrodnikowi.', 18, 6, '2024-12-02'),
  (5, 'Spełnia swoje zadanie bez problemów.', 18, 7, '2024-10-03'),
  (5, 'Trochę mniejsze niż się spodziewałem, ale działa.', 18, 5, '2025-05-04'),
  (1, 'Solidne wykonanie, polecam każdemu ogrodnikowi.', 19, 1, '2024-08-03'),
  (3, 'Szybka dostawa i świetna jakość!', 19, 7, '2024-08-22'),
  (4, 'Jakość adekwatna do ceny.', 19, 5, '2024-06-22'),
  (3, 'Jakość adekwatna do ceny.', 20, 10, '2024-11-23'),
  (2, 'Trochę mniejsze niż się spodziewałem, ale działa.', 20, 2, '2025-05-29'),
  (5, 'Bardzo dobry produkt, spełnia moje oczekiwania.', 20, 8, '2025-03-05'),
  (5, 'Nie do końca zadowolony, ale może być.', 21, 7, '2024-07-27'),
  (1, 'Nie do końca zadowolony, ale może być.', 21, 1, '2024-10-18'),
  (5, 'Spełnia swoje zadanie bez problemów.', 21, 1, '2024-12-29'),
  (2, 'Szybka dostawa i świetna jakość!', 22, 9, '2025-01-26'),
  (4, 'Używam od tygodnia i jestem bardzo zadowolony.', 22, 7, '2024-07-06'),
  (3, 'Używam od tygodnia i jestem bardzo zadowolony.', 22, 8, '2025-03-05'),
  (1, 'Spełnia swoje zadanie bez problemów.', 23, 10, '2025-05-19'),
  (2, 'Trochę mniejsze niż się spodziewałem, ale działa.', 23, 10, '2025-04-16'),
  (2, 'Działa dobrze, bez zastrzeżeń.', 23, 6, '2025-04-30'),
  (1, 'Szybka dostawa i świetna jakość!', 24, 2, '2024-11-10'),
  (2, 'Nie do końca zadowolony, ale może być.', 24, 3, '2024-10-18'),
  (1, 'Bardzo dobry produkt, spełnia moje oczekiwania.', 24, 6, '2024-07-24'),
  (3, 'Nie do końca zadowolony, ale może być.', 25, 5, '2024-11-19'),
  (3, 'Używam od tygodnia i jestem bardzo zadowolony.', 25, 10, '2025-06-05'),
  (5, 'Spełnia swoje zadanie bez problemów.', 25, 10, '2025-05-10'),
  (5, 'Nie do końca zadowolony, ale może być.', 26, 8, '2024-06-16'),
  (2, 'Trochę mniejsze niż się spodziewałem, ale działa.', 26, 10, '2025-04-10'),
  (1, 'Spełnia swoje zadanie bez problemów.', 26, 10, '2025-02-07'),
  (5, 'Spełnia swoje zadanie bez problemów.', 27, 4, '2024-10-18'),
  (1, 'Jakość adekwatna do ceny.', 27, 10, '2025-04-27'),
  (2, 'Szybka dostawa i świetna jakość!', 27, 9, '2024-10-17'),
  (2, 'Spełnia swoje zadanie bez problemów.', 28, 8, '2024-09-15'),
  (3, 'Działa dobrze, bez zastrzeżeń.', 28, 10, '2024-11-10'),
  (2, 'Szybka dostawa i świetna jakość!', 28, 10, '2024-07-30'),
  (4, 'Trochę mniejsze niż się spodziewałem, ale działa.', 29, 10, '2025-05-11'),
  (1, 'Polecam ten produkt znajomym.', 29, 3, '2025-01-21'),
  (1, 'Spełnia swoje zadanie bez problemów.', 29, 10, '2024-09-18'),
  (4, 'Polecam ten produkt znajomym.', 30, 4, '2025-04-27'),
  (4, 'Działa dobrze, bez zastrzeżeń.', 30, 10, '2024-07-24'),
  (2, 'Solidne wykonanie, polecam każdemu ogrodnikowi.', 30, 6, '2025-05-23'),
  (1, 'Spełnia swoje zadanie bez problemów.', 31, 6, '2025-05-31'),
  (4, 'Spełnia swoje zadanie bez problemów.', 31, 9, '2025-03-17'),
  (2, 'Polecam ten produkt znajomym.', 31, 7, '2024-11-04'),
  (3, 'Polecam ten produkt znajomym.', 32, 4, '2024-07-22'),
  (3, 'Trochę mniejsze niż się spodziewałem, ale działa.', 32, 1, '2024-10-20'),
  (1, 'Używam od tygodnia i jestem bardzo zadowolony.', 32, 7, '2024-06-16'),
  (4, 'Bardzo dobry produkt, spełnia moje oczekiwania.', 33, 10, '2025-01-10'),
  (2, 'Trochę mniejsze niż się spodziewałem, ale działa.', 33, 4, '2025-04-22'),
  (4, 'Spełnia swoje zadanie bez problemów.', 33, 7, '2024-12-12'),
  (1, 'Trochę mniejsze niż się spodziewałem, ale jak się popieści to się zmieści?... 🤨🤨', 34, 5, '2025-04-07'),
  (5, 'Szybka dostawa i świetna jakość!', 34, 4, '2024-06-20'),
  (1, 'Działa dobrze, bez zastrzeżeń.', 34, 4, '2025-03-11'),
  (3, 'Spełnia swoje zadanie bez problemów.', 35, 2, '2024-12-04'),
  (5, 'Bardzo dobry produkt, spełnia moje oczekiwania.', 35, 10, '2024-07-02'),
  (1, 'Trochę mniejsze niż się spodziewałem, ale działa.', 35, 1, '2024-12-03'),
  (3, 'Bardzo dobry produkt, spełnia moje oczekiwania.', 36, 2, '2025-03-28'),
  (2, 'Jakość adekwatna do ceny.', 36, 8, '2024-09-18'),
  (5, 'Solidne wykonanie, polecam każdemu ogrodnikowi.', 36, 1, '2025-05-10'),
  (5, 'Solidne wykonanie, polecam każdemu ogrodnikowi.', 37, 10, '2025-02-22'),
  (4, 'Działa dobrze, bez zastrzeżeń.', 37, 4, '2024-09-11'),
  (5, 'Trochę mniejsze niż się spodziewałem, ale działa.', 37, 5, '2024-12-16'),
  (2, 'Działa dobrze, bez zastrzeżeń.', 38, 8, '2024-08-07'),
  (2, 'Bardzo dobry produkt, spełnia moje oczekiwania.', 38, 10, '2024-11-14'),
  (5, 'Nie do końca zadowolony, ale może być.', 38, 5, '2024-10-08'),
  (4, 'Polecam ten produkt znajomym.', 39, 6, '2025-04-14'),
  (2, 'Szybka dostawa i świetna jakość!', 39, 3, '2024-12-06'),
  (3, 'Działa dobrze, bez zastrzeżeń.', 39, 5, '2025-05-13'),
  (5, 'Solidne wykonanie, polecam każdemu ogrodnikowi.', 40, 7, '2025-02-26'),
  (4, 'Solidne wykonanie, polecam każdemu ogrodnikowi.', 40, 8, '2025-04-22'),
  (2, 'Spełnia swoje zadanie bez problemów.', 40, 1, '2025-01-16'),
  (5, 'Spełnia swoje zadanie bez problemów.', 41, 2, '2024-08-29'),
  (3, 'Bardzo dobry produkt, spełnia moje oczekiwania.', 41, 5, '2024-12-25'),
  (5, 'Polecam ten produkt znajomym.', 41, 2, '2024-09-07'),
  (2, 'Trochę mniejsze niż się spodziewałem, ale działa.', 42, 10, '2025-05-25'),
  (3, 'Solidne wykonanie, polecam każdemu ogrodnikowi.', 42, 6, '2025-02-10'),
  (3, 'Jakość adekwatna do ceny.', 42, 9, '2024-07-13'),
  (2, 'Spełnia swoje zadanie bez problemów.', 43, 10, '2024-09-23'),
  (1, 'Używam od tygodnia i jestem bardzo zadowolony.', 43, 9, '2025-05-31'),
  (3, 'Solidne wykonanie, polecam każdemu ogrodnikowi.', 43, 5, '2024-12-10'),
  (4, 'Bardzo dobry produkt, spełnia moje oczekiwania.', 44, 2, '2024-08-09'),
  (1, 'Działa dobrze, bez zastrzeżeń.', 44, 5, '2024-09-22'),
  (4, 'Solidne wykonanie, polecam każdemu ogrodnikowi.', 44, 4, '2025-03-15'),
  (4, 'Jakość adekwatna do ceny.', 45, 6, '2025-01-25'),
  (2, 'Działa dobrze, bez zastrzeżeń.', 45, 4, '2024-10-22'),
  (1, 'Jakość adekwatna do ceny.', 45, 7, '2024-11-03'),
  (2, 'Jakość adekwatna do ceny.', 46, 8, '2024-11-04'),
  (2, 'Solidne wykonanie, polecam każdemu ogrodnikowi.', 46, 6, '2024-12-16'),
  (1, 'Używam od tygodnia i jestem bardzo zadowolony.', 46, 10, '2024-12-31'),
  (1, 'Działa dobrze, bez zastrzeżeń.', 47, 7, '2025-03-09'),
  (2, 'Bardzo dobry produkt, spełnia moje oczekiwania.', 47, 10, '2024-11-02'),
  (3, 'Jakość adekwatna do ceny.', 47, 1, '2025-04-27'),
  (1, 'Szybka dostawa i świetna jakość!', 48, 5, '2025-01-17'),
  (5, 'Używam od tygodnia i jestem bardzo zadowolony.', 48, 9, '2024-08-16'),
  (4, 'Polecam ten produkt znajomym.', 48, 8, '2024-10-26');

INSERT INTO carts
  (user_id) VALUES
  (8),
  (20),
  (6),
  (11),
  (7),
  (19),
  (4),
  (16),
  (9),
  (1);

INSERT INTO cart_items
  (cart_id, product_id, quantity) VALUES
  (9,       6,          5),
  (3,       21,         2),
  (8,       5,          1),
  (1,       18,         5),
  (5,       27,         5),
  (10,      32,         5),
  (2,       28,         2),
  (8,       21,         1),
  (10,      18,         5),
  (10,      19,         2),
  (7,       19,         1),
  (5,       11,         5),
  (8,       23,         2),
  (8,       25,         1),
  (7,       23,         4),
  (4,       25,         1),
  (5,       20,         3),
  (1,       15,         1),
  (5,       5,          5),
  (3,       8,          5);

INSERT INTO order_addresses
  (country,  city,         street,         building_number, apartment_number, postal_code) VALUES 
  ('Polska', 'Warszawa',   'Broadway',     '123',           '45',             '10-001'),
  ('Polska', 'Warszawa',   'Sunset Blvd',  '456',           NULL,             '90-200'),
  ('Polska', 'Grójec',     'Michigan Ave', '789',           '12',             '60-300'),
  ('Polska', 'Piaseczno',  'Main Street',  '321',           '3B',             '77-450'),
  ('Polska', 'Warszawa',   'Market St',    '654',           NULL,             '19-500'),
  ('Polska', 'Kraków',     'Central Ave',  '987',           '7',              '85-600'),
  ('Polska', 'Sandomierz', 'Alamo St',     '147',           '22',             '42-700'),
  ('Polska', 'Warszawa',   'Harbor Dr',    '258',           '15A',            '91-800'),
  ('Polska', 'Wrocław',    'Elm Street',   '369',           NULL,             '75-900'),
  ('Polska', 'Warszawa',   'First St',     '951',           '102',            '95-010');

INSERT INTO orders
  (user_id, order_address_id, delivered, order_date,   delivery_date) VALUES
  (5,       3,                TRUE,      '2024-03-15', '2024-03-18'),
  (12,      7,                FALSE,     '2024-03-18', '2024-03-22'),
  (2,       1,                TRUE,      '2024-03-20', '2024-03-23'),
  (18,      4,                FALSE,     '2024-03-22', '2024-03-26'),
  (7,       2,                TRUE,      '2024-03-25', '2024-03-27'),
  (15,      9,                TRUE,      '2024-03-28', '2024-03-30'),
  (3,       5,                FALSE,     '2024-04-01', '2024-04-06'),
  (20,      10,               TRUE,      '2024-04-03', '2024-04-05'),
  (9,       6,                FALSE,     '2024-04-05', '2024-04-10'),
  (14,      8,                TRUE,      '2024-04-08', '2024-04-11'),
  (1,       3,                FALSE,     '2024-04-10', '2024-04-15'),
  (16,      1,                TRUE,      '2024-04-12', '2024-04-14'),
  (8,       7,                TRUE,      '2024-04-15', '2024-04-17'),
  (11,      2,                FALSE,     '2024-04-18', '2024-04-23'),
  (4,       9,                TRUE,      '2024-04-20', '2024-04-22'),
  (19,      4,                FALSE,     '2024-04-22', '2024-04-27'),
  (6,       10,               TRUE,      '2024-04-25', '2024-04-28'),
  (13,      5,                TRUE,      '2024-04-28', '2024-04-30'),
  (10,      8,                FALSE,     '2024-05-01', '2024-05-06'),
  (17,      6,                TRUE,      '2024-05-03', '2024-05-05');

INSERT INTO order_items
  (order_id, product_id, quantity) VALUES
  (1, 12, 2), (1, 35, 1), (1, 7, 3),
  (2, 22, 1), (2, 41, 2),
  (3, 5, 1), (3, 18, 1), (3, 29, 1), (3, 42, 2),
  (4, 33, 3), (4, 16, 1),
  (5, 8, 2), (5, 24, 1),
  (6, 11, 1), (6, 37, 4),
  (7, 3, 1), (7, 19, 2), (7, 45, 1),
  (8, 28, 3), (8, 14, 1),
  (9, 6, 2), (9, 31, 1),
  (10, 9, 1), (10, 23, 1), (10, 40, 2),
  (11, 17, 1), (11, 38, 1),
  (12, 2, 3), (12, 25, 1), (12, 44, 2),
  (13, 13, 1), (13, 36, 1),
  (14, 4, 2), (14, 21, 1), (14, 47, 1),
  (15, 10, 1), (15, 27, 3),
  (16, 1, 1), (16, 32, 2), (16, 48, 1),
  (17, 15, 1), (17, 26, 1), (17, 43, 1),
  (18, 20, 2), (18, 39, 1),
  (19, 30, 1), (19, 46, 2),
  (20, 34, 1), (20, 5, 1), (20, 18, 2);

-- Generate extra random reviews
CREATE TEMPORARY TABLE temp_reviews AS
SELECT 
    product_id,
    user_id,
    rating,
    CASE
        WHEN rating = 5 THEN CASE FLOOR(1 + RAND() * 3)
            WHEN 1 THEN CONCAT('Wyborny produkt z kategorii ', category, '! ', title, ' przeszedł moje wszelkie oczekiwania. Bardzo polecam!')
            WHEN 2 THEN CONCAT('Rewelacja! ', title, ' to najlepszy zakup w tej kategorii ', category, ' w tym roku.')
            WHEN 3 THEN CONCAT('Fantastyczny produkt! ', title, ' jest dokładnie tym, czego szukałem.')
        END

        WHEN rating = 4 THEN CASE FLOOR(1 + RAND() * 3)
            WHEN 1 THEN CONCAT('Super produkt z kategorii ', category, '! ', title, ' działa świetnie i jestem w miarę zachwycony.')
            WHEN 2 THEN CONCAT('Bardzo dobry produkt. ', title, ' spełnił moje oczekiwania.')
            WHEN 3 THEN CONCAT('Polecam! ', title, ' to dobry wybór w kategorii ', category, '.')
        END

        WHEN rating = 3 THEN CASE FLOOR(1 + RAND() * 3)
            WHEN 1 THEN CONCAT('Średni produkt z kategorii ', category, '. ', title, ' nie zachwyca, ale nie jest porażką.')
            WHEN 2 THEN CONCAT(title, ' jest w porządku, ale nic specjalnego.')
            WHEN 3 THEN CONCAT('Tak sobie. ', title, ' spełnia minimum, ale nic więcej.')
        END

        WHEN rating = 2 THEN CASE FLOOR(1 + RAND() * 3)
            WHEN 1 THEN CONCAT('Nie do końca zachwycony produktem ', title, ' z kategorii ', category, '. Wiele aspektów jest do poprawienia.')
            WHEN 2 THEN CONCAT(title, ' mógłby być lepszy, sporo rzeczy mnie zawiodło.')
            WHEN 3 THEN CONCAT('Słaby produkt z kategorii ', category, '. ', title, ' nie spełnił moich oczekiwań.')
        END

        WHEN rating = 1 THEN CASE FLOOR(1 + RAND() * 3)
            WHEN 1 THEN CONCAT('Okropny produkt z kategorii ', category, '. Nie polecam. ', title, ' jest kompletną porażką.')
            WHEN 2 THEN CONCAT('Zdecydowanie odradzam zakup ', title, ' z kategorii ', category, '. Szkoda pieniędzy.')
            WHEN 3 THEN CONCAT('Najgorszy produkt jaki miałem. ', title, ' to totalna strata czasu.')
        END
    END AS description,
    DATE_SUB(CURDATE(), INTERVAL FLOOR(RAND() * 365) DAY) AS created_at
FROM (
    SELECT 
        _p.product_id AS product_id,
        _c.title AS category,
        _u.user_id AS user_id,
        _p.title AS title,
        -- Range: [1, 5], strong bias towards 5, 4
        IF(RAND() < 0.8, IF(RAND() < 0.75, 5, 4), ROUND(1 + RAND() * 4)) AS rating,
        DATE_SUB(CURDATE(), INTERVAL FLOOR(RAND() * 365) DAY) AS created_at
    FROM 
        users _u
        CROSS JOIN (SELECT 1 AS n UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5) AS _r
        CROSS JOIN products _p
        JOIN categories _c ON _c.category_id = _p.category_id
    LIMIT 4800 -- 48 products × 20 users × 5 = 4800 total reviews
) AS _t;

INSERT INTO reviews (rating, description, user_id, product_id, created_at)
SELECT rating, description, user_id, product_id, created_at FROM temp_reviews;

DROP TEMPORARY TABLE IF EXISTS temp_reviews;
