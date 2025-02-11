CREATE DATABASE IF NOT EXISTS posts_web_app;
USE posts_web_app;

CREATE TABLE IF NOT EXISTS posts (
                                     id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
                                     title VARCHAR(100) NOT NULL,
                                     body VARCHAR(512) NOT NULL,
                                     created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                     updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert a new post
INSERT INTO posts (title, body, created_at) VALUES("test1", "body1", NOW());

-- Update an existing post
UPDATE posts SET title = "Updated Title", updated_at = NOW() WHERE id=1;

-- Delete a post
DELETE FROM posts WHERE id = 1;