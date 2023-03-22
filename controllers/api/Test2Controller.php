<?php

namespace app\controllers\api;


use Yii;
use yii\helpers\Console;
use yii\rest\Controller;
use yii\web\Response;
use yii\web\ForbiddenHttpException;
use yii\helpers\ArrayHelper;
use yii\filters\Cors;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use \yii\filters\auth\QueryParamAuth;
use app\models\Users;
use app\models\Patrons;
use app\models\Wallets;
use app\models\transaction_logs;
use yii\httpclient\Client;
use yii\helpers\Json;





class Test2Controller extends ApiController
{
    // namespace -> controller name -> function name
    // api/test/test-api
    public function actionDeposit()
    {
        //get value from post method
        $username = Yii::$app->request->post('username');
        $deposit = Yii::$app->request->post('amount');
        //echo $username;
        //echo $deposit;

        $httpClient = new Client();
        $data = [
            "username" => $username,
            "amount" => $deposit
        ];


        Yii::Warning($data);

        //var_dump($jsonData);
        $response = $httpClient->createRequest()
            ->setMethod('POST')
            ->setUrl('http://192.168.0.94:2000/deposit')
            ->setFormat(Client::FORMAT_JSON)
            ->setData($data)
            ->send();

        if ($response->isOk) {
            // Request was successful, handle the response data
            $responseData = $response->data;
        } else {
            // Request failed, handle the error
            $error = $response->content;
        }
        return "OK";
    }
}