<?php
session_start();
$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "booking";

// Create connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['name'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $fullname = $_POST['name'];
    $phone = $_POST['phone_number'];

    $sql = "INSERT INTO users (username, password, email, full_name, phone_number) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $username, $password, $email, $fullname, $phone);

    if ($stmt->execute()) {
        echo "New record created successfully";
        $_SESSION["email"] = "$email";
        $_SESSION["password"] = "$password";
        header('Location: thank_you.php');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styling.css" />

    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;
       300;400;500;600;700&display=swap" rel="stylesheet">
       <style>
        .navbar {
            height: 12%;
            display: flex;
            align-items: center;
        }

        .logo {
            width: 80px;
            cursor: pointer;
        }

        nav {
            flex: 1;
            text-align: right;
        }

        nav ul li {
            list-style: none;
            display: inline-block;
            margin-left: 80px;
        }

        nav ul li a {
            text-decoration: none;
            color: whitesmoke;
            font-weight: bold;
            font-size: 18px;
        }

        nav ul li a:hover {
            color: blue;
        }

        .header {
            text-align: left;
            margin-top: 100px;
        }

        .header h1 {
            margin-top: 100px;
            font-size: 11vw;
            line-height: 11vw;
            color: bisque;
        }

        .header p {
            color: bisque;
        }

        label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
        }

        input[type="text"],
        input[type="email"],
        input[type="date"],
        input[type="password"],
        select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            background-color: rgba(255, 255, 255, 0.7);
        }

        .submit-button {
            padding: 10px;
            font-size: 12px;
            cursor: pointer;
            background-color: #101bb4;
            color: white;
            border: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
            display: inline-block;
            margin-top: 10px;
            text-align: center;
            width: 100px;
            /* Adjust width automatically */
            min-width: 20px;
            /* Optional: Minimum width for consistency */
        }

        .submit-button:hover {
            background-color: darkmagenta;
        }

        .button-container {
            text-align: center;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const nameInput = document.getElementById('name');
            const emailInput = document.getElementById('email');

            function validateName() {
                const nameValue = nameInput.value.trim();
                const minLength = 3;
                const maxLength = 30;
                const nameRegex = /^[A-Z][a-z]*(\s[A-Z][a-z]*)*$/;

                if (nameValue.length < minLength || nameValue.length > maxLength || !nameRegex.test(nameValue)) {
                    nameInput.setCustomValidity('Name must be between 3 and 30 characters long and each word must start with a capital letter.');
                } else {
                    nameInput.setCustomValidity('');
                }
            }

            function capitalizeWords(str) {
                return str.replace(/\b\w/g, function (match) {
                    return match.toUpperCase();
                });
            }

            function checkEmail() {
                const emailValue = emailInput.value.trim();
                if (emailValue.length > 0) {
                    fetch('email_check.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'email=' + encodeURIComponent(emailValue),
                    })
                        .then(response => response.text())
                        .then(data => {
                            if (data === 'taken') {
                                emailInput.setCustomValidity('This email is already registered.');
                            } else {
                                emailInput.setCustomValidity('');
                            }
                        })
                        .catch(error => console.error('Error:', error));
                }
            }

            nameInput.addEventListener('input', function () {
                this.value = capitalizeWords(this.value);
                validateName();
            });

            emailInput.addEventListener('input', function () {
                checkEmail();
            });
        });

        document.getElementById('bookNowBtn').addEventListener('click', function () {
            var loggedIn = <?php echo isset($_SESSION['loggedin']) ? 'true' : 'false'; ?>;
            if (loggedIn) {
                document.getElementById('bookFormModal').style.display = 'block';
            } else {
                document.getElementById('loginModal').style.display = 'block';
            }
        });

        document.querySelectorAll('.closeBtn').forEach(function (closeBtn) {
            closeBtn.addEventListener('click', function () {
                document.querySelectorAll('.modal').forEach(function (modal) {
                    modal.style.display = 'none';
                });
            });
        });

        window.onclick = function (event) {
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
                    <li><a href="#home">Home</a></li>
                    <li><a href="#about">About us</a></li>
                    <li><a href="#review">Review</a></li>
                    <li><a href="#blog">Blog</a></li>
                    <li><a href="#contact">Contact</a></li>
                    <li><a href="login1.php">Login</a></li>
                </ul>
            </nav>
        </div>
        <div class="header">
            <h1><span>SKY</span> <br><span>ADVENTURE</span></h1>
            <p>Paragliding is an exhilarating adventure sport that offers participants a unique opportunity
                to experience the freedom of flight. With its blend of excitement, tranquility, and stunning
                scenery, paragliding offers an unmatched adventure for thrill-seekers and nature enthusiasts alike.</p>
            <div class="button-container">
                <button class="btn btn-primary" id="bookNowBtn">Book Now</button>
                <div id="bookFormModal" class="modal">
                    <div class="modal-content">
                        <span class="closeBtn">&times;</span>
                        <form onsubmit="return validateForm()" method="POST" action="book_paragliding.php">
                            <h2>Book Your Paragliding Adventure</h2>
                            <label for="name">Name:</label>
                            <input type="text" id="name" name="name" required maxlength="30" autocomplete="off">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" required maxlength="30" autocomplete="off">
                            <label for="date">Date:</label>
                            <input type="date" id="date" name="date" min="<?php $currentDate = date('Y-m-d');
                                                                            echo $currentDate; ?>" required>
                            <label for="time">Time:</label>
                            <select id="time" name="time" required>
                                <option value="10:00">10:00 AM</option>
                                <option value="12:30">12:30 PM</option>
                                <option value="15:00">3:00 PM</option>
                            </select>
                            <label for="password">Password:</label>
                            <input type="password" id="password" name="password" required autocomplete="off">
                            <label for="phoneNumber">Phone Number:</label>
                            <input type="text" id="phoneNumber" name="phoneNumber" required autocomplete="off" pattern="[0-9]*" maxlength="10">
                            <div class="button-container">
                                <input type="submit" value="Submit" class="submit-button">
                            </div>
                        </form>
                    </div>
                </div>
                <div id="loginModal" class="modal">
                    <div class="modal-content">
                        <span class="closeBtn">&times;</span>
                        <p>Please log in to book your adventure.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <section id="about">
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

            So what are you waiting for? Take the leap and experience the thrill of paragliding for yourself. Trust us, you won't regret it!
        </p>
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
                    <li><a href="#"><i class="ri-facebook-circle-fill"></i></li></i></a>
                </ul>
            </div>
        </div>
        <div class="bottom-bar">
            <p> &copy: 2024 Sky adventure. All rights reserved.</p>
        </div>
    </footer>
    </div>
    <script>
        function validateForm() {
            var username = document.getElementById('name').value;
            var password = document.getElementById('password').value;
            var email = document.getElementById('email').value;
            var fullname = document.getElementById('name').value;
            var number = document.getElementById("phoneNumber").value;
            var numberPattern = /^9\d{9}$/;

            var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            var namePattern = /^[A-Z][a-zA-Z\s]*$/;

            if (username.trim() == "" || username.length < 3) {
                alert("Username must be at least 3 characters long");
                return false;
            }
            if (password.trim() == "" || password.length < 5) {
                alert("Password must be at least 5 characters long");
                return false;
            }
            if (!emailPattern.test(email)) {
                alert("Please enter a valid email address");
                return false;
            }
            if (!numberPattern.test(number)) {
                alert("Invalid number. It must start with 9 and contain exactly 10 digits.");
                return false;
            }
            return true;
        }
    </script>
    <script src="script1.js">

    </script>
</body>

</html>