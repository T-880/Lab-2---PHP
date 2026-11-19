<?php

$pageTitle = "Min Bucketlist";

// Inkludera våra klasser
require_once "includes/Database.php";
require_once "includes/Bucketlist.php";

// Skapa databasanslutning
$database = new Database();
$db = $database->getConnection();

// Skapa Bucketlist-objekt
$bucketlist = new Bucketlist($db);

// Hämta alla aktiviteter
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
    <h2>Mina drömmar och mål</h2>

    <?php if (empty($items)): ?>

        <p>Min bucketlist är tom än så länge!</p>

    <?php else: ?>

        <?php foreach ($items as $item): ?>

            <article>
                <h3>
                    <?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8') ?>
                </h3>

                <p>
                    <?= htmlspecialchars($item['description'], ENT_QUOTES, 'UTF-8') ?>
                </p>

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

<?php

include "includes/footer.php";

?>