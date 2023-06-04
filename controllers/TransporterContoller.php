<?php

class TransporterController
{

    static $db_con = null;

    public static function init()
    {
        self::$db_con = DBCONNECT::connect();
    }

    public static function getCompanyOptions()
    {
        $sql = self::$db_con->query("SELECT * FROM transport_companies");
        if (mysqli_num_rows($sql) == 0) {
            return true;
        }

        while ($row = mysqli_fetch_assoc($sql)) {
?>
            <option value="<?= $row['id'] ?>"><?= $row['company_name'] ?></option>
<?php
        }
    }

    public static function getAllTransporters()
    {
        $sql = self::$db_con->query("SELECT * FROM transport_company_owners, transport_companies, users 
                                    WHERE transport_company_owners.user_id = users.id
                                    AND transport_company_owners.transport_company_id = transport_companies.id");
        if (mysqli_num_rows($sql) == 0) {
            echo '<tr>
                    <td colspan="6" class="bg-warning">No available transporters now!</td>
                </tr>';
        } else {
            $count = 0;
            while ($row = mysqli_fetch_array($sql)) {
                $count++;
                echo '<tr>
                    <td>' . $count . '</td>
                    <td>' . $row['firstname'] . '&nbsp;' . $row['middlename'] . '&nbsp;' . $row['lastname'] . '</td>
                    <td>' . $row['phone'] . '</td>
                    <td>' . $row['email'] . '</td>
                    <td>' . $row['company_name'] . '</td>
                    <td>
                        <a class="badge bg-primary">edit</a>&nbsp;
                        <a class="badge bg-danger">delete</a>
                    </td>
                </tr>';
            }
        }
    }

    public static function registerTransporter()
    {
        $firstname = mysqli_real_escape_string(self::$db_con, $_POST['firstname']);
        $middlename = mysqli_real_escape_string(self::$db_con, $_POST['middlename']);
        $lastname = mysqli_real_escape_string(self::$db_con, $_POST['lastname']);
        $phone = mysqli_real_escape_string(self::$db_con, $_POST['phone']);
        $email = mysqli_real_escape_string(self::$db_con, $_POST['email']);
        $company = mysqli_real_escape_string(self::$db_con, $_POST['company']);
        $password = password_hash(strtolower($firstname), PASSWORD_DEFAULT);

        self::$db_con->query("INSERT users (firstname, middlename, lastname, phone, email, role_id, password) VALUES ('$firstname','$middlename', '$lastname', '$phone', '$email', 3, '$password')");

        $userId = mysqli_insert_id(self::$db_con);

        self::$db_con->query("INSERT INTO transport_company_owners (transport_company_id, user_id) VALUES ('$company', '$userId')");

        if (!mysqli_error(self::$db_con)) {
            Helper::alert_message('success', 'Transporter saved successfully!');
            Util::redirectTo('');
        } else {
            Helper::alert_message('danger', 'Failed to save transporter' . mysqli_error(self::$db_con));
        }
    }

    public static function countVehicles()
    {
        $sql = self::$db_con->query("SELECT count(*) as total FROM vehicles, transport_companies, transport_company_owners 
                                    WHERE vehicles.transport_company_id = transport_companies.id
                                    AND transport_company_owners.transport_company_id = transport_companies.id
                                    AND transport_company_owners.user_id = '" . $_SESSION['id'] . "'");
        return mysqli_fetch_assoc($sql)['total'];
    }

    public static function storeVehicles()
    {
        return 'Hello world!';
    }

    public static function getAllVehicles()
    {
        echo 'Hello worldd!';
    }
    public static function registerTransportCompany()
    {
        $company = mysqli_real_escape_string(self::$db_con, $_POST['company']);

        self::$db_con->query("INSERT INTO transport_companies (company_name) VALUES ('$company')");

        if (!mysqli_error(self::$db_con)) {
            Helper::alert_message('success', 'Company successfully added');
            Util::redirectTo('');
        } else {
            Helper::alert_message('danger', 'Failed to add company' . mysqli_error(self::$db_con));
        }
    }

    public static function getAllTransportCompanies()
    {
        $sql = self::$db_con->query("SELECT * FROM transport_companies");
        if (mysqli_num_rows($sql) == 0) {
            echo '<tr>
                    <td colspan="4" class="bg-warning">Currently, there is no registered transport companies!</td>
                </tr>';
        } else {
            $count = 0;
            while ($row = mysqli_fetch_assoc($sql)) {
                $count++;
                echo '
                        <tr>
                            <td>' . $count . '</td>
                            <td>' . $row['company_name'] . '</td>
                            <td>
                                <a class="badge bg-primary">edit</a>&nbsp;
                                <a class="badge bg-danger">delete</a>
                            </td>
                        </tr>
                    ';
            }
        }
    }

    public static function registerVehicle()
    {
        $sql = self::$db_con->query("SELECT transport_company_id as tid FROM transport_company_owners WHERE user_id = '" . $_SESSION['id'] . "'");
        $transportCompanyId = mysqli_fetch_assoc($sql)['tid'];

        $plate = mysqli_real_escape_string(self::$db_con, $_POST['plate']);

        self::$db_con->query("INSERT INTO vehicles (plate_number, transport_company_id) VALUES ('$plate', '$transportCompanyId')");

        if (!mysqli_error(self::$db_con)) {
            Helper::alert_message('success', 'Vehicle successfully added');
            Util::redirectTo('');
        } else {
            Helper::alert_message('danger', 'Failed to add vehicle' . mysqli_error(self::$db_con));
        }
    }

    public static function getAllVehiclesById()
    {
        $sql = self::$db_con->query("SELECT vehicles.* FROM vehicles, transport_companies, transport_company_owners 
                                    WHERE vehicles.transport_company_id = transport_companies.id
                                    AND transport_company_owners.transport_company_id = transport_companies.id
                                    AND transport_company_owners.user_id = '" . $_SESSION['id'] . "'");

        if (mysqli_num_rows($sql) == 0) {
            echo '<tr>
                    <td colspan="4" class="bg-warning">Currently, there is no registered Vehicles!</td>
                </tr>';
        } else {
            $count = 0;
            while ($row = mysqli_fetch_assoc($sql)) {
                $count++;
                echo '
                        <tr>
                            <td>' . $count . '</td>
                            <td>' . $row['plate_number'] . '</td>
                            <td>
                                <a class="badge bg-primary">edit</a>&nbsp;
                                <a class="badge bg-danger">delete</a>
                            </td>
                        </tr>
                    ';
            }
        }
    }
}

TransporterController::init();
