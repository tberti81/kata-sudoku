<?php

namespace Sudoku\Test;

use InvalidArgumentException;
use PHPUnit_Framework_TestCase;
use Sudoku\SudokuValidator;

class SudokuValidatorTest extends PHPUnit_Framework_TestCase
{
	/** @var SudokuValidator */
	private $subject;

	public function setUp()
	{
		$this->subject = new SudokuValidator();
	}

	/**
	 * @dataProvider invalidSudokuProvider
	 *
	 * @expectedException InvalidArgumentException
	 */
	public function testSudokuValidatorThrowsExceptionWhenInvalidSudokuGiven($sudoku)
	{
		$this->subject->validate($sudoku);
	}

	/**
	 * @dataProvider badSudokuProvider
	 */
	public function testSudokuValidatorReturnsFalseWhenBadSudokuGiven($sudoku)
	{
		$this->assertFalse($this->subject->validate($sudoku));
	}

	/**
	 * @dataProvider goodSudokuProvider
	 */
	public function testSudokuValidatorReturnsTrueWhenGoodSudokuGiven($sudoku)
	{
		$this->assertTrue($this->subject->validate($sudoku));
	}

	/**
	 * @return array
	 */
	public function invalidSudokuProvider()
	{
		return [
			[
				[]
			],
			[
				[1, 2, 3, 4]
			],
			[
				[
					[1, 2, 3, 4],
					[1, 2, 3, 4],
					[1, 2, 3, 4],
					[1, 2, 3, 4],
					[1, 2, 3, 4],
					[1, 2, 3, 4],
					[1, 2, 3, 4],
					[1, 2, 3, 4],
					[1, 2, 3, 4],
				]
			],
			[
				[
					[1, 2, 3, 4, 5, 6, 7, 8, 9],
					[1, 2, 3, 4, 5, 6, 7, 8, 9],
					[1, 2, 3, 4, 5, 6, 7, 8, 9],
					[1, 2, -1, 4, 5, 6, 7, 8, 9],
					[1, 2, 3, 4, 5, 6, 7, 8, 9],
					[1, 2, 3, 4, 5, 6, 7, 8, 9],
					[1, 2, 3, 4, 5, 6, 7, 8, 9],
					[1, 2, 3, 4, 5, 6, 7, 8, 9],
					[1, 2, 3, 4, 5, 6, 7, 8, 9],
				]
			],
		];
	}

	/**
	 * @return array
	 */
	public function badSudokuProvider()
	{
		return [
			[
				[
					[1, 2, 3, 4, 5, 6, 7, 8, 9],
					[1, 2, 3, 4, 5, 6, 7, 8, 9],
					[1, 2, 3, 4, 5, 6, 7, 8, 9],
					[1, 2, 3, 4, 5, 6, 7, 8, 9],
					[1, 2, 3, 4, 5, 6, 7, 8, 9],
					[1, 2, 3, 4, 5, 6, 7, 8, 9],
					[1, 2, 3, 4, 5, 6, 7, 8, 9],
					[1, 2, 3, 4, 5, 6, 7, 8, 9],
					[1, 2, 3, 4, 5, 6, 7, 8, 9],
				]
			],
			[
				[
					[1, 1, 1, 1, 1, 1, 1, 1, 1],
					[2, 2, 2, 2, 2, 2, 2, 2, 2],
					[3, 3, 3, 3, 3, 3, 3, 3, 3],
					[4, 4, 4, 4, 4, 4, 4, 4, 4],
					[5, 5, 5, 5, 5, 5, 5, 5, 5],
					[6, 6, 6, 6, 6, 6, 6, 6, 6],
					[7, 7, 7, 7, 7, 7, 7, 7, 7],
					[8, 8, 8, 8, 8, 8, 8, 8, 8],
					[9, 9, 9, 9, 9, 9, 9, 9, 9],
				]
			],
			[
				[
					[1, 1, 1, 2, 2, 2, 3, 3, 3],
					[1, 1, 1, 2, 2, 2, 3, 3, 3],
					[1, 1, 1, 2, 2, 2, 3, 3, 3],
					[4, 4, 4, 5, 5, 5, 6, 6, 6],
					[4, 4, 4, 5, 5, 5, 6, 6, 6],
					[4, 4, 4, 5, 5, 5, 6, 6, 6],
					[7, 7, 7, 8, 8, 8, 9, 9, 9],
					[7, 7, 7, 8, 8, 8, 9, 9, 9],
					[7, 7, 7, 8, 8, 8, 9, 9, 9],
				]
			],
			[
				[
					[1, 2, 3, 4, 5, 6, 7, 8, 9],
					[2, 3, 4, 5, 6, 7, 8, 9, 1],
					[3, 4, 5, 6, 7, 8, 9, 1, 2],
					[4, 5, 6, 7, 8, 9, 1, 2, 3],
					[5, 6, 7, 8, 9, 1, 2, 3, 4],
					[6, 7, 8, 9, 1, 2, 3, 4, 5],
					[7, 8, 9, 1, 2, 3, 4, 5, 6],
					[8, 9, 1, 2, 3, 4, 5, 6, 7],
					[9, 1, 2, 3, 4, 5, 6, 7, 8],
				]
			],
			[
				[
					[5, 3, 4, 6, 7, 8, 9, 1, 2],
					[6, 7, 2, 1, 9, 0, 3, 4, 8],
					[1, 0, 0, 3, 4, 2, 5, 6, 0],
					[8, 5, 9, 7, 6, 1, 0, 2, 0],
					[4, 2, 6, 8, 5, 3, 7, 9, 1],
					[7, 1, 3, 9, 2, 4, 8, 5, 6],
					[9, 0, 1, 5, 3, 7, 2, 1, 4],
					[2, 8, 7, 4, 1, 9, 6, 3, 5],
					[3, 0, 0, 4, 8, 1, 1, 7, 9],
				]
			],
		];
	}

	/**
	 * @return array
	 */
	public function goodSudokuProvider()
	{
		return [
			[
				[
					[5, 3, 4, 6, 7, 8, 9, 1, 2],
					[6, 7, 2, 1, 9, 5, 3, 4, 8],
					[1, 9, 8, 3, 4, 2, 5, 6, 7],
					[8, 5, 9, 7, 6, 1, 4, 2, 3],
					[4, 2, 6, 8, 5, 3, 7, 9, 1],
					[7, 1, 3, 9, 2, 4, 8, 5, 6],
					[9, 6, 1, 5, 3, 7, 2, 8, 4],
					[2, 8, 7, 4, 1, 9, 6, 3, 5],
					[3, 4, 5, 2, 8, 6, 1, 7, 9],
				]
			],
		];
	}
}