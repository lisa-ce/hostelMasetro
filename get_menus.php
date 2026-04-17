<?php
header('Content-Type: application/json');
include 'db.php';

// Nicolleth starts on 2026-04-13
$startDate = new DateTime('2026-04-13');
$today = new DateTime();
$today->setTime(0, 0, 0);
$startDate->setTime(0, 0, 0);

// If today is before start date, force Nicolleth
if ($today < $startDate) {
    $cycleIndex = 0;
} else {
    $daysPassed = $startDate->diff($today)->days;
    $weeksPassed = floor($daysPassed / 7);
    $cycleIndex = $weeksPassed % 3;
}

$cycles = ['Nicolleth', 'Rosy', 'Meriam'];
$currentCycle = $cycles[$cycleIndex];

$sql = "SELECT 
            m.day_of_week,
            m.meal_type,
            m.item_name,
            m.item_description,
            c.cycle_name
        FROM menu_items m
        JOIN cycles c ON m.cycle_id = c.id
        WHERE c.cycle_name = ?
        ORDER BY 
            m.day_of_week,
            FIELD(m.meal_type, 'breakfast', 'lunch', 'dinner'),
            m.id";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $currentCycle);
$stmt->execute();
$result = $stmt->get_result();

$groupedMenus = [];

while ($row = $result->fetch_assoc()) {
    $day = $row['day_of_week'];
    $meal = $row['meal_type'];

    if (!isset($groupedMenus[$day])) {
        $groupedMenus[$day] = [
            'breakfast' => [],
            'lunch' => [],
            'dinner' => []
        ];
    }

    $groupedMenus[$day][$meal][] = [
        'item_name' => $row['item_name'],
        'item_description' => $row['item_description']
    ];
}

echo json_encode([
    "cycle" => $currentCycle,
    "startDate" => $startDate->format('Y-m-d'),
    "menus" => $groupedMenus
]);
?>