# Card game
Card game kata.

# Installation
Simply clone this repository and run ``` composer install ``` to pull the dependencies.

# Run the game
Navigate to the installation path and run:

    ./cardgame deal

![Simple run](http://sc-cdn.scaleengine.net/i/4b437f7cd0a41752643bcd0b879f8102.png "Simple run")

This will run the default game with 4 players and 7 cards. However it will just display a message about the deck was shuffled and the players got the cards.
If you want to see the players' cards run:

    ./cardgame deal --display

![Display the players cards](http://sc-cdn.scaleengine.net/i/4fcbc838a32acec686e3062549da424a.png "Display the players cards")

If you'd like to play with number of players and cards, you can pass to arguments.

    ./cardgame deal [cards] [players] --display

so, if you play with 5 cards and 6 players you may run:

    ./cardgame deal 5 6 --display

![Play with various players and cards](http://sc-cdn.scaleengine.net/i/6d2fc3bb765fe81542e32d445747406c.png "Play with various players and cards")

# Unit tests
I used PHPSpec to unit test the class. Simply run:

    vendor/bin/phpspec run

![PHPSpec](http://sc-cdn.scaleengine.net/i/1761af28c785eb545406ab5eaa8575d0.png "PHPSpec")

