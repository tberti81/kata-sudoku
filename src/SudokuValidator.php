<?php

namespace Sudoku;

use InvalidArgumentException;
use LogicException;

class SudokuValidator
{
	/** @var array */
	private $rows;
	/** @var array */
	private $columns;
	/** @var array */
	private $blocks;

	/**
	 * @param array $sudoku
	 *
	 * @return bool
	 */
	public function validate(array $sudoku)
	{
		if (!$this->validFormat($sudoku))
		{
			throw new InvalidArgumentException();
		}

		$this->resetCheckers();

		try
		{
			for ($row = 0; $row < 9; $row++)
			{
				for ($column = 0; $column < 9; $column++)
				{
					$this->checkZero($sudoku[$row][$column]);
					$this->putIntoRow($row, $sudoku[$row][$column]);
					$this->putIntoColumn($column, $sudoku[$row][$column]);
					$this->putIntoBlock($row, $column, $sudoku[$row][$column]);
				}
			}

			return true;
		}
		catch (LogicException $exception)
		{
			return false;
		}
	}

	/**
	 * @param array $sudoku
	 *
	 * @return bool
	 */
	private function validFormat(array $sudoku)
	{
		return !empty($sudoku)
			&& count($sudoku) === 9
			&& count(
				array_filter(
					$sudoku,
					function($row) {
						return is_array($row)
						&& count($row) === 9
						&& count(
							array_filter(
								$row,
								function ($item) {
									return is_int($item) && $item >= 0 && $item <= 9;
								}
							)
						) === 9;
					}
				)
			) === 9;
	}

	/**
	 *
	 */
	private function resetCheckers()
	{
		$this->rows    = [];
		$this->columns = [];
		$this->blocks  = [];
	}

	/**
	 * @param int $item
	 *
	 * @throws LogicException
	 */
	private function checkZero($item)
	{
		if ($item === 0)
		{
			throw new LogicException();
		}
	}

	/**
	 * @param int $row
	 * @param int $item
	 *
	 * @throws LogicException
	 */
	private function putIntoRow($row, $item)
	{
		if (!$this->isItemFitIntoRow($row, $item))
		{
			throw new LogicException();
		}

		$this->rows[$row][] = $item;
	}

	/**
	 * @param int $row
	 * @param int $item
	 *
	 * @return bool
	 */
	private function isItemFitIntoRow($row, $item)
	{
		return !isset($this->rows[$row]) || !in_array($item, $this->rows[$row]);
	}

	/**
	 * @param int $column
	 * @param int $item
	 *
	 * @throws LogicException
	 */
	private function putIntoColumn($column, $item)
	{
		if (!$this->isItemFitIntoColumn($column, $item))
		{
			throw new LogicException();
		}

		$this->columns[$column][] = $item;
	}

	/**
	 * @param int $column
	 * @param int $item
	 *
	 * @return bool
	 */
	private function isItemFitIntoColumn($column, $item)
	{
		return !isset($this->columns[$column]) || !in_array($item, $this->columns[$column]);
	}

	/**
	 * @param int $row
	 * @param int $column
	 * @param int $item
	 *
	 * @throws LogicException
	 */
	private function putIntoBlock($row, $column, $item)
	{
		$blockId = $this->getBlockId($row, $column);

		if (!$this->isItemFitIntoBlock($blockId, $item))
		{
			throw new LogicException();
		}

		$this->blocks[$blockId][] = $item;
	}

	/**
	 * @param int $row
	 * @param int $column
	 *
	 * @return string
	 */
	private function getBlockId($row, $column)
	{
		$quotientRow    = (int)($row / 3);
		$quotientColumn = (int)($column / 3);

		return $quotientRow . $quotientColumn;
	}

	/**
	 * @param string $blockId
	 * @param int    $item
	 *
	 * @return bool
	 */
	private function isItemFitIntoBlock($blockId, $item)
	{
		return !isset($this->blocks[$blockId]) || !in_array($item, $this->blocks[$blockId]);
	}
}