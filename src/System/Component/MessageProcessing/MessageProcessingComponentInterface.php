<?php

declare(strict_types=1);

namespace System\Component\MessageProcessing;


use System\Entity\InternalProtocol\StageMessageVariables;
use System\Entity\Repository\StageMessage;

/**
 * Interface MessageProcessingComponentInterface
 * @package System\Component\MessageProcessing
 */
interface MessageProcessingComponentInterface
{
    /**
     * @param StageMessageVariables $variables
     * @param StageMessage $stageMessage
     *
     * @return string
     */
    public function fillMessage(StageMessageVariables $variables, StageMessage $stageMessage): string;
}