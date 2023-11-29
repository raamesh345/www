<?php

include '../components/connect.php';

if (isset($_COOKIE['tutor_id'])) {
    $tutor_id = $_COOKIE['tutor_id'];
} else {
    $tutor_id = '';
    header('location:login.php');
}

if (isset($_POST['delete_test'])) {
    $delete_id = $_POST['test_id'];
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);
    $verify_test = $conn->prepare("SELECT * FROM `tests` WHERE id = ? LIMIT 1");
    $verify_test->execute([$delete_id]);
    if ($verify_test->rowCount() > 0) {
        $delete_test = $conn->prepare("DELETE FROM `tests` WHERE id = ?");
        $delete_test->execute([$delete_id]);
        $message[] = 'test deleted!';
    } else {
        $message[] = 'test already deleted!';
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

    <section class="contents">

        <h1 class="heading">Your Contents</h1>

        <div class="box-container">

            <!-- Create New Content button -->

            <!-- Add Test button -->
            <div class="box" style="text-align: center;">
                <h3 class="title" style="margin-bottom: .5rem;">Create New Test</h3>
                <a href="add_test.php" class="btn">Add Test</a>
            </div>

            <!-- Display Tests -->
            <?php
            $select_tests = $conn->prepare("SELECT * FROM `tests` WHERE tutor_id = ? ORDER BY date DESC");
            $select_tests->execute([$tutor_id]);
            if ($select_tests->rowCount() > 0) {
                while ($fecth_tests = $select_tests->fetch(PDO::FETCH_ASSOC)) {
                    $test_id = $fecth_tests['id'];
                    ?>
                    <div class="box">
                        <form action="" method="post" class="flex-btn">
                            <input type="hidden" name="test_id" value="<?= $test_id; ?>">
                            <a href="update_test.php?get_id=<?= $test_id; ?>" class="option-btn">update</a>
                            <input type="submit" value="delete" class="delete-btn"
                                onclick="return confirm('delete this test?');" name="delete_test">
                        </form>
                        <a href="view_test.php?get_id=<?= $test_id; ?>" class="btn">view test</a>
                    </div>
                    <?php
                }
            } else {
                echo '<p class="empty">No tests added yet!</p>';
            }
            ?>

        </div>

    </section>

    <?php include '../components/footer.php'; ?>

    <script src="../js/admin_script.js"></script>

</body>

</html>