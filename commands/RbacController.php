<?php

namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();

        $adminPermission = $auth->createPermission('adminPermission');
        $adminPermission->description = 'Admin Permission';
        $auth->add($adminPermission);

        $adminRole = $auth->createRole('adminRole');
        $auth->add($adminRole);

        $auth->addChild($adminRole, $adminPermission);
    }
}
