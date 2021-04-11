<?php
/**
 * Created by PhpStorm.
 * User: Cavid
 * Date: 3/24/2018
 * Time: 10:53 AM
 */

namespace app\controllers;

use app\components\ModuleTextBehavior;
use app\components\UserVerifyBehavior;
use app\models\DepartmentForm;
use app\models\Department;
use app\models\Doctor;
use app\models\Page;
use yii;
use yii\web\Controller;
use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\easyii\modules\mailaddresses\models\Mailaddresses;

class DepartmentsController extends Controller
{
    public $content_actions = ['index'];

    public function behaviors()
    {
        return [
            ModuleTextBehavior::className(),

            'user-verify' => [
                'class' => UserVerifyBehavior::className(),
                'actions' => ['form'],
            ]
        ];
    }

    public function actionIndex()
    {
        $departments = Department::getAllDepartments();

        return $this->render('index', [
            'models' => $departments['models'],
            'pages' => $departments['pages'],
            'text' => $this->content
        ]);
    }

    public function actionView($id)
    {
        $model = Department::getDepartmentsIN($id);

        $departments = Department::getDepartmentsID($id);

        $doctors =Department::getDepDoctors(yii::$app->request->get('id'));

        $model_form = new \app\models\DepartmentForm();

        $user = yii::$app->user->identity;

        if(!yii::$app->user->isGuest) {

            $model_form->name = $user->firstname.' '.$user->lastname;
            $model_form->email = $user->email;
            $model_form->phone = $user->phone;
        }

        return $this->render('view',[
            'model' => $model,
            'departments' => $departments,
            'doctors' => $doctors,
            'model_form' => $model_form,
            'user' => $user
        ]);
    }

    public function actionForm(){

        $slug = yii::$app->request->post('slug');

        $department = Department::getDepartmentNameAz($slug);


        if(yii::$app->request->isPost)
        {
            $model = new DepartmentForm();
            $user = yii::$app->user->identity;

            if ($model->load(yii::$app->request->post())){

                if(!yii::$app->user->isGuest) {
                    $model->user_id = $user->id;
                    $model->email = $user->email;
                    $model->name = $user->firstname;
                    $model->surname = $user->lastname;
                    $model->phone = $user->phone;
                    $model->subject = $department;
                }

                if($model->save()) {
                    $mailAddress = Mailaddresses::find()->select('email')->where(['tech_name' => 'contact_form'])->one();

                    $text = '<b>Ad, Soyad: </b>';
                    $text .= $model->name;

                    if(!empty($model->surname)){
                        $text .= ' ' . $model->surname;
                    }

                    $text .= '<br>
                              <b>Email: </b>' . $model->email . '<br>
                              <b>Telefon: </b>' . $model->phone . '<br>
                              <b>Mövzü: </b> ' . $slug . '<br>
                              <b>Əlavə məlumat: </b>' . $model->text;

                    if(!empty($model->email)){
                        //$email = $model->email;
                        $email = yii::$app->params['noReplyEmail'];
                    }else{
                        $email = yii::$app->params['noReplyEmail'];
                    }

                    Yii::$app->mailer->compose('common', [
                        'text' => $text
                    ])
                        ->setFrom([$email => yii::$app->params['senderName']])
                        ->setTo($mailAddress->email)
                        ->setSubject('İstifadəçidən məktub: şöbə:' . $department)
                        ->send();

                    yii::$app->session->setFlash('success', Html::encode(yii::t('db', 'Thanks for contacting us! We will be in touch with you shortly.')));

                    return $this->redirect(Yii::$app->request->referrer);
                }
            }

            print_r($model->getErrors()); die();
        }

        throw new yii\web\BadRequestHttpException();
    }

    public function actionValidate()
    {
        if(yii::$app->request->isAjax && yii::$app->request->isPost)
        {
            $model = new DepartmentForm();

            if($model->load(yii::$app->request->post())) {

                yii::$app->response->format = 'json';
                return \yii\widgets\ActiveForm::validate($model);
            }
        }
    }
}