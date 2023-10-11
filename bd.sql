
CREATE TABLE items (
                       id bigint(20) UNSIGNED NOT NULL,
                       name varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                       code bigint(20) UNSIGNED NOT NULL,
                       weight decimal(12,3) DEFAULT NULL,
                       usagetxt text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                       quantity_1 int(11) NOT NULL DEFAULT 0,
                       quantity_2 int(11) NOT NULL DEFAULT 0,
                       quantity_3 int(11) NOT NULL DEFAULT 0,
                       quantity_4 int(11) NOT NULL DEFAULT 0,
                       quantity_5 int(11) NOT NULL DEFAULT 0,
                       quantity_6 int(11) NOT NULL DEFAULT 0,
                       quantity_7 int(11) NOT NULL DEFAULT 0,
                       quantity_8 int(11) NOT NULL DEFAULT 0,
                       price_1 int(11) NOT NULL DEFAULT 0,
                       price_2 int(11) NOT NULL DEFAULT 0,
                       price_3 int(11) NOT NULL DEFAULT 0,
                       price_4 int(11) NOT NULL DEFAULT 0,
                       price_5 int(11) NOT NULL DEFAULT 0,
                       price_6 int(11) NOT NULL DEFAULT 0,
                       price_7 int(11) NOT NULL DEFAULT 0,
                       price_8 int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE items
    ADD PRIMARY KEY (id),
  ADD UNIQUE KEY codeindex (code);

ALTER TABLE items
    MODIFY id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;