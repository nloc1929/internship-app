<?php

use Illuminate\Support\Facades\Route;


/* ------------------------------------- PROJECTS HOME PAGE -------------------------------------- */

// DISPLAY LIST OF ALL PROJECTS DATABASE ENTRIES AS LINKS
// PROJECT LIST ROUTE DISPLAYS FULL PROJECT LIST
Route::get('/', function () {
    $errorMessage = "";
    $sql = "SELECT * FROM PROJECTS";
    $projects = DB::select($sql);
    $sql2 = "SELECT * FROM PARTNERS";
    $partners = DB::select($sql2);
    $sql3 = "SELECT * FROM STUDENTS";
    $students = DB::select($sql3);
    return view('projects.project_list')->with('projects', $projects)->with('students', $students);
});


/* ------------------------------------- PROJECT DETAILS PAGE -------------------------------------- */

// DISPLAYING ALL DATA FOR SINGLE PROJECT DATABASE ENTRY //
// PROJECT DETAIL ROUTE DISPLAYS EACH PROJECT ON A NEW PAGE
Route::get('project_detail/{id}', function ($id) {
    $project = get_project($id);
    $students = get_student($id);
    return view('projects.project_detail')->with('project', $project)->with('students', $students);
}); 
// FUNCTION TO RETRIEVE PROJECT DATA AND DISPLAY ON INDIVIDUAL PROJECT PAGES
function get_project($id) {
    $sql = "SELECT * FROM PROJECTS WHERE ID=?";
    $projects = DB::select($sql, array($id));
    if (count($projects) != 1) {
        die("Error! Invalid query or result: $sql");
    }
    $project = $projects[0];
    return $project;
};
// FUNCTION TO RETRIEVE ASSOCIATED STUDENTS DATA AND DISPLAY ON INDIVIDUAL PROJECT PAGES
function get_student($id) {
    $int_val = intval($id);
    $students = DB::select("SELECT * FROM STUDENTS WHERE PROJECT_A = '$int_val' OR PROJECT_B = '$int_val' OR PROJECT_C = '$int_val'");
    return $students;
};


/* ------------------------------------- ADVERTISE PROJECT PAGE -------------------------------------- */

// ADDING NEW PROJECT AND PARTNER TO DATABASE //
// ADD PROJECT ROUTE TO ADD ADVERTISE PROJECT FORM
Route::get('add_project', function () {
    $errorMessage = "";
    return view('projects.add_project')->with('errorMessage', $errorMessage);
});

