<!-- skills section starts -->
<section class="skills bg-dark text-white py-5" id="skills">
  <div class="container">
    <h2 class="heading text-center mb-5">
      <i class="fas fa-laptop-code"></i> Skills &amp; <span>Abilities</span>
    </h2>

    <div class="row justify-content-center">
      <?php foreach ($skills as $skill): ?>
        <?php
          $skillName = htmlspecialchars($skill['name']);
          $imagePath = !empty($skill['image_url']) ? htmlspecialchars($skill['image_url']) : './assets/images/logo.png';
          $altText = htmlspecialchars($skill['alt_text'] ?? $skillName);
        ?>
        <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4 text-center">
          <div class="skill-item" tabindex="0" role="img" aria-label="<?= $skillName ?>">
            <img
              src="<?= $imagePath ?>"
              alt="<?= $altText ?>"
              loading="lazy"
              class="img-fluid skill-icon mb-2"
              onerror="this.src='./assets/images/logo.png';"
              style="max-width: 80px; height: auto;"
            />
            <div class="skill-name text-white"><?= $skillName ?></div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<!-- skills section ends -->