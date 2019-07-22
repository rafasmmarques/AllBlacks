<?php


class Banco
{
    private $user        = null;
    private $password    = null;
    private $tipoDeBanco = null;
    private $host        = null;
    private $port        = null;
    private $db          = null;
    public $error        = null;


    public function __construct($usuario, $senha, $ip, $porta, $banco, $tipo)
    {
        $this->setAtributos($usuario, $senha, $ip, $porta, $banco, $tipo);
    }

    public function setAtributos($usuario, $senha, $ip, $porta, $banco, $tipo)
    {

        $this->user = $usuario;
        $this->password = $senha;
        $this->db = $banco;
        $this->host = $ip;
        $this->port = $porta;
        $this->tipoDeBanco = $tipo;
    }

    public function getAtributos()
    {

        return array($this->user, $this->password, $this->db, $this->host, $this->port, $this->tipoDeBanco);

    }

    public function connectPdo()
    {
        try {

            if ($this->tipoDeBanco == "mysql"){
                $dsn = $this->tipoDeBanco.":host=".$this->host.";dbname=".$this->db.";charset=utf8";

                $conn = new PDO($dsn, $this->user, $this->password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                return $conn;

            }else{
                $dsn = $this->tipoDeBanco.":host=".$this->host.";dbname=".$this->db;

                $conn = new PDO($dsn, $this->user, $this->password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $query = $this->executaQuery($conn, "set client_encoding='utf8'");

                return $conn;
            }

        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            return $e->getMessage();
        }
    }

    public function executaQuery($pdo, $query)
    {

        if ($pdo != false){

            try{

                $stmt = $pdo->query($query);

                $dados = [];
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $dados[] = $row;
                }

                return $dados;

            }catch (PDOException $e){
                $this->error = $e->getMessage();
                return false;
            }
        }else{
            $this->error = "Erro ao conectar com o banco de dados.";
            return false;
        }

    }

    public function verificaTabela($pdo, $table){

        try {
            $result = $pdo->query("SELECT 1 FROM $table LIMIT 1");
        } catch (Exception $e) {

            $this->error = $e->getMessage();
            return false;
        }
        return $result !== false;
    }

    public function verificaECriaTabela($conn, $table, $queryCreateTable){

        if($conn != false){

            $verificaTabela = $this->verificaTabela($conn, $table);

            if ($verificaTabela == false){

                $criaTabela = $this->executaQuery($conn, $queryCreateTable);
            }

            return true;

        }else{

            $this->error = "Erro ao conectar ao banco";
            return false;
        }

    }

    function fechaBd($con)
    {

        unset($con);

        if (isset($con)){
            $this->error = "Erro ao fechar o banco";
            return false;
        }else{

            return true;
        }
    }
}