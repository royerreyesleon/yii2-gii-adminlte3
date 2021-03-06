<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = $model-><?= $generator->getNameAttribute() ?>;
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-detalle">

    <div class="card">
        <div class="card-header">

            <h3 class="card-title d-none d-sm-block"><?= "<?= " ?>Html::encode($this->title) ?></h3>

            <div class="float-right">

                <?= "<?= " ?>Html::a('<i class="fas fa-arrow-left"></i>', ['index'], ['class' => 'btn btn-sm btn-secondary']) ?>
                <?= "<?= " ?>Html::a('Nuevo <i class="fas fa-plus"></i>', ['nuevo'], ['class' => 'btn btn-sm btn-success']) ?>
                <?= "<?= " ?>Html::a('Editar <i class="fas fa-edit"></i>', ['editar', 'id' => $model->id], ['class' => 'btn btn-sm btn-primary']) ?>
                <?= "<?php " ?> if($model->activo == 'SI') : ?>
                    <?= "<?= " ?>Html::a('Anular <i class="fas fa-trash"></i>', ['anular', 'id' => $model->id], [
                        'class' => 'btn btn-sm btn-danger',
                        'data' => [
                            'confirm' => <?= $generator->generateString('¿Está seguro de anular este registro?') ?>,
                            'method' => 'post',
                        ],
                    ]) ?>
                <?= "<?php " ?> else: ?>
                    <?= "<?= " ?>Html::a('Activar <i class="fas fa-check"></i>', ['activar', 'id' => $model->id], [
                        'class' => 'btn btn-sm btn-warning',
                        'data' => [
                            'confirm' => <?= $generator->generateString('¿Está seguro de activar este registro?') ?>,
                            'method' => 'post',
                        ],
                    ]) ?>
                <?= "<?php " ?> endif; ?>
            </div>
        </div>

        <div class="card-body">
            <?= "<?= " ?>DetailView::widget([
                'model' => $model,
                'attributes' => [
        <?php
        if (($tableSchema = $generator->getTableSchema()) === false) {
            foreach ($generator->getColumnNames() as $name) {
                echo "            '" . $name . "',\n";
            }
        } else {
            foreach ($generator->getTableSchema()->columns as $column) {
                $format = $generator->generateColumnFormat($column);
                echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
            }
        }
        ?>
                ],
            ]) ?>
        </div>
    </div>



</div>
