<!-- hero section starts -->
<section class="home" id="home">
    <div id="particles-js"></div>

    <div class="content">
        <h1>
            <?= htmlspecialchars($homepage['greeting'] ?? 'Namaste,') ?><br />
            I'm <strong><?= htmlspecialchars($homepage['name'] ?? 'Santosh') ?></strong>
            <i class="fas fa-hands-praying"></i>
        </h1>
        <p>
            <?= nl2br(htmlspecialchars($homepage['intro_text'] ?? 'I am passionate about <span class="typing-text"></span>')) ?>
        </p>
        <a href="#about" class="btn">
            <span>Learn More About Me</span>
            <i class="fas fa-arrow-circle-down"></i>
        </a>
        <div class="socials">
            <ul class="social-icons">
                <?php foreach ($social_links as $social): ?>
                <li>
                    <a class="<?= htmlspecialchars(strtolower($social['platform_name'])) ?>"
                        aria-label="Visit my <?= htmlspecialchars($social['platform_name']) ?>"
                        href="<?= htmlspecialchars($social['url']) ?>" target="_blank" rel="noopener noreferrer">
                        <i class="<?= htmlspecialchars($social['icon_class']) ?>"></i>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <div class="image">
        <img draggable="false" class="tilt"
            src="<?= htmlspecialchars($homepage['image_path'] ?? './assets/images/hero.jpg') ?>"
            alt="<?= htmlspecialchars($homepage['name'] ?? 'Santosh') ?> - Full Stack Developer" loading="lazy"
            onerror="this.src='./assets/images/logo.png';">
    </div>
</section>
<!-- hero section ends -->