<?php function createCard($heading, $body) { ?>
<div class="card">
    <h4><?= htmlspecialchars($heading) ?></h4>
    
    <hr>
    <p class="card-text"><?= nl2br(htmlspecialchars($body)) ?></p>
</div>
<?php } ?>