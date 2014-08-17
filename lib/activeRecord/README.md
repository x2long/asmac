Production guides
=====
### Multi db connection
1. First to add a new dbConnetion ,which is typically similar to the test in asmac/conf/db_config.php file;  

2. Second register the db connection in asmac/protected/config/main.php, e.g. "db_production" is named and registered;     

3. Second add function in Ar class from this direction: e.g. connection name is 'db_prodution' added in step two  

```phpshell
class **Ar extends ActiveRecord {
	...  
	public function getDbConnection() {  
		return Yii::app()->db_production;  
	}  
	...  
}
```
