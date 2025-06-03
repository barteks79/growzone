SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `carts` (
  `cart_id` int NOT NULL,
  `user_id` int NOT NULL
);


CREATE TABLE `cart_items` (
  `cart_item_id` int NOT NULL,
  `product_id` int DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `cart_id` int DEFAULT NULL
);

CREATE TABLE `orders` (
  `order_id` int NOT NULL,
  `order_date` date NOT NULL,
  `status` enum('dostarczono','oplacono','wyslano') DEFAULT NULL,
  `shipping_address_id` int DEFAULT NULL,
  `delivery_date` date DEFAULT NULL,
  `user_id` int NOT NULL
);

CREATE TABLE `products` (
  `product_id` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `photo` text,
  `stock_quantity` tinyint(1) NOT NULL DEFAULT '1'
);

CREATE TABLE `shipping_address` (
  `shipping_address_id` int NOT NULL,
  `street` varchar(255) NOT NULL,
  `building_number` varchar(10) NOT NULL,
  `apartment_number` varchar(10) DEFAULT NULL,
  `city` varchar(100) NOT NULL,
  `postal_code` varchar(20) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL
);

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `reset_token` VARCHAR(100),
  `token_expires` DATETIME
); 


ALTER TABLE `carts`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `fk_cart_items_user` (`user_id`);


ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`cart_item_id`),
  ADD KEY `fk_carts_cart_items` (`cart_id`),
  ADD KEY `fk_cart_items_products` (`product_id`);


ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `fk_orders_users` (`user_id`),
  ADD KEY `fk_orders_shipping_address` (`shipping_address_id`);


ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);


ALTER TABLE `shipping_address`
  ADD PRIMARY KEY (`shipping_address_id`);


ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);


ALTER TABLE `carts`
  MODIFY `cart_id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `cart_items`
  MODIFY `cart_item_id` int NOT NULL AUTO_INCREMENT;


ALTER TABLE `orders`
  MODIFY `order_id` int NOT NULL AUTO_INCREMENT;


ALTER TABLE `products`
  MODIFY `product_id` int NOT NULL AUTO_INCREMENT;


ALTER TABLE `shipping_address`
  MODIFY `shipping_address_id` int NOT NULL AUTO_INCREMENT;


ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT;


ALTER TABLE `carts`
  ADD CONSTRAINT `fk_cart_items_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);


ALTER TABLE `cart_items`
  ADD CONSTRAINT `fk_cart_items_products` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`),
  ADD CONSTRAINT `fk_carts_cart_items` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`cart_id`);


ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_shipping_address` FOREIGN KEY (`shipping_address_id`) REFERENCES `shipping_address` (`shipping_address_id`),
  ADD CONSTRAINT `fk_orders_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;
