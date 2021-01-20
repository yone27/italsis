<?php

/**
 * Class "entityclassPL.PHP"
 * @author "dba, ygonzalez@durthis.com"
 * @version "1.00 2020-12-29 Elaboracion; 2020-12-29 Modificacion, [Parametro]"
 * Description: "" 
 * 
 * Others additions: entityclassPL.php:
 * functions: 
 *           
 *
 */

$version = "1.00";
$msgversion = " Class entityclassPL.PHP";
$msgversion .= " @author dba, ygonzalez@durthis.com";
$msgversion .= " @version V " . $version . ".- 2020-12-29";
$msgversion .= " ";
$url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
error_reporting(0);
session_start();
chdir(dirname(__FILE__));
include_once("entityclassBL.php");
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
    <title>entityclassPL.PHP</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
$id = $code = $name = $observation = $generator = "";

// entityclass
$id = basePL::getReq($_REQUEST, "id");
$code = basePL::getReq($_REQUEST, "code");
$name = basePL::getReq($_REQUEST, "name");
$observation = basePL::getReq($_REQUEST, "observation");
$generator = basePL::getReq($_REQUEST, "generator");
$active = basePL::getReqCheck($_REQUEST, "active");
$deleted = basePL::getReqCheck($_REQUEST, "deleted");

// entitysubclass
$codeSub = basePL::getReq($_REQUEST, "codeSub");
$nameSub = basePL::getReq($_REQUEST, "nameSub");
$identityclass = basePL::getReq($_REQUEST, "identityclass");
$observationSub = basePL::getReq($_REQUEST, "observationSub");
$activeSub = basePL::getReqCheck($_REQUEST, "activeSub");
$deletedSub = basePL::getReqCheck($_REQUEST, "deletedSub");

$sbl = new entityclassBL(
    $code,
    $name,
    $observation,
    $generator,
    $active,
    $deleted,

    $codeSub,
    $nameSub,
    $identityclass,
    $observationSub,
    $activeSub,
    $deletedSub
);

$sbl->buildLinks(
    "entityclassPL.php",
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
    "document.entityclassPL",
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

if ($oper == "find" || $oper == "findByName") {
    $id = $arPar[0];
    $code = $arPar[1];
    $name = $arPar[2];
    $observation = $arPar[3];
    $generator = $arPar[4];
    $active = $arPar[5];
    $deleted = $arPar[6];
}

?>
<!-- 
<body oncontextmenu="return false;">
-->

<body>
    <!-- entityclass -->
    <FORM action="<?php echo $action; ?>" method="post" name="entityclassPL" class="italsis">
        <?php
        presentationLayer::buildFormTitle("entityclassBL", "");
        presentationLayer::buildInitColumn();
        presentationLayer::buildIdInput($id, "document.entityclassPL", $fLink);
        presentationLayer::buildInput("code", "code", "code", $code, "50");
        presentationLayer::buildInput("name", "name", "name", $name, "50");
        presentationLayer::buildInput("observation", "observation", "observation", $observation, "50");
        presentationLayer::buildInput("generator", "generator", "generator", $generator, "50");
        presentationLayer::buildCheck("active", "active", "active", $active);
        presentationLayer::buildCheck("deleted", "deleted", "deleted", $deleted);
        presentationLayer::buildEndColumn();
        presentationLayer::buildFormTitle("entitysubclassBL", "");
        // entitysubclass
        presentationLayer::buildInitColumn();
        presentationLayer::buildInput("code sub", "codeSub", "codeSub", $codeSub, "50");
        presentationLayer::buildInput("name sub", "nameSub", "nameSub", $nameSub, "50");
        presentationLayer::buildSelect("identityclass", "identityclass", "identityclass", $sbl, "entityclass", $identityclass, "base", "");
        presentationLayer::buildInput("observation Sub", "observationSub", "observationSub", $observationSub, "50");
        presentationLayer::buildInput("identitysubclass", "identitysubclass", "identitysubclass", $identitysubclass, "50");
        presentationLayer::buildCheck("activeSub", "activeSub", "activeSub", $activeSub);
        presentationLayer::buildCheck("deletedSub", "deletedSub", "deletedSub", $deletedSub);
        // entitysubclass
        presentationLayer::buildEndColumn();
        presentationLayer::buildFooter($bpl, $sbl, $pn);
        ?>
    </form>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Profile</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Contact</a>
        </li>
    </ul>
    <script src="./js/mainEntityClassSub.js"></script>
</body>

</html>