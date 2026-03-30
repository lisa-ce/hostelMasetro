CREATE DATABASE HostelMenuDB;
GO
USE HostelMenuDB;
GO

--CYCLE TABLE
CREATE TABLE menu_cycle(
cycle_id INT PRIMARY KEY IDENTITY(1,1),
cycle_name VARCHAR(50) NOT NULL,
    cycle_order INT NOT NULL UNIQUE
);


--MENU TABLE

CREATE TABLE menu_item (
    menu_id INT PRIMARY KEY IDENTITY(1,1),
    cycle_id INT NOT NULL,
    day_of_week VARCHAR(20) NOT NULL,
    meal_type VARCHAR(20) NOT NULL,
    meal_name VARCHAR(255) NOT NULL,
    side_items VARCHAR(500),
    FOREIGN KEY (cycle_id) REFERENCES menu_cycle(cycle_id)
);