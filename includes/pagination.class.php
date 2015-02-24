<?php 

class pagination 
{

	public $array;
	public $page;
	public $pages;
	public $total; 
	public $limit;
	public $paginated;
	public $rt; 
	public $start; 
	public $end;
	public $max;

	public function __construct( $array, $limit, $return_type = 'array' ) 
	{
		$return_array = [];
		if( is_object($array) ) :

			foreach( $array as $key=>$obj ):
				$return_array[$key] = (array) $obj;
			endforeach;

		else:
			$return_array = (array) $array; 
		endif;

		$this->array = (array)$return_array;
		$this->limit = $limit;
		$this->total = count( $this->array );
		$this->pages = ceil( $this->total / $limit ); 
		$this->rt = $return_type; 
	}

	public function page($page = 1) 
	{
		if( $page < 1 or $page > $this->pages ):
			$this->page == false;
			return false;
		else:
	
			$this->page = $page;
			$pages = $this->pages; 
			$items = $this->total; 

			$start = ( $page * $this->limit ) - $this->limit; 
			$this->start = $start + 1;
			$this->end = $this->limit + $this->start - 1; 
			$paginated = array_slice( $this->array, $start, $this->limit );
			$this->paginated = $paginated; 
			$return_obj = []; 
			$this->max = count( $return_obj );
			if( $this->rt == 'array' ) :
				return (array)$paginated; 
			elseif( $this->rt == 'object' ): 
				foreach( $paginated as $value ) {
					$return_obj[] = (object) $value; 
				}
				return (object) $return_obj; 
			else: 
				return $paginated; 
			endif;
		endif;
	}
	public function prev() {
		if( $this->page - 1 >= 1 ) {
			return $this->page - 1;
		} else {
			return false;
		}
	}

	public function next() {
		if( $this->page + 1 <= $this->pages ) {
			return $this->page + 1; 
		} else {
			return false;
		}
	}
}