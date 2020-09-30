// product list html
function readProfilesTemplate(data, keywords){

    console.log(data.records);
 
    var read_profiles_html=`
        <!-- search products form -->
        <form id='search-product-form' action='#' method='post'>
        <div class='input-group pull-left w-30-pct'>
 
            <input type='text' value='` + keywords + `' name='keywords' class='form-control product-search-keywords' placeholder='Search Staff Profile...' />
 
            <span class='input-group-btn'>
                <button type='submit' class='btn btn-default' type='button'>
                    <span class='glyphicon glyphicon-search'></span>
                </button>
            </span>
 
        </div>
        </form>
 
        
 
        <!-- start table -->
        <div class='row'>`;
 
 
    // loop through returned list of data
    $.each(data.records, function(key, val) {
        var image = "images/image_1.jpg";
        // creating new table row per record
        read_profiles_html+=`<div class='col-md-4'>
            <div class="blog-entry">
              <a href='#'>
                <img src='images/` + val.profile_pic + `' class='block-20' style='width:100%;' />
              </a>
              <div class='text p-4 d-block'>
                <div class='meta mb-3'>
                  <div>` + val.department + `</div>
                  <div>` + val.designation + `</div>
                  <div><a href='#' class='meta-chat'><span class='icon-chat'></span> 3</a></div>
                </div>
                <h3 class='heading'><a href='#'>` + val.firstname + ` ` + val.lastname + `</a></h3>
              </div>
            </div>
          </div>`;
    });
 
    // end table
    read_profiles_html+=`</div>`;
    // pagination
    if(data.paging){
        read_profiles_html+="<ul class='pagination pull-left margin-zero padding-bottom-2em'>";
    
            // first page
            if(data.paging.first!=""){
                read_profiles_html+="<li><a style='cursor:pointer;' data-page='" + data.paging.first + "'>First Page</a></li>";
            }
    
            // loop through pages
            $.each(data.paging.pages, function(key, val){
                var active_page=val.current_page=="yes" ? "class='active'" : "";
                read_profiles_html+="<li " + active_page + "><a style='cursor:pointer;' data-page='" + val.url + "'>" + val.page + "</a></li>";
            });
    
            // last page
            if(data.paging.last!=""){
                read_profiles_html+="<li><a style='cursor:pointer;' data-page='" + data.paging.last + "'>Last Page</a></li>";
            }
        read_profiles_html+="</ul>";
    }
 
    // inject to 'page-content' of our app
    $("#page-content").html(read_profiles_html);
}