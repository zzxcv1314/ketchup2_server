// Add Record
function addRecord() {
    // get values
    var first_name = $("#first_name").val();
    var last_name = $("#last_name").val();
    var email = $("#email").val();
    var buttonon = $("#buttonon").val();
    var buttonoff = $("#buttonoff").val();
    var ptime = $("#ptime").val(); 
    var info = $("#info").val(); 

    console.log(ptime); 
    
    // Add record
    $.post("ajax/addRecord.php", {
        first_name: first_name,
        last_name: last_name,
        email: email,
        buttonon: buttonon,
        buttonoff: buttonoff,
        ptime: ptime, 
        info: info 
    }, function (data, status) {
        // close the popup
        $("#add_new_record_modal").modal("hide");

        // read records again
        readRecords();

        // clear fields from the popup
        $("#first_name").val("");
        $("#last_name").val("");
        $("#email").val("");
        $("#buttonon").val(""); 
        $("#buttonoff").val(""); 
        $("#ptime").val(""); 
        $("#info").val(""); 
    });
}

// READ records
function readRecords() {
    $.get("ajax/readRecords.php", {}, function (data, status) {
        $(".records_content").html(data);
    });
}


function DeleteUser(id) {
    var conf = confirm("Are you sure, do you really want to delete User?");
    if (conf == true) {
        $.post("ajax/deleteUser.php", {
                id: id
            },
            function (data, status) {
                // reload Users by using readRecords();
                readRecords();
            }
        );
    }
}

function GetUserDetails(id) {
    // Add User ID to the hidden field for furture usage
    $("#hidden_user_id").val(id);
    $.post("ajax/readUserDetails.php", {
            id: id
        },
        function (data, status) {
            // PARSE json data
            var user = JSON.parse(data);
            // Assing existing values to the modal popup fields
            $("#update_first_name").val(user.first_name);
            $("#update_last_name").val(user.last_name);
            $("#update_email").val(user.email);
            $("#update_buttonon").val(user.buttonon);
            $("#update_buttonoff").val(user.buttonoff);
            $("#update_ptime").val(user.ptime); 
            $("#update_info").val(user.info);   
        }
    );
    // Open modal popup
    $("#update_user_modal").modal("show");
}

function UpdateUserDetails() {
    // get values
    var first_name = $("#update_first_name").val();
    var last_name = $("#update_last_name").val();
    var email = $("#update_email").val();
    var buttonon = $("#update_buttonon").val(); 
    var buttonoff = $("#update_buttonoff").val(); 
    var ptime = $("#update_ptime").val(); 
    var info = $("#update_info").val(); 

    // get hidden field value
    var id = $("#hidden_user_id").val();

    // Update the details by requesting to the server using ajax
    $.post("ajax/updateUserDetails.php", {
            id: id,
            first_name: first_name,
            last_name: last_name,
            email: email,
            buttonon: buttonon,
            buttonoff: buttonoff, 
            ptime: ptime, 
            info: info
        },
        function (data, status) {
            // hide modal popup
            $("#update_user_modal").modal("hide");
            // reload Users by using readRecords();
            readRecords();
        }
    );
}
function clickbuttonon(id) {
    // Add User ID to the hidden field for furture usage
    $("#hidden_user_id").val(id);
    console.log(id); 
    $.post("ajax/readUserbutton.php", {
            id: id
        },
        function (data, status) {
            // PARSE json data
            var user = JSON.parse(data);
            // Assing existing values to the modal popup fields
            
            console.log(user);
            var a = 'http://';
            window.location.href=a+user.buttonon;

            //user.buttonon; 
        }
    );
    // Open modal popup
    
}

function clickbuttonoff(id) {
    // Add User ID to the hidden field for furture usage
    $("#hidden_user_id").val(id);
    $.post("ajax/readUserbuttonoff.php", {
            id: id
        },
        function (data, status) {
            // PARSE json data
            var user = JSON.parse(data);
            // Assing existing values to the modal popup fields
            
            console.log(user);
            var a = 'http://';
            window.location.href=a+user.buttonoff;

            //user.buttonon; 
        }
    );
    // Open modal popup
    
}
$(document).ready(function () {
    // READ recods on page load
    readRecords(); // calling function
});