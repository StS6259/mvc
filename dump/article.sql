create table article (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(50) not null,
    `content` text NOT NULL,
    `member_id` int(10) unsigned,
    `country_code` VARCHAR(2),
    PRIMARY KEY (`id`),
    UNIQUE KEY `members_title_unique` (`title`),
    CONSTRAINT `article_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `member`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
