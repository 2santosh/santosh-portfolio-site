<!-- experience section starts -->
<section class="experience" id="experience">
    <h2 class="heading"><i class="fas fa-briefcase"></i> Experience </h2>
    <div class="timeline">
        <?php
        $left = true;
        foreach ($experienceList as $exp):
            $containerClass = $left ? 'container left' : 'container right';
            $left = !$left;
        ?>
        <div class="<?= $containerClass ?>">
            <div class="content">
                <h3><?= htmlspecialchars($exp['title']) ?></h3>
                <p><?= htmlspecialchars($exp['description']) ?></p>
                <span class="date">
                    <?= htmlspecialchars($exp['timeline'] ?? 'Date not specified') ?>
                </span>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- experience section ends -->
