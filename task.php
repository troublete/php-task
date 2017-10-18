<?php
namespace Task;

/**
 * Function to fork a task from the main thread, execute its task and return the pid
 * @param callable $taskClosure
 * @return mixed
 */
function forkTask(callable $taskClosure) {
	$processId = pcntl_fork();
	if ($processId === -1) {
		throw new Exception('The task could not be forked off.');
	}

	if (
		$processId !== -1
		&& $processId !== 0
	) {		
		return $processId;
	}

	if ($processId === 0) {
		call_user_func($taskClosure);
	}	
}

/**
 * Function to check the status of a process by process id
 * @param int $processId
 * @return int|null
 */
function getProcessStatus($processId = null) {
	if ($processId === null) {
		return null;
	}

	return pcntl_waitpid($processId, $status, WNOHANG);
}

/**
 * Function to check if a process exists
 * @param int|null $processId
 * @return bool
 */
function checkAvailable($processId = null): bool {
	$state = getProcessStatus($processId);
	return $state !== null;
}

/**
 * Function to check if a process succeeded
 * @param int|null $processId
 * @return bool
 */
function checkSuccess($processId = null): bool {
	$state = getProcessStatus($processId);
	return $state > 0;
}

/**
 * Function to check if a process failed
 * @param int|null $processId
 * @return bool
 */
function checkFail($processId = null): bool {
	$state = getProcessStatus($processId);
	return $state === -1;
}

/**
 * Function to close a fork by process id
 * @param int $processId
 * @return bool
 */
function closeTask(int $processId): bool {
	return posix_kill($processId, SIGQUIT);
}