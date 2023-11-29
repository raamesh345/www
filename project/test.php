<?php

include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['post_test'])) {
    // Code for handling test submission by tutors
    // ...
    // You can include the logic for inserting the test into the database
    // Redirect or display a success message
    // header("Location: tests.php"); // Redirect to the tests page
    // exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses and Tests</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <?php include 'components/user_header.php'; ?>

    <!-- Courses and Tests section starts -->
    <section class="courses-tests">

        <h1 class="heading">All Courses and Tests</h1>

        <!-- Test submission form for tutors -->
        <?php if ($user_role === 'tutor') { ?>
            <form method="post" action="">
                <!-- Add form fields for test title, description, etc. -->
                <input type="text" name="title" placeholder="Test Title" required>
                <textarea name="description" placeholder="Test Description" required></textarea>
                <button type="submit" name="post_test">Post Test</button>
            </form>
        <?php } ?>


        <div class="box-container">

            <!-- Display Courses -->
            <?php
            $select_courses = $conn->prepare("SELECT * FROM `playlist` WHERE status = ? ORDER BY date DESC");
            $select_courses->execute(['active']);
            if ($select_courses->rowCount() > 0) {
                while ($fetch_course = $select_courses->fetch(PDO::FETCH_ASSOC)) {
                    // Display course information
                    // ...
                }
            } else {
                echo '<p class="empty">No courses added yet!</p>';
            }
            ?>

            <!-- Display Tests -->
            <?php
            $select_tests = $conn->prepare("SELECT * FROM tests WHERE status = 'active' ORDER BY date DESC");
            $select_tests->execute();

            if ($select_tests->rowCount() > 0) {
                while ($fetch_test = $select_tests->fetch(PDO::FETCH_ASSOC)) {
                    // Display test information
                    // ...
                }
            } else {
                echo '<p class="empty">No tests available yet!</p>';
            }
            ?>

        </div>

    </section>
    <!-- Courses and Tests section ends -->

    <?php include 'components/footer.php'; ?>

    <!-- custom js file link  -->
    <script src="js/script.js"></script>

</body>

</html>