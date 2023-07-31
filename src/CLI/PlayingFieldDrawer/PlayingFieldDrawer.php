<?php
declare(strict_types=1);

namespace TicTacToe\CLI\PlayingFieldDrawer;

use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Helper\TableStyle;
use Symfony\Component\Console\Output\OutputInterface;
use TicTacToe\PlayingField\PlayingField;

class PlayingFieldDrawer
{
    private const COLUMN_WIDTH = 5;
    private OutputInterface $output;
    private TableStyle $tableStyle;
    private PlayingField $playingField;

    public function __construct(OutputInterface $output, PlayingField $playingField)
    {
        $this->output = $output;
        $this->playingField = $playingField;
        $this->tableStyle = new TableStyle();
        $this->tableStyle->setPadType(\STR_PAD_BOTH);
    }

    public function draw(): void
    {
        $table = new Table($this->output);
        $table->setColumnWidths(\array_fill(0, $this->playingField->getColumns(), static::COLUMN_WIDTH));
        $table->setStyle($this->tableStyle);

        $cellIndex = 1;

        for ($row = 0; $row < $this->playingField->getRows(); $row++) {
            $rowContent = [];

            for ($column = 0; $column < $this->playingField->getColumns(); $column++) {
                $cell = $this->playingField->getCellByIndex($cellIndex);
                $rowContent[] = null !== $cell->getOccupiedBy() ? $cell->getOccupiedBy()->getId() : $cell->getIndex();

                $cellIndex++;
            }

            $table->addRow($rowContent);

            if ($row + 1 < $this->playingField->getRows()) {
                $table->addRow(new TableSeparator());
            }
        }

        $table->render();
    }
}
