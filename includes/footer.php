
    <!-- footer section starts -->
    <section class="footer">

        <div class="box-container">

            <div class="box">
                <h3>Santosh's Portfolio</h3>
                <p>Thank you for visiting my personal portfolio website. Connect with me over socials. <br /> <br />
                    Keep Rising
                    🚀. Connect with me over live chat!</p>
            </div>

            <div class="box">
                <h3>quick links</h3>
                <a href="#home"><i class="fas fa-chevron-circle-right"></i> home</a>
                <a href="#about"><i class="fas fa-chevron-circle-right"></i> about</a>
                <a href="#skills"><i class="fas fa-chevron-circle-right"></i> skills</a>
                <a href="#education"><i class="fas fa-chevron-circle-right"></i> education</a>
                <a href="#work"><i class="fas fa-chevron-circle-right"></i> work</a>
                <a href="#experience"><i class="fas fa-chevron-circle-right"></i> experience</a>
            </div>

            <div class="box">
                <h3>contact info</h3>
                <!-- <p> <i class="fas fa-phone"></i>+91 XXX-XXX-XXXX</p> -->
                <p> <i class="fas fa-envelope"></i>1.santoshadh@gmail.com</p>
                <p> <i class="fas fa-map-marked-alt"></i>Kathmandu, Nepal</p>
                <div class="share">

                    <a href="https://www.linkedin.com/in/santosh-adhikari-79a783233/" class="fab fa-linkedin"
                        aria-label="LinkedIn" target="_blank"></a>
                    <a href="https://github.com/2santosh" class="fab fa-github" aria-label="GitHub" target="_blank"></a>
                    <a href="mailto:1.santoshadh@gmail.com" class="fas fa-envelope" aria-label="Mail"
                        target="_blank"></a>
                    <a href="" class="fab fa-twitter" aria-label="Twitter" target="_blank"></a>
                </div>
            </div>
        </div>

        <h1 class="credit">Designed with <i class="fa fa-heart pulse"></i> by <a
                href="https://santoshadhikari111.com.np/">
                CodeWithSantosh</a></h1>

    </section>
    <!-- footer section ends -->


    <!-- scroll top btn -->
    <a href="#home" aria-label="ScrollTop" class="fas fa-angle-up" id="scroll-top"></a>
    <!-- scroll back to top -->
    <script>
    document.getElementById("contact-form").addEventListener("submit", function(e) {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);

        fetch("contact-submit.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                if (data.status === 'success') {
                    form.reset();
                }
            })
            .catch(error => {
                alert("An error occurred. Please try again.");
                console.error("Error:", error);
            });
    });
    </script>
    <!-- ==== ALL MAJOR JAVASCRIPT CDNS STARTS ==== -->
    <!-- jquery cdn -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- typed.js cdn -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typed.js/2.0.5/typed.min.js"
        integrity="sha512-1KbKusm/hAtkX5FScVR5G36wodIMnVd/aP04af06iyQTkD17szAMGNmxfNH+tEuFp3Og/P5G32L1qEC47CZbUQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- particle.js links -->
    <script src="./assets/js/particles.min.js"></script>
    <script src="./assets/js/app.js"></script>

    <!-- vanilla tilt.js links -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.7.0/vanilla-tilt.min.js"
        integrity="sha512-SttpKhJqONuBVxbRcuH0wezjuX+BoFoli0yPsnrAADcHsQMW8rkR84ItFHGIkPvhnlRnE2FaifDOUw+EltbuHg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- scroll reveal anim -->
    <script src="https://unpkg.com/scrollreveal"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/emailjs-com@3/dist/email.min.js"></script>

    <!-- ==== ALL MAJOR JAVASCRIPT CDNS ENDS ==== -->

    <script src="./assets/js/script.js"></script>

</body>

</html>