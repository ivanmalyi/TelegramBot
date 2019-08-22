<?php

declare(strict_types=1);

namespace System\Kernel\Protocol;

/**
 * Interface ProtocolInterface
 * @package System\Kernel\Protocol
 */
interface ProtocolInterface
{
    /**
     * @return ProtocolPacket
     */
    public function getIncomingPacket() : ProtocolPacket;

    /**
     * @return ProtocolHeaders
     */
    public function getIncomingHeaders() : ProtocolHeaders;

    /**
     * @param ProtocolPacket $packet
     * @return void
     */
    public function sendResponse(ProtocolPacket $packet);
}