// ADDS NEW PROJECT TO DATABASE AND TRANSFERS DATA TO PARTNERS DATABASE
Route::post('add_project_action', function () {
    $id = request('ID');
    $title = request('TITLE');
    $title = htmlspecialchars($title);
    $partner = request('PARTNER');
    $partner = htmlspecialchars($partner);
    $location = request('LOCATION');
    $location = htmlspecialchars($location);
    $field = request('FIELD');
    $field = htmlspecialchars($field);
    $description = request('DESCRIPTION');
    $description = htmlspecialchars($description);
    $studentNum = request('STUDENT_NUM');
    $checkPartnerId = check_partners($partner);
    $errorMessage = request('errorMessage');
    $int_val = intval($studentNum);
    // INPUT VALIDATION CHECK
    if ($title == "" || $partner == "" || $location == "" || $field == "" || $description == "" || $studentNum == "") {
        $errorMessage = "* At least one field must contain value.";
        return view('projects.add_project')->with('errorMessage', $errorMessage);
    } else if ($int_val < 3 || $int_val > 8) {
        $errorMessage = "* Please enter a number between 3 and 8 for Students Required";
        return view('projects.add_project')->with('errorMessage', $errorMessage);
    }
    if ($checkPartnerId) {
        // EXISTING PARTNER ENTRY 
        // select partner.id and make projects.partner_id = partner.id
        $partnerId = $checkPartnerId;
        $int_val = intval($partnerId);
        $projectId = DB::select("SELECT MAX(ID) AS maxPID FROM PROJECTS");
        $maxPID = $projectId[0];
        $maxPID2 = $maxPID->maxPID;
        $int_PID = intval($maxPID2);
        $int_PID += 1; 
        $id1 = add_project($int_PID, $title, $partner, $location, $field, $description, $studentNum, $int_val);
        if ($id1) {
            return redirect(url("project_detail/$id1"));
        } else {
            die("Error! project NOT added.");
        }
    } else if (!$checkPartnerId) {
        // NEW PARTNER ENTRY 
        // select next available partner.id = MAX(ID) and make projects.partner_id = MAX(ID)
        $partnerId = DB::select("SELECT MAX(ID) AS maxId FROM PARTNERS");
        $maxId = $partnerId[0];
        $maxId2 = $maxId->maxId;
        $int_val = intval($maxId2);
        $int_val += 1;        
        $projectId = DB::select("SELECT MAX(ID) AS maxPID FROM PROJECTS");
        $maxPID = $projectId[0];
        $maxPID2 = $maxPID->maxPID;
        $int_PID = intval($maxPID2);
        $int_PID += 1; 
        $id1 = add_partner($partner, $location);
        $id2 = add_project($int_PID, $title, $partner, $location, $field, $description, $studentNum, $int_val);
        if ($id1 || $id2) {
            return redirect(url("project_detail/$id2"));
        } else {
            die("Error! project NOT added.");
        }
    }
});
// FUNCTION CHECKS PARTNERS TABLE IF PARTNER ALREADY EXISTS
function check_partners($partnerName) {
    $id = DB::select("SELECT distinct PARTNERS.ID FROM PROJECTS, PARTNERS WHERE partners.company = '$partnerName'");
    if (!$id) {
        return null;
    } else {
        $id2 = $id[0];
        $partnerId = $id2->ID;
        return $partnerId;
    }
};
// FUNCTION ADDS NEW PARTNER TO PARTNERS DATABASE
function add_partner($partner, $location) {
    $sql = "INSERT INTO PARTNERS (COMPANY, LOCATION) VALUES (?, ?)";
    DB::insert($sql, array($partner, $location));
    $id = DB::getPdo()->lastInsertId();
    return $id;
};
// FUNCTION ADDS NEW PROJECT TO PROJECTS DATABASE
function add_project($int_PID, $title, $partner, $location, $field, $description, $studentNum, $partnerId) {
    $sql = "INSERT INTO PROJECTS (ID, TITLE, PARTNER, LOCATION, FIELD, DESCRIPTION, STUDENT_NUM, PARTNER_ID) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    DB::insert($sql, array($int_PID, $title, $partner, $location, $field, $description, $studentNum, $partnerId));
    return $int_PID;
};


/* ------------------------------------- UPDATE PROJECT PAGE -------------------------------------- */

// UPDATING EXISTING PROJECT IN PROJECTS DATABASE
// UPDATE PROJECT ROUTE TO RETRIEVE PROJECT INFORMATION AND DIRECT TO UPDATE PROJECT FORM
Route::get('update_project/{id}', function ($id) {
    $project = get_project($id);
    $errorMessage = "";
    return view('projects.update_project')->with('project', $project)->with('errorMessage', $errorMessage);
});

// UPDATE PROJECT ACTION FORM EXECUTES WHEN USER UPDATES AND SUBMITS FORM, DIRECTS TO PROJECT DETAILS PAGE
Route::post('update_project_action', function () {
    $id = request('ID');
    $title = request('TITLE');
    $title = htmlspecialchars($title);
    $field = request('FIELD');
    $field = htmlspecialchars($field);
    $description = request('DESCRIPTION');
    $description = htmlspecialchars($description);
    $studentNum = request('STUDENT_NUM');
    $errorMessage = request('errorMessage');
    $project = get_project($id);
    // INPUT VALIDATION CHECK
    if ($title == "" || $field == "" || $description == "" ||$studentNum == "") {
        $errorMessage = "* All fields must be entered";
        return view('projects.update_project')->with('project', $project)->with('errorMessage', $errorMessage);
    }
    update_project($id, $title, $field, $description, $studentNum);
    update_students($id, $title);
    return redirect(url("project_detail/$id"));
});
// FUNCTION TO UPDATE EXISTING PROJECT DATA
function update_project($id, $title, $field, $description, $studentNum) {
    $sql = "UPDATE PROJECTS SET TITLE = ?, FIELD = ?, DESCRIPTION = ?, STUDENT_NUM = ? WHERE ID = ?";
    DB::update($sql, array($title, $field, $description, $studentNum, $id));
};
// FUNCTION TO UPDATE CORRESPONDING INFORMATION IN STUDENTS DATABASE
function update_students($id, $title) {
    $int_val = intval($id);
    $sql = "UPDATE STUDENTS SET TITLE_A = ? WHERE PROJECT_A = ?";
    DB::update($sql, array($title, $int_val));
    $sql = "UPDATE STUDENTS SET TITLE_B = ? WHERE PROJECT_B = ?";
    DB::update($sql, array($title, $int_val));
    $sql = "UPDATE STUDENTS SET TITLE_C = ? WHERE PROJECT_C = ?";
    DB::update($sql, array($title, $int_val));
}


