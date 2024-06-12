<?php

// Initialisation des variables
$message_type = 'success';
$errors = [];

// Fonction de nettoyage des données
function cleanData($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = htmlentities($data);
    return $data;
}

// Etape 1 : On récupère les données du formulaire
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Récupération des données nettoyées
    $name = cleanData($_POST['name'] ?? '');
    $email = cleanData($_POST['email'] ?? '');
    $subject = cleanData($_POST['subject'] ?? '');
    $message = cleanData($_POST['message'] ?? '');

    // Etape 2 : On vérifie les données

    // Vérification du nom
    if (empty($name)) {
        $errors[] = "Please enter your name.";
        $message_type = 'error';
    } elseif (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
        $errors[] = "Only letters and white space allowed for your name";
        $message_type = 'error';
    }

    // Vérification de l'email
    if (empty($email)) {
        $errors[] = "Please enter your email address.";
        $message_type = 'error';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "The email address is invalid.";
        $message_type = 'error';
    }

    // Vérification du sujet
    if (empty($subject)) {
        $errors[] = "Please choose a subject.";
        $message_type = 'error';
    }

    // Etape 3 : Si pas d'erreur, redirection vers la page de remerciement
    if ($message_type == 'success') {
        header('Location: result.php');
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Results</title>
    <link rel="stylesheet" href="/assets/styles/style.css">
    <link rel="stylesheet" href="/assets/styles/contact.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Source+Sans+3:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet">
</head>

<body>
    <header class="other_pages">
        <?php include '_navbar.php' ?>
    </header>

    <main>
        <section class="d-flex-center">
            <h2 class="text-center">Get in touch</h2>
            <h3 class="text-center">Please fix errors below</h3>
            <ul class="errors">
                <!-- Etape 7 : On affiche les erreurs s'il y en a -->
                <?php foreach ($errors as $error) : ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </section>

        <div class="container">
            <form action="" method="post">
                <label for="name" require>Name</label>
                <input type="text" id="name" name="name" required>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
                <label for="subject">Subject</label>
                <select name="subject" required>
                    <option value=""></option>
                    <option value="appointment">Schedule an appointment</option>
                    <option value="newsletter">Suscribe to the newsletter</option>
                    <option value="reclamation">Reclamation</option>
                    <option value="quote">Request a quote</option>
                </select>
                <label for="message">Message</label>
                <textarea id="message" name="message" rows="16"></textarea>
                <button type="submit">Send</button>
            </form>
        </div>
    </main>
    <?php include '_footer.php' ?>
</body>

</html>