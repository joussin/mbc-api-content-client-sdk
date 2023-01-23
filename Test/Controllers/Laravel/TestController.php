<?php


namespace SdkRestApi\Test\Controllers\Laravel;



use SdkRestApi\RestSdk\Services\PageServiceInterface;

class TestController extends \App\Http\Controllers\Controller
{
protected $mainService;
    public function __construct(PageServiceInterface $mainService)
    {
        $this->mainService = $mainService;
    }


    public function allPages()
    {
        $r = $this->mainService->getAllPages();

        dd($r);
        return $r;
    }

    public function getPage($id)
    {
        $r = $this->mainService->getPage($id);

        dd($r);

        return json_encode($r);
    }


}
