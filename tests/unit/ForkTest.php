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

	public function testCheckCloseForkPositive()
	{
		$pid = forkTask(function () {
			sleep(2);
		});

		if ($pid !== null) {
			$return = closeTask($pid);
			$this->assertTrue($return);
		}		
	}

	public function testCheckCloseForkNegative()
	{
		$return = closeTask(999999);
		$this->assertFalse($return);
	}
}