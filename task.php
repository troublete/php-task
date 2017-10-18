<?php
namespace Task;

/**
 * Function to fork a task from the main thread, execute its task and return the pid
 * @param callable $taskClosure
 * @param array $arguments
 * @return mixed
 */
function forkTask(
	callable $taskClosure, 
	array $arguments = [], 
	callable $signalHandler = null
) {
	// allow signal passing
	pcntl_signal_dispatch();
	$processId = pcntl_fork();

	if ($processId === -1) {
		throw new Exception('The task could not be forked off.');
	}

	// ingore child termination event
	pcntl_signal(SIGCHLD, SIG_IGN);
	if ($signalHandler !== null) {
		pcntl_signal(SIGTERM, $signalHandler);
	}

	if ($processId === 0) {
		call_user_func_array($taskClosure, $arguments);
		exit(0);
	}

	if (
		$processId !== -1
		&& $processId !== 0
	) {		
		return $processId;
	}	
}

/**
 * Function to check the status of a process by process id
 * @param int $processId
 * @param int $status
 * @return int|null
 */
function getProcessStatus($processId = null, &$status = null) {
	if ($processId === null) {
		return null;
	}

	return pcntl_waitpid($processId, $status, WNOHANG);
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
 * Function to close a fork by process id
 * @param int $processId
 * @return bool
 */
function closeTask(int $processId): bool {
	return posix_kill($processId, SIGQUIT);
}