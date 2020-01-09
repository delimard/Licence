
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- Licence
-- ---------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `Licence`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `order_id` INTEGER,
    `customer_id` INTEGER,
    `product_id` INTEGER,
    `product_key` TEXT,
    `active_machine` TEXT,
    `expiration_date` DATE,
    `version` INTEGER DEFAULT 0,
    `version_created_at` DATETIME,
    `version_created_by` VARCHAR(100),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- Licence_version
-- ---------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `Licence_version`
(
    `id` INTEGER NOT NULL,
    `order_id` INTEGER,
    `customer_id` INTEGER,
    `product_id` INTEGER,
    `product_key` TEXT,
    `active_machine` TEXT,
    `expiration_date` DATE,
    `version` INTEGER DEFAULT 0 NOT NULL,
    `version_created_at` DATETIME,
    `version_created_by` VARCHAR(100),
    PRIMARY KEY (`id`,`version`),
    CONSTRAINT `Licence_version_FK_1`
        FOREIGN KEY (`id`)
        REFERENCES `Licence` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
