<?php

include '../components/connect.php';

if (isset($_COOKIE['tutor_id'])) {
    $tutor_id = $_COOKIE['tutor_id'];
} else {
    $tutor_id = '';
    header('location:login.php');
}

if (isset($_POST['submit'])) {
    $test_id = unique_id();
    $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
    $test_link = filter_input(INPUT_POST, 'test_link', FILTER_SANITIZE_URL);

    // Validate inputs (add more as needed)
    if (empty($title) || empty($description) || empty($test_link)) {
        $message[] = 'Please fill in all required fields.';
    } else {
        // Add further validation or processing as needed

        // If using a link input
        $add_test = $conn->prepare("INSERT INTO tests (test_id, tutor_id, title, description, test_link, status) VALUES (?, ?, ?, ?, ?, ?)");
        $add_test->execute([$test_id, $tutor_id, $title, $description, $test_link, $status]);

        $message[] = 'New test uploaded!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="../css/admin_style.css">
</head>

<body>

    <?php include '../components/admin_header.php'; ?>

    <section class="video-form">

        <h1 class="heading">Upload Test</h1>

        <form action="" method="post" enctype="multipart/form-data">
            <p>Test status <span>*</span></p>
            <select name="status" class="box" required>
                <option value="" selected disabled>-- Select status</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
            <p>Test title <span>*</span></p>
            <input type="text" name="title" maxlength="100" required placeholder="Enter test title" class="box">
            <p>Test description <span>*</span></p>
            <textarea name="description" class="box" required placeholder="Write test description" maxlength="1000"
                cols="30" rows="10"></textarea>

            <!-- If using a file input -->
            <!-- <p>Select test file <span>*</span></p>
      <input type="file" name="test" accept=".pdf, .doc, .docx" required class="box"> -->

            <!-- If using a link input -->
            <p>Enter test link <span>*</span></p>
            <input type="text" name="test_link" placeholder="Enter test link" required class="box">

            <input type="submit" value="Upload Test" name="submit" class="btn">
        </form>

    </section>

    <?php include '../components/footer.php'; ?>

    <script src="../js/admin_script.js"></script>

</body>

</html>