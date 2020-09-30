$(document).ready(function(){
 
    
    // show html form when 'create product' button was clicked
    $(document).on('click', '.create-profile-button', function(){
        // categories api call will be here
        // load list of categories
        console.log('test')
        // $.getJSON("https://profiles.uniben.edu/api/profile/read.php", function(data){
        //     // build categories option html
        // // loop through returned list of data
        // var categories_options_html=`<select name='category_id' class='form-control' style='height:40px'>`;
        // $.each(data.records, function(key, val){
        //     categories_options_html+=`<option value='` + val.id + `'>` + val.name + `</option>`;
        // });
        // categories_options_html+=`</select>`;

        // we have our html form here where product information will be entered
        // we used the 'required' html5 property to prevent empty fields
        var create_profile_html=`
        
            <!-- 'read products' button to show list of products -->
            <div id='read-profiles' class='btn btn-primary pull-right m-b-15px read-profiles-button'>
                <span class='glyphicon glyphicon-list'></span> View Profiles
            </div>
            <div id='page-error'></div>
            <!-- 'create product' html form -->
            <form id='create-profile-form' action='#' method='post' border='0'>
                <table class='table table-hover table-responsive table-bordered'>
            
                    <!-- name field -->
                    <tr>
                        <td>First Name</td>
                        <td><input type='text' name='firstname' class='form-control' required /></td>
                    </tr>
                    <tr>
                        <td>Last Name</td>
                        <td><input type='text' name='lastname' class='form-control' required /></td>
                    </tr>
                    <tr>
                        <td>Email Address</td>
                        <td><input type='email' name='email' class='form-control' required /></td>
                    </tr>
                    <tr>
                        <td>Select Photo</td>
                        <td><input type='text' name='profile_pic' class='form-control' /></td>
                    </tr>
                    <tr>
                        <td>Phone Number</td>
                        <td><input type='phonenumber' name='phone1' class='form-control' /></td>
                    </tr>
                    <tr>
                        <td>Additional Phone Number</td>
                        <td><input type='phonenumber' name='phone2' class='form-control' /></td>
                    </tr>
                    <tr>
                        <td>Faculty</td>
                        <td><input type='text' name='faculty' class='form-control' /></td>
                    </tr>
                    <tr>
                        <td>Department</td>
                        <td><input type='text' name='department' class='form-control' /></td>
                    </tr>
                    <tr>
                        <td>Designation</td>
                        <td><input type='text' name='designation' class='form-control' /></td>
                    </tr>
                    <tr>
                        <td>Gender</td>
                        <td><input type='text' name='gender' class='form-control' /></td>
                    </tr>
                    <tr>
                        <td>Office Address</td>
                        <td><input type='text' name='office_address' class='form-control' /></td>
                    </tr>
                    <tr>
                        <td>Biography</td>
                        <td><textarea name='biography' class='form-control'></textarea></td>
                    </tr>
            
                    <!-- price field 
                    <tr>
                        <td>Position</td>
                        <td><select name='price' class='form-control' style='height:40px'>
                            <option value='President'>President</option>
                            <option value='Vice-President'>Vice-President</option>
                            <option value='Dean'>Dean</option>
                        </select></td>
                    </tr>-->
            
                    <!-- description field 
                    <tr>
                        <td>Description</td>
                        <td><textarea name='description' class='form-control' required></textarea></td>
                    </tr>-->
            
                    <!-- categories 'select' field 
                    <tr>
                        <td>Category</td>
                        <td> + categories_options_html + </td>
                    </tr>-->
            
                    <!-- button to submit form -->
                    <tr>
                        <td></td>
                        <td>
                            <input type='hidden' value='NO' name='profile_show'>
                            <button type='submit' class='btn btn-primary'>
                                <span class='glyphicon glyphicon-plus'></span> Create Profile
                            </button>
                        </td>
                    </tr>
            
                </table>
            </form>`;
            // inject html to 'page-content' of our app
            $("#page-content").html(create_profile_html);
            
            // chage page title
            changePageTitle("Create Profile");
        });
    //});
 
    // 'create product form' handle will be here
    // will run if create product form was submitted
    $(document).on('submit', '#create-profile-form', function(){
        // form data will be here
        // get form data
        var form_data=JSON.stringify($(this).serializeObject());
        // submit form data to api
        $.ajax({
            url: "https://profiles.uniben.edu/api/profile/create.php",
            type : "POST",
            contentType : 'application/json',
            data : form_data,
            success : function(result) {
                // product was created, go back to products list
                showProfilesFirstPage();
            },
            error: function(xhr, resp, text) {
                // show error to console
                console.log(xhr, resp, text);
                //console.log(form_data);
                 $("#page-error").html("<p>" + text + "</p>");
            }
        });
        
        return false;
    });
});