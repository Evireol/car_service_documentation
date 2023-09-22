<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <style>
        a {
            text-decoration: none;
            color: black;
        }

        p {
            margin: 0px 0;
            padding: 0px;
            border: 0px solid #999;
        }
        /* Стили для сообщения */
        .centered-message {
            position: fixed; /* Фиксированная позиция */
            top: 50%; /* Положение по вертикали в 50% */
            left: 50%; /* Положение по горизонтали в 50% */
            transform: translate(-50%, -50%); /* Центрирование по обоим осям */
            background-color: white; /* Фон сообщения */
            padding: 20px; /* Внутренние отступы */
            border: 1px solid #ccc; /* Граничная рамка */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); /* Тень */
            z-index: 9998; /* Позиция над всеми элементами */
        }

        .z-index
        {
            z-index: 9999; /* Позиция над всеми элементами */
        }
    </style>
</head>

<body class="bg-secondary">

    <?php

        $MessageModal = false;
        $MessageModalError = false;

    function select_lead_time()
    {
        if (isset($lead_time)) {
            $rezult = '<p>' . $lead_time . '</p>';
        } else {
            $rezult = '<b>--</b>';
        }

        return $rezult;
    }
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "task tracker";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Ошибка подключения к базе данных: " . $conn->connect_error);
    }

    if (isset($_POST['delete'])) {
        $id = $_POST['id'];

        $sql = "DELETE FROM tasks WHERE id = $id";

        if ($conn->query($sql) === TRUE) {
            $MessageModal = true;
        } else {
            echo "Ошибка удаления строки из базы данных: " . $conn->error;
        }

    }
    
    ?>

<nav class="navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <div class="row justify-content-center py-1">
            <div class="col-6">
                <div class="row justify-content-center">
                    <form method="post" action="" class="w-100"> <!-- Форма для кнопки "Отобразить все" -->
                        <div class="btn-group d-flex justify-content-center" role="group" aria-label="Кнопки">
                            <button id="showAllBtn" name="All" class="btn btn-outline-success" style="background-color: rgb(255, 153, 68); color: rgb(255, 255, 255); white-space: nowrap;" type="submit">Отобразить все</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-6">
                <div class="row justify-content-center">
                    <!-- Отдельная форма для остальных кнопок -->
                        <div class="btn-group d-flex justify-content-center" role="group" aria-label="Кнопки">
                            <button id="showAddBtn" class="btn btn-outline-success" style="background-color: rgb(19, 165, 104); color: rgb(255, 255, 255); white-space: nowrap;" type="submit">Создать запись</button>
                            <button id="showSearchBtn" class="btn btn-outline-success" style="background-color: rgb(255, 153, 68); color: rgb(255, 255, 255); white-space: nowrap;" type="submit">Поиск</button>
                        </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
        document.addEventListener("DOMContentLoaded", function() {
            var body = document.body;
            var jumbotron = body.querySelector(".jumbotron");
            var centeredMessage = document.querySelector(".centered-message");

            // Если элемент с классом "jumbotron" существует, скрываем сообщение
            if (jumbotron) {
                centeredMessage.style.display = "none";
            } else {
                // Иначе, отображаем сообщение
                centeredMessage.style.display = "block";
            }
        });
    </script>

