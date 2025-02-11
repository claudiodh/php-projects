-- Create the database
CREATE DATABASE IF NOT EXISTS c3015_lab4;
USE c3015_lab4;

-- Create the inventory table
CREATE TABLE IF NOT EXISTS inventory (
                                         id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                                         item_name VARCHAR(255) NOT NULL,
                                         quantity INT UNSIGNED NOT NULL
);

-- Insert sample data (Matching Screenshot)
INSERT INTO inventory (item_name, quantity) VALUES
                                                ('Apples', 10),
                                                ('Pineapples', 126),
                                                ('Kraft Dinner', 138),
                                                ('Pineapples', 99),
                                                ('Oikos Greek Yogurt', 25),
                                                ('Pierogis', 199);