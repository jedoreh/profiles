$(document).ready(function(){
    console.log("test")
    // show list of product on first load
    showProfilesFirstPage();
 
    // when a 'read products' button was clicked
    $(document).on('click', '.read-profiles-button', function(){
        showProfilesFirstPage();
    });
 
    // when a 'page' button was clicked
    $(document).on('click', '.pagination li', function(){
        // get json url
        var json_url=$(this).find('a').attr('data-page');
 
        // show list of products
        showProfiles(json_url);
    });
 
 
});
 
function showProfilesFirstPage(){
   
    var json_url="https://profiles.uniben.edu/api/profile/read_paging.php";
    
    showProfiles(json_url);
}
 
// function to show list of products
function showProfiles(json_url){
   
    // get list of products from the API
    $.getJSON(json_url, function(data){
         
        // html for listing products
        
        readProfilesTemplate(data, "");
 
        // chage page title
        changePageTitle("View Staff Profiles1");
 
    });
}