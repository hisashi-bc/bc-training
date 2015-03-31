<?php
/**
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package    Fuel
 * @version    1.7
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2013 Fuel Development Team
 * @link       http://fuelphp.com
 */


/**
 * Log core class facade for the Monolog composer package.
 *
 * This class will provide the interface between the Fuel v1.x class API
 * and the Monolog package, in preparation for FuelPHP v2.0
 */
class Log extends \Fuel\Core\Log
{

    /**
     * Logs a message with the Info Log Level
     *
     * @param   string  $msg     The log message
     * @param   string  $method  The method that logged
     * @return  bool    If it was successfully logged
     */
    public static function info($msg, $method = null)
    {
        $msg = self::_addMsgInfo($msg);
        return parent::info($msg, $method);
    }

    /**
     * Logs a message with the Debug Log Level
     *
     * @param   string  $msg     The log message
     * @param   string  $method  The method that logged
     * @return  bool    If it was successfully logged
     */
    public static function debug($msg, $method = null)
    {
        $msg = self::_addMsgInfo($msg);
        return parent::debug($msg, $method);
//		return parent::write(\Fuel::L_DEBUG, $msg, $method);
    }

    /**
     * Logs a message with the Warning Log Level
     *
     * @param   string  $msg     The log message
     * @param   string  $method  The method that logged
     * @return  bool    If it was successfully logged
     */
    public static function warning($msg, $method = null)
    {
        $msg = self::_addMsgInfo($msg);
        return parent::warning($msg, $method);
//		return parent::write(\Fuel::L_WARNING, $msg, $method);
    }

    /**
     * Logs a message with the Error Log Level
     *
     * @param   string  $msg     The log message
     * @param   string  $method  The method that logged
     * @return  bool    If it was successfully logged
     */
    public static function error($msg, $method = null)
    {
        $msg = self::_addMsgInfo($msg);
        return parent::error($msg, $method);
//		return parent::write(\Fuel::L_ERROR, $msg, $method);
    }


    /**
     * Exceptionオブジェクトを元にエラーメッセージを出力
     *
     * @param Exception $e
     * @param null $method
     * @return bool
     */
    public static function exception_error(Exception $e, $method = null)
    {
        $msg = $e->getMessage() . " at line " . $e->getLine();
        $msg = self::_addMsgInfo($msg);
        return parent::error($msg, $method);
//		return parent::write(\Fuel::L_ERROR, $msg, $method);
    }


    /**
     * Write Log File
     *
     * Generally this function will be called using the global log_message() function
     *
     * @access	public
     * @param	int|string	the error level
     * @param	string	the error message
     * @param	string	information about the method
     * @return	bool
     */
    public static function write($level, $msg, $method = null)
    {
        return parent::write($level, $msg, $method);
    }

    private static function _addMsgInfo($msg){
        //string以外はJSON_ENCODEで文字列化
        if(!is_string($msg)) {
            //オブジェクトの場合はメンバ変数を取得して出力e
            if(is_object($msg)){
                $arr = array();
                foreach($msg as $k=>$v){
                    $arr[$k]=$v;
                }
                $msg = array('object'=>get_class($msg),'variables'=>$arr);
            }
            $msg = json_encode($msg,JSON_UNESCAPED_UNICODE);
        }
        //出力箇所のAPPEND
        $ar = debug_backtrace();
//        var_dump($ar);
        if(!empty($ar[2]['class'])) $msg = $msg." at ".$ar[2]['class'];
        if(!empty($ar[1]['line'])) $msg = $msg." line ".$ar[1]['line'];

        return $msg;
    }



}
