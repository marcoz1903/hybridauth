<?php namespace HybridauthTest\Hybridauth\Storage;

use Hybridauth\Storage\Session;

class SessionTest extends \PHPUnit_Framework_TestCase
{
	function some_randome_session_data(){
		return [
			[ 'foo', 'bar' ],
			[  1234, 'bar' ],
			[ 'foo',  1234 ],

			[ 'Bonjour', '안녕하세요' ],
			[ 'ஹலோ'   , 'Γεια σας' ],

			[ 'array', [ 1, 2, 3 ] ],
			[ 'string',  json_encode( $this ) ],
			[ 'object', $this ],

			[ 'provider.token.request_token', '9DYPEJ&qhvhP3eJ!' ],
			[ 'provider.token.oauth_token', '80359084-clg1DEtxQF3wstTcyUdHF3wsdHM' ],
			[ 'provider.token.oauth_token_secret', 'qiHTi1znz6qiH3tTcyUdHnz6qiH3tTcyUdH3xW3wsDvV08e' ],
		];
	}

	public function test_instance_of(){
		$storage = new Session;

		$this->assertInstanceOf( '\\Hybridauth\\Storage\\StorageInterface', $storage );
	}

	/**
	* @dataProvider some_randome_session_data
	*/
	function test_set_and_get_data( $key, $value ){
		$storage = new Session;
		
		$storage->set( $key, $value );

		$data = $storage->get( $key );

		$this->assertEquals( $value, $data );
	}

	/**
	* @dataProvider some_randome_session_data
	*/
	function test_delete_data( $key, $value ){
		$storage = new Session;

		$storage->set( $key, $value );

		$storage->delete( $key );

		$data = $storage->get( $key );

		$this->assertNull( $data );
	}

	/**
	* @dataProvider some_randome_session_data
	*/
	function test_clear_data( $key, $value ){
		$storage = new Session;

		$storage->set( $key, $value );

		$storage->clear();

		$data = $storage->get( $key );

		$this->assertNull( $data );
	}

	/**
	* @dataProvider some_randome_session_data
	*/
	function test_delete_match_data( $key, $value ){
		$storage = new Session;

		$storage->set( $key, $value );

		$storage->deleteMatch( 'provider.token.');

		$data = $storage->get( 'provider.token.request_token' );

		$this->assertNull( $data );
	}
}
