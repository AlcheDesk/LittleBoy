<?php

namespace App\Models;

class MeowlomoResponse implements \JsonSerializable {
	private $metadata;
	private $error;
	private $data;

	public function __construct() {
		$get_arguments = func_get_args();
		$number_of_arguments = func_num_args();

		if (method_exists($this, $method_name = '__construct' . $number_of_arguments)) {
			call_user_func_array(array($this, $method_name), $get_arguments);
		}
	}

	public function __construct0() {
		$this->metadata = '{}';
		$this->data = '[]';
		$this->error = new MeowlomoErrorResponse();
	}

	public function __construct1(array $values = []) {
		array_key_exists('metadata', $values) ? $this->setMetadata($values['metadata']) : $this->metadata = '{}';
		array_key_exists('data', $values) ? $this->setData($values['data']) : $this->data = '[]';
		array_key_exists('error', $values) ? $this->setError($values['error']) : $this->error = new MeowlomoErrorResponse();
	}

	public function getMetadata(): array
	{
		return $this->metadata;
	}

	public function setMetadata(array $metadata = []) {
		$this->metadata = $metadata;
	}

	public function getError(): MeowlomoErrorResponse {
		return $this->error;
	}

	public function setError(MeowlomoErrorResponse $error) {
		$this->error = $error;
	}

	public function getData(): array
	{
		return $this->data;
	}

	public function setData(array $data = []) {
		$this->data = $data;
	} //String

	/**
	 * Specify data which should be serialized to JSON
	 * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
	 * @return mixed data which can be serialized by <b>json_encode</b>,
	 * which is a value of any type other than a resource.
	 * @since 5.4.0
	 */
	public function jsonSerialize() {
		$returnArray = [];
		if ($this->metadata != null) {
			$returnArray['metadata'] = $this->getMetadata();
		} else {
			$returnArray['metadata'] = '{}';
		};
		if ($this->data != null) {
			$returnArray['data'] = $this->getData();
		} else {
			$returnArray['data'] = '[]';
		};
		if ($this->error != null) {
			$returnArray['error'] = $this->getError();
		} else {
			$returnArray['error'] = '{}';
		};
		return $returnArray;
	}
}
