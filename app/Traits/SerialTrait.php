<?php


namespace App\Traits;

use App\Models\Serial;

trait SerialTrait
{

    function createSerialNumber($fullyQualifiedClassName,$prefix)
    {

        $model = new $fullyQualifiedClassName();
        $countRows = $model->withTrashed()->count();

       $serialNumber = $prefix . ($countRows + 100);

        return $serialNumber;
    }
}
