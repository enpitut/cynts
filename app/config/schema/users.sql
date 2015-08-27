CREATE TABLE users (
    id         INT          NOT NULL AUTO_INCREMENT,
    name       VARCHAR(100) NOT NULL,
    mail       VARCHAR(300) NOT NULL,
    password   VARCHAR(300) NOT NULL,
    created_at DATETIME,
    updated_at TIMESTAMP             DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
)
    ENGINE = InnoDB
    DEFAULT CHARSET = utf8mb4;
