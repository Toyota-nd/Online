<?
// library\My\Validate\PidValidator.php
class My_Validate_PidValidator extends Zend_Validate_Abstract {
	const SIZE = 'size';
	const FORMAT = 'format';
	const CHECK = 'check';
 
	protected $_messageTemplates = 
		array(
			self::SIZE=>"'%value%' 身份證字串長度不符合。",
			self::FORMAT=>"'%value%' 的第一個字元必須是英文字母，其他必須是數字。",
			self::CHECK=>"'%value%' 是非法的身份證字號。"
		);
 
	public function isValid($value){
		$this->_setValue($value);
		if(strlen($value) != 10){
			$this->_error(self::SIZE);
			return false;
		}

		$value=strtoupper($value);
		if(!ereg("[A-Z]{1}[0-9]{9}",$value)){
			$this->_error(self::FORMAT);
		return false;
		}

		if($this->check($value)){
			return true;
		} else {
			$this->_error(self::CHECK);
			return false;
		}
	}

	private function check($value){
		$first = 
			array(
			'A'=>10,'B'=>11,'C'=>12,'D'=>13,'E'=>14,
			'F'=>15,'G'=>16,'H'=>17,'I'=>34,'J'=>18,
			'K'=>19,'L'=>20,'M'=>21,'N'=>22,'O'=>35,
			'P'=>23,'Q'=>24,'R'=>25,'S'=>26,'T'=>27,
			'U'=>28,'V'=>29,'W'=>32,'X'=>30,'Y'=>31,
			'Z'=>33);
  /**
   * convert the first alpha character to two digits
   * and combines to the rest digits
   */
		$value = $first[$value[0]].substr($value,1);

		$sum = (int)$value[0];
		for($i=1;$i<=9;$i++){
		   $sum+=$value[$i]*(10-$i);
		}

  /**
   * get the single-digit of 10-$sum
   */
		$single = 10 - ($sum % 10);
		if($single == $value[10]){
			return true;
		} else {
			return false;
		}
	}
}
