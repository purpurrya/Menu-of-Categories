<?php
$db = new PDO('pgsql:host=127.0.0.1;dbname=categories_db;user=postgres;password=password');

function export() {
    global $db;

    $indentation = '';
    
    $stmt = $db->query("SELECT * FROM categories WHERE parent_id IS NULL");
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $output = '';
    foreach ($categories as $index => $category) {
        $output .= "{$index}\n{$indentation}{$category['name']}\n";
    }
    return $output;
}

$output = export();
file_put_contents('type_b.txt', $output);
?>
