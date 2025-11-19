
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS messages;

CREATE TABLE users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT UNIQUE,
    password TEXT
);

CREATE TABLE messages (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER,
    content TEXT,
    FOREIGN KEY(user_id) REFERENCES users(id)
);

INSERT INTO users(username,password) VALUES ('admin','admin123');
INSERT INTO messages(user_id, content) VALUES (1,'Welcome to <b>VulnApp</b>! Post something malicious :)');
