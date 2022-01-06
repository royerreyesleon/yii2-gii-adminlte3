<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$modelClass = StringHelper::basename($generator->modelClass);

echo "<?php\n";
?>

// use yii\helpers\Html;
use yii\bootstrap4\Html;
use yii\helpers\Url;
app\assets\AppAssetAdminlte3DataTable::register($this);

$this->title = <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-index">

    <div class="card">
        <div class="card-header">

            <h3 class="card-title"><?= "<?= " ?>Html::encode($this->title) ?></h3>

            <div class="float-right">
                <?= "<?= " ?>Html::a('Nuevo <i class="fas fa-plus"></i>', ['nuevo'], ['class' => 'btn btn-sm btn-success']) ?>
            </div>
        </div>
        <div class="card-body">

            <table id="data_table" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>

        </div>
    </div>

</div>


<?= "<?php " ?>
<?php echo '$urlBase = Url::home(true);'; ?>
<?php $script = '
$js = <<<SCRIPT
$(function () {
    $("#data_table").DataTable({
      dom: `<"row"<"col-md-4 mb-2"l><"col-md-4 mb-2 mt-2 d-flex justify-content-center"f><"col-md-4 mb-2 d-flex justify-content-center"B>>
                <"row"<"col-md-12 d-flex justify-content-center mb-2 mt-2"p>>
                <"row"<"col-sm-12"tr>>
                <"row"<"col-sm-5"i><"col-sm-7"p>>
            `,
        buttons: [
            // "copyHtml5",
            "excelHtml5",
            // "csvHtml5",
            "pdfHtml5",
            // "colvis",
        ],
        "language": language,
      // "responsive": true, "lengthChange": false, "autoWidth": false,
      // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
      "ajax": {
        "url": "$urlBase/' . Inflector::camel2id(StringHelper::basename($generator->modelClass)) . '/obtener-datos",
    },
    "columns": [
    { "data": "id" },
    { "data": "nombre" },
    {
        "render":
            function (data, type, row) {
                return `
                        <a class="btn btn-sm btn-light" href="detalle?id=${row.id}"><i class="fas fa-eye"></i></a>
                        <a class="btn btn-sm btn-primary" href="editar?id=${row.id}"><i class="fas fa-edit"></i></a>
                        <a class="btn btn-sm btn-danger" href="anular?id=${row.id}"><i class="fas fa-trash"></i></a>
                        `;
            }, "className": "text-right"
        },
    ],
    // }).buttons().container().appendTo("#example1_wrapper .col-md-6:eq(0)");
    });

    /*
        $("#example2").DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        });
    */

  });
SCRIPT;' . PHP_EOL;
?>
<?php echo $script; ?>
<?php echo '$this->registerJs($js);' . PHP_EOL; ?>
<?= "?>" ?>