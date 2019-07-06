<?php
namespace backend\libraries;

use Yii;

class SimplePager extends \yii\base\Object
{

    public $total = 0;
    public $start = 0;
    public $perpage = 20;

    public $pageTotal = 1;
    public $pageCurrent = 1;
    public $pageStart = 1;
    public $pageEnd = 1;
    public $pagePrev;
    public $pageNext;
    public $requestURI = '';

    const PAGE_SIZE = 20;

    public function __construct($perpage = self::PAGE_SIZE, $requestURI = '', $config = [])
    {
        parent::__construct($config);
        if (!empty($requestURI)) {
            $this->requestURI = trim($requestURI);
        }
        $this->perpage = $perpage;
        $this->pageCurrent = !empty($_GET['p']) ? intval($_GET['p']) : 1;
        $this->start = ($this->pageCurrent - 1) * $this->perpage;
        //fake forever next page......
        $this->setTotal(10000000);
    }

    public function setTotal($total)
    {
        $this->total = $total;

        $this->pageStart = $this->pageCurrent > 5 ? $this->pageCurrent - 5 : 1;
        $this->pageTotal = ceil($this->total / $this->perpage);

        $this->pageEnd = $this->pageStart + 10;
        if ($this->pageEnd > $this->pageTotal) {
            $this->pageEnd = $this->pageTotal;
        }

        $this->pagePrev = $this->pageCurrent == 1 ? false : $this->pageCurrent - 1;
        $this->pageNext = $this->pageCurrent == $this->pageTotal ? false : $this->pageCurrent + 1;

    }

    public function __toString()
    {
        return Yii::$app->view->render('@backend/views/layouts/_pager', ['Pager' => $this]);
    }

    public function url($page)
    {
        if (!empty($this->requestURI)) {
            return $this->requestURI . '?' . http_build_query(array_merge($_GET, ['p' => $page]));
        }
        return '?' . http_build_query(array_merge($_GET, ['p' => $page]));
    }

} 
