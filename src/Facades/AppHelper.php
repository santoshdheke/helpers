<?php
namespace SsGroup\Helper\Facades;
use Illuminate\Support\Facades\Facade;

class AppHelper extends Facade{
    protected static function getFacadeAccessor() { return 'apphelper'; }
}