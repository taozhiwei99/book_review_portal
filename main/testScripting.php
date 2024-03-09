<?php 
    include_once('Controller/LoginController.php');
    include_once('Connection.php');

    use PHPUnit\Framework\TestCase;

    final class testScripting extends TestCase {

        public function setUp(): void {
            $connConfig = new Connection();
            $conn = new mysqli($connConfig->get_servername(), $connConfig->get_username(), $connConfig->get_password(), $connConfig->get_dbname());

            $query = "INSERT INTO user_info (user_ID, user_FName, user_LName, user_Email, user_Mobile, user_Password, user_Profile) 
                        VALUES ('author', 'Script', 'testing', 'scripttest@gmail.com', '123456789', 'author', 'Author')";
            
            $conn->query($query);
        }

        /** @test */
        public function LoginTest() {
            $cont = new LoginController();

            $pass = $cont->loginTest('author', 'author');

            $this->assertTrue($pass);

            $fail = $cont->loginTest('xxxxxx', 'xxxxxx');

            $this->assertFalse($fail);
        }

        public function tearDown(): void {
            $connConfig = new Connection();
            $conn = new mysqli($connConfig->get_servername(), $connConfig->get_username(), $connConfig->get_password(), $connConfig->get_dbname());

            $query = "DELETE FROM user_info WHERE user_ID = 'author'";

            $conn->query($query);
        }
    }
?>

