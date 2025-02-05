
CREATE TABLE mydatabases (
  id_mydatabase int(11) AUTO_INCREMENT PRIMARY KEY,
  database__name varchar(35) DEFAULT NULL
);

CREATE TABLE mytables (
  id_table int(11) AUTO_INCREMENT PRIMARY KEY,
  table__name varchar(35) DEFAULT NULL,
  mydatabase_id int(11) DEFAULT NULL
);

CREATE TABLE myfields (
  id_field int(11) AUTO_INCREMENT PRIMARY KEY,
  field_name varchar(35) DEFAULT NULL,
  field_position int(11) DEFAULT NULL,
  field_type_id int(11) DEFAULT NULL,
  field_size_id int(11) DEFAULT NULL,
  field_index_id int(11) DEFAULT NULL,
  table_id int(11) DEFAULT NULL
);

CREATE TABLE field_types (
  id_field_type int(11) AUTO_INCREMENT PRIMARY KEY,
  field_type varchar(20) DEFAULT NULL
);

CREATE TABLE field_sizes (
  id_field_size int(11) AUTO_INCREMENT PRIMARY KEY,
  field_size varchar(10) DEFAULT NULL
);

CREATE TABLE field_indexes (
  id_field_index int(11) AUTO_INCREMENT PRIMARY KEY,
  field_index varchar(11) DEFAULT NULL
);

ALTER TABLE myfields
  ADD KEY field_type_id (field_type_id),
  ADD KEY field_index_id (field_index_id),
  ADD KEY field_size_id (field_size_id),
  ADD KEY table_id (table_id);

ALTER TABLE mytables
  ADD KEY id_mydatabase (mydatabase_id);

ALTER TABLE myfields
  ADD CONSTRAINT myfields_ibfk_1 FOREIGN KEY (field_index_id) REFERENCES field_indexes (id_field_index) ON UPDATE CASCADE,
  ADD CONSTRAINT myfields_ibfk_2 FOREIGN KEY (field_type_id) REFERENCES field_types (id_field_type) ON UPDATE CASCADE,
  ADD CONSTRAINT myfields_ibfk_3 FOREIGN KEY (field_size_id) REFERENCES field_sizes (id_field_size) ON UPDATE CASCADE,
  ADD CONSTRAINT myfields_ibfk_4 FOREIGN KEY (table_id) REFERENCES mytables (id_table) ON UPDATE CASCADE;

ALTER TABLE mytables
  ADD CONSTRAINT mytables_ibfk_1 FOREIGN KEY (mydatabase_id) REFERENCES mydatabases (id_mydatabase) ON UPDATE CASCADE;

INSERT INTO mydatabases (id_mydatabase, database__name) VALUES
(15, 'aa_ventas_prueba');

INSERT INTO mytables (id_table, table__name, mydatabase_id) VALUES
(28, 'clientes', 15),
(29, 'vendedores', 15),
(33, 'proveedores', 15),
(34, 'productos', 15),
(35, 'citas', 15);

INSERT INTO field_types (id_field_type, field_type) VALUES
(1, 'int'),
(2, 'varchar'),
(3, 'date'),
(4, 'datetime');

INSERT INTO field_sizes (id_field_size, field_size) VALUES
(1, '11'),
(2, '25'),
(3, '35'),
(4, '45'),
(5, '55'),
(6, '190'),
(7, '50'),
(8, '100');

INSERT INTO field_indexes (id_field_index, field_index) VALUES
(1, 'N/A'),
(2, 'INDEX'),
(3, 'PRIMARY KEY');

INSERT INTO myfields (id_field, field_name, field_position, field_type_id, field_size_id, field_index_id, table_id) VALUES
(2, 'nombre', 2, 2, 6, 1, 28),
(3, 'id_vendedor', 1, 1, 1, 3, 29),
(4, 'nombre', 2, 2, 6, 1, 29),
(30, 'id_cliente', 1, 1, 1, 3, 28),
(31, 'apellido', 3, 2, 5, 1, 28),
(32, 'direccion', 4, 2, 6, 1, 28),
(33, 'celular', 5, 1, 2, 1, 28),
(34, 'apellido', 3, 2, 5, 1, 29),
(35, 'direccion', 4, 2, 6, 1, 29),
(36, 'celular', 5, 1, 2, 1, 29),
(37, 'id_proveedor', 1, 1, 1, 3, 33),
(38, 'nombre', 2, 2, 3, 1, 33),
(40, 'id_producto', 1, 1, 1, 3, 34),
(41, 'nombre', 2, 2, 3, 1, 34),
(43, 'proveedor_id', 3, 1, 1, 2, 34),
(48, 'id_cita', 1, 1, 1, 3, 35),
(49, 'producto_id', 2, 1, 1, 2, 35),
(50, 'vendedor_id', 3, 1, 1, 2, 35),
(51, 'cliente_id', 4, 1, 1, 2, 35);
