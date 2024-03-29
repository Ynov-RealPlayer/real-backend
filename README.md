# RealPlayer - Project 🎈

The goal is to create a platform for gamers so that they can share their gaming experiences in the form of screens or clips.
This project aims to create a community platform for gamers to allow users to share their gaming experiences, encourage user engagement and participation, and provide a more social vision. We would like to be able to make a meeting place after the games and allow the players to increase their ego and competitiveness.

# Features of the project 🔍

1. Allow users to create an account on the application and customize their profile by adding information about their favorite video games or wearing badges.
2. Offer users the ability to publish video and image content related to their video game games, with the ability to share them on social networks.
3. Offer a content discovery feature for users, which will allow them to see the publications of other users on games and themes they like.
4. Provide a simple and intuitive interface for a pleasant and fluid user experience.
5. Ensure the security of user data by guaranteeing the confidentiality of personal information and published content.


# Installation ⬇️

To run the project, you'll need :
```
php 8+
docker fully installed (client on windows or wsl)
composer 2.0+
node v17+
Clone the projet and navigate inside with your terminal to execute the next commands
```

Then,

    docker run --rm --interactive --tty \
    --volume $PWD:/app \
    composer install --ignore-platform-reqs

Then,

    run : cp .env.example .env
    run : npm install
    run : ./vendor/bin/sail up -d
    migrate and seed the database with : ./vendor/bin/sail artisan migrate:fresh --seed
    refresh routes and configurations with : ./vendor/bin/sail artisan optimize
    run : npm run dev

# Utilisation 🪧

You can now go on http://localhost for the Back Office

You can use http://localhost/api/{model} to use the API

You may register and login to have a full experience of the project
