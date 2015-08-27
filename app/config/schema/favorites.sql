CREATE TABLE favorites (
    id            INT NOT NULL AUTO_INCREMENT,
    user_id       INT NOT NULL,
    coordinate_id INT NOT NULL,
    status        INT,
    created_at    DATETIME,
    updated_at    TIMESTAMP    DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE (user_id, coordinate_id),
    KEY (status)
)
    ENGINE = InnoDB
    DEFAULT CHARSET = utf8mb4;
