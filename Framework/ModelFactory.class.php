<?php
//单例工厂类
//通过这个工厂类，可以传递过来一个模型类的类名
//并返回该类的实例（对象），并保证其为“单例的”
class ModelFactory{
	static $all_model = array();
	static function M( $model_name ){ //$model_name是一个模型类的类名
		//如果 static::$all_model[$model_name] 不存在
		if ( !isset(static::$all_model[$model_name]) 
				||   
			  //如果 static::$all_model[$model_name] 不是 $model_name 的实例
			 !(static::$all_model[$model_name] instanceof $model_name) 
		    ) 
		{
			// 创建一个实例（对象）
			static::$all_model[$model_name] = new $model_name();
		}
		//返回该 $model_name 的对象
		return static::$all_model[$model_name];
	} 
}
?>