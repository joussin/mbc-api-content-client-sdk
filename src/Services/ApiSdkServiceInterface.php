<?php

namespace MbcApiContentSdk\Services;

use MbcApiContentSdk\Entity\Page\PageEntityInterface;
use MbcApiContentSdk\Entity\PageContent\PageContentEntityInterface;
use MbcApiContentSdk\Entity\Route\RouteEntityInterface;
use MbcApiContentSdk\Entity\Synchronization\SynchronizationEntityInterface;

interface ApiSdkServiceInterface
{

    /**
     * @return RouteEntityInterface
     */
    public function getRouteEntity(): RouteEntityInterface;

    /**
     * @return PageEntityInterface
     */
    public function getPageEntity(): PageEntityInterface;

    /**
     * @return PageContentEntityInterface
     */
    public function getPageContentEntity(): PageContentEntityInterface;

    /**
     * @return SynchronizationEntityInterface
     */
    public function getSynchronizationEntity(): SynchronizationEntityInterface;
}
