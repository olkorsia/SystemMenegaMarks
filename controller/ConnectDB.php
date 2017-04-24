<?php 
	class connectDB {
		private static $_db = null;

		public static function getInstance() {
			if (self::$_db === null) {
				try {
					self::$_db = new PDO('mysql:host=localhost;dbname=alexandrkorsia_diplom', '046443409_mywork', '8-46u%+bVtf-');
                    self::$_db->exec('SET CHARACTER SET utf8');
				}
				catch(PDOException $e) {  
				    echo 'Не удалось подключится. Ошибка: ' . $e->getMessage();  
				}	
			}
			return self::$_db;
		}
	}
?>