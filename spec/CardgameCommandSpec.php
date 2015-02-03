<?php

namespace spec\Smartbit;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CardgameCommandSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Smartbit\CardgameCommand');
    }

    function it_gets_a_new_deck()
    {
        $this->getANewDeck();

        $this->dealCard(0)->shouldBe('Heart Ace');
        $this->dealCard(1)->shouldBe('Heart Two');
        $this->dealCard(37)->shouldBe('Spade Queen');
        $this->dealCard(51)->shouldBe('Diamond King');
    }

    function it_shuffles_the_deck()
    {
        $this->shuffleCards();

        $this->dealCard(0)->shouldNotBe('Heart Ace');
        $this->dealCard(1)->shouldNotBe('Heart Two');
        $this->dealCard(37)->shouldNotBe('Spade Queen');
        $this->dealCard(51)->shouldNotBe('Diamond King');
    }

    public function it_shuffles_the_deck_and_deal_7_cards_to_4_players()
    {
        $this->shuffleCards();

        $players = 4;

        $this->dealCardsToPlayers();

        $this->tableHeaders()->shouldHaveType('Illuminate\Support\Collection');
        $this->tableHeaders()->all()->shouldBe(['Player 1', 'Player 2', 'Player 3', 'Player 4']);
        $this->tableRows()->shouldHaveType('Illuminate\Support\Collection');
        // After the first round of the deals players should got the first 4 cards from the deck
        $this->tableRows()->first()->shouldBe($this->deck->chunk($players)->first()->all());
    }

    public function it_shuffles_the_deck_and_deal_4_cards_to_7_players()
    {
        $this->shuffleCards();

        $players = 7;

        $this->dealCardsToPlayers(4, 7);

        $this->tableHeaders()->shouldHaveType('Illuminate\Support\Collection');
        $this->tableHeaders()->all()->shouldBe(['Player 1', 'Player 2', 'Player 3', 'Player 4', 'Player 5', 'Player 6', 'Player 7']);
        $this->tableRows()->shouldHaveType('Illuminate\Support\Collection');
        // After the first round of the deals players should got the first 7 cards from the deck
        $this->tableRows()->first()->shouldBe($this->deck->chunk($players)->first()->all());
    }
}
