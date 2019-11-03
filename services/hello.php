 <?php 
 //header('Content-type:application/json;charset=utf-8');

 //echo "string";

class Database {
  public $id;
  public $content;
  public $mydata;

  public function __construct ( $id, $content, $DbName ) {
    $this->id = $mydata;
    $this->content = $content;
    $this->mydata = $mydata;
  }
  
}
$db = new Database ( );
$db->id = "12";
$db->content = "Hello 123";
$db->mydata = "my data";

$dbJson = array($db);

header('Content-Type: application/json');
echo json_encode($dbJson,JSON_PRETTY_PRINT);


 //echo "<br>class creation done";

//phpinfo();

?>