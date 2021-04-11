<?php
namespace yii\easyii\modules\language\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\VarDumper;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

use yii\easyii\components\Controller;
use yii\easyii\modules\language\models\SourceMessage;
use yii\easyii\modules\language\models\Message;

class AController extends Controller
{
//    public $rootActions = ['create', 'delete'];

    public function actionIndex()
    {
        $data = new ActiveDataProvider([
            'query' => SourceMessage::find()
                ->groupBy('source_message.id')
                ->orderBy(['message' => SORT_ASC]),
            'pagination' => ['pageSize' => 150],
        ]);
        return $this->render('index', [
            'data' => $data
        ]);
    }

    public function actionCreate($slug = null)
    {
        $model = new Message();

        $sourceMessage = new SourceMessage();

        if ($model->load(Yii::$app->request->post())) {
            if(Yii::$app->request->isAjax){
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            else {

                $form = yii::$app->request->post('Message');

                $message = $form['translation'];

                $sourceMessage->category = 'db';
                $sourceMessage->message = $message['en'];

                if ($sourceMessage->save())
                {
                    $message_insert = [];

                    foreach ($message as $k => $v) {

                        $message_insert[] = [$sourceMessage->id, $k, Html::encode($v)];
                    }

                    $row = yii::$app->db->createCommand()
                        ->batchInsert('message', ['id', 'language', 'translation'], $message_insert)
                        ->execute();
                }

                if(isset($row) && $row){
                    $this->flash('success', Yii::t('easyii', 'Created successfully'));

                    return $this->redirect(['/admin/'.$this->module->id]);
                }
                else{
                    $this->flash('error', Yii::t('easyii', 'Create error. {0}', $model->formatErrors()));
                    return $this->refresh();
                }
            }
        }
        else {
            if($slug){
                $model->slug = $slug;
            }
            return $this->render('create', [
                'model' => $model
            ]);
        }
    }

    public function actionEdit($id)
    {
        $model = Message::findOne($id);

        $messages = Message::find()
            ->where(['id' => $id])
            ->all();

        if($model === null){
            $this->flash('error', Yii::t('easyii', 'Not found'));
            return $this->redirect(['/admin/'.$this->module->id]);
        }

        if ($model->load(Yii::$app->request->post())) {
            if(Yii::$app->request->isAjax){
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            else{

                $form = yii::$app->request->post('Message');

                $x = 0;
                $success = true;

                foreach ($form['translation'] as $k => $v) {

                    $messages[$x]['translation'] = $v;

                    if(!$messages[$x]->save()) {
                        $success = false;
                    }

                    $x++;
                }

                if($success){
                    $this->flash('success', Yii::t('easyii', 'Updated successfully'));

                }
                else{
                    $this->flash('error', Yii::t('easyii', 'Update error. {0}', $model->formatErrors()));
                }

                return $this->render('edit', [
                    'model' => $model,
                    'messages' => $messages
                ]);
                return $this->refresh();
            }
        }
        else {
            return $this->render('edit', [
                'model' => $model,
                'messages' => $messages
            ]);
        }
    }

    public function actionDelete($id)
    {
        if(($model = SourceMessage::findOne($id))){
            $model->delete();
        } else {
            $this->error = Yii::t('easyii', 'Not found');
        }
        return $this->formatResponse(Yii::t('easyii', 'Deleted successfully'));
    }
}