/* ---------------------------------------------- DELETE PROJECT PAGE --------------------------------------------- */

// DELETING EXISTING ENTRY FROM DATABASE
// DELETE PROJECT ROUTE TO RETRIEVE project INFORMATION AND DIRECT TO DELETE PROJECT FORM
Route::get('delete_project/{id}', function ($id) {
    $project = get_project($id);
    return view('projects.delete_project')->with('project', $project);
});

// DELETE PROJECT ACTION FORM EXECUTES WHEN USER UPDATES AND SUBMITS FORM, DIRECTS TO PROJECT DETAILS PAGE
Route::post('delete_project_action', function () {
    $id = request('id');
    update_student_pref($id);
    delete_project($id);
    return redirect(url("/"));
});
// FUNCTION TO DELETE ENTIRE PROJECT FROM PROJECTS DATABASE
function delete_project($id) {
    $sql = "DELETE FROM PROJECTS WHERE id = ?";
    DB::delete($sql, array($id));
};
// FUNCTION TO DELETE ASSOCIATED PROJECT DATA IN STUDENTS DATABASE
function update_student_pref($id) {
    $int_val = intval($id);
    $title = "";
    $partner = "";
    $justText = "";
    $sql = "UPDATE STUDENTS SET PROJECT_A = ?, TITLE_A = ?, PARTNER_A = ?, JUST_TEXT_A = ? WHERE PROJECT_A = ?";
    DB::update($sql, array(0, $title, $partner, $justText, $int_val));
    $sql = "UPDATE STUDENTS SET PROJECT_B = ?, TITLE_B = ?, PARTNER_B = ?, JUST_TEXT_B = ? WHERE PROJECT_B = ?";
    DB::update($sql, array(0, $title, $partner, $justText, $int_val));
    $sql = "UPDATE STUDENTS SET PROJECT_C = ?, TITLE_C = ?, PARTNER_C = ?, JUST_TEXT_C = ? WHERE PROJECT_C = ?";
    DB::update($sql, array(0, $title, $partner, $justText, $int_val));
}


/* ------------------------------------- STUDENT APPLY FOR PROJECT PAGE -------------------------------------- */

