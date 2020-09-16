// product list html
function readProfilesTemplate(data, keywords){
 
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
 
        <!-- when clicked, it will load the create product form -->
        <div id='create-product' class='btn btn-primary pull-right m-b-15px create-profile-button'>
            <span class='glyphicon glyphicon-plus'></span> Create Candidate
        </div>
 
        <!-- start table -->
        <div class='row'>`;
 
 
    // loop through returned list of data
    $.each(data.records, function(key, val) {
 
        // creating new table row per record
        read_profiles_html+=`<div class='col-md-4 ftco-animate'>
            <div class="blog-entry">
              <a href='blog-single.html' class='block-20' style='background-image: url(`+`'images/image_1.jpg'`+`);'>
              </a>
              <div class='text p-4 d-block'>
                <div class='meta mb-3'>
                  <div><a href='#'>July 12, 2018</a></div>
                  <div><a href='#'>Admin</a></div>
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