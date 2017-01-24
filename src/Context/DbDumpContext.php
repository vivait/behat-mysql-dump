<?php

namespace Vivait\Behat\DbDump\Context;

use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\AfterScenarioScope;
use Symfony\Component\Process\Process;

class DbDumpContext implements Context
{

    /**
     * @var string
     */
    private $dbUser;

    /**
     * @var string
     */
    private $dbPass;

    /**
     * @var string
     */
    private $dbName;

    /**
     * @var string
     */
    private $rootDirectory;

    /**
     * @param string $dbUser
     * @param string $dbPass
     * @param string $dbName
     * @param string $rootDirectory
     */
    public function __construct($dbUser, $dbPass, $dbName, $rootDirectory)
    {
        $this->dbUser = $dbUser;
        $this->dbPass = $dbPass;
        $this->dbName = $dbName;
        $this->rootDirectory = $rootDirectory;
    }

    /**
     * @AfterScenario
     *
     * @param AfterScenarioScope $scope
     */
    public function dumpDatabaseToFile(AfterScenarioScope $scope)
    {
        if ( ! $scope->getTestResult()->isPassed()) {
            $title = $scope->getScenario()->getTitle();
            $processCommand = $this->getProcess($title);

            $sqlDumpProcess = new Process($processCommand);
            $sqlDumpProcess->start();
        }
    }

    /**
     * @param string $scenarioTitle
     *
     * @return string
     */
    private function getDumpFileName($scenarioTitle)
    {
        return sprintf(
            '%s/behat-scenario-failed-%s-%s.sql',
            rtrim($this->rootDirectory, DIRECTORY_SEPARATOR),
            $scenarioTitle,
            (new \DateTimeImmutable)->format('YmdHis')
        );
    }

    /**
     * @param string $title
     *
     * @return string
     */
    private function getProcess($title)
    {
        return sprintf(
            "mysqldump --user='%s' --password='%s' %s > '%s'",
            $this->dbUser,
            $this->dbPass,
            $this->dbName,
            $this->getDumpFileName($title)
        );
    }
}
