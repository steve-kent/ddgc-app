<?php
require_once("../lib/AuthHelper.php");
function createCard($heading, $body, $editLink, $eventLink, $subHeading = null)
{ ?>
    <div class="card">
        <h3><?= htmlspecialchars($heading) ?></h3>
        <?php
        if ($subHeading) {
            echo '<p class="small-text">' . $subHeading . '</p>';
        }
        ?>
        <hr>
        <p class="card-text"><?= nl2br(htmlspecialchars($body)) ?></p>
        <?php if ($eventLink) : ?>
            <div class="button button-secondary w-30"><a href="<?= $eventLink ?>">Learn More</a></div>
        <?php endif; ?>
        <?= ShowEditCardFooter($editLink) ?>
    </div>
<?php } ?>