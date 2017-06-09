<?php

namespace GotSorter\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;

/**
 * Class SortCommand
 * @author Matthieu de Canteloube <matthieu@vimies.com>
 */
class SortCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('sort')
            ->setDescription('Sort')
            ->setHelp('This command allows you to sort characters written in an input file')
            ->addArgument('input', InputArgument::REQUIRED, 'The input file.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $lines = file($input->getArgument('input'), FILE_IGNORE_NEW_LINES);
        $helper = $this->getHelper('question');


        usort($lines, function($character1, $character2) use ($helper, $input, $output) {
            $question = new ChoiceQuestion(
                'Please select your favorite character ?',
                [$character1, $character2],
                0
            );
            $question->setErrorMessage('Charcter %s is invalid.');

            $chosenCharacter = $helper->ask($input, $output, $question);

            return $chosenCharacter === $character1 ? 1 : -1;
        });

        print_r($lines);
    }
}
