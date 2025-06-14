
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
            alert(data.message); // Show popup with the message
            if (data.status === 'success') {
                form.reset(); // Clear the form if success
            }
        })
        .catch(() => {
            alert('An error occurred. Please try again.');
        });
});
</script>