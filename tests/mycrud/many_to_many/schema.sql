CREATE TABLE test_users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

CREATE TABLE test_roles (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

CREATE TABLE test_user_role (
    user_id INT UNSIGNED NOT NULL,
    role_id INT UNSIGNED NOT NULL,
    PRIMARY KEY (user_id, role_id),
    CONSTRAINT fk_test_user_role_user FOREIGN KEY (user_id) REFERENCES test_users(id),
    CONSTRAINT fk_test_user_role_role FOREIGN KEY (role_id) REFERENCES test_roles(id)
);
