--wszystkie produkty 
-- select * from products; 

--koszyki dla uzytkownika (po user_id)
-- select * from carts where user_id = ?;

--produkt nalezacy do koszyka (po cart_id)
-- select p.name, p.price, p.photo from products p join cart_items ci on p.product_id = ci.product_id where ci.cart_id = 1;