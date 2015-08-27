CREATE TABLE items (
    id          INT          NOT NULL AUTO_INCREMENT,
    name        VARCHAR(200) NOT NULL,
    shop_id     INT,
    colors      VARCHAR(250),
    sizes       VARCHAR(250),
    category    VARCHAR(50),
    price       INT,
    photos      TEXT,
    description TEXT,
    sex         TINYINT,
    status      INT,
    created_at  DATETIME,
    updated_at  TIMESTAMP             DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY (shop_id),
    KEY (category),
    KEY (price),
    KEY (sex),
    KEY (status)
)
    ENGINE = InnoDB
    DEFAULT CHARSET = utf8mb4;
