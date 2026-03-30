CREATE DATABASE HostelMenuDB;
GO
USE HostelMenuDB;
GO
CREATE TABLE menu_cycle(
cycle_id INT PRIMARY KEY IDENTITY(1,1),
cycle_name VARCHAR(50) NOT NULL,
    cycle_order INT NOT NULL UNIQUE
);
