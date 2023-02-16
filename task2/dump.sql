CREATE TABLE goods (
                       id INT PRIMARY KEY,
                       name VARCHAR(255)
);

CREATE TABLE additional_fields (
                                   id INT PRIMARY KEY,
                                   name VARCHAR(255)
);

CREATE TABLE additional_field_values (
                                         id INT PRIMARY KEY,
                                         additional_field_id INT,
                                         value VARCHAR(255),
                                         FOREIGN KEY (additional_field_id) REFERENCES additional_fields(id)
);

CREATE TABLE additional_goods_field_values (
                                               id INT PRIMARY KEY,
                                               good_id INT,
                                               additional_field_value_id INT,
                                               FOREIGN KEY (good_id) REFERENCES goods(id),
                                               FOREIGN KEY (additional_field_value_id) REFERENCES additional_field_values(id)
);

INSERT INTO goods (id, name) VALUES (1, 'Товар 1'), (2, 'Товар 2'), (3, 'Товар 3');

INSERT INTO additional_fields (id, name) VALUES (1, 'Дополнительное поле 1'), (2, 'Дополнительное поле 2'), (3, 'Дополнительное поле 3');

INSERT INTO additional_field_values (id, additional_field_id, value) VALUES
(1, 1, 'Значение 1'), (2, 1, 'Значение 2'), (3, 2, 'Значение 3'), (4, 2, 'Значение 4'), (5, 3, 'Значение 5'), (6, 3, 'Значение 6');

INSERT INTO additional_goods_field_values (id, good_id, additional_field_value_id) VALUES
(1, 1, 1), (2, 1, 3), (3, 2, 2), (4, 2, 4), (5, 3, 1), (6, 3, 6);
