<?php


session_start();

class Users
{
    private $conn;
    private $table_name = "users";

    public $id;
    public $username;
    public $email;
    public $password;

    public function __construct($db) {
        $this->conn = $db;
    }


    public function register($name, $email, $password) {

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);


        $stmt = $this->conn->prepare('SELECT * FROM ' . $this->table_name . ' WHERE username = ? OR email = ?');
        $stmt->execute([$name, $email]);

        if ($stmt->rowCount() > 0) {
            return "Пользователь с таким именем или почтой уже существует.";
            header('Location: ../../views/auth/registrationForm.php');
            exit;
        } else {
            try {

                $stmt = $this->conn->prepare('INSERT INTO ' . $this->table_name . ' (username, email, password) VALUES (:username, :email, :password)');
                $stmt->execute([
                    ':username' => $name,
                    ':email' => $email,
                    ':password' => $hashed_password
                ]);
                setcookie('username', $name, time() + (86400 * 30), "/");
                header('Location: ../../index.php');
                exit;
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }
    }



    public function Login($name, $email, $password) {

        $stmt = $this->conn->prepare('SELECT * FROM ' . $this->table_name . ' WHERE username = ? OR email = ?');
        $stmt->execute([$name, $email]);


        if ($stmt->rowCount() == 0) {
            $_SESSION['errMsg'] = 'Пользователь с такими данными не зарегистрирован';
            header('Location: ../../views/auth/loginForm.php');
            exit();
        } else {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
        }

        if (password_verify($password, $user['password'])) {
            setcookie('username', $user['username'], time() + (86400 * 30), "/");
            header('Location: ../../index.php');
            exit();
        } else {
            $_SESSION['errMsg'] = 'Неверный пароль';
            header('Location: ../../views/auth/loginForm.php');
            exit();
        }
    }



}