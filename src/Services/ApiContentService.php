<?php

namespace MbcApiContentSdk\Services;

use MbcApiContentSdk\Entity\Page\PageEntityInterface;
use MbcApiContentSdk\Entity\PageContent\PageContentEntityInterface;
use MbcApiContentSdk\Entity\Route\RouteEntityInterface;
use MbcApiContentSdk\Entity\Synchronization\SynchronizationEntityInterface;


class ApiContentService implements ApiContentServiceInterface
{

    protected RouteEntityInterface $routeEntity;
    protected PageEntityInterface $pageEntity;
    protected PageContentEntityInterface $pageContentEntity;
    protected SynchronizationEntityInterface $synchronizationEntity;

    public function __construct(RouteEntityInterface           $routeEntity,
                                PageEntityInterface            $pageEntity,
                                PageContentEntityInterface     $pageContentEntity,
                                SynchronizationEntityInterface $synchronizationEntity
    )
    {
        $this->routeEntity = $routeEntity;
        $this->pageEntity = $pageEntity;
        $this->pageContentEntity = $pageContentEntity;
        $this->synchronizationEntity = $synchronizationEntity;
    }


    /**
     * @return RouteEntityInterface
     */
    public function getRouteEntity(): RouteEntityInterface
    {
        return $this->routeEntity;
    }

    /**
     * @return PageEntityInterface
     */
    public function getPageEntity(): PageEntityInterface
    {
        return $this->pageEntity;
    }

    /**
     * @return PageContentEntityInterface
     */
    public function getPageContentEntity(): PageContentEntityInterface
    {
        return $this->pageContentEntity;
    }

    /**
     * @return SynchronizationEntityInterface
     */
    public function getSynchronizationEntity(): SynchronizationEntityInterface
    {
        return $this->synchronizationEntity;
    }




}
