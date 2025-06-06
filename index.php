<?php
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/db.php';  // Your data functions file

// Fetch data for the page
$dataHomepage = getHomepageContent();
$homepage = $dataHomepage['content'] ?? [];
$social_links = $dataHomepage['social_links'] ?? [];

$dataAbout = getAboutMe();
$about = $dataAbout['content'] ?? [];
$about_links = $dataAbout['links'] ?? [];

$skills = getSkills();
$educationList = getEducation();
$projects = getProjects();
$experienceList = getExperience();
?>

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
                <a href="<?= htmlspecialchars($link['url']) ?>" target="_blank" class="btn"
                    rel="noopener noreferrer">
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

<!-- skills section starts -->
<section class="skills" id="skills">
    <div class="container">
        <h2 class="heading text-center mb-5">
            <i class="fas fa-laptop-code"></i> Skills &amp; <span>Abilities</span>
        </h2>
        <div class="row" id="skillsContainer">
            <?php foreach ($skills as $skill): ?>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
                <div class="skill-circle" tabindex="0" role="button" aria-label="<?= htmlspecialchars($skill['name']) ?>">
                    <img src="<?= htmlspecialchars($skill['image_url']) ?>"
                        onerror="this.src='./assets/images/logo.png';"
                        alt="<?= htmlspecialchars($skill['alt_text'] ?? $skill['name']) ?>"
                        class="skill-icon">
                </div>
                <div class="skill-name text-center mt-2"><?= htmlspecialchars($skill['name']) ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<!-- skills section ends -->



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

<!-- contact section starts -->
<section class="contact" id="contact">
  <h2 class="heading">
    <i class="fas fa-envelope"></i> Contact <span>Me</span>
  </h2>
  <div class="row contact-row">
    <div class="contact-info">
      <div class="box">
        <i class="fas fa-phone"></i>
        <h3>Phone</h3>
        <p>+977 9843745335</p>
      </div>
      <div class="box">
        <i class="fas fa-envelope"></i>
        <h3>Email</h3>
        <p><a href="mailto:1.santoshadh@gmail.com">1.santoshadh@gmail.com</a></p>
      </div>
      <div class="box">
        <i class="fas fa-map-marker-alt"></i>
        <h3>Address</h3>
        <p>Madhyapur Thimi, Bhaktapur, Nepal</p>
      </div>
    </div>
    <form action="send_message.php" method="post" class="contact-form" novalidate>
      <label for="name" class="sr-only">Name</label>
      <input type="text" id="name" name="name" placeholder="Enter your name" required autocomplete="name" />

      <label for="email" class="sr-only">Email</label>
      <input type="email" id="email" name="email" placeholder="Enter your email" required autocomplete="email" />

      <label for="subject" class="sr-only">Subject</label>
      <input type="text" id="subject" name="subject" placeholder="Enter the subject" required />

      <label for="message" class="sr-only">Message</label>
      <textarea id="message" name="message" rows="5" placeholder="Write your message here..." required></textarea>

      <button type="submit" class="btn btn-primary">Send Message</button>
    </form>
  </div>
</section>
<!-- contact section ends -->

