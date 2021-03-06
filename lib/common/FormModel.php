<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class FormModel extends CFormModel
{
    public $pagination;//分页相关的数据
    public $countPerPage;//页面大小
    public $totalNum; //所有的记录数
    public $currentPage; //当前的页码
    public $totalPage; //所有的页数
    public $error;//错误信息
    public $logname;//日志中操作的名称
    public $logid;//日志id
	public $page_selector; // 页面选择index or recommend?
    public $class_selector; // body class页选择
    public $upUrl;//上一级的URL包括上一级的参数，通过$_SERVER['HTTP_REFERER']得到
    public $params;//一些零时的数据

	public function init(){
		if(isset(Yii::app()->user->id) && Yii::app()->user->id) {
		//还没想好，先空着
		}
	}
	
	/**
	 * auto trim all
	 */
	public function setAttributes($values,$safeOnly=true)
	{
		if (is_array($values)) {
			foreach ($values as $name => $val) {
				if (is_string($val)) {
					$values[$name] = trim($val);
				}
			}
		}
		return parent::setAttributes($values,$safeOnly);
	}

	/**
	 * auto trim all
	 */
	public function beforeValidate()
	{
		if (is_array($this->attributes)) {
			foreach ($this->attributes as $name => $val) {
				if (is_string($val)) {
					$this->$name = trim($val);
				}
			}
		}
		return parent::beforeValidate();
	}

	/**
	 *@param array 要转码的字符数组
	 *@return array() 转码后的字符数组
	 */
	public function iconv_array($array) {
		foreach($array as &$value) {
			$temp = $value;
			try {
				$value = iconv('UTF-8','GBK//ignore',$value);
			} catch(Exception $e) {
				$value = $temp;
			}
		}
		return $array;
	}
	
    /**
     *错误处理
     */
    public function error()
    {
        $temp=array_values($this->errors);
        echo "<h1>".$temp[0][0]."</h1>";
    }
	
	/**
	 * 判断字符串是否是utf8编码
	 */
	// Returns true if $string is valid UTF-8 and false otherwise. 
	function is_utf8($word) 
	{ 
		if (preg_match("/^([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){1}/",$word) == true || preg_match("/([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){1}$/",$word) == true || preg_match("/([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){2,}/",$word) == true) 
		{ 
			return true; 
		} 
		else 
		{ 
			return false; 
		} 
	} // function is_utf8 
	
	/**
	 * 对字符串进行处理，如果不是utf8编码，转成utf8编码
	 */
	public function string_detect_format($string)
	{
		if($this->is_utf8($string)) {
			return $string;
		} else {
			return iconv('GBK','UTF-8//ignore', $string);  //GBK转成utf8编码
		}
	}
}
