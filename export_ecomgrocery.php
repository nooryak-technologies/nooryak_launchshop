<?php
$host = '127.0.0.1';
$db = 'nooryak_launchshopp';
$user = 'root';
$pass = '';

$pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$userId = 67;

// Verify user
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ? OR username = 'ecomgrocery'");
$stmt->execute([$userId]);
$userData = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$userData) {
    echo "User ecomgrocery not found!\n";
    exit(1);
}

$userId = $userData['id'];
echo "Found user: {$userData['username']} with ID {$userId}\n";

$sqlOutput = "-- Restore Ecom Grocery Demo Theme (User ID $userId: ecomgrocery)\n";
$sqlOutput .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

function dumpTable($pdo, $table, $whereClause, $params, &$sqlOutput) {
    $stmt = $pdo->prepare("SELECT * FROM `$table` WHERE $whereClause");
    $stmt->execute($params);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (empty($rows)) return 0;

    $cols = array_keys($rows[0]);
    $colsStr = implode('`, `', $cols);

    $sqlOutput .= "-- Data for table `$table` (" . count($rows) . " rows)\n";
    foreach ($rows as $row) {
        $vals = [];
        foreach ($row as $val) {
            if (is_null($val)) {
                $vals[] = 'NULL';
            } else {
                $vals[] = "'" . addslashes($val) . "'";
            }
        }
        $valsStr = implode(', ', $vals);
        $sqlOutput .= "INSERT INTO `$table` (`$colsStr`) VALUES ($valsStr) ON DUPLICATE KEY UPDATE id=VALUES(id);\n";
    }
    $sqlOutput .= "\n";
    return count($rows);
}

// 1. users table
dumpTable($pdo, 'users', 'id = ?', [$userId], $sqlOutput);

// 2. user_basic_settings
dumpTable($pdo, 'user_basic_settings', 'user_id = ?', [$userId], $sqlOutput);

// 3. memberships
dumpTable($pdo, 'memberships', 'user_id = ?', [$userId], $sqlOutput);

// 4. user_languages
dumpTable($pdo, 'user_languages', 'user_id = ?', [$userId], $sqlOutput);

// 5. user_currencies
dumpTable($pdo, 'user_currencies', 'user_id = ?', [$userId], $sqlOutput);

// 6. user_footers
dumpTable($pdo, 'user_footers', 'user_id = ?', [$userId], $sqlOutput);

// 7. user_headers
dumpTable($pdo, 'user_headers', 'user_id = ?', [$userId], $sqlOutput);

// 8. user_shop_settings
dumpTable($pdo, 'user_shop_settings', 'user_id = ?', [$userId], $sqlOutput);

// 9. user_seos
dumpTable($pdo, 'user_seos', 'user_id = ?', [$userId], $sqlOutput);

// 10. user_contacts
dumpTable($pdo, 'user_contacts', 'user_id = ?', [$userId], $sqlOutput);

// 11. user_ulinks
dumpTable($pdo, 'user_ulinks', 'user_id = ?', [$userId], $sqlOutput);

// 12. user_permissions
dumpTable($pdo, 'user_permissions', 'user_id = ?', [$userId], $sqlOutput);

// 13. user_hero_sliders
dumpTable($pdo, 'user_hero_sliders', 'user_id = ?', [$userId], $sqlOutput);

// 14. user_menus
dumpTable($pdo, 'user_menus', 'user_id = ?', [$userId], $sqlOutput);

// 15. user_item_categories
dumpTable($pdo, 'user_item_categories', 'user_id = ?', [$userId], $sqlOutput);

// 16. user_item_sub_categories
dumpTable($pdo, 'user_item_sub_categories', 'category_id IN (SELECT id FROM user_item_categories WHERE user_id = ?)', [$userId], $sqlOutput);

// 17. user_items
dumpTable($pdo, 'user_items', 'user_id = ?', [$userId], $sqlOutput);

// 18. user_item_contents
dumpTable($pdo, 'user_item_contents', 'item_id IN (SELECT id FROM user_items WHERE user_id = ?)', [$userId], $sqlOutput);

// 19. user_item_images
dumpTable($pdo, 'user_item_images', 'item_id IN (SELECT id FROM user_items WHERE user_id = ?)', [$userId], $sqlOutput);

$sqlOutput .= "SET FOREIGN_KEY_CHECKS=1;\n";

file_put_contents(__DIR__ . '/database/restore_ecomgrocery.sql', $sqlOutput);
echo "SQL export completed! File written to database/restore_ecomgrocery.sql (" . strlen($sqlOutput) . " bytes)\n";
