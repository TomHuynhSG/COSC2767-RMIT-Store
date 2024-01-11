-- Revoke privileges and drop the user
DROP USER 'db_admin'@'localhost';

-- Drop the database
DROP DATABASE IF EXISTS rmit_store_db;

-- Note: If you want to keep the database and only remove the table, comment the above DROP DATABASE line
-- and uncomment the following line:
-- DROP TABLE IF EXISTS store;
