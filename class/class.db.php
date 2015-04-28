<?php 
/*
*author:akic
*操作数据的基础类
*
*/

class DB{
	//定义属性
	public $host;
	public $port;
	public $user;
	public $pass;
	public $charset;
	public $dbname;
	public $link;

	/*
	*构造方法：初始化属性
	*@param array $dbinfo  = array()
	*/

	public function __construct($dbinfo = array()) {
		$this->host = isset($dbinfo['host']) ? $dbinfo['host'] : 'localhost';
		$this->port = isset($dbinfo['port']) ? $dbinfo['port'] : 3306;
		$this->user = isset($dbinfo['user']) ? $dbinfo['user'] : 'root';
		$this->pass = isset($dbinfo['pass']) ? $dbinfo['pass'] : '';
		$this->charset = isset($dbinfo['charset']) ? $dbinfo['charset'] : 'utf8';
		$this->dbname = isset($dbinfo['dbname']) ? $dbinfo['dbname'] : 'project';

		//对连接数据库，设置字符集，选择数据库三个方法进行初始化调用
		//连接认证
		$this->db_connect();
		//设置字符集
		$this->db_charset();
		//选择数据库
		$this->db_select();
	}

	//连接数据库
	private function db_connect() {
		$this->link = mysql_connect($this->host . ':' . $this->port,$this->user,$this->pass);
		if(!$this->link) {
			echo '数据库连接失败!<br/>';
			echo '错误编码：' . mysql_errno() . '<br/>';
			echo '错误信息：' . mysql_error() . '<br/>';
			exit;
		}
	}

	//设置字符集
	private function db_charset() {
		$sql = "set names {$this->charset}";
		//调用query方法检测语句执行情况
		$this->db_query($sql);
	}

	//选择数据库
	private function db_select() {
		$sql = "use {$this->daname}";
		$this->db_query($sql);
	}

	//query方法用于检测sql语句执行情况
	/*
	*@param string $sql 需执行sql语句
	*@return mixed true或者执行结果集
	*/
	private function db_query($sql) {
		$res = mysql_query($sql);
		if(!$res) {
			echo 'sql语句错误！<br/>';
			echo '错误编码：' . mysql_errno() . '<br/>';
			echo '错误信息：' . mysql_error() . '<br/>';
			exit;
		}
		return $res;
	}

	//用户新增数据
	/*
	*@param string $sql 需执行sql语句
	*@return int 子增长id
	*/
	public function db_insert($sql) {
		$this->db_query($sql);
		//返回子增长ID
		return mysql_insert_id();
	}

	//用户更新与删除数据
	/*
	*@param string $sql 需执行sql语句
	*@return int 受影响的行数
	*/
	public function db_us($sql) {
		$this->db_query($sql);
		//返回受影响的行数
		return mysql_affected_rows();
	}

	//用户查询数据:分成查询一条记录与多行记录
	//查询一行记录
	/*
	*@param string $sql 需执行sql语句
	*@return mixed 返回一维数据
	*/

	public function db_selectOne($sql) {
		$res = $this->db_query($sql);
		//解析资源
		return mysql_fetch_assoc($res);
	}

	//查询多行记录
	public function db_selectAll($sql) {
		$res = $this->db_query($sql);
		//解析资源，循环遍历
		$lis = [];
		while ($row = mysql_fetch_assoc($res)) {
			$lis[] = $row;
		}
		return $lis;
	}
}