// ADDING NEW STUDENT TO STUDENTS DATABASE VIA PROJECT APPLICATION FORM
// ADD STUDENTS ROUTE TO APPLY PROJECT FORM
Route::get('apply_project/{id}', function ($id) {
    $project = get_project($id);
    $errorMessage = "";
    return view('projects.apply_project')->with('project', $project)->with('errorMessage', $errorMessage);
});
// RETRIEVES FORM DATA TO ADD TO STUDENTS DATABASE
Route::post('apply_project_action', function () {
    $projectId = request('PID');
    $title = request('TITLE');
    $partner = request('PARTNER');
    $project = get_project($projectId);
    $id = request('ID');
    $firstName = request('FIRST_NAME');
    $firstName = htmlspecialchars($firstName);
    $lastName = request('LAST_NAME');
    $lastName = htmlspecialchars($lastName);
    $justText = request('JUST_TEXT');
    $justText = htmlspecialchars($justText);
    $projectNum = request('PROJECT_NUM');
    $errorMessage = request('errorMessage');
    $checkStudent = true;
    // INPUT VALIDATION CHECK
    $checkStudent = check_student($projectId, $firstName, $lastName);
    if ($firstName == "" || $lastName == "" || $justText == "" ||$projectNum == "") {
        $errorMessage = "* At least one field must contain value.";
        return view('projects.apply_project')->with('project', $project)->with('errorMessage', $errorMessage);
    }
    if ($checkStudent) {
        // STUDENT HAS NOT ALREADY APPLIED FOR THIS PROJECT -> PROCESS FORM
        $checkAllStudents = check_all_students($firstName, $lastName);
        if (!$checkAllStudents) {
            // STUDENT IS NEW TO SYSTEM -> ADD NEW STUDENT TO DATABASE
            add_new_student($projectId, $title, $partner, $id, $firstName, $lastName, $justText, $projectNum);
            update_project_apps($projectId);
            return redirect(url("project_detail/$projectId"));
        } else if ($checkAllStudents) {
            // STUDENT EXISTS IN SYSTEM -> UPDATE EXISTING STUDENT IN DATABASE
            update_existing_student($projectId, $title, $partner, $projectNum, $justText, $firstName, $lastName);
            update_project_apps($projectId);
            return redirect(url("project_detail/$projectId"));
        }
    } else if (!$checkStudent) {
        // STUDENT HAS ALREADY APPLIED FOR THIS PROJECT -> DO NOT PROCESS FORM
        $errorMessage = "You have already applied";
        return view('projects.apply_project')->with('project', $project)->with('errorMessage', $errorMessage);
    }
});

// FUNCTION TO CHECK IF STUDENT NAME MATCHES ANY OTHER STUDENT WHO HAS APPLIED FOR THIS PROJECT
function check_student($projectId, $firstName, $lastName) {
    $int_val = intval($projectId);
    $students = DB::select("SELECT * FROM STUDENTS WHERE PROJECT_A = '$int_val' OR PROJECT_B = '$int_val' OR PROJECT_C = '$int_val'");
    $flag = true;
    if (count($students) == 0) {
        return true;
    } else {
        for ($i = 0; $i < count($students); $i++) {
            $student = $students[$i];
            if ($student->FIRST_NAME == $firstName && $student->LAST_NAME == $lastName) {
                $flag = false;
            }
        }
        if ($flag == false) {
            return false;
        } else if ($flag == true) {
            return true;
        }
    }
};
// FUNCTION TO CHECK IF STUDENT NAME MATCHES ALREADY EXISTS IN STUDENTS DATABASE
function check_all_students($firstName, $lastName) {
    $students = DB::select("SELECT * FROM STUDENTS WHERE FIRST_NAME = '$firstName' AND LAST_NAME = '$lastName'");
    $flag = true;
    if (count($students) == 0) {
        return false;
    } else {
        return true;
    }
};
// FUNCTION TO ADD NEW STUDENT TO STUDENTS DATABASE
function add_new_student($projectId, $title, $partner, $id, $firstName, $lastName, $justText, $projectNum) {
    $int_val = intval($projectNum);
    $projectInt = intval($projectId);
    $student = DB::select("SELECT * FROM STUDENTS WHERE FIRST_NAME = '$firstName' AND LAST_NAME = '$lastName'");
    if ($int_val == 1) {
        $sql = "INSERT INTO STUDENTS (ID, FIRST_NAME, LAST_NAME, PROJECT_A, TITLE_A, PARTNER_A, JUST_TEXT_A) VALUES (?, ?, ?, ?, ?, ?, ?)";
        DB::insert($sql, array($id, $firstName, $lastName, $projectInt, $title, $partner, $justText));
        $id = DB::getPdo()->lastInsertId();
        return $id;
    } else if ($int_val == 2) {
        $sql = "INSERT INTO STUDENTS (ID, FIRST_NAME, LAST_NAME, PROJECT_B, TITLE_B, PARTNER_B, JUST_TEXT_B) VALUES (?, ?, ?, ?, ?, ?, ?)";
        DB::insert($sql, array($id, $firstName, $lastName, $projectInt, $title, $partner, $justText));
        $id = DB::getPdo()->lastInsertId();
        return $id;
    } else if ($int_val == 3) {
        $sql = "INSERT INTO STUDENTS (ID, FIRST_NAME, LAST_NAME, PROJECT_C, TITLE_C, PARTNER_C, JUST_TEXT_C) VALUES (?, ?, ?, ?, ?, ?, ?)";
        DB::insert($sql, array($id, $firstName, $lastName, $projectInt, $title, $partner, $justText));
        $id = DB::getPdo()->lastInsertId();
        return $id;
    }
};

