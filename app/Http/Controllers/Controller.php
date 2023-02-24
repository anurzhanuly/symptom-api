<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\JsonApiSerializer;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Сообщение об успехе
     */
    protected const SUCCESS_MESSAGE = 'Данные получены';

    private function getFractalManager(): Manager
    {
        $request = app(Request::class);
        $manager = new Manager();
        $manager->setSerializer(new JsonApiSerializer());
        if (!empty($request->query('include'))) {
            $manager->parseIncludes($request->query('include'));
        }

        return $manager;
    }

    public function item($data, $transformer): ?array
    {
        $manager = $this->getFractalManager();
        $resource = new Item($data, $transformer, $transformer->type);

        return $manager->createData($resource)->toArray();
    }

    public function collection($data, $transformer): ?array
    {
        $manager  = $this->getFractalManager();
        $resource = new Collection($data, $transformer, $transformer->type);

        return $manager->createData($resource)->toArray();
    }
}
