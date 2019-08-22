<?php

declare(strict_types=1);

namespace System\Facade\TelegramAd;

use System\Entity\InternalProtocol\Request\UtmRequest;
use System\Entity\InternalProtocol\Response\TelegramAdResponse;
use System\Entity\Repository\UserAd;
use System\Exception\DiException;
use System\Repository\UserAds\UserAdsRepositoryInterface;
use System\Util\Logging\LoggerReferenceTrait;

/**
 * Class TelegramAdFacade
 * @package System\Facade\TelegramAd
 */
class TelegramAdFacade implements TelegramAdFacadeInterface
{
    use LoggerReferenceTrait;

    /**
     * @var UserAdsRepositoryInterface
     */
    private $userAdsRepository;

    /**
     * @return UserAdsRepositoryInterface
     * @throws DiException
     */
    public function getUserAdsRepository(): UserAdsRepositoryInterface
    {
        if ($this->userAdsRepository === null) {
            throw new DiException('UserAdsRepository');
        }
        return $this->userAdsRepository;
    }

    /**
     * @param UserAdsRepositoryInterface $userAdsRepository
     */
    public function setUserAdsRepository(UserAdsRepositoryInterface $userAdsRepository): void
    {
        $this->userAdsRepository = $userAdsRepository;
    }

    /**
     * @param UtmRequest $request
     *
     * @return TelegramAdResponse
     *
     * @throws DiException
     */
    public function process(UtmRequest $request): TelegramAdResponse
    {
        $guid = $this->getUserAdsRepository()->generateGuid();
        $this->getUserAdsRepository()->save(new UserAd(
            0,
            $guid,
            $request->getSource(),
            $request->getMedium(),
            $request->getTerm(),
            $request->getContent(),
            $request->getCampaign(),
            '',
            date('Y-m-d H:i:s'),
            date('Y-m-d H:i:s')
        ));

        return new TelegramAdResponse($guid);
    }
}
