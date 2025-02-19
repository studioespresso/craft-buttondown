<?php

namespace studioespresso\buttondown\controllers;

use craft\web\Controller;
use GuzzleHttp\Exception\GuzzleException;
use studioespresso\buttondown\Buttondown;

/**
 *  Class SubscriberController
 */
class SubscriberController extends Controller
{
    /**
     * @inheritdoc
     */
    public $defaultAction = 'add';

    /**
     * @inheritdoc
     */
    protected array|bool|int $allowAnonymous = true;

    /**
     * @return \yii\web\Response|null
     * @throws \yii\web\BadRequestHttpException
     */
    public function actionAdd()
    {
        $email = $this->request->getRequiredBodyParam('email');
        try {
            $fields = $this->request->getBodyParam('fields', []);
            $tags = $this->request->getBodyParam('tags', []);
            $response = Buttondown::getInstance()->subscriber->add($email, $fields, $tags);
            if (!$response) {
                return $this->asFailure(\Craft::t("buttondown", "Something went wrong"), [
                    'email' => $email,
                ]);
            }

            return $this->asSuccess(\Craft::t('buttondown', 'Subscribed!'), [
                'email' => $email,
            ]);
        } catch (GuzzleException $e) {
            \Craft::error($e->getMessage(), 'buttondown');
            return $this->asFailure(\Craft::t("buttondown", "Something went wrong"), [
                'email' => $email,
            ]);
        }
    }
}
