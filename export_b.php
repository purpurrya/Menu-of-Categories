<?php
$db = new PDO('pgsql:host=127.0.0.1;dbname=categories_db;user=username;password=password;charset=utf8');

function exportTopLevelCategories() {
    global $db;
    $stmt = $db->query("SELECT * FROM categories WHERE parent_id IS NULL");
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $output = '';
    foreach ($categories as $index => $category) {
        $output .= "{$index}\n{$indentation}{$category['name']}\n";
    }
    return $output;
}

$output = exportTopLevelCategories();
file_put_contents('type_b.txt', $output);
?>
