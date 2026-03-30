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


--MENU OVVERIDE

CREATE TABLE menu_override (
    override_id INT PRIMARY KEY IDENTITY(1,1),
    override_date DATE NOT NULL,
    day_of_week VARCHAR(20) NOT NULL,
    meal_type VARCHAR(20) NOT NULL,
    meal_name VARCHAR(255) NOT NULL,
    side_items VARCHAR(500),
    reason VARCHAR(255)
);


--ADMIN USER
CREATE TABLE admin_user (
    user_id INT PRIMARY KEY IDENTITY(1,1),
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL
);


--THE CYCLES

INSERT INTO menu_cycle (cycle_name, cycle_order)
VALUES
('Nicolleth', 1),
('Rosy', 2),
('Meriam', 3);


USE HostelMenuDB;
GO

INSERT INTO menu_item (cycle_id, day_of_week, meal_type, meal_name, side_items)
VALUES

-- =====================================================
-- NICOLLETH (cycle_id = 1)
-- =====================================================

-- Monday
(1, 'Monday', 'Breakfast', 'Boiled egg', 'Weet-bix, Sugar, Bread, Margarine, Jam, Milk, Tea/Coffee'),
(1, 'Monday', 'Lunch', 'Brisket', 'Rice, Vegetables, Juice'),
(1, 'Monday', 'Supper', 'Russian', 'Hotdog, Chakalaka, Bread, Margarine, Peanut Butter, Fruit, Tea/Coffee'),

-- Tuesday
(1, 'Tuesday', 'Breakfast', 'Viennas', 'Taysteewheat, Sugar, Bread, Margarine, Peanut Butter, Milk, Tea/Coffee'),
(1, 'Tuesday', 'Lunch', 'Chicken Potjie', 'Rice, Salad, Juice'),
(1, 'Tuesday', 'Supper', 'Mince', 'Lasagna, Bread, Margarine, Jam, Fruit, Tea/Coffee'),

-- Wednesday
(1, 'Wednesday', 'Breakfast', 'Cheese', 'Cornflakes, Sugar, Bread, Margarine, Jam, Milk, Tea/Coffee'),
(1, 'Wednesday', 'Lunch', 'Mutton', 'Elbows, Vegetables, Juice'),
(1, 'Wednesday', 'Supper', 'Hake Fish', 'Potato Wedges, Bread, Margarine, Peanut Butter, Fruit, Tea/Coffee'),

-- Thursday
(1, 'Thursday', 'Breakfast', 'Boerewors', 'Oats, Sugar, Bread, Margarine, Peanut Butter, Milk, Tea/Coffee'),
(1, 'Thursday', 'Lunch', 'Pork Chops', 'Rice, Salad, Juice'),
(1, 'Thursday', 'Supper', 'Boerewors Stew', 'Spaghetti, Bread, Margarine, Jam, Fruit, Tea/Coffee'),

-- Friday
(1, 'Friday', 'Breakfast', 'Fish Fingers', 'Weet-bix, Sugar, Bread, Margarine, Jam, Milk, Tea/Coffee'),
(1, 'Friday', 'Lunch', 'Beef Stroganoff', 'Elbows, Vegetables, Juice'),
(1, 'Friday', 'Supper', 'Meat Pies', 'Chips, Bread, Margarine, Peanut Butter, Fruit, Tea/Coffee'),

-- Saturday
(1, 'Saturday', 'Breakfast', 'Polony', 'Taysteewheat, Sugar, Bread, Margarine, Peanut Butter, Milk, Tea/Coffee'),
(1, 'Saturday', 'Lunch', 'Chicken Baked', 'Garlic Potatoes, Salad, Juice, Pudding'),
(1, 'Saturday', 'Supper', 'Mince Patty', 'Pizza/Fatcake/Rice, Bread, Margarine, Jam, Fruit, Tea/Coffee'),

-- Sunday
(1, 'Sunday', 'Breakfast', 'Scrambled Eggs', 'Cornflakes, Sugar, Bread, Margarine, Jam, Milk, Tea/Coffee'),
(1, 'Sunday', 'Lunch', 'Steak', 'Curry Noodle, Vegetables, Juice, Pudding'),
(1, 'Sunday', 'Supper', 'Chicken Stirfry', 'Cheese Burger/Green Salad, Bread, Margarine, Peanut Butter, Fruit, Tea/Coffee'),

-- =====================================================
-- ROSY (cycle_id = 2)
-- =====================================================

-- Monday
(2, 'Monday', 'Breakfast', 'Vienna', 'Taysteewheat, Sugar, Bread, Margarine, Jam, Milk, Tea/Coffee'),
(2, 'Monday', 'Lunch', 'Mutton Stew', 'Rice, Salad, Vegetables, Juice'),
(2, 'Monday', 'Supper', 'Vienna', 'Potato Baked, Bread, Margarine, Peanut Butter, Fruit, Tea/Coffee'),

-- Tuesday
(2, 'Tuesday', 'Breakfast', 'Polonies', 'Cornflakes, Sugar, Bread, Margarine, Peanut Butter, Milk, Tea/Coffee'),
(2, 'Tuesday', 'Lunch', 'Chutney Chicken', 'Spaghetti, Vegetables, Salad, Juice'),
(2, 'Tuesday', 'Supper', 'Boerewors', 'Noodle Salad, Bread, Margarine, Jam, Fruit, Tea/Coffee'),

