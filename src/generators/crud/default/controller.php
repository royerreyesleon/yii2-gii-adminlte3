<?php
/**
 * This is the template for generating a CRUD controller class file.
 */

use yii\db\ActiveRecordInterface;
use yii\helpers\StringHelper;


/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$controllerClass = StringHelper::basename($generator->controllerClass);
$modelClass = StringHelper::basename($generator->modelClass);
$searchModelClass = StringHelper::basename($generator->searchModelClass);
if ($modelClass === $searchModelClass) {
    $searchModelAlias = $searchModelClass . 'Search';
}

/* @var $class ActiveRecordInterface */
$class = $generator->modelClass;
$pks = $class::primaryKey();
$urlParams = $generator->generateUrlParams();
$actionParams = $generator->generateActionParams();
$actionParamComments = $generator->generateActionParamComments();

echo "<?php\n";
?>

namespace <?= StringHelper::dirname(ltrim($generator->controllerClass, '\\')) ?>;

use <?= ltrim($generator->modelClass, '\\') ?>;
<?php if (!empty($generator->searchModelClass)): ?>
use <?= ltrim($generator->searchModelClass, '\\') . (isset($searchModelAlias) ? " as $searchModelAlias" : "") ?>;
<?php else: ?>
use yii\data\ActiveDataProvider;
<?php endif; ?>
use <?= ltrim($generator->baseControllerClass, '\\') ?>;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;


/**
 * <?= $controllerClass ?> implements the CRUD actions for <?= $modelClass ?> model.
 */
class <?= $controllerClass ?> extends <?= StringHelper::basename($generator->baseControllerClass) . "\n" ?>
{

    /*
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }
    */

    // WEBVIMARK
    public function behaviors()
    {
        return [
            'ghost-access'=> [
                'class' => 'webvimark\modules\UserManagement\components\GhostAccessControl',
            ],
        ];
    }

    public function actionIndex()
    {
<?php if (!empty($generator->searchModelClass)): ?>
        $searchModel = new <?= isset($searchModelAlias) ? $searchModelAlias : $searchModelClass ?>();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
<?php else: ?>
        $dataProvider = new ActiveDataProvider([
            'query' => <?= $modelClass ?>::find(),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
<?php foreach ($pks as $pk): ?>
                    <?= "'$pk' => SORT_DESC,\n" ?>
<?php endforeach; ?>
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
<?php endif; ?>
    }

    public function actionDetalle($id)
    {
        return $this->render('detalle', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionNuevo()
    {
        $model = new <?= $modelClass ?>();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['detalle', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('nuevo', [
            'model' => $model,
        ]);
    }

    public function actionEditar($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['detalle', 'id' => $model->id]);
        }

        return $this->render('editar', [
            'model' => $model,
        ]);
    }

    public function actionAnular($id)
    {   
        /* $this->findModel($id)->delete(); */

        $model = $this->findModel($id);
        $model->activo = 'NO';
        $model->save();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
<?php
$condition = [];
foreach ($pks as $pk) {
    $condition[] = "'$pk' => \$$pk";
}
$condition = '[' . implode(', ', $condition) . ']';
?>
        if (($model = <?= $modelClass ?>::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(<?= $generator->generateString('La página solicitada no existe.') ?>);
    }

    public function actionObtenerDatos()
    {
        $model = <?= $modelClass ?>::find()->All();

        $array = [];

        foreach ($model as $key => $value) {

            $array['data'][] = [
                            'id'     => $value->td_id,
                            'nombre' => $value->td_id,
                        ];
        }
    
        return json_encode($array);
		// return json_encode($array, JSON_UNESCAPED_UNICODE);
    }
}
