<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styling.css"/>
    
  <link rel="stylesheet"
  href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
  <link
    href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css"
    rel="stylesheet"/>
   <link rel="preconnect" href="https://fonts.googleapis.com">        
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;
   300;400;500;600;700&display=swap" rel="stylesheet">
   <script>
        document.addEventListener("DOMContentLoaded", function() {
            const nameInput = document.getElementById('name');
            const timeInput = document.getElementById('time');

            function validateName() {
                const nameValue = nameInput.value.trim();
                const minLength = 3;
                const maxLength = 30;
                const nameRegex = /^[A-Za-z\s]+$/;

                if (nameValue.length < minLength || nameValue.length > maxLength || !nameRegex.test(nameValue)) {
                    nameInput.setCustomValidity('Name must be between 3 and 30 characters long and contain only letters and spaces.');
                } else {
                    nameInput.setCustomValidity('');
                }
            }

            function validateTime() {
                const selectedTime = new Date('1970-01-01T' + timeInput.value);
                const startTime = new Date('1970-01-01T10:00:00');
                const endTime = new Date('1970-01-01T16:00:00');

                if (selectedTime < startTime || selectedTime > endTime) {
                    timeInput.setCustomValidity('Time must be between 10:00 AM and 4:00 PM.');
                } else {
                    timeInput.setCustomValidity('');
                }
            }

            nameInput.addEventListener('input', validateName);
            timeInput.addEventListener('input', validateTime);
        });
       
        document.getElementById('bookNowBtn').addEventListener('click', function() {
    var loggedIn = <?php echo isset($_SESSION['loggedin']) ? 'true' : 'false'; ?>;
    if (loggedIn) {
        document.getElementById('bookFormModal').style.display = 'block';
    } else {
        document.getElementById('loginModal').style.display = 'block';
    }
});
document.querySelectorAll('.closeBtn').forEach(function(closeBtn) {
            closeBtn.addEventListener('click', function() {
                document.querySelectorAll('.modal').forEach(function(modal) {
                    modal.style.display = 'none';
                });
            });
        });

        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = 'none';
            }
        }
    
    </script>
    <title>PARAGLIDE booking</title>
</head>
<body>
  <div class="container">
<div class="navbar">
    <img src="images/logo1.png" class="logo">
    <nav> 
        <ul>
            <li><a href="#home" >Home</a></li>
            <li> <a href="#about" >About us</a></li>
            <li><a href="#review" >Review</a> </li>
            <li><a href="#blog" >Blog</a> </li>
            <li><a href="#contact" >Contact</a> </li>
            <li> <a href="login1.php"> Login</a></li>        
    </ul>
