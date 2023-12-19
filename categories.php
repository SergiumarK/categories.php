<?php
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($_POST["type"] === "category") {
        $name = $_POST["name"];
        $sql = "INSERT INTO categories(name) VALUES('$name')";
        if ($conn->query($sql) === TRUE) {
            $categoryMessage = "Category created successfully";
        } else {
            $categoryMessage = "Category not created";
        }
    }

    if ($_POST["type"] === "subcategory") {
        $name = $_POST["name"];
        $categoryId = $_POST["category_id"];
        $sql = "INSERT INTO subcategories(name, category_id) VALUES('$name', $categoryId)";
        if ($conn->query($sql) === TRUE) {
            $subcategoryMessage = "Subcategory created successfully";
        } else {
            $subcategoryMessage = "Subcategory not created";
        }
    }

    if ($_POST["type"] === "subsubcategory") {
        $name = $_POST["name"];
        $subcategoryId = $_POST["subcategory_id"];
        $sql = "INSERT INTO subsubcategories(name, subcategory_id) VALUES('$name', $subcategoryId)";
        if ($conn->query($sql) === TRUE) {
            $subsubcategoryMessage = "Subsubcategory created successfully";
        } else {
            $subsubcategoryMessage = "Subsubcategory not created";
        }
    }
}

$sql = "SELECT * FROM categories ORDER BY name ASC";
$resultCategories = $conn->query($sql);

$sql = "SELECT * FROM subcategories ORDER BY name ASC";
$resultSubcategories = $conn->query($sql);
$subcategories = [];

if ($resultSubcategories->num_rows > 0) {
    while ($rowSubcategory = $resultSubcategories->fetch_assoc()) {
        $subcategories[] = $rowSubcategory;
    }
}

$sql = "SELECT * FROM subsubcategories ORDER BY name ASC";
$resultSubsubcategories = $conn->query($sql);
$subsubcategories = [];

if ($resultSubsubcategories->num_rows > 0) {
    while ($rowSubsubcategory = $resultSubsubcategories->fetch_assoc()) {
        $subsubcategories[] = $rowSubsubcategory;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .subcategory {
            margin-left: 50px;
        }

        .subsubcategory {
            margin-left: 100px;
        }
    </style>
</head>

<body>
    <header>
        <h1>Categories</h1>
    </header>
    <main>
        <form action="" method="POST">
            <input type="text" name="name" placeholder="Category name" required>
            <button name="type" value="category">Create category</button>
        </form>

        <?php
        if (isset($categoryMessage)) {
            echo "<p>$categoryMessage</p>";
        }
        ?>

        <div class="categories">
            <?php
            if ($resultCategories->num_rows > 0) {
                while ($row = $resultCategories->fetch_assoc()) {
                    echo "<div class='category'>
                            <h2>$row[name]</h2>
                            <form method='POST'>
                                <input type='text' name='name' placeholder='Subcategory name' required>
                                <input type='hidden' name='category_id' value='$row[category_id]'>
                                <button name='type' value='subcategory'>Create subcategory</button>
                            </form>";

                    foreach ($subcategories as $rowSubcategory) {
                        if ($row["category_id"] === $rowSubcategory["category_id"]) {
                            echo "<div class='subcategory'>
                                    <h3>$rowSubcategory[name]</h3>
                                    <form method='POST'>
                                        <input type='text' name='name' placeholder='Subsubcategory name' required>
                                        <input type='hidden' name='subcategory_id' value='$rowSubcategory[subcategory_id]'>
                                        <button name='type' value='subsubcategory'>Create subsubcategory</button>
                                    </form>";

                            foreach ($subsubcategories as $rowSubsubcategory) {
                                if ($rowSubcategory["subcategory_id"] === $rowSubsubcategory["subcategory_id"]) {
                                    echo "<div class='subsubcategory'>
                                            <h4>$rowSubsubcategory[name]</h4>
                                        </div>";
                                }
                            }

                            echo "</div>";
                        }
                    }

                    echo "</div>";
                }
            }
            ?>
        </div>
    </main>
</body>

</html>
