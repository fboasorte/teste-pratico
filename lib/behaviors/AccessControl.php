<?php

namespace lib\behaviors;

use yii;
use yii\base\ActionFilter;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class AccessControl extends ActionFilter
{
    public function beforeAction($action)
    {
        $permission = $action->controller->id . '/' . $action->id;
        $user = Yii::$app->user;
        
        if (!$user->can($permission)) {
            $this->denyAccess($user);
        }
        
        return parent::beforeAction($action);
    }

    protected function denyAccess($user): void
    {
        if ($user->getIsGuest()) {
            $user->loginRequired();
        } else {
            // throw new ForbiddenHttpException('Você não está autorizado a realizar essa ação.');
            throw new NotFoundHttpException('Página não encontrada.');
        }
    }
}
