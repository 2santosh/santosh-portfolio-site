<!-- about section starts -->
<section class="about" id="about">
    <h2 class="heading"><i class="fas fa-user-alt"></i> About <span>Me</span></h2>

    <div class="row">
        <div class="image">
            <img draggable="false" class="tilt"
                src="<?= htmlspecialchars($about['image_path'] ?? './assets/images/imgg.avif') ?>"
                alt="About <?= htmlspecialchars($about['name'] ?? 'Santosh Adhikari') ?>" loading="lazy"
                onerror="this.src='./assets/images/logo.png';">
        </div>
        <div class="content">
            <h3>I'm <?= htmlspecialchars($about['name'] ?? 'Santosh') ?></h3>
            <span class="tag"><?= htmlspecialchars($about['role'] ?? 'Full-Stack Developer') ?></span>

            <p>
                <?= nl2br(htmlspecialchars($about['description'] ?? "I am a Developer based in Kathmandu, Nepal.\nI am passionate about coding, enhancing my skills, and creating innovative applications and websites.\nI specialize in building WebApps and websites using modern technologies.\nConstantly striving to improve and deliver value, I love working on both personal and professional projects.")) ?>
            </p>

            <div class="box-container">
                <div class="box">
                    <p><span> email : </span>
                        <a href="mailto:<?= htmlspecialchars($about['email'] ?? '1.santoshadh@gmail.com') ?>">
                            <?= htmlspecialchars($about['email'] ?? '1.santoshadh@gmail.com') ?>
                        </a>
                    </p>
                    <p><span> place : </span>
                        <?= htmlspecialchars($about['location'] ?? 'Madhyapur Thimi, Bhaktapur, Nepal') ?></p>
                </div>
            </div>

            <?php if (count($about_links) > 0): ?>
            <div class="resumebtn">
                <?php foreach ($about_links as $link): ?>
                <a href="<?= htmlspecialchars($link['url']) ?>" target="_blank" class="btn" rel="noopener noreferrer">
                    <span><?= htmlspecialchars($link['link_text']) ?></span>
                    <?php if (!empty($link['icon_class'])): ?>
                    <i class="<?= htmlspecialchars($link['icon_class']) ?>"></i>
                    <?php else: ?>
                    <i class="fas fa-chevron-right"></i>
                    <?php endif; ?>
                </a>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <div class="resumebtn">
                <a href="http://www.santoshadhikari111.com.np/?i=1" target="_blank" class="btn"
                    rel="noopener noreferrer">
                    <span>About More</span>
                    <i class="fas fa-chevron-right"></i>
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<!-- about section ends -->