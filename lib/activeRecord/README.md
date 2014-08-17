Production guides
=====
### Multi db connection
1. First to add a new dbConnetion ,which is typically similar to the test in asmac/conf/db_config.php file;

2. Second add function in Ar class from this direction: e.g. connection name is 'db_prodution' added in step one  

```phpshell
class **Ar extends ActiveRecord {
	...  
	public function getDbConnection() {  
		return Yii::app()->db_production;  
	}  
	...  
}
```
