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

            <h3 class="card-title d-none d-sm-block"><?= "<?= " ?>Html::encode($this->title) ?></h3>

            <div class="float-right">
                <?= "<?= " ?>Html::a('Nuevo <i class="fas fa-plus"></i>', ['nuevo'], ['class' => 'btn btn-sm btn-success']) ?>
            </div>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
                <table id="data_table" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Descripción</th>
                            <th width="25%">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>


<?= "<?php " ?>
<?php echo '$urlBase = Url::home(true);'; ?>
<?php echo '$controller = Yii::$app->controller->id;;'; ?>
<?php echo '$detalle = Url::to(["detalle"]);'; ?>
<?php echo '$editar = Url::to(["editar"]);'; ?>
<?php echo '$anular = Url::to(["anular"]);'; ?>
<?php $script = '
$js = <<<SCRIPT
$(function () {
    $("#data_table").DataTable({
        autoWidth: true,
        responsive: true,
        order: [[ 3, "desc" ]],
        pageLength: 10,
        dom: `<"row"<"col-md-4 mb-2"l><"col-md-4 mb-2 mt-2 d-flex justify-content-center"f><"col-md-4 mb-2 d-flex justify-content-center"B>>
                <"row"<"col-md-12 d-flex justify-content-center mb-2 mt-2"p>>
                <"row"<"col-sm-12"tr>>
                <"row"<"col-sm-5"i><"col-sm-7"p>>
            `,
        /*      
        buttons: [
            "excelHtml5",
            "pdfHtml5",
            // "copyHtml5",
            // "csvHtml5",
            // "colvis",
        ],
        */
        buttons: {
            buttons: [
                {
                    text: "Limpiar",
                    action: function ( e, dt, node, config ) {
                        // $("#data_table").DataTable().search("").draw();
                        this.search("").draw();
                        $("#data_table_filter input").focus();
                    }
                },
                {
                    text: "Recargar",
                    action: function ( e, dt, node, config ) {
                        window.location = "";
                    },
                },
                // { extend: "excel", className: "btn btn-md btn-secondary", text: "Excel <i class="far fa-file"></i>" },
                // { extend: "pdfHtml5", className: "btn btn-md btn-secondary", text: "PDF <i class="fas fa-file-pdf"></i>" },
                { extend: "excel", className: "btn btn-md btn-secondary", text: "Excel" },
                { extend: "pdfHtml5", className: "btn btn-md btn-secondary", text: "PDF" },
            ]
        },
        "language": language,
        "ajax": {
            "url": "$urlBase/$controller/obtener-datos",
        },

        "createdRow": function( row, data, dataIndex){
            if(data.td_activo == "NO"){
                // $(row).addClass("bg-danger");
                $(row).css("background", "#F2DEDE");
            }
        },

        "columns": [
            { "data": "id" },
            { "data": "nombre" },
            {
                "data": null,
                "render":
                    function (data, type, row) {
                        let html = `
                            <a class="btn btn-sm btn-light" href="$detalle?id=`+row.td_id+`">Detalle <i class="fas fa-eye"></i></a>
                            <a class="btn btn-sm btn-primary" href="$editar?id=`+row.td_id+`">Editar <i class="fas fa-edit"></i></a>
                            <a class="btn btn-sm btn-danger" href="$anular?id=`+row.td_id+`" data-confirm="¿Está seguro de anular este registro?" data-method="post">Anular <i class="fas fa-trash"></i></a>
                            `;
                        if(data.td_activo == "NO"){
                            html = `
                                    <a class="btn btn-sm btn-light" href="$detalle?id=`+row.td_id+`">Detalle <i class="fas fa-eye"></i></a>
                                    <a class="btn btn-sm btn-primary" href="$editar?id=`+row.td_id+`">Editar <i class="fas fa-edit"></i></a>
                                    <a class="btn btn-sm btn-warning" href="$activar?id=`+row.td_id+`" data-confirm="¿Está seguro de activar este registro?" data-method="post">Activar <i class="fas fa-check"></i></a>
                                `;
                        }
                }, "className": "text-right"
            },
        ],
        initComplete: function() {
            // $(".buttons-html5").addClass("btn-xs");
            $("#data_table_filter input").focus();
        },
    });

  });
SCRIPT;' . PHP_EOL;
?>
<?php echo $script; ?>
<?php echo '$this->registerJs($js);' . PHP_EOL; ?>
<?= "?>" ?>