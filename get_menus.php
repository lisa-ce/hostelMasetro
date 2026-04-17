<?php
header('Content-Type: application/json');
include 'db.php';

$startDate = new DateTime('2026-04-13');
$today = new DateTime();

$startDate->setTime(0, 0, 0);
$today->setTime(0, 0, 0);

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
            m.item_description
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

$menus = [];

while ($row = $result->fetch_assoc()) {
    $day = (int)$row['day_of_week'];
    $meal = $row['meal_type'];

    if (!isset($menus[$day])) {
        $menus[$day] = [
            'breakfast' => [],
            'lunch' => [],
            'dinner' => []
        ];
    }

    $menus[$day][$meal][] = [
        'item_name' => $row['item_name'],
        'item_description' => $row['item_description']
    ];
}

echo json_encode([
    'cycle' => $currentCycle,
    'menus' => $menus
]);
?>