</nav>
</div>
  <div class="header">
    <h1><span>SKY</span> <br><span>ADVENTURE</span></h1>
    <p>Paragliding is an exhilarating adventure sport that offers participants a unique opportunity
       to experience the freedom of flight.  With its blend of excitement, tranquility, and stunning 
       scenery, paragliding offers an unmatched adventure for thrill-seekers and nature enthusiasts alike.</p>
       <div class="button-container">
        <button class="btn btn-primary" id="bookNowBtn" >Book Now</button>

        <div id="bookFormModal" class="modal" >
          <div class="modal-content">
            <span class="closeBtn">&times;</span>
            <form id="" method="POST" action="book_paragliding.php">
              <h2>Book Your Paragliding Adventure</h2>
              <label for="name">Name:</label>
              <input type="text" id="name" name="name" required maxlength="30" autocomplete="off">
              <label for="email">Email:</label>
              <input type="email" id="email" name="email" required maxlength="30" autocomplete="off">
              <label for="date">Date:</label>
              <input type="date" id="date" name="date"min="<?php $currentDate = date('Y-m-d'); echo $currentDate; ?>" required >
              <label for="time">Time:</label>
              <input type="time" id="time" name="time" required>
              <label for="booking_number">No.of booking:</label>
              <input type="text" id="booking_number" name="booking_number" required pattern="[0-9]{1,2}" maxlength="2" autocomplete="off">

   
              <input type="submit"value="submit">
            </form>
          </div>
        </div>
        </div>
      </div>
      
      
      <section id="about" >
        <div class="content">
          
          <div class="overlay">
            <h1>OUR SERVICES</h1>
              <p>Paragliding services offer thrilling opportunities for individuals to experience the joy of 
                flight and adventure. These services typically provide tandem paragliding flights with experienced 
                pilots, allowing passengers to soar through the sky and take in breathtaking aerial views of the 
                surrounding landscape. Whether it's a leisurely flight over scenic valleys, a high-adrenaline acrobatic 
                flight, or a tranquil sunset flight, paragliding services cater to a variety of preferences and skill 
                levels. Safety is paramount, with professional instructors providing thorough briefings and ensuring that
                 all necessary safety measures are in place.</p>
                 <a href="#" class="ctn"> Learn more</a>
              </div>
          </div>
      </section>
      
      <div class="cont">
        <section id="review" class="bc">
        <h1>CUSTOMER REVIEWS</h1>
        <div class="review">
          <div class="review-img">
            <img src="images/prateekdai.jpg" alt="Review 1">
          </div>
          <div class="review-content">
            <h2>Prateek vannarotti</h2>
            <p>"As someone who has always been fascinated by flying, my paragliding experience with was 
              nothing short of exhilarating. The feeling of soaring through the sky, surrounded by breathtaking views of the landscape below, 
              was absolutely surreal. The instructors were professional, knowledgeable, and made me feel completely safe throughout the entire 
              experience. I would highly recommend to anyone looking for an unforgettable adventure and a unique perspective of the world from
               above."</p>
          </div>
        </div>
        <div class="review">
          <div class="review-img">
            <img src="images/roji.JPG" alt="Review 2">
          </div>
          <div class="review-content">
            <h2>Jyoti saini</h2>
            <p>"My paragliding experience was nothing short of exhilarating. As I soared high above the landscape, 
              suspended by nothing but a canopy and the wind, I felt a sense of freedom unlike anything I've ever 
              experienced before. The rush of adrenaline as I launched into the air quickly gave way to a feeling 
              of tranquility as I glided effortlessly through the sky, taking in the breathtaking views below. The 
              skilled pilot maneuvered us gracefully through the air, allowing me to fully immerse myself in the 
              beauty of the surroundings. From the lush green valleys to the majestic mountains, every moment of 
              the flight was a feast for the senses. As we gently landed back on solid ground, I couldn't help but 
              feel grateful for the opportunity to embark on such an unforgettable adventure.
               Paragliding has truly left an indelible mark on my soul, and I can't wait to take to the skies again."</p>
          </div>
        </div>
        </div>
      
    </section>
    <section id="blog">
      <h1> BLOGS</h1>
      <p>Soaring High: A Beginner's Guide to Paragliding<br>

        Are you someone who is always seeking new adventures and thrills? Have you ever dreamt of flying like a bird, feeling the wind rushing past your face as you glide through the sky? If so, then paragliding might just be the perfect adventure for you!
        
        <br>What is Paragliding?<br>
        
        Paragliding is an exhilarating adventure sport that allows you to experience the thrill of free flight. Unlike skydiving, which involves jumping out of an airplane, paragliding involves launching yourself from a hill or mountain using a specially designed parachute-like wing. Once in the air, you are able to soar like a bird, riding the thermals and currents to stay aloft for extended periods of time.
        
        <br>Why Paragliding?<br>
        
        Paragliding offers a unique perspective of the world, allowing you to see stunning landscapes from a completely different vantage point. Whether you're soaring high above lush green valleys, gliding past towering mountains, or floating serenely above crystal-clear lakes, the views from a paraglider are truly breathtaking.
        
        <br>Is Paragliding Safe?<br>
        
        While paragliding may seem like an extreme sport, it is actually quite safe when done properly. Modern paragliding equipment is designed to be extremely reliable, and rigorous safety standards are in place to ensure that pilots and passengers are kept safe at all times. Additionally, all paragliding flights are accompanied by experienced instructors who are trained to handle any situation that may arise.
           
        <br>The Thrill of a Lifetime<br>
        
        There's nothing quite like the feeling of soaring through the sky, feeling the wind in your face and the sun on your skin. Paragliding offers a unique opportunity to experience the world from a completely different perspective, and once you've experienced the thrill of free flight, you'll be hooked for life.
        
        So what are you waiting for? Take the leap and experience the thrill of paragliding for yourself. Trust us, you won't regret it!</p>
    </section>
    <footer>
      <div class="qwe">
      <div class="footer-content">
        <h1> Contact info</h1>
        <p> Email: skyadventure@gmail.com</p>
        <p> Phone no: +977 9898989800</p>
        <p> Address: abcde, 123 street</p>
      </div>
      <div class="footer-content">
        <h3>Follow us</h3>
        <ul class="social-icons">
       <li><a href="#"><i class="ri-instagram-line"></i></a></li> 
        <li><a href="#"><i class="ri-twitter-fill"></i></a></li>
        <li><a href="#"><i class="ri-facebook-circle-fill"></i></li></i></a></ul>
      </div>
    </div>
    <div class="bottom-bar">
      <p> &copy: 2024 Sky adventure. All rights reserved.</p>
    </div>
    </footer>
  </div>
  <script src="script1.js">

  </script> 
  </body></html>