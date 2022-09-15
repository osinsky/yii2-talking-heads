<?php

declare(strict_types=1);

namespace app\actions;

use yii\rest\Action;

class BookViewAction extends Action
{
    public function run($id)
    {
        $model = $this->findModel($id);

        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $model);
        }

        return $model->transformForView();
    }
}
