# JsonHandleFreedom
Json Encoding - Decoding, Bindings To Class( Json to Class Instance), Decoding to Class Or Associative Array

-------------------------------------------------------------------------------------------------------------------


JsonHandleFreedom Use:
		
		---------------------------------------------------------------------
			1: Encoding To Json Objects Or Array Of Objects And All Variables Or Properties.
			2: Encoding To Json With Encryption For Api Use.
			3: Decoding From Json To Objects Or Associative Array Except Of The Base Encoded Object That Will Be Class.
			4: Decoding From Json To Object Or A Class Instance.
			5: Decoding And Decrypt For Api use.
		---------------------------------------------------------------------
		
		

Encoding To Json Examples And Decoding #1
---------------------------------------------------

		User Model For Example is:{
		
			class User extends Model
			{
				public static $table = 'users';
				private $prive = 'private';
				public $id;
				public $username;
				public $pass;
				public $user_nick_name;
				public $val;
				public $jsonval;


				/**
				 * @return string
				 */
				public function get_prive()
				{
					return $this->prive;
				}

				/**
				 * @param string $prive
				 */
				public function set_prive($prive)
				{
					$this->prive = $prive;
				}


				public function __construct()
				{
					parent::$table = self::$table;
					parent::$modelName = self::class;

					return $this;
				}
			}	
	
		}
		
        $freeJson = new \Freedom\JsonHandler\JsonClassFreedom();
        
        $first = new \Models\User();
        $first->username = 'someone';

        $second = new \Models\User();
        $second->username = 'newsss';
        $second->name = 'hello';
        $second->pass =[1,2,3,4,5,6,0];
        $second->jsona = $first;
		
		$main = new \Models\User();
        $main->username= 'hello1';
        $main->jsona = $second;
        
        $flag= true;
        $final = $freeJson->encodeJsonMaster($main);
       
        $results = $freeJson->jsonDecodeToClass($final, \Models\User::class);

        return var_dump($results);
		
		
		
		The $results output is:{
		
	$main--	object(Models\User)#12 (8) { 
			["prive":"Models\User":private]=> string(7) "private" 
			["id"]=> NULL 
			["username"]=> string(6) "hello1" 
			["pass"]=> NULL 
			["user_nick_name"]=> NULL 
			["val"]=> NULL ["jsonval"]=> NULL 
			["jsona"]=> object(stdClass)#17 (10) {
	$second--- 	["id"]=> NULL 
				["username"]=> string(6) "newsss" 
				["pass"]=> array(7) { [0]=> int(1) [1]=> int(2) [2]=> int(3) [3]=> int(4) [4]=> int(5) [5]=> int(6) [6]=> int(0) } 
				["user_nick_name"]=> NULL 
				["val"]=> NULL 
				["jsonval"]=> NULL 
				["name"]=> string(5) "hello" 
				["jsona"]=> object(stdClass)#14 (8) {
	$first------		["id"]=> NULL 
					["username"]=> string(7) "someone" 
					["pass"]=> NULL 
					["user_nick_name"]=> NULL 
					["val"]=> NULL 
					["jsonval"]=> NULL 
				["FrStatic"]=> array(2) { 
					[0]=> object(stdClass)#19 (1) {
						["table"]=> string(5) "users" } 
					[1]=> object(stdClass)#16 (1) {
						["modelName"]=> string(11) "Models\User" } } 
				["FrPrivate"]=> array(1) {
					[0]=> object(stdClass)#18 (1) {
						["prive"]=> string(7) "private" } } } 
					["FrStatic"]=> array(2) {
						[0]=> object(stdClass)#13 (1) { 
							["table"]=> string(5) "users" } 
						[1]=> object(stdClass)#20 (1) {
							["modelName"]=> string(11) "Models\User" } } 
						["FrPrivate"]=> array(1) { 
							[0]=> object(stdClass)#21 (1) { 
								["prive"]=> string(7) "private" } } } }
		
		}

---------------------------------------------------

Encoding To Json Examples And Decoding #2

----------------------------------------------------



	$results = $freeJson->jsonDecodeToClass($final);

	
	Will output all the same but the first Class will be Std Class,
	at FrStatic will be stored all the static props,
	at FrPrivate will be stored all the private props.



-----------------------------------------------------



---------------------------------------------------

Encoding To Json Examples And Decoding #3

----------------------------------------------------



	$results = $freeJson->jsonDecodeToClass($final, null ,'array');

	
	Will output all the same but the first Class will be Std Class,
			everything else will be accosiative array,
		at FrStatic will be stored all the static props,
		at FrPrivate will be stored all the private props.



-----------------------------------------------------


---------------------------------------------------

Encoding To Json Examples And Decoding #4

----------------------------------------------------


	$final = $freeJson->encodeJsonMaster($main, true);
       
        

	If At object main there is Encoded Json Will return the $main object with the stored Json decoded 
	
-----------------------------------------------------





Encoding To Json Examples And Decoding #5

----------------------------------------------------


	$final = $freeJson->encodeJsonMaster($main, false, 'encrypt_pass');
    
	$middle = $final; //Will be String -- JSON Encrypted -- "fd670ee04834fedeec4ed4cc217f9ed..."
        
	$results = $freeJson->jsonDecodeToClass($final, null ,'class', 'encrypt_pass');

	
	Will output all the same but the first Class will be Std Class,
			everything else will be accosiative array,
		at FrStatic will be stored all the static props,
		at FrPrivate will be stored all the private props.
		
					Encrypt Decrypt Example.



-----------------------------------------------------



Encoding To Json Examples And Decoding #6

----------------------------------------------------


	//TODO ARRAY


-----------------------------------------------------








