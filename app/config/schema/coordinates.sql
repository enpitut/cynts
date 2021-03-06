CREATE TABLE coordinates (
    id         INT NOT NULL AUTO_INCREMENT,
    user_id    INT,
    photo      TEXT,
    n_like     INT NOT NULL,
    n_unlike   INT NOT NULL,
    status     INT,
    created_at DATETIME,
    updated_at TIMESTAMP    DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY (user_id),
    KEY (status)
)
    ENGINE = InnoDB
    DEFAULT CHARSET = utf8mb4;
