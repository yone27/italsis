<?php

/**
 * Class "assistantbankPL.PHP"
 * @author "dba, ygonzalez@durthis.com"
 * @version "1.00 2021-01-07 Elaboracion; 2021-01-07 Modificacion, [Parametro]"
 * Description: "" 
 * 
 * Others additions: assistantbankPL.php:
 * functions: 
 *           
 *
 */
$version = "1.00";
$msgversion = " Class assistantbankPL.PHP";
$msgversion .= " @author dba, ygonzalez@durthis.com";
$msgversion .= " @version V " . $version . ".- 2021-01-07";
$msgversion .= " ";
$url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
error_reporting(0);
session_start();
chdir(dirname(__FILE__));
include_once("assistantbankBL.php");
chdir(dirname(__FILE__));
include_once("../base/basePL.php");
chdir(dirname(__FILE__));
include_once("../../../includes/presentationLayer.php");

basePL::buildjs();
basePL::buildccs();

//Utilitario para desplegar menu de funciones
//utilities::trueUser();

?>

<html>

<head>
    <title>assistantbankPL.PHP</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="css/modal.css">
    <link rel="stylesheet" href="css/pagination.css">
    <link rel="stylesheet" href="css/inputs.css">
    <link rel="stylesheet" href="css/custom.css">
</head>


<?php
//links
$sLink = $dLink = $pLink = $cLink = $flink = $fbnlink = "";

//actions
$action = "";
$urloper = "";

//For pagination
$pn = 0;

$urloper = basePL::getReq($_REQUEST, "urloper");
$pn = basePL::getReq($_REQUEST, "pn");
$parS = "";

// default
$active = "Y";
$deleted = "N";
$id = $code = $name = "";

$idpartybankinfo = $idaccassistant = $idpartyuser = $dateregister = $idpartylocation = "";
$identitysubclass = "";


$id = basePL::getReq($_REQUEST, "id");
$code = basePL::getReq($_REQUEST, "code");
$name = basePL::getReq($_REQUEST, "name");
$idpartybankinfo = basePL::getReq($_REQUEST, "idpartybankinfo");
$idaccassistant = basePL::getReq($_REQUEST, "idaccassistant");
$idpartyuser = basePL::getReq($_REQUEST, "idpartyuser");
$dateregister = basePL::getReq($_REQUEST, "dateregister");
$active = basePL::getReqCheck($_REQUEST, "active");
$deleted = basePL::getReqCheck($_REQUEST, "deleted");
$idpartylocation = basePL::getReq($_REQUEST, "idpartylocation");
$identitysubclass = basePL::getReq($_REQUEST, "identitysubclass");

$sbl = new assistantbankBL(
    $code,
    $name,
    $idpartybankinfo,
    $idaccassistant,
    $idpartyuser,
    $dateregister,
    $active,
    $deleted,
    $idpartylocation,
    $identitysubclass
);


$sbl->buildLinks(
    "assistantbankPL.php",
    $pn,
    $sLink,
    $dLink,
    $pLink,
    $cLink,
    $fLink,
    $fbnLink,
    $action,
    $parS
);
$bpl = new basePL(
    "document.assistantbankPL",
    $sLink,
    $dLink,
    $pLink,
    $cLink,
    $fLink,
    $fbnLink
);

$oper = $urloper;
if ($urloper == "save" && $id == "") {
    $oper = "insert";
}
if ($urloper == "save" && $id != "") {
    $oper = "update";
}

if ($id != "") {
    $arPar[] = $id;
}

$sbl->buildArray($arPar);
$sbl->execute($oper, $arPar);

if ($oper == "find" || $oper == "findByName" || $oper == "findByDept") {
    $id = $arPar[0];
    $code = $arPar[1];
    $name = $arPar[2];
    $idpartybankinfo = $arPar[3];
    $idaccassistant = $arPar[4];
    $idpartyuser = $arPar[5];
    $dateregister = $arPar[6];
    $active = $arPar[7];
    $deleted = $arPar[8];
    $idpartylocation = $arPar[9];
    $identitysubclass = $arPar[10];
}

?>
<!-- 
<body oncontextmenu="return false;">
-->

<body>
    <FORM action="<?php echo $action; ?>" method="post" name="assistantbankPL1" id="assistantbankPL1" class="italsis">
        <h1 style="
    display: flex;
    justify-content: space-between;
    align-items: center;
">assistantbankBL
            <button class="btn btn-success" aria-label="open modal" type="button" data-open="assistantBankModal">Agregar nuevo registro</button>
        </h1>
        <div id="showAlert"></div>
        <div class="grid grid-2">
            <?php
            presentationLayer::buildInput("Nombre compañia", "idpartylocation", "idpartylocation", $idpartylocation, "50");
            $com = "select * from base.entitysubclass where identityclass in (select id from base.entityclass where code in ('Departamentos'))";
            presentationLayer::buildSelectWithComEvent('Dept', 'identitysubclass', 'identitysubclass', $sbl, $com, "id", "name", $identitysubclass);
            ?>
        </div>
        <div class="table-custom">
            <div id="table-pagination-header">
                <div class="pageSize-container">
                    <!-- <label for="pageSize">Mostrar</label>
                    <select id="pageSize">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select> -->
                </div>
            </div>
            <table id="table-assistantBank" class="table table-striped table-bordered text-center" style="max-width: 100%;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Codigo</th>
                        <th>Cuenta</th>
                        <th>Fecha</th>
                        <th>Nombre Comp</th>
                        <th>Dept</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
            <div id="table-pagination-footer">
                <div class="info">

                </div>
                <div class="buttons-pagination">

                </div>
            </div>
        </div>
    </form>
    <?php include 'modal_assistantBank.php'; ?>
    <?php include 'modal_assistantBankEdit.php'; ?>
    <script src="./js/mainAssistantBank.js"></script>
    <!-- <script type="module" src="./js/app.js"></script> -->
</body>

</html>