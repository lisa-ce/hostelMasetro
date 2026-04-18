<?php
header('Content-Type: application/json');
include 'db.php';

date_default_timezone_set('Africa/Windhoek');

// Base cycle start:
// 2026-04-13 = Nicolleth
// 2026-04-20 = Rosy
// 2026-04-27 = Meriam
$cycleStartDate = new DateTime('2026-04-13');
$today = new DateTime();
$cycleStartDate->setTime(0, 0, 0);
$today->setTime(0, 0, 0);

// -------------------------
// 1. Work out current cycle
// -------------------------
if ($today < $cycleStartDate) {
    $cycleIndex = 0;
} else {
    $daysPassed = $cycleStartDate->diff($today)->days;
    $weeksPassed = floor($daysPassed / 7);
    $cycleIndex = $weeksPassed % 3;
}

$cycles = ['Nicolleth', 'Rosy', 'Meriam'];
$currentCycle = $cycles[$cycleIndex];

// -------------------------
// 2. Get planned menu items
// -------------------------
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

// Prepare all 7 days
$menus = [];
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

// Put planned items into the correct weekday buckets
while ($row = $result->fetch_assoc()) {
    $day = (int)$row['day_of_week'];
    $meal = $row['meal_type'];

    $menus[$day][$meal][] = [
        'item_name' => $row['item_name'],
        'item_description' => $row['item_description']
    ];
}
$stmt->close();

// ----------------------------------------------------
// 3. Assign REAL upcoming dates starting from today
// ----------------------------------------------------
// Today example:
// Saturday 18 -> today bucket shown first in frontend
// Sunday -> 19
// Monday -> 20

$todayDayNumber = (int)$today->format('w'); // 0=Sun, 1=Mon, ... 6=Sat

for ($day = 0; $day <= 6; $day++) {
    // Always move FORWARD from today, never backward
    $daysAhead = ($day - $todayDayNumber + 7) % 7;

    $menuDate = clone $today;
    if ($daysAhead > 0) {
        $menuDate->modify("+$daysAhead days");
    }

    $menus[$day]['date'] = $menuDate->format('Y-m-d');

    // -----------------------------------------
    // 4. Check overrides for that exact date
    // -----------------------------------------
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

    foreach (['breakfast', 'lunch', 'dinner'] as $mealType) {
        if (!empty($overrideMeals[$mealType])) {
            $menus[$day][$mealType] = $overrideMeals[$mealType];
            $menus[$day][$mealType . '_note'] = $overrideNotes[$mealType];
            $menus[$day][$mealType . '_source'] = 'override';
        }
    }
}

// -------------------------
// 5. Return JSON
// -------------------------
echo json_encode([
    'cycle' => $currentCycle,
    'today' => $today->format('Y-m-d'),
    'today_day_number' => $todayDayNumber,
    'menus' => $menus
]);

$conn->close();
?>