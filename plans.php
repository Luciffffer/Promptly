<?php 

require_once(__DIR__ . '/vendor/autoload.php');

Promptly\Helpers\Security::onlyLoggedIn();

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plans - Promptly</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="shortcut icon" href="assets/images/site/promptly-logo.svg" type="image/x-icon">
    <style>
        main {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            padding: 3rem;
        }

        #get-credits-btn {
            border: none;
            color: var(--off-white);
            padding: 0.5rem 2rem;
            background: var(--blue-purple-gradient);
            font-family: "Montserrat", sans-serif;
            font-weight: bold;
            font-size: 1rem;
            margin: 2rem 0;
            cursor: pointer;
        }

        #feedback-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
            max-width: 600px;
            border: 2px solid var(--green);
            border-radius: 10px;
            padding: 1rem;
            text-align: center;
        }

    </style>
</head>
<body>
    <?php include_once(__DIR__ . "/partials/nav.inc.php"); ?>
    <main>
        <div id="feedback-container" class="hidden"></div>
        <h1 class="red-text">This page is work in progress</h1>
        <p>In the future it would display the subscription plans and options for buying credits.</p>
        <p>Right now just use the button bellow to get credits. This is purely for testing purposes</p>
        <button id="get-credits-btn" class="button">Get 5 Credits</class>
    </main>
    <script>
        const btn = document.querySelector('#get-credits-btn');

        btn.addEventListener('click', e => {
            e.preventDefault();

            fetch('ajax/get-credits.ajax.php')
                .then(response => response.json())
                .then(json => {
                    if (json.status == 'error') {
                        throw json.message;
                    }

                    const feedbackContainer = document.querySelector('#feedback-container');
                    feedbackContainer.classList.remove('hidden');
                    feedbackContainer.innerHTML = '';

                    const p = document.createElement('p');
                    p.textContent = json.message;
                    feedbackContainer.appendChild(p);

                    const p2 = document.createElement('p');
                    p2.textContent = 'Refresh the page to see your new credits';
                    feedbackContainer.appendChild(p2);

                })
                .catch(error => {
                    console.error(error);
                });
        });
    </script>
</body>
</html>