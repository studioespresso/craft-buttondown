<?php

namespace studioespresso\buttondown\controllers;

use craft\web\Controller;
use studioespresso\buttondown\Buttondown;

class SubscriberController extends Controller
{
    public $defaultAction = 'add';

    protected array|bool|int $allowAnonymous = true;

    public function actionAdd()
    {
        $email = $this->request->getRequiredBodyParam('email');
        $response = Buttondown::getInstance()->subscriber->add($email);


        if (!$response) {
            return $this->asFailure("Something went wrong", [
                'email' => $email,
            ]);
        }

        return $this->asSuccess();
    }
}
