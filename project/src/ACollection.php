<?php


abstract class ACollection implements Iterator
{

	/**
	 * @var int
	 */
	private $position = 0;

	/**
	 * @var array
	 */
	protected $elements = [];


	/**
	 * @param $element
	 */
	public function add($element)
	{
		$this->elements[count($this->elements)] = $element;
	}

	/**
	 * @param $key
	 * @param $element
	 */
	public function set($key, $element)
	{
		$this->elements[$key] = $element;
	}

	/**
	 * @param $key
	 *
	 * @return mixed|null
	 */
	public function get($key)
	{
		if (array_key_exists($key, $this->elements)) {
			return $this->elements[$key];
		}
		return null;
	}

	/**
	 * Return the current element
	 * @return mixed Can return any type.
	 */
	public function current()
	{
		return $this->elements[$this->position];
	}

	/**
	 * Move forward to next element
	 * @return void Any returned value is ignored.
	 */
	public function next(): void
	{
		++$this->position;
	}

	/**
	 * Return the key of the current element
	 * @return mixed scalar on success, or null on failure.
	 */
	public function key(): int
	{
		return $this->position;
	}

	/**
	 * Checks if current position is valid
	 * @return boolean The return value will be casted to boolean and then evaluated.
	 * Returns true on success or false on failure.
	 */
	public function valid(): bool
	{
		return isset($this->elements[$this->position]);
	}

	/**
	 * Rewind the Iterator to the first element
	 * @return void Any returned value is ignored.
	 */
	public function rewind(): void
	{
		$this->position = 0;
	}

	/**
	 * Seeks to a position
	 *
	 * @param int $position
	 * @return void
	 */
	public function seek($position): void
	{
		try {
			if (!isset($this->elements[$position])) {
				throw new OutOfBoundsException("invalid seek position ($position)");
			}
			$this->position = $position;
		} catch (OutOfBoundsException $e) {
			echo $e->getMessage() . "\n";
		}
	}
}