<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePin;
use App\Services\PinManager;

/**
 * Class PinController
 *
 * @package App\Http\Controllers
 */
class PinController extends Controller
{
    /**
     * @return mixed
     */
    public function index()
    {
        return ['pins' => \TokenAuth::getUser()->pins];
    }

    /**
     * @param CreatePin $request
     * @param PinManager $pinManager
     *
     * @return array
     */
    public function create(CreatePin $request, PinManager $pinManager)
    {
        $pin = $pinManager->createPinForUser(\TokenAuth::getUser(), $request->get('pin'));

        return compact('pin');
    }
}
