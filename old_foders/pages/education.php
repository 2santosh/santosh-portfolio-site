<!-- education section starts -->
<section class="education" id="education">
    <h1 class="heading"><i class="fas fa-graduation-cap"></i> My <span>Education</span></h1>
    <p class="qoute">Education is not the learning of facts, but the training of the mind to think.</p>

    <div class="box-container">
        <?php foreach ($educationList as $edu): ?>
        <div class="box">
            <div class="image">
                <img draggable="false" src="<?= htmlspecialchars($edu['image']) ?>"
                    alt="<?= htmlspecialchars($edu['institution']) ?>" loading="lazy"
                    onerror="this.src='./assets/images/logo.png';">
            </div>
            <div class="content">
                <h3><?= htmlspecialchars($edu['title']) ?></h3>
                <p><?= htmlspecialchars($edu['institution']) ?><?= !empty($edu['location']) ? ' | ' . htmlspecialchars($edu['location']) : '' ?>
                </p>
                <h4><?= htmlspecialchars($edu['timeline']) ?><?= !empty($edu['status']) ? ' | ' . htmlspecialchars($edu['status']) : '' ?>
                </h4>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>
<!-- education section ends -->