<div class="centered-message">
        <p>Здесь будут отображаться результаты поиска</p>
    </div>

    <div class="modal z-index" id="ModalSearch" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Параметры поиска</h5>
                    <button id="closeModalSearch" type="button" class="close" data-dismiss="modal" aria-label="Закрыть">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" name="SearchForm">
                    <div class="modal-body">

                        <div class="form-group p-1">
                            <label for="exampleInputGos">Гос. номер</label>
                            <input type="text" class="form-control" id="exampleInputGos" name="Gos" placeholder="Введите Гос. номер" data-next-input="exampleInputSurname">
                        </div>
                        <div class="form-group p-1">
                            <label for="exampleInputSurname">Фамилия</label>
                            <input type="text" class="form-control" id="exampleInputSurname" name="Surname" placeholder="Введите Фамилию" data-next-input="exampleInputFirstName">
                        </div>
                        <div class="form-group p-1">
                            <label for="exampleInputFirstName">Имя</label>
                            <input type="text" class="form-control" id="exampleInputFirstName" name="Name" placeholder="Введите Имя" data-next-input="exampleInputPatronymic">
                        </div>
                        <div class="form-group p-1">
                            <label for="exampleInputPatronymic">Отчество</label>
                            <input type="text" class="form-control" id="exampleInputPatronymic" name="Patronymic" placeholder="Введите Отчество" data-next-input="exampleInputmarka">
                        </div>
                        <div class="form-group p-1">
                            <label for="exampleInputmarka">Марка</label>
                            <input type="text" class="form-control" id="exampleInputmarka" name="marka" placeholder="Введите Модель" data-next-input="exampleInputVIN">
                        </div>
                        <div class="form-group p-1">
                            <label for="exampleInputVIN">VIN</label>
                            <input type="text" class="form-control" id="exampleInputVIN" name="VIN" placeholder="Введите VIN" maxlength="17">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button style="background-color: rgb(255, 153, 68);"; id="Search" type="submit" name="Search" class="btn btn-primary">Поиск</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <div class="modal z-index" id="ModalAdd" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Добавление записи</h5>
                    <button id="closeModalAdd" type="button" class="close" data-dismiss="modal" aria-label="Закрыть">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" name="AddForm" id="AddForm">
                    <div class="modal-body">
                        <!-- Здесь размещайте вашу форму -->
                        <div class="form-group p-1">
                            <label for="exampleInputGos2">Гос. номер</label>
                            <input type="text" class="form-control" id="exampleInputGos2" name="Gos" placeholder="Введите Гос. номер" data-next-input="exampleInputSurname2">
                        </div>
                        <div class="form-group p-1">
                            <label for="exampleInputSurname2">Фамилия</label>
                            <input type="text" class="form-control" id="exampleInputSurname2" name="Surname" placeholder="Введите Фамилию" data-next-input="exampleInputFirstName2">
                        </div>
                        <div class="form-group p-1">
                            <label for="exampleInputFirstName2">Имя</label>
                            <input type="text" class="form-control" id="exampleInputFirstName2" name="Name" placeholder="Введите Имя" data-next-input="exampleInputPatronymic2">

                        </div>
                        <div class="form-group p-1">
                            <label for="exampleInputPatronymic2">Отчество</label>
                            <input type="text" class="form-control" id="exampleInputPatronymic2" name="Patronymic" placeholder="Введите Отчество" data-next-input="exampleInputmarka2">
                        </div>
                        <div class="form-group p-1">
                            <label for="exampleInputmarka2">Марка</label>
                            <input type="text" class="form-control" id="exampleInputmarka2" name="marka" placeholder="Введите Модель" data-next-input="exampleInputVIN2">
                        </div>
                        <div class="form-group p-1">
                            <label for="exampleInputVIN2">VIN</label>
                            <input type="text" class="form-control" id="exampleInputVIN2" name="VIN" placeholder="Введите VIN" maxlength="17" data-next-input="exampleInputPhone2">
                        </div>
                        <div class="form-group p-1">
                            <label for="exampleInputPhone2">Телефон:</label>
                            <input type="tel" class="form-control phone-input" id="exampleInputPhone2" name="Phone" placeholder="Введите телефон" maxlength="18" data-next-input="exampleInputDescription2">
                        </div>
                        <div class="form-group p-1">
                            <label for="exampleInputDescription2">Описание:</label>
                            <textarea class="form-control" id="exampleInputDescription2" name="Description" placeholder="Введите описание" rows="5" maxlength="3494"></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button> -->
                        <button style="background-color: rgb(19, 165, 104)"; type="submit" name="Add"  id="AddPostButton" class="btn btn-primary ">Добавить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal z-index" id="successModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <p>Операция успешно выполнена!</p>
            </div>
        </div>
    </div>
    
    </div>
    <div class="modal z-index" id="successModalError" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <p>ОШИБКА при выполнении операции!</p>
            </div>
        </div>
    </div>
    </div>

    <?php
        if (isset($_POST['Edit'])) {
            $id = $_POST['id'];

            $Gos =''; 
            $marka = '';
            $VIN = '';
            $Name = '';
            $Patronymic = '';
            $Surname = '';
    
            $groups = select_and_sorting_groups($Gos, $marka, $VIN, $Name, $Patronymic, $Surname, $id);
        

    echo '
    <div class="modal z-index" style="display: block;" id="ModalEdit" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Редактирование записи</h5>
                    <button id="closeModalEdit" type="button" class="close" data-dismiss="modal" aria-label="Закрыть">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" name="EditForm" id="EditForm">
                    <div class="modal-body">';

                        foreach ($groups as $row) {
                            $rezult = select_id_row($row['id'], $groups);
                
                            $NameEdit = $rezult['result_Name'];
                            $SurnameEdit = $rezult['result_Surname'];
                            $PatronymicEdit = $rezult['result_Patronymic'];
                            $gosEdit = $rezult['result_gos'];
                            $descriptionEdit = $rezult['result_description'];
                            $PhoneEdit = $rezult['result_Phone'];
                            $VINEdit = $rezult['result_VIN'];
                            $markaEdit = $rezult['result_marka'];

                        echo '<div class="form-group">
                        <input type="hidden" name="idEdit" value='. $id .'>
                            <label for="exampleInputGos2"> Гос. номер</label>
                            <input type="text" class="form-control" id="exampleInputGos2" name="GosEdit" placeholder="Введите Гос. номер" value="'. $gosEdit .'" data-next-input="exampleInputSurname2">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputSurname2">Фамилия</label>
                            <input type="text" class="form-control" id="exampleInputSurname2" name="SurnameEdit" placeholder="Введите Фамилию" value="'. $SurnameEdit .'" data-next-input="exampleInputFirstName2">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFirstName2">Имя</label>
                            <input type="text" class="form-control" id="exampleInputFirstName2" name="NameEdit" placeholder="Введите Имя" value="'. $NameEdit .'" data-next-input="exampleInputPatronymic2">

                        </div>
                        <div class="form-group">
                            <label for="exampleInputPatronymic2">Отчество</label>
                            <input type="text" class="form-control" id="exampleInputPatronymic2" name="PatronymicEdit" placeholder="Введите Отчество" value="'. $PatronymicEdit .'" data-next-input="exampleInputmarka2">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputmarka2">Марка</label>
                            <input type="text" class="form-control" id="exampleInputmarka2" name="markaEdit" placeholder="Введите Модель" value="'. $markaEdit .'" data-next-input="exampleInputVIN2">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputVIN2">VIN</label>
                            <input type="text" class="form-control" id="exampleInputVINedit" name="VINEdit" placeholder="Введите VIN" value="'. $VINEdit .'" maxlength="17" data-next-input="exampleInputPhone2">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPhone2">Телефон:</label>
                            <textarea class="form-control phone-input" rows="1" style="resize: none;" id="exampleInputPhone3" name="PhoneEdit" placeholder="Введите телефон" maxlength="18" data-next-input="exampleInputDescription2"> '.$PhoneEdit.'</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputDescription2">Описание:</label>
                            <textarea class="form-control" id="exampleInputDescription2" name="DescriptionEdit" placeholder="Введите описание" rows="5" maxlength="3494">'.$descriptionEdit.'</textarea>
                        </div>
                    </div>
                    

                    <div class="modal-footer">
                        <button style="background-color: rgb(255, 255, 255); color: rgb(0, 0, 0);  border-color: rgb(0, 0, 0)"; type="submit" name="EditPost" id="EditPostButton" class="btn btn-primary ">Редактировать</button>
                    </div>
                </form>
                ';
                        break; } }'
            </div>
        </div>
    </div>';

    $conn->close();

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "task tracker";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Ошибка подключения к базе данных: " . $conn->connect_error);
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Search'])) {
        $Gos = isset($_POST["Gos"]) ? $_POST["Gos"] : "";
        $Surname = isset($_POST["Surname"]) ? $_POST["Surname"] : "";
        $Name = isset($_POST["Name"]) ? $_POST["Name"] : "";
        $Patronymic = isset($_POST["Patronymic"]) ? $_POST["Patronymic"] : "";
        $marka = isset($_POST["marka"]) ? $_POST["marka"] : "";
        $VIN = isset($_POST["VIN"]) ? $_POST["VIN"] : "";
        $id = '';

        $conn->close();

        $groups = select_and_sorting_groups($Gos, $marka, $VIN, $Name, $Patronymic, $Surname, $id);
        display_tasks($groups);
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['All'])) {
        $conn->close();
        $groups = select_all_groups();
        display_tasks($groups);
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Add'])) {
        $Gos = isset($_POST["Gos"]) ? $_POST["Gos"] : "";
        $Surname = isset($_POST["Surname"]) ? $_POST["Surname"] : "";
        $Name = isset($_POST["Name"]) ? $_POST["Name"] : "";
        $Patronymic = isset($_POST["Patronymic"]) ? $_POST["Patronymic"] : "";
        $Phone = isset($_POST["Phone"]) ? $_POST["Phone"] : "";
        $marka = isset($_POST["marka"]) ? $_POST["marka"] : "";
        $VIN = isset($_POST["VIN"]) ? $_POST["VIN"] : "";
        $Description = isset($_POST["Description"]) ? $_POST["Description"] : "";

        $conn->close();

        Add_groups($Gos, $marka, $VIN,$Description, $Name, $Patronymic,$Phone, $Surname);

        // $MessageModal = true;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['EditPost'])) {
        $id = isset($_POST["idEdit"]) ? $_POST["idEdit"] : ""; 
        $Gos = isset($_POST["GosEdit"]) ? $_POST["GosEdit"] : "";
        $Surname = isset($_POST["SurnameEdit"]) ? $_POST["SurnameEdit"] : "";
        $Name = isset($_POST["NameEdit"]) ? $_POST["NameEdit"] : "";
        $Patronymic = isset($_POST["PatronymicEdit"]) ? $_POST["PatronymicEdit"] : "";
        $marka = isset($_POST["markaEdit"]) ? $_POST["markaEdit"] : "";
        $VIN = isset($_POST["VINEdit"]) ? $_POST["VINEdit"] : "";
        $Phone = isset($_POST["PhoneEdit"]) ? $_POST["PhoneEdit"] : "";
        $Description = isset($_POST["DescriptionEdit"]) ? $_POST["DescriptionEdit"] : "";


        $conn->close();

        if (
            empty($Gos) &&
            empty($Surname) &&
            empty($Name) &&
            empty($Patronymic) &&
            empty($marka) &&
            empty($VIN) &&
            empty($Phone) &&
            empty($Description)
        ) {
            // echo '<script>alert("Пожалуйста, заполните хотя бы одно поле перед отправкой формы.");</script>';

        } else {
        Edit_groups($Gos, $marka, $VIN, $Name, $Patronymic, $Surname, $Phone, $Description, $id);
        }
        
    }

    function display_tasks($groups)
    {
        foreach ($groups as $row) {
            $rezult = select_id_row($row['id'], $groups);

            $Name = $rezult['result_Name'];
            $Surname = $rezult['result_Surname'];
            $Patronymic = $rezult['result_Patronymic'];
            $gos = $rezult['result_gos'];
            $description = $rezult['result_description'];
            $Phone = $rezult['result_Phone'];
            $VIN = $rezult['result_VIN'];
            $marka = $rezult['result_marka'];
            $lead_time = $rezult['result_lead_time'];



            echo

        '<div class="jumbotron jumbotron-fluid mt-3 mb-3">
        <div class="container bg-light rounded-2" id="container-data">
    
            <div class="row justify-content-center pt-3">
                <div class="col-6">
                        <div class="row justify-content-start">
                            <div class="col-md-auto">
                                <a class="navbar-brand" href="#">
                                <img src="icon.png" width="50" height="50" alt="">
                                </a>
                            </div>
                            <div class="col-md-auto">
                                 <p>' . $Name . " ".  $Patronymic ." ". $Surname . '</p> 
                            </div>
                        </div>
                    </div>
            

                <div class="col-6">
                    <div class="row justify-content-end">
                        <div class="col-md-auto col-sm-auto dropdown justify-content-end">
                            <button class="btn dropdown-toggle" type="button" id="dropdownMenuItems" data-bs-toggle="dropdown" aria-expanded="false">
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuItems">
                            <form id="deleteForm" class="DelForm" method="post" action="">
                            <input type="hidden" name="id" value='. $row['id'] .'>
                            <li>
                                <button class="dropdown-item DelButton" name="delete" id="deleteButton" type="submit" value="Удалить">Удалить</button>
                            </li>
                            <li>
                                <button class="dropdown-item" name="Edit" id="showEditBtn" type="submit">Редактировать</button>
                            </li>
                        </form>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row py-1 justify-content-start">
            <div class="col">
            <b>' . $gos . '</b>
            </div>
        </div>
        <div class="row justify-content-center py-1">
            <div class="col" style="height: auto;">
            <textarea readonly style="height: auto;     width: 100% ; min-height: 4em;
            background-color: transparent;"
            >' . $description . '</textarea>
            </div>
        </div>
        <div class="row justify-content-center pb-3 mt-3">
            <div class="col">


                <div class="row justify-content-start">
                    <div class="col">
                        <div class="row justify-content-start">
                            <div class="col">
                                VIN:
                            </div>
                        </div>
                        <div class="row justify-content-start mt-2">
                            <div class="col">
                                <span class="input-group-text" width="50">
                                    <p>' . $VIN . '</p>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="row justify-content-start">
                            <div class="col">
                                Телефон:
                            </div>
                        </div>
                        <div class="row justify-content-start mt-2">
                            <div class="col">
                                <span class="input-group-text" width="50">' . $Phone . '
                                    
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            
            <div class="col">
                <div class="row justify-content-end">
                    <div class="col">
                        <div class="row justify-content-start">
                            <div class="col">
                                Модель:
                            </div>
                        </div>
                        <div class="row justify-content-start mt-2">
                            <div class="col">
                                <span class="input-group-text" width="50">
                                    <p>' . $marka . '</p>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="row justify-content-start">
                            <div class="col">
                                Дата создания:
                            </div>
                        </div>
                        <div class="row justify-content-start mt-2">
                            <div class="col">
                                <span class="input-group-text" width="50">' . $lead_time . '
                                    
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>';
        }
    }

    function select_all_groups()
    {
        $db = new mysqli('localhost', 'root', '', 'task tracker');

        $result = mysqli_query($db, "SELECT * FROM `tasks` ");

        $groups = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $groups[] = $row;
        }
        $db->close();

        return $groups;
    }


    function select_and_sorting_groups($Gos, $marka, $VIN, $Name, $Patronymic, $Surname, $id)
    {
        $db = new mysqli('localhost', 'root', '', 'task tracker');

        $result = mysqli_query($db, "SELECT * FROM `tasks` WHERE gos = '$Gos' or marka = '$marka' or VIN = '$VIN' or Name = '$Name' or Patronymic = '$Patronymic' or Surname = '$Surname' or id = '$id'");

        $groups = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $groups[] = $row;
        }

        $db->close();

        return $groups;
    }

    function Add_groups($Gos, $marka, $VIN,$Description, $Name, $Patronymic,$Phone, $Surname)
    {
        global $MessageModal, $MessageModalError;
        $db = new mysqli('localhost', 'root', '', 'task tracker');

        $query ="INSERT INTO `tasks` (gos, marka, VIN, description, Name, Patronymic, Phone, Surname, lead_time) VALUES ('$Gos', '$marka', '$VIN','$Description', '$Name', '$Patronymic','$Phone', '$Surname', NOW())";

        if (mysqli_query($db, $query)) {
            $MessageModal = true;
        } else {
            $MessageModalError = true;
        }

        $db->close();

    }

    function Edit_groups($Gos, $marka, $VIN, $Name, $Patronymic, $Surname, $Phone, $Description, $id)
    {
        global $MessageModal, $MessageModalError;
        $db = new mysqli('localhost', 'root', '', 'task tracker');

        $query = "UPDATE `tasks` SET gos='$Gos', marka = '$marka', VIN = '$VIN', Name = '$Name', Patronymic='$Patronymic', Surname = '$Surname', Phone = '$Phone', description = '$Description' WHERE id = '$id'";

        if (mysqli_query($db, $query)) {
            $MessageModal = true;
        } else {
            $MessageModalError = true;
        }
    
        $db->close();
    }
    

    function select_id_row($id,$groups)
    {
        $result = array(
            'result_Name' => '0',
            'result_Surname' => '0',
            'result_Patronymic' => '0',
            'result_gos' => '0',
            'result_description' => '0',
            'result_marka' => '0',
            'result_lead_time' => '0',
            'result_VIN' => '0',
            'result_Phone' => '0'
        );

        foreach ($groups as $groups_row) {
            if ($groups_row['id'] == $id) { 
                $result['result_Name'] = $groups_row['Name'];
                $result['result_Surname'] = $groups_row['Surname'];
                $result['result_Patronymic'] = $groups_row['Patronymic'];
                $result['result_gos'] = $groups_row['gos'];
                $result['result_description'] = $groups_row['description'];
                $result['result_marka'] = $groups_row['marka'];
                $result['result_lead_time'] = $groups_row['lead_time'];
                $result['result_VIN'] = $groups_row['VIN'];
                $result['result_Phone'] = $groups_row['Phone'];

                break; // Остановка цикла после первого совпадения
            }
        }

        return $result;
    }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script>
        $(document).ready(function() {


            //Поиск

            $("#showSearchBtn").click(function() {
                $("#ModalSearch").modal('show');
            });

            $("#closeModalSearch").click(function() {
                $("#ModalSearch").modal('hide');
            });

            $("#Search").click(function() {
                var inputValue = $("#exampleInputName").val();
            });

            //Добавление

            $("#showAddBtn").click(function() {
                $("#ModalAdd").modal('show');
            });

            $("#closeModalAdd").click(function() {
                $("#ModalAdd").modal('hide');
            });

            $("#Add").click(function() {
                var inputValue = $("#exampleInputName").val();
            });

            $(document).ready(function() {
                $('#exampleInputPhone2, #exampleInputPhone3').inputmask("+7 (999) 999-9999"); // Замените на нужный формат
            });

            //Редактирование

    });


    console.log($("#closeModalEdit"))
        $(document).on("click", "#closeModalEdit", function() {
        var modal = document.getElementById('ModalEdit');
        modal.style.display = 'none'; 
        });

        // Информирование по успешности операции

        <?php if (isset($MessageModal) && $MessageModal) { ?>
    $(document).ready(function() {
        // Открываем модальное окно
        $("#successModal").modal("show");

        // Закрываем модальное окно через 3 секунды (или другое нужное время)
        setTimeout(function() {
            $("#successModal").modal("hide");
        }, 3000); // 3000 миллисекунд = 3 секунды
    });
    <?php } ?>

    <?php if (isset($MessageModalError) && $MessageModalError) { ?>
    $(document).ready(function() {
        $("#successModalError").modal("show");

        setTimeout(function() {
            $("#successModalError").modal("hide");
        }, 3000);
    });


    <?php } ?>

    document.addEventListener("DOMContentLoaded", function() {
        var form = document.getElementById("AddForm");
        form.addEventListener("submit", function(event) {
            var atLeastOneFieldFilled = false;

            var inputs = form.querySelectorAll("input[type=text], input[type=tel], textarea");
            inputs.forEach(function(input) {
                if (input.value.trim() !== "") {
                    atLeastOneFieldFilled = true;
                }
            });

            if (!atLeastOneFieldFilled) {
                alert("Пожалуйста, заполните хотя бы одно поле перед отправкой формы.");
                event.preventDefault(); // Отменяет отправку формы
            }
        });
    });
    
    document.addEventListener("DOMContentLoaded", function() {
        var editPostButton = document.getElementById("EditPostButton");  

        editPostButton.addEventListener("click", function(event) {
    console.log("Клик на кнопке EditPost");
    // ... ваша проверка формы ...
        });

        editPostButton.addEventListener("click", function(event) {
            var editForm = document.getElementById("EditForm");
            var atLeastOneFieldFilled = false;

            var inputs = editForm.querySelectorAll("input[type=text], input[type=tel], textarea");
            inputs.forEach(function(input) {
                if (input.value.trim() !== "") {
                    atLeastOneFieldFilled = true;
                }
            });

            if (!atLeastOneFieldFilled) {
                alert("Пожалуйста, заполните хотя бы одно поле перед отправкой формы.");
                event.preventDefault(); // Отменяет отправку формы
            }
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        var editPostButton = document.getElementById("EditPostButton");  

        editPostButton.addEventListener("click", function(event) {
    console.log("Клик на кнопке EditPost");
    // ... ваша проверка формы ...
});

        editPostButton.addEventListener("click", function(event) {
            var editForm = document.getElementById("EditForm");
            var atLeastOneFieldFilled = false;

            var inputs = editForm.querySelectorAll("input[type=text], input[type=tel], textarea");
            inputs.forEach(function(input) {
                if (input.value.trim() !== "") {
                    atLeastOneFieldFilled = true;
                }
            });

            if (!atLeastOneFieldFilled) {
                alert("Пожалуйста, заполните хотя бы одно поле перед отправкой формы.");
                event.preventDefault(); // Отменяет отправку формы
            }
        });
    });

    //Для смешения через Enter по полям

        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('input[data-next-input]');
            inputs.forEach((input, index) => {
                input.addEventListener('keypress', function(event) {
                    if (event.key === 'Enter') {
                        event.preventDefault();
                        const nextInputId = input.getAttribute('data-next-input');
                        if (nextInputId) {
                            const nextInput = document.getElementById(nextInputId);
                            if (nextInput) {
                                nextInput.focus();
                            }
                        }
                    }
                });
            });
        });

        // Получаем все элементы с классом "DelForm" 
        var deleteForms = document.querySelectorAll('.DelForm');

        // Добавляем обработчик события для каждой формы
        deleteForms.forEach(function(form) {
            form.addEventListener('submit', function(event) {

                var button = event.submitter; // Получаем кнопку, которая вызвала отправку формы
                if (button && button.classList.contains('DelButton')) {

                    var confirmed = confirm('Уверены что хотите удалить?');
                    if (confirmed)
                    { 
                        event.currentTarget.submit();
                    }
                    else 
                    {  
                        // Если пользователь нажал "Отмена" (нет), ничего не делаем 
                    event.preventDefault();  
                    }  
                }
            }); 
        });


        
    </script>
</body>

</html>