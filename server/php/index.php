<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../../dist/w2ui.min.css" />
    <script type="text/javascript" src="../../libs/jquery/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="../../dist/w2ui.min.js"></script>
</head>
<body>
    <div id="users" style="width: 100%; height: 600px;"></div>
</body>
<script>
$(function () {
    // define and render grid
    $('#users').w2grid({
        name    : 'users',
        url     : 'users.php',
        header  : 'List of Users',
        show: {
            header        : true,
            toolbar       : true,
            footer        : true,
            toolbarAdd    : true,
            toolbarDelete : true
        },
        columns: [
      			{ field: 'inum', caption: 'i-Nummer', size: '150px', searchable: true },      
                  { field: 'fname', caption: 'First Name', size: '150px', searchable: true },
                  { field: 'lname', caption: 'Last Name', size: '150px', searchable: true },
                  { field: 'email', caption: 'Email', size: '150px', searchable: true },
                  { field: 'tele', caption: 'Telefon', size: '150px', searchable: false },
                  { field: 'po', caption: 'PO', size: '50px', searchable: false },
                  { field: 'hu11', caption: 'Hu 11', size: '100px', searchable: false },
                  { field: 'bemerk', caption: 'Bemerkung', size: '100%', searchable: false }
        ],
        onAdd: function (event) {
            editUser(0);
        },
        onDblClick: function (event) {
            editUser(event.recid);
        }
    });

    // defined form
    $().w2form({
        name     : 'user_edit',
        url     : 'users.php',
        style     : 'border: 0px; background-color: transparent;',
        formHTML: 
            '<div class="w2ui-page page-0">'+
            '    <div class="w2ui-label">First Name:</div>'+
            '    <div class="w2ui-field">'+
            '        <input name="fname" type="text" size="35"/>'+
            '    </div>'+
            '    <div class="w2ui-label">Last Name:</div>'+
            '    <div class="w2ui-field">'+
            '        <input name="lname" type="text" size="35"/>'+
            '    </div>'+
            '    <div class="w2ui-label">Email:</div>'+
            '    <div class="w2ui-field">'+
            '        <input name="email" type="text" size="35"/>'+
            '    </div>'+
            '    <div class="w2ui-label">PO:</div>'+
            '    <div class="w2ui-field">'+
            '        <input name="po" type="text" size="25"/>'+
            '    </div>'+
            '    <div class="w2ui-label">Bemerkung:</div>'+
            '    <div class="w2ui-field">'+
            '        <input name="bemerk" type="test" size="25"/>'+
            '    </div>'+
            '	 <div class="w2ui-label">Hausubung SB 1:</div>'+
            '    <div class="w2ui-input">'+
            '        <input name="hu11" type="checkbox" />'+
            '    </div>'+
            '</div>'+
            '<div class="w2ui-buttons">'+
            '    <input type="button" value="Cancel" name="cancel">'+
            '    <input type="button" value="Save" name="save">'+
            '</div>',
        fields: [
            { name: 'fname', type: 'text', required: true },
            { name: 'lname', type: 'text', required: true },
            { name: 'email', type: 'email',required: true  },
            { name: 'po', type: 'text', required: true },
            { name: 'hu11', type: 'checkbox', required: false },

        ],
        actions: {
            "save": function () { 
                this.save(function (data) {
                    if (data.status == 'success') {
                        w2ui['users'].reload();
                        $().w2popup('close');
                    }
                    // if error, it is already displayed by w2form
                }); 
            },
            "cancel": function () { 
                $().w2popup('close');
            },
        }
    });    
});

function editUser(recid) {
    $().w2popup('open', {
        title   : (recid == 0 ? 'Add User' : 'Edit User'),
        body    : '<div id="user_edit" style="width: 100%; height: 100%"></div>',
        style   : 'padding: 15px 0px 0px 0px',
        width   : 500,
        height  : 300, 
        onOpen  : function (event) {
            event.onComplete = function () {
                w2ui['user_edit'].clear();
                w2ui['user_edit'].recid = recid;
                $('#w2ui-popup #user_edit').w2render('user_edit');
            }
        }
    });
}
</script>
</html>