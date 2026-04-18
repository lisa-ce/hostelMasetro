<?php
header('Content-Type: application/json');
include 'db.php';

$startDate = new DateTime('2026-04-13');
$today = new DateTime();

$startDate->setTime(0, 0, 0);
$today->setTime(0, 0, 0);

// figure out current cycle
if ($today < $startDate) {
    $cycleIndex = 0;
} else {
    $daysPassed = $startDate->diff($today)->days;
    $weeksPassed = floor($daysPassed / 7);
    $cycleIndex = $weeksPassed % 3;
}

$cycles = ['Nicolleth', 'Rosy', 'Meriam'];
$currentCycle = $cycles[$cycleIndex];

// get planned menu for current cycle
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

// initialize all 7 days
for ($day = 0; $day <= 6; $day++) {
    $menus[$day] = [
        'date' => '',
        'breakfast' => [],
        'lunch' => [],
        'dinner' => [],
        'breakfast_note' => '',
        'lunch_note' => '',
        'dinner_note' => '',
        'breakfast_source' => 'planned',
        'lunch_source' => 'planned',
        'dinner_source' => 'planned'
    ];
}

// fill planned data
while ($row = $result->fetch_assoc()) {
    $day = (int)$row['day_of_week'];
    $meal = $row['meal_type'];

    $menus[$day][$meal][] = [
        'item_name' => $row['item_name'],
        'item_description' => $row['item_description']
    ];
}

$stmt->close();

// assign actual calendar date to each day in this week
$todayDayNumber = (int)$today->format('w'); // 0=Sun, 1=Mon, ..., 6=Sat

for ($day = 0; $day <= 6; $day++) {
    $diff = $day - $todayDayNumber;

    $menuDate = clone $today;
    if ($diff !== 0) {
        $menuDate->modify(($diff > 0 ? '+' : '') . $diff . ' days');
    }

    $menus[$day]['date'] = $menuDate->format('Y-m-d');

    // now check overrides for this actual date
    $overrideSql = "SELECT meal_type, item_name, item_description, notes
                    FROM menu_overrides
                    WHERE override_date = ?
                    ORDER BY FIELD(meal_type, 'breakfast', 'lunch', 'dinner'), id";

    $overrideStmt = $conn->prepare($overrideSql);
    $dateString = $menuDate->format('Y-m-d');
    $overrideStmt->bind_param("s", $dateString);
    $overrideStmt->execute();
    $overrideResult = $overrideStmt->get_result();

    $overrideMeals = [
        'breakfast' => [],
        'lunch' => [],
        'dinner' => []
    ];

    $overrideNotes = [
        'breakfast' => '',
        'lunch' => '',
        'dinner' => ''
    ];

    while ($overrideRow = $overrideResult->fetch_assoc()) {
        $mealType = $overrideRow['meal_type'];

        $overrideMeals[$mealType][] = [
            'item_name' => $overrideRow['item_name'],
            'item_description' => $overrideRow['item_description']
        ];

        if (!empty($overrideRow['notes'])) {
            $overrideNotes[$mealType] = $overrideRow['notes'];
        }
    }

    $overrideStmt->close();

    // replace planned meal only if override exists
    foreach (['breakfast', 'lunch', 'dinner'] as $mealType) {
        if (!empty($overrideMeals[$mealType])) {
            $menus[$day][$mealType] = $overrideMeals[$mealType];
            $menus[$day][$mealType . '_note'] = $overrideNotes[$mealType];
            $menus[$day][$mealType . '_source'] = 'override';
        }
    }
}

echo json_encode([
    'cycle' => $currentCycle,
    'menus' => $menus
]);

$conn->close();
?>