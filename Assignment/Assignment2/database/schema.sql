DROP DATABASE IF EXISTS article_aggregator_co;
CREATE DATABASE IF NOT EXISTS article_aggregator_co;
USE article_aggregator_co;

CREATE TABLE IF NOT EXISTS users (
                                     `id` INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
                                     `password` VARCHAR(255),
                                     `email` VARCHAR(255) NOT NULL UNIQUE,
                                     `name` VARCHAR(255) NOT NULL,
                                     `profile_picture` VARCHAR(255) DEFAULT 'default.jpg'
);

CREATE TABLE IF NOT EXISTS articles (
                                        `id` INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
                                        `title` VARCHAR(255) NOT NULL,
                                        `url` VARCHAR(255) NOT NULL,
                                        `created_at` DATETIME NOT NULL,
                                        `updated_at` DATETIME,
                                        `author_id` INT NOT NULL,
                                        FOREIGN KEY (author_id) REFERENCES users (id)
);

