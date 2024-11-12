<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>課題2</title>
</head>
<body>
    <table class="table">
        <tr><th>名前</th><th>趣味</th>
    <?php
        if(isset($_POST["name"], $_POST["hobby"])) {
            print "<tr><td>" . $_POST["name"] . "</td><td>" . $_POST["hobby"] . "</td></tr>\n";
        } else {
            print "<tr><td></td></tr>";
        }
    ?>
    </table>
</body>