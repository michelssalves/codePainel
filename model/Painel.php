<?php
require_once 'Conexao.php';

class PainelItajai
{

    private $connection;

    public function __construct()
    {
        $this->connection = new Conexao();
    }

    public function selectMotoristasAguardando(){ 

        $sql = $this->connection->connection()->prepare("SELECT TOP 9 id, motorista, DATEFORMAT(ar.datahoraChegada, 'HH:NN') AS hora FROM arm_registro AS ar 
		WHERE status = 'aberto' AND datahoraChegada IS NOT NULL AND datahoraChamada IS NULL
		ORDER BY datahoraChegada ASC");
        if ($sql->execute()) {
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        return $data;

    }
    public function selectMotoristasChamados(){ 

        $sql = $this->connection->connection()->prepare("SELECT DATEFORMAT(ar.datahoraChamada, 'HH:NN') AS hora, id, motorista FROM arm_registro AS ar
        WHERE status = 'aberto' AND datahoraChamada IS NOT NULL 
        ORDER BY datahoraChamada DESC");
        if ($sql->execute()) {
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        
        return $data;

    }
    public function selectMotoristasNomes(){

        $sql = $this->connection->connection()->prepare("SELECT id,motorista FROM arm_registro 
		WHERE status = 'aberto' AND datahoraChamada IS NOT NULL  AND chamado IS NULL
		ORDER BY datahoraChamada ASC");
        if ($sql->execute()) {
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        
        return $data;

    }
    public function findCodigoDeBarras($codigo){

        $sql = $this->connection->connection()->prepare("SELECT  COUNT(*) AS resultados FROM (SELECT datahoraChegada FROM arm_registro WHERE id = :codigo) AS SUB");
        $sql ->bindValue('codigo', $codigo);
        $sql->execute();
        $resultados = $sql->fetch(PDO::FETCH_ASSOC);
        if(intval($resultados['resultados']) <= 0){
            return false;
        }
        $sql = $this->connection->connection()->prepare("SELECT datahoraChegada FROM arm_registro WHERE id = :codigo");
        $sql ->bindValue('codigo', $codigo);
        $sql->execute();
        $dataHoraChegada = $sql->fetch(PDO::FETCH_ASSOC);
        if(!($dataHoraChegada['datahoraChegada'] === NULL)){
            return false;
        }   
        
        
        return true;
    }
    public function updateRegistro($codigo){

        $hoje = date('Y-m-d H:i');
        
        $sql = $this->connection->connection()->prepare("UPDATE arm_registro SET datahoraChegada = :hoje WHERE id = :codigo");
        $sql ->bindValue('codigo', $codigo);
        $sql ->bindValue('hoje', $hoje);
        if ($sql->execute()) {
            return true;
        }

        return false;


    }
    public function updateAgenda($codigo){
        
        $hoje = date('Y-m-d H:i');

        $sql = $this->connection->connection()->prepare("UPDATE agenda SET datahora_chegada = :hoje WHERE id = :codigo");
        $sql ->bindValue('codigo', $codigo);
        $sql ->bindValue('hoje', $hoje);
        if ($sql->execute()) {
            return true;
        }

        return false;
    }
    public function updateMotoristaChamado($id){

        
        $hoje = date('Y-m-d H:i:s');
        $chamado = "1";

        $sql = $this->connection->connection()->prepare("UPDATE arm_registro SET chamado = :chamado, dataHoraChamado = :hoje
        WHERE id = :id");
        $sql ->bindValue('id', $id);
        $sql ->bindValue('chamado', $chamado);
        $sql ->bindValue('hoje', $hoje);
        if ($sql->execute()) {
            return true;
        }

        return false;

    }




}





















?>