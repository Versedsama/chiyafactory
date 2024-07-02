<?php
require_once '../config.php';

// Start the session
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- 
    - primary meta tags
  -->
  <title>Chiya Factory- where every sip tells a story</title>
  <meta name="title" content="Grilli - Amazing & Delicious Food">
  <meta name="description" content="This is a Restaurant html template made by codewithsadee">

  <!-- 
    - favicon
  -->
  <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml">

  <!-- 
    - google font link
  -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&family=Forum&display=swap" rel="stylesheet">

  <!-- 
    - custom css link
  -->
  <link rel="stylesheet" href="./assets/css/style.css">

  <!-- 
    - preload images
  -->
  <link rel="preload" as="image" href="./assets/images/hero-slider-1.jpg">
  <link rel="preload" as="image" href="./assets/images/hero-slider-2.jpg">
  <link rel="preload" as="image" href="./assets/images/hero-slider-3.jpg">

</head>

<body id="top">

    <?php
        $reservationStatus = $_GET['reservation'] ?? null;
        $message = '';
        if ($reservationStatus === 'success') {
            $message = "Reservation successful";
            $reservation_id = $_GET['reservation_id'] ?? null;
            echo '<a class="nav-link" href="../home/home.php#hero">' .
            '<h1 class="text-center" style="font-family: Copperplate; color: whitesmoke;">JOHNNY\'S</h1>' .
            '<span class="sr-only"></span></a>';
            echo '<script>alert("Table Successfully Reserved. Click OK to view your reservation receipt."); window.location.href = "reservationReceipt.php?reservation_id=' . $reservation_id . '";</script>';

        }
        $head_count = $_GET['head_count'] ?? 1;
    ?>


  <main>
    <article>

      <section class="section testi text-center has-bg-image"
        style="background-image: url('./assets/images/testimonial-bg.jpg')" aria-label="testimonials">
        <div class="container">

        </div>
      </section>





      <!-- 
        - #RESERVATION
      -->

      <section class="reservation">
        <div class="container">

          <div class="form reservation-form bg-black-10">

            <form id="reservation-form" method="POST" action="insertReservation.php" class="form-left">

              <h2 class="headline-1 text-center">Online Reservation</h2>

              <p class="form-text text-center">
                Booking request <a href="tel:+88123123456" class="link">+977-9869748333</a>
                or fill out the order form
              </p>

              <div class="input-wrapper">
                <input type="text" name="customer_name" placeholder="Your Name" autocomplete="off" class="input-field" required>
              </div>

              <div class="input-wrapper">

                <div class="icon-wrapper">
                  <ion-icon name="person-outline" aria-hidden="true"></ion-icon>

                  <select name="table_id" class="input-field" required>
                    <?php 
                        $select_query_tables = "SELECT * FROM restaurant_tables";
                        $result_tables = mysqli_query($link, $select_query_tables);
                        $resultCheckTables = mysqli_num_rows($result_tables);

                        $resultCheckTables = mysqli_num_rows($result_tables);
                        if ($resultCheckTables > 0) {
                            while ($row = mysqli_fetch_assoc($result_tables)) {
                                echo '<option value="' . $row['table_id'] . '">For ' . $row['capacity'] . ' people. (Table : ' . $row['table_id'] . ')</option>';
                            }
                        }  else {
                            echo '<option disabled>No tables available, please choose another time.</option>';
                            echo '<script>alert("No reservation tables found for the selected time. Please choose another time.");</script>';
                        }
                    ?>
                  </select>

                  

                  <ion-icon name="chevron-down" aria-hidden="true"></ion-icon>
                </div>

                <div class="icon-wrapper">
                  <ion-icon name="calendar-clear-outline" aria-hidden="true"></ion-icon>

                  <input type="date" name="reservation_date" class="input-field" required>

                  <ion-icon name="chevron-down" aria-hidden="true"></ion-icon>
                </div>

                <div class="icon-wrapper">
                  <ion-icon name="time-outline" aria-hidden="true"></ion-icon>

                  <select name="reservation_time" class="input-field" required>
                    <option value="08:00am">08 : 00 am</option>
                    <option value="09:00am">09 : 00 am</option>
                    <option value="010:00am">10 : 00 am</option>
                    <option value="011:00am">11 : 00 am</option>
                    <option value="012:00am">12 : 00 am</option>
                    <option value="01:00pm">01 : 00 pm</option>
                    <option value="02:00pm">02 : 00 pm</option>
                    <option value="03:00pm">03 : 00 pm</option>
                    <option value="04:00pm">04 : 00 pm</option>
                    <option value="05:00pm">05 : 00 pm</option>
                    <option value="06:00pm">06 : 00 pm</option>
                    <option value="07:00pm">07 : 00 pm</option>
                    <option value="08:00pm">08 : 00 pm</option>
                    <option value="09:00pm">09 : 00 pm</option>
                    <option value="10:00pm">10 : 00 pm</option>
                  </select>

                  <ion-icon name="chevron-down" aria-hidden="true"></ion-icon>
                </div>

              </div>

              <textarea name="special_request" placeholder="Message" autocomplete="off" class="input-field" required></textarea>

              <button type="submit" class="btn btn-secondary">
                <span class="text text-1">Book A Table</span>

                <span class="text text-2" aria-hidden="true">Book A Table</span>
              </button>

            </form>

            <div class="form-right text-center" style="background-image: url('./assets/images/form-pattern.png')">

              <h2 class="headline-1 text-center">Contact Us</h2>

              <p class="contact-label">Booking Request</p>

              <a href="tel:+88123123456" class="body-1 contact-number hover-underline">+977-9869748333</a>

              <div class="separator"></div>

              <p class="contact-label">Location</p>

              <address class="body-4">
                Kirtipur-09, Chhugaun <br>
                Nepal
              </address>

              <p class="contact-label">Lunch Time</p>

              <p class="body-4">
                Monday to Sunday <br>
                11.00 am - 2.30pm
              </p>

              <p class="contact-label">Dinner Time</p>

              <p class="body-4">
                Monday to Sunday <br>
                05.00 pm - 10.00pm
              </p>

            </div>

          </div>

          <div style="height: 100px;">

          </div>

        </div>
      </section>
    </article>
  </main>


  <!-- 
    - custom js link
  -->
  <script src="./assets/js/script.js"></script>

  <!-- 
    - ionicon link
  -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>