CREATE TABLE shops (
    id         INT          NOT NULL AUTO_INCREMENT,
    name       VARCHAR(100) NOT NULL,
    url        VARCHAR(300),
    address    VARCHAR(300),
    photos     TEXT,
    created_at DATETIME,
    updated_at TIMESTAMP             DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
)
    ENGINE = InnoDB
    DEFAULT CHARSET = utf8mb4;
