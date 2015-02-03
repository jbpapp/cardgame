# Card game
Card game kata.

# Installation
Simply clone this repository and run composer install to pull the dependencies.

# Run the game
Navigate to the installation path and run:

    ``` ./cardgame deal ```

This will run the default game with 4 players and 7 cards. However it will just display a message about the deck was shuffled and the players got the cards.
If you want to see the players' cards run:

    ``` ./cardgame deal --display ```

If you'd like to play with number of players and cards, you can pass to arguments.

    ``` ./cardgame deal [cards] [players] --display ```

so, if you play with 5 cards and 6 players you may run:

    ``` ./cardgame deal 5 6 --display ```

# Unit tests
I used PHPSpec to unit test the class. Simply run:

    ``` vendor/bin/phpspec run ```


