CREATE TABLE categories (
    id INT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    alias VARCHAR(255) NOT NULL,
    parent_id INT DEFAULT NULL,
    FOREIGN KEY (parent_id) REFERENCES categories(id)
);

