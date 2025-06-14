<!-- work project section starts -->
<section class="work" id="work">

    <h2 class="heading"><i class="fas fa-laptop-code"></i> Projects <span>Made</span></h2>

    <div class="box-container">
        <?php foreach ($projects as $project): ?>
        <div class="box tilt">
            <img draggable="false" src="<?= htmlspecialchars($project['image']) ?>"
                onerror="this.src='./assets/images/logo.png';" alt="<?= htmlspecialchars($project['title']) ?>" />
            <div class="content">
                <div class="tag">
                    <h3><?= htmlspecialchars($project['title']) ?></h3>
                </div>
                <div class="desc">
                    <p><?= htmlspecialchars($project['description']) ?></p>
                    <div class="btns">
                        <?php if (!empty($project['view_url'])): ?>
                        <a href="<?= htmlspecialchars($project['view_url']) ?>" class="btn" target="_blank"
                            rel="noopener noreferrer">
                            <i class="fas fa-eye"></i> View
                        </a>
                        <?php endif; ?>
                        <?php if (!empty($project['code_url'])): ?>
                        <a href="<?= htmlspecialchars($project['code_url']) ?>" class="btn" target="_blank"
                            rel="noopener noreferrer">
                            Code <i class="fas fa-code"></i>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="viewall">
        <a href="/projects" class="btn"><span>View All</span>
            <i class="fas fa-arrow-right"></i>
        </a>
    </div>

</section>
<!-- work project section ends -->