<style>
  
  .contact-row {
    display: flex;
    flex-wrap: wrap;
    gap: 3rem;
    justify-content: center;
    align-items: flex-start;
    padding: 2rem 1rem;
  }

  /* Contact info boxes */
  .contact-info {
    flex: 1 1 280px;
    max-width: 350px;
  }
  .contact-info .box {
    background: #fff;
    border-radius: 10px;
    padding: 20px 25px;
    margin-bottom: 20px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    text-align: center;
    transition: transform 0.3s ease;
  }
  .contact-info .box:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
  }
  .contact-info .box i {
    font-size: 2.5rem;
    color: #007bff;
    margin-bottom: 10px;
  }
  .contact-info .box h3 {
    margin-bottom: 8px;
    font-weight: 600;
    color: #333;
  }
  .contact-info .box p,
  .contact-info .box a {
    font-size: 1rem;
    color: #555;
    text-decoration: none;
  }
  .contact-info .box a:hover {
    text-decoration: underline;
  }

  /* Contact form */
  .contact-form {
    flex: 1 1 350px;
    max-width: 500px;
    background: #f9f9f9;
    padding: 25px 30px;
    border-radius: 12px;
    box-shadow: 0 4px 25px rgba(0, 0, 0, 0.1);
  }

  .contact-form input,
  .contact-form textarea {
    width: 100%;
    padding: 12px 15px;
    margin-bottom: 18px;
    border: 1.5px solid #ddd;
    border-radius: 8px;
    font-size: 1rem;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
    font-family: inherit;
  }

  .contact-form input:focus,
  .contact-form textarea:focus {
    border-color: #007bff;
    outline: none;
    box-shadow: 0 0 5px #007bffaa;
  }

  .contact-form textarea {
    resize: vertical;
    min-height: 120px;
  }

  /* Button */
  .btn-primary {
    display: inline-block;
    padding: 12px 30px;
    background-color: #007bff;
    border: none;
    border-radius: 50px;
    color: #fff;
    font-size: 1.15rem;
    font-weight: 600;
    cursor: pointer;
    transition: background-color 0.25s ease;
    width: 100%;
  }
  .btn-primary:hover,
  .btn-primary:focus {
    background-color: #0056b3;
    outline: none;
  }

  /* Accessibility: hide labels but keep them for screen readers */
  .sr-only {
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    border: 0;
  }

  /* Responsive */
  @media (max-width: 768px) {
    .contact-row {
      flex-direction: column;
      padding: 1rem;
    }
    .contact-info,
    .contact-form {
      max-width: 100%;
    }
  }
.skill-circle {
    width: 70px;
    height: 70px;
    background: #f5f5f5;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    transition: box-shadow 0.3s ease, transform 0.3s ease, background-color 0.3s ease;
    cursor: pointer;
}

.skill-circle:hover,
.skill-circle:focus {
    background-color: #e0f7fa;
    box-shadow: 0 6px 15px rgba(0, 150, 136, 0.4);
    transform: scale(1.15);
    outline: none;
}

.skill-icon {
    width: 40px;
    height: 40px;
    object-fit: contain;
    user-select: none;
}

.skill-name {
    font-weight: 600;
    font-size: 0.9rem;
    color: #333;
    user-select: none;
}

/* Responsive adjustment */
@media (max-width: 576px) {
    .skill-circle {
        width: 60px;
        height: 60px;
    }
    .skill-icon {
        width: 30px;
        height: 30px;
    }
    .skill-name {
        font-size: 0.85rem;
    }
}
.col-6, .col-sm-4, .col-md-3, .col-lg-2 {
    /* Bootstrap's grid already handles width */
    /* Ensure text-center is applied on the container */
    text-align: center; /* This centers inline and inline-block children */
}

.skill-circle {
    width: 70px;
    height: 70px;
    background: #f5f5f5;
    border-radius: 50%;
    display: inline-flex; /* inline-flex helps center inside parent */
    align-items: center;
    justify-content: center;
    margin: 0 auto; /* center the circle itself */
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    transition: box-shadow 0.3s ease, transform 0.3s ease, background-color 0.3s ease;
    cursor: pointer;
}

.skill-circle:hover,
.skill-circle:focus {
    background-color: #e0f7fa;
    box-shadow: 0 6px 15px rgba(0, 150, 136, 0.4);
    transform: scale(1.15);
    outline: none;
}

.skill-icon {
    width: 40px;
    height: 40px;
    object-fit: contain;
    user-select: none;
}

.skill-name {
    font-weight: 600;
    font-size: 0.9rem;
    color: #333;
    margin-top: 8px;
    user-select: none;
}

/* Responsive adjustments */
@media (max-width: 576px) {
    .skill-circle {
        width: 60px;
        height: 60px;
    }
    .skill-icon {
        width: 30px;
        height: 30px;
    }
    .skill-name {
        font-size: 0.85rem;
    }
}


</style>

<?php
require_once __DIR__ . '/includes/footer.php';
?>

<script>
document.querySelector('.contact-form').addEventListener('submit', function(e) {
  e.preventDefault(); // Stop normal form submit

  const form = e.target;
  const formData = new FormData(form);

  fetch(form.action, {
    method: 'POST',
    body: formData,
  })
  .then(response => response.json())
  .then(data => {
    alert(data.message);  // Show popup with the message
    if (data.status === 'success') {
      form.reset();  // Clear the form if success
    }
  })
  .catch(() => {
    alert('An error occurred. Please try again.');
  });
});
</script>
