<?php

$pageTitle = "Min Bucketlist";

require_once "includes/Database.php";
require_once "includes/Bucketlist.php";

$database = new Database();
$db = $database->getConnection();

$bucketlist = new Bucketlist($db);

$error = "";
$success = "";

// Hantera formuläret
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["add_item"])) {

    $name = trim($_POST["name"] ?? "");
    $description = trim($_POST["description"] ?? "");
    $priority = filter_input(INPUT_POST, "priority", FILTER_VALIDATE_INT);

    if ($name === "" || $description === "" || $priority === false || $priority === null || $priority < 1 || $priority > 5) {

        $error = "Fyll i alla fält och välj en prioritet mellan 1 och 5.";

    } else {

        if ($bucketlist->addItem($name, $description, $priority)) {
            header("Location: bucketlist.php?added=1");
            exit();
        } else {
            $error = "Det gick inte att lägga till aktiviteten.";
        }
    }
}

if (isset($_GET["added"])) {
    $success = "Aktiviteten har lagts till i din bucketlist!";
}

$items = $bucketlist->getAllItems();

include "includes/header.php";

?>

<section>
    <h2>Min Bucketlist</h2>

    <p>
        Här samlar jag de saker som jag vill hinna göra, uppleva och uppnå innan jag är död.
    </p>
</section>

<section>
    <h2>Lägg till en aktivitet</h2>

    <?php if ($error !== ""): ?>
        <p class="error">
            <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
        </p>
    <?php endif; ?>

    <?php if ($success !== ""): ?>
        <p class="success">
            <?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?>
        </p>
    <?php endif; ?>

    <form method="POST" action="bucketlist.php">

        <label for="name">Namn på aktivitet:</label>
        <input type="text" id="name" name="name" required maxlength="100">

        <label for="description">Beskrivning:</label>
        <textarea id="description" name="description" required></textarea>

        <label for="priority">Prioritet:</label>
        <select id="priority" name="priority" required>
            <option value="">Välj prioritet</option>
            <option value="1">1 - Högst</option>
            <option value="2">2 - Hög</option>
            <option value="3">3 - Medel</option>
            <option value="4">4 - Låg</option>
            <option value="5">5 - Lägst</option>
        </select>

        <button type="submit" name="add_item">Lägg till i bucketlistan</button>

    </form>
</section>

<section>
    <h2>Mina drömmar och mål</h2>

    <?php if (empty($items)): ?>

        <p>Din bucketlist är tom än så länge!</p>

    <?php else: ?>

        <?php foreach ($items as $item): ?>

            <article>
                <h3><?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8') ?></h3>

                <p><?= htmlspecialchars($item['description'], ENT_QUOTES, 'UTF-8') ?></p>

                <p>
                    <strong>Prioritet:</strong>
                    <?= htmlspecialchars((string) $item['priority'], ENT_QUOTES, 'UTF-8') ?>
                </p>

                <p>
                    <strong>Tillagd:</strong>
                    <?= htmlspecialchars($item['created_at'], ENT_QUOTES, 'UTF-8') ?>
                </p>
            </article>

        <?php endforeach; ?>

    <?php endif; ?>

</section>

<?php include "includes/footer.php"; ?>