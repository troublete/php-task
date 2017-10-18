# task

> A PHP process forking and fork handling library.

[![Build Status](https://travis-ci.org/troublete/load.svg?branch=master)](https://travis-ci.org/troublete/task)

## Install

```bash
$ composer require troublete/task
```

## Usage

```php
<?php
require_once '/path/to/autoload.php';

use function Task\{forkTask, checkFail, checkSuccess};

$pid = forkTask(function () {
	// do something that is only happening in the forked process
});

// continue work...

checkFail($pid); // to check if the process failed 
checkSuccess($pid); // to check if the process finished with great success
```

## API

### Functions

#### forkTask($taskClosure)

Function to fork off a child process. Returns the `pid` of the forked off process if successfull, throws an Exception if forking was not possible.

##### Arguments

| Argument | Type | Description |
|---|---|---|
| $taskClosure | `callable` | Closure function that is only executed in the child process |

#### getProcessStatus($processId = null)

Function that returns that status of a forked child by process id. If provided process id is null it'll return `0`.

##### Arguments

| Argument | Type | Description |
|---|---|---|
| $processId | `int` | Id of the process to be checked |

#### checkAvailable($processId = null)

Function to check if a process exists.

##### Arguments

| Argument | Type | Description |
|---|---|---|
| $processId | `int` | Id of the process to be checked |

#### checkSuccess($processId = null)

Function that returns based on the process status if a process already finished with great success. If the return value of this is `false` it does not necessarily mean that the process failed though. Since this is a non blocking process check. It is just not successfully finished at the point of the check.

##### Arguments

| Argument | Type | Description |
|---|---|---|
| $processId | `int` | Id of the process to be checked |

#### checkFail($processId = null)

Function that checks if a processed failed. If the return value is `false` it does not mean that the process didnt fail. Since this is a non blocking check, it is just not failed in the moment of the check.

##### Arguments

| Argument | Type | Description |
|---|---|---|
| $processId | `int` | Id of the process to be checked |

#### closeTask($processId = null)

Function to close a forked process. Returns `true` if successfull. 

##### Arguments

| Argument | Type | Description |
|---|---|---|
| $processId | `int` | Id of the process to be checked |

## License

GPL-2.0 © Willi Eßer