// FUNCTION TO ADD PROJECT DETAILS TO PREFERENCE SLOT OF EXISTING STUDENT IN STUDENTS DATABASE
function update_existing_student($projectId, $title, $partner, $projectNum, $justText, $firstName, $lastName) {
    $int_val = intval($projectNum);
    $projectInt = intval($projectId);
    if ($int_val == 1) {
        $sql = "UPDATE STUDENTS SET PROJECT_A = ?, TITLE_A = ?, PARTNER_A = ?, JUST_TEXT_A = ? WHERE FIRST_NAME = ? AND LAST_NAME = ?";
        DB::update($sql, array($projectInt, $title, $partner, $justText, $firstName, $lastName));
    } else if ($int_val == 2) {
        $sql = "UPDATE STUDENTS SET PROJECT_B = ?, TITLE_B = ?, PARTNER_B = ?,  JUST_TEXT_B = ? WHERE FIRST_NAME = ? AND LAST_NAME = ?";
        DB::update($sql, array($projectInt, $title, $partner, $justText, $firstName, $lastName));
    } else if ($int_val == 3) {
        $sql = "UPDATE STUDENTS SET PROJECT_C = ?, TITLE_C = ?, PARTNER_C = ?,  JUST_TEXT_C = ? WHERE FIRST_NAME = ? AND LAST_NAME = ?";
        DB::update($sql, array($projectInt, $title, $partner, $justText, $firstName, $lastName));
    }
};
// FUNCTION TO INCREMENT SELECTED PROJECT'S TOTAL NUMBER OF APPLICATIONS COUNT
function update_project_apps($pid) {
    $int_val = intval($pid);
    $appNumber = DB::select("SELECT APP_NUMBER FROM PROJECTS WHERE ID = '$int_val'");
    $appNumber2 = $appNumber[0];
    $appNumber3 = $appNumber2->APP_NUMBER;
    $int_val2 = intval($appNumber3) + 1;
    $sql = "UPDATE PROJECTS SET APP_NUMBER = ? WHERE ID = ?";
    DB::update($sql, array($int_val2, $int_val));
};


/* --------------------------------------------------- STUDENTS LIST PAGE --------------------------------------------------- */

// STUDENT LIST ROUTE DISPLAYS ALL STUDENTS AND THEIR DETAILS
Route::get('student_list', function () {
    $sql = "SELECT * FROM STUDENTS";
    $students = DB::select($sql);
    return view('students.student_list')->with('students', $students);
});


/* ------------------------------------------------- TOP 3 PARTNERS LIST PAGE ------------------------------------------------- */

// PARTNERS LIST ROUTE DISPLAYS TOP 3 PARTNERS AND THEIR DETAILS
Route::get('partners_list', function () {
    $sql = "SELECT * FROM PARTNERS";
    $partners = DB::select($sql);
    $top3Partners = get_top_partners();
    return view('partners.partners_list')->with('top3Partners', $top3Partners);
});
// FUNCTION TO COUNT THE FREQUENCY OF EACH PARTNER_ID OCCURING IN ALL PROJECTS, SELECTING THE TOP THREE IN DESCENDING ORDER
function get_top_partners() {
    $id = DB::select("SELECT PARTNER, COUNT(PARTNER_ID) AS 'projects' FROM PROJECTS GROUP BY PARTNER ORDER BY COUNT(PARTNER_ID) DESC LIMIT 3");
    return $id;
};

/* ------------------------------------------------- DOCUMENTATION PAGE ------------------------------------------------- */

// PARTNERS LIST ROUTE DISPLAYS TOP 3 PARTNERS AND THEIR DETAILS
Route::get('documentation', function () {
    return view('documentation.documentation_page');
});

/*

DEBUGGING SQL TIP:
This code will show the last query entered into the database.

$id = 4;
DB::connection()->enableQueryLog();
$sql = "select * from project where id=?";
$projects = DB::select($sql, array($id));
dd(DB::getQueryLog());

*/
