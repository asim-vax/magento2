<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Framework\Logger\Handler;

use Magento\Framework\Filesystem\DriverInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

abstract class Base extends StreamHandler
{
    /**
     * @var string
     */
    protected $fileName;

    /**
     * @var int
     */
    protected $loggerType = Logger::DEBUG;

    /**
     * @var DriverInterface
     */
    protected $filesystem;

    /**
     * @param DriverInterface $filesystem
     */
    public function __construct(DriverInterface $filesystem)
    {
        $this->filesystem = $filesystem;
        parent::__construct(BP . $this->fileName, $this->loggerType);
    }

    /**
     * @{inheritDoc}
     *
     * @param $record array
     * @return void
     */
    public function write(array $record)
    {
        $logDir = $this->filesystem->getParentDirectory($this->url);
        if (!$this->filesystem->isDirectory($logDir)) {
            $this->filesystem->createDirectory($logDir, 0777);
        }

        parent::write($record);
    }
}
