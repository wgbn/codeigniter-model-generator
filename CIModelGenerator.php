<?php
require_once('Conexao.php');
/**
 * Created by PhpStorm.
 * User: walter
 * Date: 10/09/15
 * Time: 15:21
 */
class CIModelGenerator {

    private $host;
    private $user;
    private $pass;
    private $db;
    private $conn;

    /**
     * Generator constructor.
     * @param $host
     * @param $user
     * @param $pass
     * @param $db
     */
    public function __construct($host, $user, $pass, $db){
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->db = $db;

        self::conecta();
    }

    private function pre($pre){
        echo "<pre>"; print_r($pre); echo "</pre>";
    }

    /**
     * @return mixed
     */
    public function getHost(){
        return $this->host;
    }

    /**
     * @param mixed $host
     */
    public function setHost($host){
        $this->host = $host;
    }

    /**
     * @return mixed
     */
    public function getUser(){
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user){
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getPass(){
        return $this->pass;
    }

    /**
     * @param mixed $pass
     */
    public function setPass($pass){
        $this->pass = $pass;
    }

    /**
     * @return mixed
     */
    public function getDb(){
        return $this->db;
    }

    /**
     * @param mixed $db
     */
    public function setDb($db){
        $this->db = $db;
    }

    private function criaDiretorios(){
        if ($this->db){
            if (!is_dir(__DIR__.'/'.$this->db))
                mkdir(__DIR__.'/'.$this->db);

            if (!is_dir(__DIR__.'/'.$this->db."/controllers"))
                mkdir(__DIR__.'/'.$this->db."/controllers");

            if (!is_dir(__DIR__.'/'.$this->db."/models"))
                mkdir(__DIR__.'/'.$this->db."/models");

            return true;
        }
        return false;
    }

    private function criaModelFile($nome, $conteudo){
        $nome = self::padronizaNome($nome, true);
        if (($arq = fopen(__DIR__.'/'.$this->db.'/models/'.$nome.'_model.php','w+')) !== false)
            if (fwrite($arq, $conteudo) !== false)
                if (fclose($arq) === true)
                    return true;
        return false;
    }

    private function criaControllerFile($nome, $conteudo){
        $nome = self::padronizaNome($nome, true);
        if (($arq = fopen(__DIR__.'/'.$this->db.'/controllers/'.$nome.'.php','w+')) !== false)
            if (fwrite($arq, $conteudo) !== false)
                if (fclose($arq) === true)
                    return true;
        return false;
    }

    private function padronizaNome($nome, $classe = false){
        $arrNome = explode("_", $nome);
        $tmpNome = '';

        foreach($arrNome as $k=>$n)
            if ($classe || $k)
                $tmpNome .= ucfirst($n);
            else
                $tmpNome .= strtolower($n);

        return $tmpNome;
    }

    private function conecta(){
        $this->conn = Conexao::getInstance($this->host, $this->user, $this->pass, $this->db);
    }

    private function showTables(){
        $sql = 'show tables';

        try {
            $conn = $this->conn->prepare($sql);
            $conn->execute();

            if ($res = $conn->fetchAll(PDO::FETCH_COLUMN))
                return $res;
        } catch (Exception $e){
            self::pre($e->getMessage());
        }

        return false;
    }

    private function describeTable($tabela){
        $sql = "describe $tabela";

        try {
            $conn = $this->conn->prepare($sql);
            $conn->execute();

            if ($res = $conn->fetchAll(PDO::FETCH_ASSOC))
                return $res;
        } catch (Exception $e){
            self::pre($e->getMessage());
        }

        return false;
    }

    public function criaModels(){
        self::criaDiretorios();

        if ($tabelas = self::showTables()){
            self::pre("showTables()");
            foreach ($tabelas as $tabela){
                $forengkey = array();
                $primary_key = array();
                $campos = self::describeTable($tabela);

                // criacao da classe
                $php = "<?php\n";
                $php .= "public class ".self::padronizaNome($tabela, true)."_model {\n\n";

                // percorre os campos
                if ($campos){
                    foreach ($campos as $campo){
                        $php .= "\tprivate \$".$campo['Field'].";\n";
                        if ($campo['Key'] == 'PRI')
                            $primary_key[] = $campo['Field'];
                        if ($campo['Key'] == 'MUL')
                            $forengkey[] = $campo['Field'];
                    }
                }

                $php .= "\n";

                // cria __construct
                if (count($forengkey)) {
                    $php .= "\n";
                    $php .= "\tpublic function __construct(){\n";
                        $php .= "\t\t\$CI = & get_instance();\n";
                        $fks = '';
                        $mls = '';

                        $php .= "\t\t\$CI->load->model(array(";
                        foreach ($forengkey as $fk) {
                            $mls .= "'" . self::padronizaNome(str_replace("_id", "", $fk), true) . "_model',";
                            $fks .= "'$fk',";
                        }
                        $php .= rtrim($mls,",");
                        $php .= "));\n";

                    $php .= "\t}\n\n";
                }


                // regras dos campos
                if (count($campos)) {
                    $php .= "\tprivate static function regras(){\n";
                    $php .= "\t\treturn array(\n";
                    $ppk = '';

                    if (count($primary_key) == 1){
                        $php .=  "\t\t\t'pk' => '{$primary_key[0]}',\n";
                    }
                    if (count($primary_key) > 1){
                        $php .=  "\t\t\t'pk' => array(";
                        foreach($primary_key as $pk)
                            $ppk .= "'$pk',";
                        $php .= rtrim($ppk, ",")."),\n";
                    }

                    $req = '';
                    $num = '';
                    foreach ($campos as $campo) {
                        if ($campo['Null'] == 'No')
                            $req .= "'{$campo['Field']}',";
                        if (substr($campo['Type'], 0, 3) == 'int' || substr($campo['Type'], 0, 3) == 'flo' || substr($campo['Type'], 0, 3) == 'dou' || substr($campo['Type'], 0, 3) == 'dec' || substr($campo['Type'], 0, 3) == 'num' || substr($campo['Type'], 0, 3) == 'bit')
                            $num .= "'{$campo['Field']}',";
                    }
                    if ($req != '')
                        $php .= "\t\t\t'requerido' => array($req),\n";
                    if ($num != '')
                        $php .= "\t\t\t'numero' => array($num),\n";
                    if (count($forengkey)) {
                        $php .= "\t\t\t'fk' => array($fks),\n";
                    }
                    $php .= "\t\t);\n";
                    $php .= "\t}\n\n";
                }


                // relacoes entre tabelas
                if (count($forengkey)){
                    $php .= "\tprivate function relations(){\n";
                    $php .= "\t\treturn array(\n";
                    foreach($forengkey as $fk){
                        $php .= "\t\t\t'".self::padronizaNome(str_replace("_id","",$fk))."'=>".self::padronizaNome(str_replace("_id","",$fk), true)."_model::findByPk(\$this->$fk),\n";
                    }
                    $php .= "\t\t);\n";
                    $php .= "\t}\n\n";
                }

                // getTabela
                $php .= "\tprivate static function getTabela(){\n";
                    $php .= "\t\treturn '$tabela';\n";
                $php .= "\t}\n\n";

                // getters e setters
                foreach($campos as $campo){
                    $php .= "\tpublic function ".self::padronizaNome($campo['Field'])."(\${$campo['Field']} = null){\n";
                        $php .= "\t\tif (!is_null(\${$campo['Field']}))\n";
                            $php .= "\t\t\t\$this->{$campo['Field']} = \${$campo['Field']};\n";
                        $php .= "\t\treturn \$this->{$campo['Field']};\n";
                    $php .= "\t}\n\n";
                }

                // getters das relacoes
                if (count($forengkey)){
                    foreach($forengkey as $fk){
                        $php .= "\tpublic function ".self::padronizaNome(str_replace("_id","",$fk))."(){\n";
                            $php .= "\t\t\$relations = self::relations();\n";
                            $php .= "\t\treturn \$relations['".self::padronizaNome(str_replace("_id","",$fk))."'];\n";
                        $php .= "\t}\n\n";
                    }
                }

                // metodo save
                $php .= "\tpublic function save(){\n";
                    $php .= "\t\t\$return = false;\n";
                    $php .= "\t\t\$regras = self::regras();\n";

                    $php .= "\t\tif (self::validaCampos())\n";
                        $php .= "\t\t\tif (\$this->{\$regras['pk']})\n";
                            $php .= "\t\t\t\t\$return = self::update();\n";
                        $php .= "\t\t\telse\n";
                            $php .= "\t\t\t\t\$return = self::insert();\n";

                    $php .= "\t\treturn \$return;\n";
                $php .= "\t}\n\n";

                // metodo insert
                $php .= "\tprivate function insert(){\n";
                    $php .= "\t\t\$regras = self::regras();\n";
                    $php .= "\t\treturn Modelo::instance()->insert(self::getTabela(), self::getAttrs(true), isset(\$regras['pk']));\n";
                $php .= "\t}\n\n";

                // matodo update
                $php .= "\tpublic function update(){\n";
                    $php .= "\t\t\$regras = self::regras();\n";
                    $php .= "\t\tif (\$this->{\$regras['pk']}) {\n";
                        $php .= "\t\t\treturn Modelo::instance()->update(self::getTabela(), array(\$regras['pk'], \$this->{\$regras['pk']}), self::getAttrs(true));\n";
                    $php .= "\t\t}\n";
                    $php .= "\t\treturn false;\n";
                $php .= "\t}\n\n";

                // metodo updateAll
                $php .= "\tpublic static function updateAll(\$condicao = null, \$dados = null){\n";
                    $php .= "\t\treturn Modelo::instance()->updateAll(self::getTabela(), \$condicao, \$dados);\n";
                $php .= "\t}\n\n";

                // metodo findAll
                $php .= "\tpublic static function findAll(\$condicoes = null, \$limit = 100, \$offset = 0){\n";
                    $php .= "\t\t\$res = Modelo::instance()->findAll(self::getTabela(), \$condicoes, \$limit, \$offset);\n";
                    $php .= "\t\t\$result = array();\n";

                    $php .= "\t\tforeach(\$res as \$k=>\$r){\n";
                        $php .= "\t\t\t\$result[\$k] = new ".self::padronizaNome($tabela, true)."_model;\n";
                        $php .= "\t\t\t\$result[\$k]->setAttrs(\$r);\n";
                    $php .= "\t\t}\n";

                    $php .= "\t\treturn \$result;\n";
                $php .= "\t}\n\n";

                // metodo find
                $php .= "\tpublic static function find(\$condicoes = null){\n";
                    $php .= "\t\t\$res = Modelo::instance()->find(self::getTabela(), \$condicoes);\n";

                    $php .= "\t\t\$obj = new ".self::padronizaNome($tabela, true)."_model;\n";
                    $php .= "\t\t\$obj->setAttrs(\$res[0]);\n";

                    $php .= "\t\treturn \$obj;\n";
                $php .= "\t}\n\n";

                // metodo findByPk
                $php .= "\tpublic static function findByPk(\$pk){\n";
                    $php .= "\t\t\$regras = self::regras();\n";
                    $php .= "\t\tif (\$this->{\$regras['pk']}) {\n";
                        $php .= "\t\t\t\$row = Modelo::instance()->findByPk(self::getTabela(), array(\$regras['pk'], \$pk));\n";
                        $php .= "\t\t\t\$obj = new ".self::padronizaNome($tabela, true)."_model;\n";
                        $php .= "\t\t\t\$obj->setAttrs(\$row);\n";
                        $php .= "\t\t\treturn \$obj;\n";
                    $php .= "\t\t}\n";
                    $php .= "\t\treturn false;\n";
                $php .= "\t}\n\n";

                // metodo delete
                $php .= "\tpublic function delete(){\n";
                    $php .= "\t\t\$regras = self::regras();\n";
                    $php .= "\t\tif (\$this->{\$regras['pk']}){\n";
                        $php .= "\t\t\treturn Modelo::instance()->delete(self::getTabela(), array(\$regras['pk'], \$this->{\$regras['pk']}));\n";
                    $php .= "\t\t}\n";
                    $php .= "\t\treturn false;\n";
                $php .= "\t}\n\n";

                // metodo deleteAll
                $php .= "\tpublic static function deleteAll(\$condicoes = null){\n";
                    $php .= "\t\treturn Modelo::instance()->deleteAll(self::getTabela(), \$condicoes);\n";
                $php .= "\t}\n\n";

                // metodo setAttrs
                $php .= "\tpublic function setAttrs(\$attrs){\n";
                    $php .= "\t\t\$params = get_class_vars(__CLASS__);\n";

                    $php .= "\t\tforeach(\$attrs as \$key=>\$val){\n";
                        $php .= "\t\t\tif (array_key_exists(\$key, \$params)) {\n";
                            $php .= "\t\t\t\t\$this->{\$key} = \$val;\n";
                            //$php .= "\t\t\t\tif (\$key == 'senha')\n";
                                //$php .= "\t\t\t\t\tself::senha(\$val);\n";
                        $php .= "\t\t\t}\n";
                    $php .= "\t\t}\n";
                $php .= "\t}\n\n";

                // metodo getAttrs
                $php .= "\tpublic function getAttrs(\$nulos = false){\n";
                    $php .= "\t\t\$params = array();\n";

                    $php .= "\t\tforeach(get_class_vars(__CLASS__) as \$key=>\$val){\n";
                        $php .= "\t\t\t\$params[\$key] = \$this->{\$key};\n";
                    $php .= "\t\t}\n";

                    $php .= "\t\tif (\$nulos)\n";
                        $php .= "\t\t\tforeach(get_class_vars(__CLASS__) as \$key=>\$val)\n";
                            $php .= "\t\t\t\tif (!\$this->{\$key})\n";
                                $php .= "\t\t\t\t\tunset(\$params[\$key]);\n";

                    $php .= "\t\treturn \$params;\n";
                $php .= "\t}\n\n";

                // metodo valida campos
                $php .= "\tpublic function validaCampos(){\n";
                    $php .= "\t\t\$ok = true;\n";
                    $php .= "\t\t\$regras = self::regras();\n";

                    $php .= "\t\tforeach(self::getAttrs() as \$key=>\$val){\n";
                        $php .= "\t\t\tif (isset(\$regras['requerido']))\n";
                            $php .= "\t\t\t\tif (in_array(\$key, \$regras['requerido']) && !\$val)\n";
                                $php .= "\t\t\t\t\t\$ok = false;\n";

                        $php .= "\t\t\tif (isset(\$regras['numero']))\n";
                            $php .= "\t\t\t\tif (in_array(\$key, \$regras['numero']) && !is_numeric(\$val))\n";
                                $php .= "\t\t\t\t\t\$ok = false;\n";

                    $php .= "\t\t}\n";

                    $php .= "\t\treturn \$ok;\n";
                $php .= "\t}\n\n";

                $php .= "}";

                self::criaModelFile($tabela, $php);
            }
        } else {
            self::pre("showTables() false");
        }
        //return false;
    }

    /*public function teste(){
        foreach(self::showTables() as $table) {
            self::pre($table);
            self::pre(self::describeTable($table));
        }
    }*/
}