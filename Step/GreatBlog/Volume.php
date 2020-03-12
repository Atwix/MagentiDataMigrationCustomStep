<?php

namespace Vendor\Migration\Step\GreatBlog;

use Migration\ResourceModel;
use Migration\App\ProgressBar;
use Migration\Logger\Logger;
use Migration\Step\Stores\Model\DocumentsList;

class Volume extends \Migration\App\Step\AbstractVolume
{
    /**
     * @var ResourceModel\Source
     */
    private $source;

    /**
     * @var ResourceModel\Destination
     */
    private $destination;

    /**
     * @var ProgressBar\LogLevelProcessor
     */
    private $progress;

    /**
     * @var DocumentsList
     */
    private $documentsList;

    /**
     * @param ProgressBar\LogLevelProcessor $progress
     * @param ResourceModel\Source $source
     * @param ResourceModel\Destination $destination
     * @param DocumentsList $documentsList
     * @param Logger $logger
     */
    public function __construct(
        ProgressBar\LogLevelProcessor $progress,
        ResourceModel\Source $source,
        ResourceModel\Destination $destination,
        DocumentsList $documentsList,
        Logger $logger
    ) {
        $this->progress = $progress;
        $this->source = $source;
        $this->destination = $destination;
        $this->documentsList = $documentsList;
        parent::__construct($logger);
    }

    /**
     * @inheritdoc
     */
    public function perform()
    {
        $documentName = 'greatblog_post';
        $sourceCount = $this->source->getRecordsCount($documentName);
        $destinationCount = $this->destination->getRecordsCount($documentName);
        if ($sourceCount != $destinationCount) {
            $this->errors[] = sprintf(
                'Mismatch of entities in the document: %s Source: %s Destination: %s',
                $documentName,
                $sourceCount,
                $destinationCount
            );
        }

        return $this->checkForErrors(Logger::ERROR);
    }

    /**
     * Get iterations count for step
     *
     * @return int
     */
    private function getIterationsCount()
    {
        return 0;
    }
}
