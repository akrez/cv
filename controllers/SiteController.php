<?php

namespace app\controllers;

use app\components\Data;
use Yii;
use Throwable;
use app\models\User;
use yii\helpers\Url;
use app\models\Field;
use yii\web\Controller;
use app\components\Helper;
use app\models\Content;
use app\models\Gallery;
use yii\helpers\ArrayHelper;
use yii\web\ForbiddenHttpException;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class SiteController extends Controller
{
    public function behaviors()
    {
        $rules = [
            [
                'actions' => ['error', 'index', 'captcha'],
                'allow' => true,
                'verbs' => ['POST', 'GET'],
                'roles' => ['?', '@'],
            ],
            [
                'actions' => ['signin'],
                'allow' => true,
                'verbs' => ['POST', 'GET'],
                'roles' => ['?'],
            ],
            [
                'actions' => ['signout', 'profile'],
                'allow' => true,
                'verbs' => ['POST', 'GET'],
                'roles' => ['@'],
            ],
            [
                'actions' => ['field', 'user'],
                'allow' => true,
                'verbs' => ['POST', 'GET'],
                'roles' => ['adminPermission'],
            ],
        ];
        //
        $behaviors = parent::behaviors();
        $behaviors['access'] = [
            'class' => 'yii\filters\AccessControl',
            'rules' => $rules,
            'denyCallback' => function ($rule, $action) {
                if (Yii::$app->user->isGuest) {
                    Yii::$app->user->setReturnUrl(Url::current());
                    return $this->redirect(['/site/signin']);
                }
                throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
            }
        ];
        return $behaviors;
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
            ],
        ];
    }

    public function actionProfile()
    {
        $action = Yii::$app->request->get('action');
        $fieldId = Yii::$app->request->get('field_id');
        $id = Yii::$app->request->get('id');
        $post = Yii::$app->request->post();
        //
        $model = null;
        //
        $contents = Content::find()->where(['user_email' => Yii::$app->user->getId()])->indexBy('id')->all();
        $contents = ArrayHelper::index($contents, 'id', 'field_id');
        //
        $fields = Field::find()->indexBy('id')->all();
        //
        if ($action && $fieldId && isset($fields[$fieldId])) {
            if (!isset($contents[$fieldId])) {
                $contents[$fieldId] = [];
            }
            //
            if ($id && isset($contents[$fieldId][$id])) {
                $model = $contents[$fieldId][$id];
            }
            //
            if ($action == 'content' && $post) {
                if (!$model) {
                    if ($fields[$fieldId]->is_multiple || empty($contents[$fieldId])) {
                        $model = new Content();
                    } else {
                        $model = reset($contents[$fieldId]);
                    }
                }

                $staticAttributes = [
                    'field_id' => $fieldId,
                    'user_email' => Yii::$app->user->getId(),
                ];

                if ($model->image = UploadedFile::getInstance($model, 'image')) {
                    $gallery = Gallery::upload($model->image->tempName);
                    if ($gallery->hasErrors()) {
                        $model->addErrors(['image' => $gallery->getErrorSummary(true)]);
                    } else {
                        $staticAttributes['gallery_name'] = $gallery->name;
                    }
                }

                Helper::store($model, $post, $staticAttributes);
                $contents[$fieldId][$model->id] = $model;
            } elseif ($action == 'delete' && $model) {
                $galleryName = $model->gallery_name;
                if (Helper::delete($contents[$fieldId][$id])) {
                    Gallery::deleteImage($galleryName);
                    unset($contents[$fieldId][$id]);
                }
            } elseif ($action == 'delete-gallery' && $model) {
                $galleryName = $model->gallery_name;
                if (Helper::deleteAttribute($model, 'gallery_name', null)) {
                    Gallery::deleteImage($galleryName);
                }
            }
        }

        $fields = ArrayHelper::index($fields, 'subtitle', 'title');

        return $this->render('content', compact('fields', 'contents'));
    }

    public function actionIndex()
    {
        $user = User::getUserOfHost($_SERVER['HTTP_HOST'], Yii::$app->params['mainHost']);
        if (empty($user)) {
            throw new NotFoundHttpException();
        }

        $contents = Content::find()->where(['user_email' => $user->email])->indexBy('id')->all();
        $contents = ArrayHelper::index($contents, 'id', 'field_id');

        $fields = Field::find()->indexBy('id')->all();
        $fields = ArrayHelper::index($fields, 'subtitle', 'title');

        $data = [];
        foreach ($fields as $fieldTitle => $fieldsTitle) {
            foreach ($fieldsTitle as $fieldSubtitle => $field) {
                if (isset($contents[$field->id])) {
                    foreach ($contents[$field->id] as $contentId => $content) {
                        $data[$fieldTitle][$fieldSubtitle][] = $content->toArray();
                    }
                }
            }
        }

        return $this->renderFile('@app/views/' . $user->theme . '.php', [
            'data' => new Data(['data' => $data]),
        ]);
    }

    public function actionField($id = null, $delete = null)
    {
        $post = Yii::$app->request->post();
        $updateCacheNeeded = null;
        $redirectUrl = Url::to(['site/field']);

        $model = null;
        $newModel = new Field();
        $fields = Field::find()->orderBy(['title' => SORT_ASC, 'subtitle' => SORT_ASC])->indexBy('id')->all();

        if ($id && isset($fields[$id])) {
            $model = $fields[$id];
            if ($delete) {
                Helper::delete($model);
                $updateCacheNeeded = true;
            } else {
                $updateCacheNeeded = Helper::store($model, $post);
            }
        } elseif ($post) {
            $updateCacheNeeded = Helper::store($newModel, $post);
        }

        if ($updateCacheNeeded) {
            return $this->redirect($redirectUrl);
        }

        $fields = ArrayHelper::index($fields, 'subtitle', 'title');

        return $this->render('field', compact('model', 'fields', 'newModel'));
    }

    public function actionUser($email = null)
    {
        $post = Yii::$app->request->post();
        $updateCacheNeeded = null;
        $redirectUrl = Url::to(['site/user']);

        $model = null;
        $newModel = new User();
        $models = User::find()
            ->where(['<>', 'email', Yii::$app->user->getId()])
            ->orderBy(['updated_at' => SORT_DESC])
            ->indexBy('email')->all();

        $handler = new User();
        if ($handler->load($post)) {

            if ($email && isset($models[$email])) {
                $model = $models[$email];
                if (trim($handler->password)) {
                    $model->setPasswordHash($handler->password);
                    $model->setAuthKey();
                }
                $updateCacheNeeded = Helper::store($model, $post, [
                    'email' => $email,
                ]);
            } elseif ($post) {
                $newModel->setPasswordHash($handler->password ? $handler->password : Yii::$app->security->generateRandomString());
                $newModel->setAuthKey();
                $updateCacheNeeded = Helper::store($newModel, $post);
            }
        }

        if ($updateCacheNeeded) {
            return $this->redirect($redirectUrl);
        }
        return $this->render('user', compact('model', 'models', 'newModel'));
    }

    public function actionSignin()
    {
        try {
            $signin = new User(['scenario' => 'signin']);
            if ($signin->load(Yii::$app->request->post())) {
                if ($signin->validate()) {
                    $user = $signin->getUser();
                    $auth = Yii::$app->authManager;
                    $auth->revokeAll($user->getId());
                    if ($user->is_admin) {
                        $adminRole = $auth->getRole('adminRole');
                        $auth->assign($adminRole, $user->id);
                    }
                    Yii::$app->user->login($user, 86400);
                    return $this->redirect(['site/profile']);
                }
            }
            return $this->render('signin', ['model' => $signin]);
        } catch (Throwable $e) {
            throw new BadRequestHttpException();
        }
    }

    public function actionSignout()
    {
        try {
            $signout = Yii::$app->user->getIdentity();
            $signout->setAuthKey();
            if ($signout->save(false)) {
                Yii::$app->user->logout();
            }
            return $this->goHome();
        } catch (Throwable $e) {
            throw new BadRequestHttpException();
        }
    }
}
