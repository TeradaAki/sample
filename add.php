<?php  

    include('config/connect_dp.php');

    // --- 13. ---
    // if(isset($_GET['submit'])) {
    //     echo $_GET['email'];
    //     echo $_GET['title'];
    //     echo $_GET['ingredients'];
    // }

    $title = $email = $ingredients = '';
    $errors = array('email' => '', 'title' => '', 'ingredients' => '');
    // the "POST" is more secured its not showing any data in the search bar or link
    if(isset($_POST['submit'])) {// this would create a set(isset) of arrays from the data that has been submitted(submit)
        // The "htmlspecialchars" would prevent any attack from submission of harmful link but now with the htmlspecialchars it would just render it as an entity
        // echo htmlspecialchars($_POST['email']);
        // echo htmlspecialchars($_POST['title']);
        // echo htmlspecialchars($_POST['ingredients']);

        // validating email
        if(empty($_POST['email'])) {// read it like "if its empty and nothing has been post on the email then echo the message "an email is required" but if there is something posted then procced to else"
            $errors['email'] = 'An email is required <br />';
        } else {
            $email = $_POST['email'];
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {// this would validate the email that it needs to have .com, @gmail, @yahoo and so on.
                $errors['email'] = 'INVALID EMAIL ADDRESS';               // lastly the "!" is negating the codition meaning the data that would pass through would be false"
            }
        }

        // validating title
        if(empty($_POST['title'])) {
            $errors['title'] = 'A title is required <br />';
        } else {
            $title = $_POST['title'];
            if(!preg_match('/^[a-zA-Z\s]+$/', $title)) {
                $errors['title'] = 'TITLE MUST BE LETTERS AND SPACES ONLY!!';
            }
        }

        // validating ingredients
        if(empty($_POST['ingredients'])) {
            $errors['ingredients'] = 'An ingredient is required <br />';
        } else {
            $ingredients = $_POST['ingredients'];
            if(!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $ingredients)) {
                $errors['ingredients'] = 'INGREDIENTS MUST BE A COMMA SEPERATED LIST!!!!!!';
            }
        }

        // the "array_filter" would check one by one to identifying the "$errors" on each of the input 
        if(array_filter($errors)) {// to read this would be "if the group of data(array) has filter(_filter) the data one by one in the error($errors) varaible"
            // echo 'errors in the form';
        } else {
            // this would allow it to be send as a data in sql
            $email = mysqli_real_escape_string($connection, $_POST['email']);
            $title = mysqli_real_escape_string($connection, $_POST['title']);
            $ingredients = mysqli_real_escape_string($connection, $_POST['ingredients']);

            // create sql
            $sql = "INSERT INTO pizzas(title, email, ingredients) VALUES('$title', '$email', '$ingredients')";// to read this "i want to  INSERT this INTO "pizzas" table and update this columns which is the title, email, and ingredients their VALUE is this $title, $email, and $ingredients

            // save to db and check
            if(mysqli_query($connection, $sql)) {// "if the data has been send then it would be succes otherwise "failed""
                // success
                header('Location: index.php');
            } else {
                echo 'failed: ' . mysqli_error($connection);
            }

        }



    }// end of the POST validation

?>

<!DOCTYPE html>
<html lang="en">
    <!-- 13. -->
    <?php include('templates/header.php') ?>

    <section class="container grey-text">
        <h4 class="center">Add a pizza</h4>
        <form class="white" action="add.php" method="POST">
            <label>Your Email: </label>
            <input type="text" name="email" value="<?php echo htmlspecialchars($email) ?>">
            <div class="red-text"><?php echo $errors['email']; ?></div>

            <label>Pizza Title: </label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($title) ?>">
            <div class="red-text"><?php echo $errors['title']; ?></div>

            <label>Ingredients (comma seperated): </label>
            <input type="text" name="ingredients" value="<?php echo htmlspecialchars($ingredients) ?>">
            <div class="red-text"><?php echo $errors['ingredients']; ?></div>
            <div class="center">
                <input type="submit" name="submit" value="submit" class="btn brand z-depth-0">
            </div>
        </form>
    </section>
    
    <?php include('templates/footer.php') ?>
    

</html>