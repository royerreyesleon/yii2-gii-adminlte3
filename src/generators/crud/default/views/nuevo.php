<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

echo "<?php\n";
?>

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = <?= $generator->generateString('Nuevo ' . Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>;
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-nuevo">

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">

                <h3 class="card-title"><?= "<?= " ?>Html::encode($this->title) ?></h3>

            </div>
        </div>

        <div class="card-body">

            <?= "<?= " ?>$this->render('_form', [
                'model' => $model,
            ]) ?>

        </div>
    </div>

</div>
