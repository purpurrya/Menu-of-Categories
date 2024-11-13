<?php
$db = new PDO('pgsql:host=127.0.0.1;dbname=categories_db;user=postgres;password=password');

function export($parentId = null, $level = 0) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM categories WHERE parent_id " . ($parentId ? "= :parent_id" : "IS NULL"));
    if ($parentId) {
        $stmt->bindParam(':parent_id', $parentId);
    }
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $output = '';
    foreach ($categories as $index => $category) {
        $indentation = str_repeat(' ', $level * 2); 
        $urlPath = UrlPath($category['id']);
        $output .= "{$index}\n{$indentation}{$category['name']} {$urlPath}\n";
        $output .= export($category['id'], $level + 1);
    }
    return $output;
}

function UrlPath($categoryId) {
    global $db;
    $path = [];
    $stmt = $db->prepare("SELECT id, name, parent_id FROM categories WHERE id = :id");
    $stmt->execute([':id' => $categoryId]);
    $category = $stmt->fetch(PDO::FETCH_ASSOC);
    
    while ($category) {
        array_unshift($path, strtolower(str_replace(' ', '-', $category['name']))); 
        $category = $category['parent_id'] ? fetchCategory($category['parent_id']) : null;
    }
    return '/' . implode('/', $path);
}

function fetchCategory($id) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM categories WHERE id = :id");
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

$output = export();
file_put_contents('type_a.txt', $output);
?>
