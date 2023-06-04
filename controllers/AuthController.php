<?php

class Authentication
{
    static $db_con = null;

    public static function init()
    {
        self::$db_con = DBCONNECT::connect();
    }

    static function register()
    {
        $_SESSION['old_input'] = [];
        $_SESSION['error'] = [];
        $_SESSION['message'] = [];
        $isErrorPersist = false;

        $firstname = mysqli_real_escape_string(self::$db_con, $_POST['firstname']);
        $lastname = mysqli_real_escape_string(self::$db_con, $_POST['lastname']);
        $email = mysqli_real_escape_string(self::$db_con, $_POST['email']);
        $phone = mysqli_real_escape_string(self::$db_con, $_POST['phone']);
        $password = mysqli_real_escape_string(self::$db_con, $_POST['password']);
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $confirm = mysqli_real_escape_string(self::$db_con, $_POST['confirm']);

        $_SESSION['old_input'] = $_POST;

        $sql = self::$db_con->query("SELECT phone, email FROM users");

        if (mysqli_num_rows($sql) == 0) {
            return Helper::alert_message('danger', 'You have forgotten to run "cd seeders/php seeders.php in your terminal"');
        }

        while ($array_check = mysqli_fetch_assoc($sql)) {
            $checkPhoneNumber[] = $array_check['phone'];
            $checkEmailAddress[] = $array_check['email'];
        }

        // firstname validation
        if (empty($firstname)) {
            $isErrorPersist = true;
            $_SESSION['error']['firstname'] = true;
            $_SESSION['message']['firstname'] = 'Firstname cannot be empty!';
        } elseif (!preg_match('/^[a-zA-Z ]+$/', $firstname)) {
            $isErrorPersist = true;
            $_SESSION['error']['firstname'] = true;
            $_SESSION['message']['firstname'] = 'Invalid characters in first name';
        }

        //lastname validation
        if (empty($lastname)) {
            $isErrorPersist = true;
            $_SESSION['error']['lastname'] = true;
            $_SESSION['message']['lastname'] = 'Lastname cannot be empty!';
        } elseif (!preg_match('/^[a-zA-Z ]+$/', $lastname)) {
            $isErrorPersist = true;
            $_SESSION['error']['lastname'] = true;
            $_SESSION['message']['lastname'] = 'Invalid characters in last name';
        }

        // email validation
        if (empty($email)) {
            $isErrorPersist = true;
            $_SESSION['error']['email'] = true;
            $_SESSION['message']['email'] = 'Email address cannot be empty!';
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $isErrorPersist = true;
            $_SESSION['error']['email'] = true;
            $_SESSION['message']['email'] = 'Invalid email format!';
        } else if (in_array($email, $checkEmailAddress)) {
            $isErrorPersist = true;
            $_SESSION['error']['email'] = true;
            $_SESSION['message']['email'] = 'Email address already taken!';
        }

        // phone number validation
        if (empty($phone)) {
            $isErrorPersist = true;
            $_SESSION['error']['phone'] = true;
            $_SESSION['message']['phone'] = 'Phone number cannot be empty!';
        } elseif (!preg_match('/^0[0-9]{9}$/', $phone)) {
            $isErrorPersist = true;
            $_SESSION['error']['phone'] = true;
            $_SESSION['message']['phone'] = 'Phone number is invalid!';
        } else if (in_array($phone, $checkPhoneNumber)) {
            $isErrorPersist = true;
            $_SESSION['error']['phone'] = true;
            $_SESSION['message']['phone'] = 'phone number already taken!';
        }

        // password validation
        if (strlen($password) < 6) {
            $isErrorPersist = true;
            $_SESSION['error']['password'] = true;
            $_SESSION['message']['password'] = 'Password must be at least 6 characters long!';
        }

        if (!preg_match('/[A-Za-z]/', $password)) {
            $isErrorPersist = true;
            $_SESSION['error']['password'] = true;
            $_SESSION['message']['password'] = 'Password must contain at least one letter!';
        }

        if (!preg_match('/\d/', $password)) {
            $isErrorPersist = true;
            $_SESSION['error']['password'] = true;
            $_SESSION['message']['password'] = 'Password must contain at least one number!';
        }

        if (!preg_match('/[!@#$%^&*]/', $password)) {
            $isErrorPersist = true;
            $_SESSION['error']['password'] = true;
            $_SESSION['message']['password'] = 'Password must contain at least one special character!';
        }

        if ($password != $confirm) {
            $isErrorPersist = true;
            $_SESSION['error']['confirm'] = true;
            $_SESSION['message']['confirm'] = 'Passwords must match!';
        }

        if ($isErrorPersist != true) {
            //unset the session variables to reduce server consumption
            unset($_SESSION['old_input']);
            unset($_SESSION['error']);
            unset($_SESSION['message']);

            $sql = self::$db_con->query("INSERT INTO users (firstname, lastname, phone, email, role_id, password) VALUES ('" . $firstname . "', '" . $lastname . "', '" . $phone . "', '" . $email . "',4, '" . $password_hash . "')");
            $userId = mysqli_insert_id(self::$db_con);
            if (!mysqli_error(self::$db_con)) {
                $sql = self::$db_con->query("SELECT users.id as id, roles.role, phone FROM users, roles WHERE users.role_id = roles.id AND users.id = $userId");
                $userDetail = mysqli_fetch_assoc($sql);
                $_SESSION = [
                    'username' => $firstname . ' ' . $lastname,
                    'id' => $userDetail['id'],
                    'role' => $userDetail['role'],
                    'phone' => $userDetail['phone'],
                ];

                Util::redirectTo('homepage.php');
            } else {
                Helper::alert_message('danger', mysqli_error(self::$db_con));
            }
        }
    }

