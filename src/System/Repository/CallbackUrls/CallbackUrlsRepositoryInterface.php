<?php

declare(strict_types=1);

namespace System\Repository\CallbackUrls;

use System\Entity\Repository\CallbackUrl;

interface CallbackUrlsRepositoryInterface
{
    /**
     * @param int $chatBitId
     *
     * @return CallbackUrl
     *
     * @throws \System\Exception\EmptyFetchResultException
     */
    public function findCallBackUrl(int $chatBitId): CallbackUrl;
}