-- Wednesday
(2, 'Wednesday', 'Breakfast', 'Boiled Egg', 'Oats, Sugar, Bread, Margarine, Jam, Milk, Tea/Coffee'),
(2, 'Wednesday', 'Lunch', 'Beef Stirfry', 'Elbows, Salad, Vegetables, Juice'),
(2, 'Wednesday', 'Supper', 'Chicken Schnitzel', 'Hamburger, Cheese Chips, Bread, Margarine, Peanut Butter, Fruit, Tea/Coffee'),

-- Thursday
(2, 'Thursday', 'Breakfast', 'Fish Fingers', 'Weetbix, Sugar, Bread, Margarine, Peanut Butter, Milk, Tea/Coffee'),
(2, 'Thursday', 'Lunch', 'Pork Chops', 'Mash Potato, Vegetables, Salad, Juice'),
(2, 'Thursday', 'Supper', 'Mince Balls', 'Spaghetti, Bread, Margarine, Jam, Fruit, Tea/Coffee'),

-- Friday
(2, 'Friday', 'Breakfast', 'Boerewors', 'Taysteewheat, Sugar, Bread, Margarine, Jam, Milk, Tea/Coffee'),
(2, 'Friday', 'Lunch', 'Lamb Chops', 'Starch Salad, Salad, Vegetables, Juice'),
(2, 'Friday', 'Supper', 'Russian', 'Brotchen, Bread, Margarine, Peanut Butter, Fruit, Tea/Coffee'),

-- Saturday
(2, 'Saturday', 'Breakfast', 'Cheese', 'Oats, Sugar, Bread, Margarine, Peanut Butter, Milk, Tea/Coffee'),
(2, 'Saturday', 'Lunch', 'Fish', 'Rice, Salad, Juice, Pudding'),
(2, 'Saturday', 'Supper', 'Pie', 'Chips, Polonies, Bread, Margarine, Jam, Fruit, Tea/Coffee'),

-- Sunday
(2, 'Sunday', 'Breakfast', 'Scrambled Eggs', 'Cornflakes, Sugar, Bread, Margarine, Jam, Milk, Tea/Coffee'),
(2, 'Sunday', 'Lunch', 'Brisket', 'Noodle, Vegetables, Salad, Juice, Pudding'),
(2, 'Sunday', 'Supper', 'Chicken Drum', 'Potato Salad, Bread, Margarine, Peanut Butter, Fruit, Tea/Coffee'),

-- =====================================================
-- MERIAM (cycle_id = 3)
-- =====================================================

-- Monday
(3, 'Monday', 'Breakfast', 'Vienna', 'Oats, Sugar, Bread, Margarine, Peanut Butter, Milk, Tea/Coffee'),
(3, 'Monday', 'Lunch', 'Chicken Curry', 'Noodle, Vegetable Salad, Juice'),
(3, 'Monday', 'Supper', 'Mince', 'Spaghetti, Cheese, Bread, Margarine, Jam, Fruit, Tea/Coffee'),

-- Tuesday
(3, 'Tuesday', 'Breakfast', 'Fish Fingers', 'Weet-bix, Sugar, Bread, Margarine, Jam, Milk, Tea/Coffee'),
(3, 'Tuesday', 'Lunch', 'Beef Stew', 'Mash Potatoes, Vegetables Salad, Juice'),
(3, 'Tuesday', 'Supper', 'Meat Pie', 'Chips, Bread, Margarine, Jam, Fruit, Tea/Coffee'),

-- Wednesday
(3, 'Wednesday', 'Breakfast', 'Polonies', 'Taystee Wheat, Sugar, Bread, Margarine, Peanut Butter, Milk, Tea/Coffee'),
(3, 'Wednesday', 'Lunch', 'Fish', 'Rice, Salad, Vegetables, Juice'),
(3, 'Wednesday', 'Supper', 'Boerewors', 'Noodle Salad, Bread, Margarine, Jam, Fruit, Tea/Coffee'),

-- Thursday
(3, 'Thursday', 'Breakfast', 'Boerewors', 'Cornflakes, Sugar, Bread, Margarine, Jam, Milk, Tea/Coffee'),
(3, 'Thursday', 'Lunch', 'Brisket', 'Butter Potatoes, Vegetables, Salad, Juice'),
(3, 'Thursday', 'Supper', 'Chicken Drum', 'Salad, Bread, Margarine, Jam, Fruit, Tea/Coffee'),

-- Friday
(3, 'Friday', 'Breakfast', 'Boiled Eggs', 'Oats, Sugar, Bread, Margarine, Peanut Butter, Milk, Tea/Coffee'),
(3, 'Friday', 'Lunch', 'Spare Rib', 'Rice, Vegetable Salad, Juice'),
(3, 'Friday', 'Supper', 'Viennas', 'Potato Baked, Bread, Margarine, Jam, Fruit, Tea/Coffee'),

-- Saturday
(3, 'Saturday', 'Breakfast', 'Cold Meat', 'Weet-bix, Sugar, Bread, Margarine, Jam, Milk, Tea/Coffee'),
(3, 'Saturday', 'Lunch', 'Mutton', 'Noodles, Vegetable Salad, Juice, Pudding'),
(3, 'Saturday', 'Supper', 'Fish', 'Chips, Bread, Margarine, Jam, Fruit, Tea/Coffee'),

-- Sunday
(3, 'Sunday', 'Breakfast', 'Scrambled Eggs', 'Taystee Wheat, Sugar, Bread, Margarine, Peanut Butter, Milk, Tea/Coffee'),
(3, 'Sunday', 'Lunch', 'Chicken', 'Rice, Vegetable Salad, Juice, Pudding'),
(3, 'Sunday', 'Supper', 'Mince', 'Lasagna/Cheese Mix Salad, Bread, Margarine, Jam, Fruit, Tea/Coffee');
GO