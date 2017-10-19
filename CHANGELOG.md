# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [Unreleased]
## [2.1.1] - 19.10.2017
### [Added]

* `ext-pcntl` as dependency

## [2.1.0] - 18.10.2017
### [Changed]
*  signal handling for child termination to signal handler

## [2.0.0] - 18.10.2017
### [Added]
*  signal handling

### [Removed]
* `checkFail`, `checkAvailable`

### [Fixed]
* forking, so that childs exit on closure run


## [1.0.1] - 18.10.2017
### [Fixed]

* fixed check success function

## [1.0.0] - 18.10.2017
### [Added]

* added methods for forking tasks of, closing them, and checking on them. 
* added docs
* added rudimental test