<?php
class CorefireAliPayException extends Exception {
	public function errorMessage()
	{
		return $this->getMessage();
	}
}
