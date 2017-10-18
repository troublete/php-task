<?php

use function Task\{forkTask,getProcessStatus,checkAvailable,checkSuccess,checkFail,closeTask};

class ForkTest extends \Codeception\Test\Unit
{
	public function testProcessFork()
	{
		$pid = forkTask(function () {
			usleep(1);
		});

		if ($pid !== null) {
			$this->assertTrue(is_numeric($pid));
		}    	
	}

	public function testProcessGetStatus() 
	{
		$pid = forkTask(function () {
			return 0;
		});		

		if ($pid !== null) {
			$this->assertTrue(is_numeric(getProcessStatus($pid)));
		}
	}

	public function testProcessCheckSuccessNegative()
	{
		$this->assertFalse(checkSuccess(null));
	}

	public function testProcessCheckFailNegative()
	{
		$pid = forkTask(function () {
			usleep(1);
		});

		sleep(1);
		$this->assertFalse(checkFail(null));
		$this->assertFalse(checkFail($pid));
	}

	public function testProcessCheckAvailablePositive()
	{
		$pid = forkTask(function () {
			usleep(1);
		});

		if ($pid !== null) {
			$this->assertTrue(checkAvailable($pid));
		}
	}

	public function testProcessCheckAvailableNegative()
	{
		$this->assertFalse(checkAvailable(null));
	}

	public function checkCloseForkPositive()
	{
		$pid = forkTask(function () {
			sleep(2);
		});

		$return = closeTask($pid);

		$this->assertFalse(checkAvailable($pid));
		$this->assertTrue($return);
	}

	public function checkCloseForkNegative()
	{
		$return = closeTask(99999999999999999999999999);

		$this->assertFalse($return);
	}
}