<!-- pagina de lucru cu categorii -->
<?php
    require_once "config.php";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if ($_POST["type"] === "category") {
            $name = $_POST["name"];
            $sql = "INSERT INTO categories(name) VALUES('$name')";
            IF ($conn->query($sql) ===true) {
                $categoryMessage = "Category created successfully";
             } else {
                $categoryMessage = "Category not created";
             }
        }
    }

    $sql = "SELECT * FROM categories ORDER BY name ASC";
    $resultCategories = $conn -> query($sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <header>
        <h1>Categories</h1>
    </header>
    <main>
        <form action="" method="post">
            <input type="text" name="name" placeholder="Category name" required>
            <button name="type" value="category">Create category</button>
        </form>

        <?php
            if (isset($categoryMessage)) {
                echo "<p>$categoryMessage</p>";
            }
        ?>
        <div class="categories">
            <!-- verificare -->
            <?php
                if($resultCategories->num_rows > 0) {
                    while ($row = $resultCategories->fetch_assoc()) {
                        $categoryId = $row['category_id'];
                        echo "<div class='category'>
                            <h2>$row[name]</h2>
                            <form method='post'>
                                <input type='text' name='name' placeholder='Subcategory name' required>
                                <input type='hidden' name='category_id' value='$row[category_id]'>
                                <button name='type' value='subcategory'>Create subcategory</button>
                            </form>
                        </div>";
                    }
                }
            ?>
        </div>
    </main>
</body>
</html>