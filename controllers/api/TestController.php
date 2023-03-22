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





class TestController extends ApiController
{
    // namespace -> controller name -> function name
    public function actionDbInfoApi()
    {
        $db = Yii::$app->db;
        print "<pre>";
        print_r($db);
        print "</pre>";

        exit;
    }
    
    public function actionRegister()
    {

        $username = Yii::$app->request->post('username');
        $password = Yii::$app->request->post('password');
        //$username = $request['username'];
        //$password = $request['password'];
        //echo $username;

        if ($password == "")
        {
            return ["MSG" => "Please insert password"];
        }
        $check_registered = Patrons::findOne(['username' => $username]);
        if ($check_registered) {
            return ["MSG" => "Username taken"];
        }

        $patron_register = Yii::$app->db->createCommand()->batchInsert('patrons', ['username', 'password'], [
            [$username, $password]
        ])->execute();

        $check_patron_register = Patrons::findOne(['username' => $username]);
        $check_wallet_register = Wallets::findOne(['patronId' => $check_patron_register['id']]);

        if (!$check_wallet_register && $username!="" &&  $password!="") {
            $wallet_register = Yii::$app->db->createCommand()->batchInsert('wallets', ['patronId'], [
                [$check_patron_register['id']]
            ])->execute();
        }

        return ["MSG" => "successfully registered"];
    }

    public function actionLogin()
    {

        $username = Yii::$app->request->post('username');
        $password = Yii::$app->request->post('password');

        
        $check_username = Patrons::findOne(['username' => $username]);
        $check_login = Patrons::findOne(['username' => $username, 'password' => $password]);

        if (!$check_username) {
            return ["MSG" => "User not found "];
        }
        if (!$check_login) {
            return ["MSG" => "Invalid password"];
        }
        return ["MSG" => "Login successfully"];
    }

    public function actionWithdraw()
    {
        //get value from post method
        $username = Yii::$app->request->post('username');
        $withdraw = Yii::$app->request->post('amount');

        if ($withdraw <= 0) {
            return ["MSG" => "invalid value"];
        }
        //insert record into transaction_log and make a remark
        $transaction_insert = Yii::$app->db->createCommand()->batchInsert(
            'transaction_logs',
            ['username', 'amount', 'remark'],
            [
                [$username, $withdraw, 'withdraw']
            ]
        )->execute();
        $check_username = Patrons::findOne(['username' => $username]);
        $check_patron_amount = Wallets::findOne(['patronId' => $check_username['id']]);

        // if account balance <  withdraw amount then cannot procceed
        if ($check_patron_amount['balance'] < $withdraw) {
            return ["MSG" => "Insufficient balance"];
        }

        // update balance in table after withdraw
        $check_patron_amount['balance'] -= $withdraw;
        Yii::$app->db->createCommand()
            ->update('wallets', ['balance' => $check_patron_amount['balance']], ['patronId' => $check_username['id']])
            ->execute();

        //call sql again after the balance is updated to get the latest value
        $check_patron_amount = Wallets::findOne(['patronId' => $check_username['id']]);
        return ["MSG" => "Successfully withdraw", "amount" => $withdraw, "Balance" => $check_patron_amount['balance']];
    }

    public function actionDeposit()
    {
        //get value from post method
        $username = Yii::$app->request->post('username');
        $deposit = Yii::$app->request->post('amount');

        if ($deposit <= 0) {
            return ["MSG" => "invalid value"];
        }

        //insert record into transaction_log and make a remark
        $transaction_insert = Yii::$app->db->createCommand()->batchInsert(
            'transaction_logs',
            ['username', 'amount', 'remark'],
            [
                [$username, $deposit, 'deposit']
            ]
        )->execute();
        $check_username = Patrons::findOne(['username' => $username]);
        $check_patron_amount = Wallets::findOne(['patronId' => $check_username['id']]);

        // update balance in table after deposit
        $check_patron_amount['balance'] += $deposit;
        Yii::$app->db->createCommand()
            ->update('wallets', ['balance' => $check_patron_amount['balance']], ['patronId' => $check_username['id']])
            ->execute();

        //call sql again after the balance is updated to get the latest value
        $check_patron_amount = Wallets::findOne(['patronId' => $check_username['id']]);
        return ["MSG" => "Successfully deposit", "amount" => $deposit, "Balance" => $check_patron_amount['balance']];

    }

    public function actionToNodejsDeposit()
    {
        $username = Yii::$app->request->post('username');
        $deposit = Yii::$app->request->post('amount');

        $httpClient = new Client();
        $data = [
            "username" => $username,
            "amount" => $deposit
        ];
        //Yii::Warning($data);
        $response = $httpClient->createRequest()
            ->setMethod('POST')
            ->setUrl('http://192.168.0.94:2000/deposit')
            ->setFormat(Client::FORMAT_JSON)
            ->setData($data)
            ->send();

        if ($response->isOk) {
            // Request was successful, handle the response data
            return $response->data;
        } else {
            // Request failed, handle the error
            return $response->content;
        }
    }

    public function actionToNodejsWithdraw()
    {
        $username = Yii::$app->request->post('username');
        $deposit = Yii::$app->request->post('amount');

        $httpClient = new Client();
        $data = [
            "username" => $username,
            "amount" => $deposit
        ];
        //Yii::Warning($data);
        $response = $httpClient->createRequest()
            ->setMethod('POST')
            ->setUrl('http://192.168.0.94:2000/withdraw')
            ->setFormat(Client::FORMAT_JSON)
            ->setData($data)
            ->send();

        if ($response->isOk) {
            // Request was successful, handle the response data
            return $response->data;
        } else {
            // Request failed, handle the error
            return $response->content;
        }
    }
}