ALTER TABLE user
    ADD CONSTRAINT pk_user_user_id PRIMARY KEY (user_id);

ALTER TABLE stores
    ADD CONSTRAINT pk_stores_store_id PRIMARY KEY (store_id);

ALTER TABLE categories
    ADD CONSTRAINT pk_categories_category_id PRIMARY KEY (category_id);

ALTER TABLE products
    ADD CONSTRAINT pk_products_product_id PRIMARY KEY (product_id),
    ADD CONSTRAINT fk_category_id_on_products FOREIGN KEY (category_id) REFERENCES categories (category_id);

ALTER TABLE product_images
    ADD CONSTRAINT pk_product_images_product_images_id PRIMARY KEY (product_images_id),
    ADD CONSTRAINT fk_product_id_on_product_images FOREIGN KEY (product_id) REFERENCES products (products_id);

ALTER TABLE orders
    ADD CONSTRAINT pk_orders_order_id PRIMARY KEY (order_id),
    ADD CONSTRAINT fk_user_id_on_orders FOREIGN KEY (user_id) REFERENCES 'user' (user_id);

ALTER TABLE order_items
    ADD CONSTRAINT pk_order_items_order_item_id PRIMARY KEY (order_item_id),
    ADD CONSTRAINT fk_order_id_on_order_items FOREIGN KEY (order_id) REFERENCES orders (order_id),
    ADD CONSTRAINT fk_product_id_on_order_items FOREIGN KEY (product_id) REFERENCES products (products_id);



