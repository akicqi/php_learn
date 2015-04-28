<?php
/*
*author:akic
*低版本与高版本构造方法
*/ 
class Student{
	public $number;
	public $age;

	//低版本构造方法：
	public function Student($num,$age) {
		$this->__construct($num,$age);
	}

	//高版本构造方法
	public function __construct($num,$age) {
		$this->number = $num;
		$this->age = $age;
	}

}
?>