    static function login()
    {
        $_SESSION['old_input'] = [];
        $_SESSION['error'] = [];
        $_SESSION['message'] = [];
        $isErrorPersist = false;

        $phone = mysqli_real_escape_string(self::$db_con, $_POST['phone']);
        $password = mysqli_real_escape_string(self::$db_con, $_POST['password']);

        // phone number validation
        if (empty($phone)) {
            $isErrorPersist = true;
            $_SESSION['error']['phone'] = true;
            $_SESSION['message']['phone'] = 'Phone number cannot be empty!';
        }

        //password validation
        if (empty($password)) {
            $isErrorPersist = true;
            $_SESSION['error']['phone'] = true;
            $_SESSION['message']['phone'] = 'Password field  is required!';
        }

        if ($isErrorPersist != true) {
            unset($_SESSION['error']);
            unset($_SESSION['message']);

            $_SESSION['old_input'] = [
                'phone' => $phone
            ];

            $sql = self::$db_con->query("SELECT users.id as id, phone, password, concat(firstname, ' ', lastname) as name, role FROM users, roles WHERE phone = '" . $phone . "' AND users.role_id = roles.id");

            if (mysqli_num_rows($sql) == 0) {
                return Helper::alert_message("danger", "Phone number " . $phone . " doesn't exist in our database!");
            }
            $user = mysqli_fetch_assoc($sql);

            if (!mysqli_error(self::$db_con)) {
                if (password_verify($password, $user['password'])) {
                    unset($_SESSION['old_input']);
                    unset($_SESSION['error']);
                    unset($_SESSION['message']);
                    $_SESSION = [
                        'id' => $user['id'],
                        'username' => $user['name'],
                        'role' => $user['role'],
                        'phone' => $user['phone'],
                    ];
                    Util::redirectTo('homepage.php');
                } else {
                    return Helper::alert_message('danger', 'Invalid credentials!');
                }
            } else {
                return Helper::alert_message('warning', 'technical error!');
            }
        }
    }

    static function isLoggedIn()
    {
        if (isset($_SESSION['id']) && !empty($_SESSION['role'])) return true;
    }

    static function isAdmin()
    {
        if (self::isLoggedIn() && $_SESSION['role'] == 'admin') return true;
    }

    static function isManager()
    {
        if (self::isLoggedIn() && $_SESSION['role'] == 'manager') return true;
    }

    static function isTransporter()
    {
        if (self::isLoggedIn() && $_SESSION['role'] == 'transporter') return true;
    }

    static function isCustomer()
    {
        if (self::isLoggedIn() && $_SESSION['role'] == 'customer') return true;
    }
}

Authentication::init();
