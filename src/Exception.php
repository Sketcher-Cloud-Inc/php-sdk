<?php

namespace Sketcher\SDK;

class Exception extends \Exception {

    private $BodyDatas = null;

    public function __construct($codename, $BodyDatas)  {
        parent::__construct($codename);
        $this->BodyDatas = $BodyDatas;
    }

    public function getExceptionCode() {
        return $this->BodyDatas->type;
    }

    public function getResponseData() {
        return (!empty($this->BodyDatas)? $this->BodyDatas: null);
    }
}

?>