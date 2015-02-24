<?php 

# login class
# Necessita da class SimpleCRUD

class login
{

	protected $user;
	protected $password;
	public $encrypted;
	public $salt;
	public $session_name = "adm_user";
	public $session_password = "adm_password";
	public $table;
	public $userfield;
	public $passwordfield;
	public $crud; 

	public function __construct( $config = array(), $crudinstance ) 
	{
		$defaults = array(
			'user_field'=> 'user',
			'password_field' => 'password',
			'table' => 'users',
			'salt' => 'p32P%2k$RzxZKgw0Z_4u_ygdafsWNF*A7J4iTof#L19yE*&EkxGxn*uU8$5T1SvhdE1VYM!zCZO((FlqNzu6!8y7sdSk#upyzjj&*y^uu5-E$O$WEbf*O_HJbpWFo7o6)',
			);
		$c = $config + $defaults;

		$this->table = $c['table'];
		$this->userfield = $c['user_field'];
		$this->passwordfield = $c['password_field'];
		$this->salt = $c['salt'];
		$this->crud = $crudinstance;
	}

	public function encrypt($string) 
	{
		$salt = md5($string);
		$code = crypt($string,$this->salt);
		$code = hash('sha512',$code);
		$this->encrypted = $code;  
		return $code;
	}

	private function login_register($user,$password)
	{
		$_SESSION[$this->session_name] = $user;
		$_SESSION[$this->session_password] = $this->encrypt( $password );
		return true;
	}

	public function logoff() 
	{
		unset( $_SESSION[$this->session_name] );
		unset( $_SESSION[$this->session_password] ); 
		return true;
	}

	public function session_verify()
	{
		if( isset( $_SESSION[$this->session_name]) && isset( $_SESSION[$this->session_password])) :
			
			$user = $_SESSION[$this->session_name];
			$password = $_SESSION[$this->session_password];



			$get = $this->crud->get( $this->table, array( $this->userfield => $user, $this->passwordfield => $password ) );
			
			if( $get->num_rows == 1 ):
				return true;
			else:
				return false;
			endif;
		else:
			return false;
		endif;
	}

	public function login($user, $password) 
	{
		$table = $this->table;
		$userfield = $this->userfield;
		$passfield = $this->passwordfield;
		$get = $this->crud->get( $table, array( $userfield => $user, $passfield => $this->encrypt( $password ) ) );
		if( $get != false && $get ->num_rows == 1 ):
			$this->login_register($user,$password);
			return true;
		else:
			return false;
		endif;
	}

	public function make_user($user, $password, $another = array() ) {

		$all = $another + array( $this->userfield => $user, $this->passwordfield => $this->encrypt($password) );
		$insert = $this->crud->insert( $this->table, $all );
		if( $insert ) :
			return true;
		else: 
			return false;
		endif;
	}
}