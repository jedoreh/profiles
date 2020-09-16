$(document).ready(function(){

    //check token
    //var jwt = getCookie('jwt');
    //if(jwt){
    //    console.log('Welcome to UNIBEN Online Voting - 2020')
    //} else {
    //    window.location = "http://testphp.uniben.edu/adminlogin.html";
    //}
    
    
 
    // app html
    var app_html=`
        <div class='container'>
 
            <div class='page-header'>
                <h1 id='page-title'>View Staff Profiles</h1>
            </div>
 
            <!-- this is where the contents will be shown. -->
            <div id='page-content'></div>
 
        </div>`;
 
    // inject to 'app' in index.html
    $("#app").html(app_html);
 
});

// getCookie() will be here
        // get or read cookie
        function getCookie(cname){
            var name = cname + "=";
            var decodedCookie = decodeURIComponent(document.cookie);
            var ca = decodedCookie.split(';');
            for(var i = 0; i <ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' '){
                    c = c.substring(1);
                }
        
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }
 
// change page title
function changePageTitle(page_title){
 
    // change page title
    $('#page-title').text(page_title);
 
    // change title tag
    document.title=page_title;
}
 
// function to make form values to json format
$.fn.serializeObject = function()
{
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};