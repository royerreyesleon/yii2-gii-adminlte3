<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n";
?>

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form">

    <?= "<?php " ?>$form = ActiveForm::begin(); ?>

<?php foreach ($generator->getColumnNames() as $attribute) {
    if (in_array($attribute, $safeAttributes)) {
        echo "    <?= " . $generator->generateActiveField($attribute) . " ?>\n\n";
    }
} ?>
    <div class="form-group text-center">
        <?= "<?= " ?>Html::a('Cerrar', ['index'], ['class' => 'btn btn-md btn-light']) ?>
        <?= "<?= " ?>Html::submitButton('Guardar', ['class' => $model->isNewRecord ? 'btn btn-md btn-success' : 'btn btn-md btn-primary']) ?>
    </div>

    <?= "<?php " ?>ActiveForm::end(); ?>

</div>

<?= "<?php " ?>
<?php $script = '
$js = <<<SCRIPT
$(function () {
    $("#tipodocumento-td_nombre").focus();
});
SCRIPT;' . PHP_EOL;
?>
<?php echo $script; ?>
<?php echo '$this->registerJs($js);' . PHP_EOL; ?>
<?= "?>" ?>