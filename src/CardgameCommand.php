<?php namespace Smartbit;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Illuminate\Support\Collection;

class CardgameCommand extends Command {

    public $deck;
    public $playerCards;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->deck = $this->getANewDeck();

        parent::__construct();
    }

    /**
     * Configure the command.
     */
    public function configure()
    {
        $this->setName('deal')
            ->setDescription('Shuffles the cards and deal them to the players.')
            ->addArgument('cards', InputArgument::OPTIONAL, 'The number of cards to deal.')
            ->addArgument('players', InputArgument::OPTIONAL, 'The number of players.')
            ->addOption('display', null, InputOption::VALUE_NONE, 'Display the players card in a table.');
    }
    /**
     * Execute the command.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $cards = $input->getArgument('cards') ?: 7;
        $players = $input->getArgument('players') ?: 4;

        $this->shuffleCards($output)->dealCardsToPlayers($cards, $players);

        $message = 'The deck has been shuffled and all of the ' . $players .
            ' players got ' . $cards . ' cards after the deal.';
        $output->writeln("<info>{$message}</info>");

        if ($input->getOption('display'))
            $this->displayPlayersCards($output);
    }

    /**
     * Build an array of cards for a new deck
     */
    public function getANewDeck()
    {
        $suits = ['Heart', 'Club', 'Spade', 'Diamond'];
        $values = ['Ace', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten', 'Jack', 'Queen', 'King'];

        $cards = [];
        foreach ($suits as $suit)
        {
            foreach ($values as $value)
                $cards[] = $suit . ' ' . $value;
        }

        return new Collection($cards);
    }

    /**
     * Deal the given card to the player
     *
     * @param integer $index
     * @return string
     */
    public function dealCard($index)
    {
        return $this->deck[$index];
    }

    public function dealCardsToPlayers($rounds = 7, $players = 4)
    {
        $round = 1;
        $card = 0;
        $deal = [];
        while ($round <= $rounds)
        {
            $player = 1;
            while ($player <= $players)
            {
                $deal[$player][$round] = $this->dealCard($card);
                $card++;
                $player++;
            }

            $round++;
        }

        $this->playerCards = new Collection($deal);
    }

    /**
     * Shuffle the cards
     *
     * @return $this
     */
    public function shuffleCards()
    {
        $this->deck->shuffle();

        return $this;
    }

    public function displayPlayersCards($output)
    {
        $table = new Table($output);
        $table
            ->setHeaders($this->tableHeaders()->all())
            ->setRows($this->tableRows()->all());
        $table->render();
    }

    public function tableHeaders()
    {
        return new Collection(array_map(function($value)
        {
            return 'Player ' . $value;
        }, $this->playerCards->keys()));
    }

    public function tableRows()
    {
        $rows = [];
        $players = $this->playerCards->count();
        $cards = count($this->playerCards[1]);

        $card = 1;
        while ($card <= $cards)
        {
            $player = 1;
            $row = [];
            while ($player <= $players)
            {
                $row[] = $this->playerCards[$player][$card];
                $player++;
            }

            $rows[] = $row;
            $card++;
        }

        return new Collection($rows);
    }
}
