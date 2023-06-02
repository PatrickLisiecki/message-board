# Message Board

A message board web application built using HTML, CSS, PHP, and JavaScript. Features include user login and registration, post creation, and commenting.

# Installation

### Clone the repository:
```shell
git clone https://github.com/PatrickLisiecki/message-board.git
cd message-board
```

### Configure the database using MySQL:
```MySQL
CREATE TABLE users (
    userid INT PRIMARY KEY AUTO_INCREMENT,
    password CHAR(60) NOT NULL,
    email CHAR(255) NOT NULL,
    board_username CHAR(255) NOT NULL,
    UNIQUE(board_username)
); 

CREATE TABLE post (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title CHAR(255),
    body VARCHAR(5000),
    userid INT,
    date_time TIMESTAMP NOT NULL,
    FOREIGN KEY (userid) REFERENCES users(userid)
);

CREATE TABLE comments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    userid INT,
    body VARCHAR(5000),
    postid INT,
    date_time TIMESTAMP NOT NULL,
    FOREIGN KEY (userid) REFERENCES users(userid),
    FOREIGN KEY (postid) REFERENCES post(id)
);
```

### Create a configuration file:
* Create a private folder in the project's root directory
* In the private folder create a "config.ini" file
* Inside the config file include your database credentials
```ini
[database]
username = "your-username"
password = "your-password"
dbname = "your-dbname"
```

### Start a local development server:
```php
php -S localhost:7000
```

### Open the project in the browser:
```php
localhost:7000/src/login/login.php
```

# Collaborators
* https://github.com/PatrickLisiecki
* https://github.com/okGus
