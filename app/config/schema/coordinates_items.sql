CREATE TABLE coordinates_items (
    coordinate_id INT NOT NULL,
    item_id       INT NOT NULL,
    color         VARCHAR(50),
    size          VARCHAR(50),
    status        INT,
    created_at    DATETIME,
    updated_at    TIMESTAMP DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE (coordinate_id, item_id),
    KEY (item_id),
    KEY (status)
)
    ENGINE = InnoDB
    DEFAULT CHARSET = utf8mb4;
