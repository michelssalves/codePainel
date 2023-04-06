<?php
include '../model/Painel.php';

$painelItajai = new PainelItajai();

$action = $_REQUEST['action'];
function utf8ize($d) {
	if (is_array($d)) {
		foreach ($d as $k => $v) {
			$d[$k] = utf8ize($v);
		}
	} else if (is_string ($d)) {
		return utf8_encode($d);
	}
	return $d;
}

if ($action == 'selectMotoristasAguardando') {

   
    $rows = $painelItajai->selectMotoristasAguardando();
 
    $data = array('row' => utf8ize($rows));

    echo json_encode($data);
}
if ($action == 'selectMotoristasChamados') {

    $rows = $painelItajai->selectMotoristasChamados();

    $data = array('row' => utf8ize($rows));

    echo json_encode($data);
}
if ($action == 'selectMotoristasNomes') {

    $rows = $painelItajai->selectMotoristasNomes();

    $data = array('row' => utf8ize($rows));

    echo json_encode($data);

}
if ($action == 'findCodigoDeBarras') {

    $codigo = $_REQUEST['codigo'];

    if($painelItajai->findCodigoDeBarras($codigo)){

        if($painelItajai->updateRegistro($codigo)){

         $msg = "Código Cadastrado com Sucesso!";
         $cor = "green";
         $data = array('res' => 'success', 'msg' => utf8ize($msg), 'cor' => utf8ize($cor));
        }else{
            $msg = "Erro ao Cadastrar Motorista!";
            $cor = "yellow";
            $data = array('res' => 'error', 'msg' => utf8ize($msg), 'cor' => utf8ize($cor));
        }
    } else {

        $msg = "Código Já Cadastrado";
        $cor = "red";
        $data = array('res' => 'error', 'msg' => utf8ize($msg), 'cor' => utf8ize($cor));

    }

    echo json_encode($data);
}
if ($action == 'updateMotoristaChamado') {

   echo $id = $_REQUEST['id'];

    if($data = $painelItajai->updateMotoristaChamado($id)){


         $msg = "Código Cadastrado com Sucesso!";
         $cor = "green";
         $data = array('res' => 'success', 'msg' => utf8ize($id), 'cor' => utf8ize($cor));

    } else {

        $msg = "Código Já Cadastrado";
        $cor = "red";
        $data = array('res' => 'error', 'msg' => utf8ize($msg), 'cor' => utf8ize($cor));

    }

    echo json_encode($data);
}