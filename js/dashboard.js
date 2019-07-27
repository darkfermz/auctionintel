
$(document).ready(function() {

    var base_url = 'https://auctionintel.com/clients/';

    var tableBidders = $('#identityReports').DataTable( {
            "dom": 'Bfrtip',
            "ajax" : base_url+"dashboard/getBadBidders",
            "columns": [
                        {
                          "className": 'details-control',
                          "data": '',
                          "defaultContent": ''
                        },
                        { "data": "identity" },
                        { "data": "problem" },
                        { "data": "date_added", 
                          "className": 'date_added',
                          "defaultContent": '' 
                        }
                    ],
            "columnDefs": [ {
                        "targets": 0,
                        "searchable": false,
                        "orderable": false
                        
                        } ,
                        {targets:3, render:function(data){
                          return moment(data).format('MMMM DD, YYYY HH:mm.ss a');
                        }}
                        ],

            createdRow: function (row, data, index) {
                $(row).addClass("main-tr");
             },       
            //"order": [[3, 'desc']],
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "select": { style: 'single'},
            "buttons": [
                        {  
                            text: '<i class="fa fa-user-plus"></i> Add',
                            className: 'btn btn-inverse-danger btn-md btn-addtolist',
                            attr:{
                                'title': 'Add Bad Bidders'
                            },
                            action: function(){
                                $('#biddersModal').modal('show')
                            } 
                        },
                        {  
                            text: '<i class="fa fa-comments"></i> Add Comment',
                            className: 'btn btn-dark btn-comment',
                            attr:{
                                title: 'Add Comment'
                            },
                            action: function ( e, dt, node, config ) {

                                var datas =  dt.row( { selected: true } ).data();
                                var bidder_id = datas['bidder_id'];
                                var bidder_name = datas['identity'];
                                var bidder_issue = datas['problem'];
                                   

                                    $('#biddersCommentsWrapper').show();
                                    //$('.comment-button').trigger('click');
                                    $('#bidder_id_comment').val(bidder_id);
                                    $('#bidders_name').html(bidder_name);
                                    $('#bidders_issue').html(bidder_issue);

                                    $('#post_comment .Editor-editor').focus();

                                    if ( $.fn.DataTable.isDataTable('#bad_bidder_reviews') ) {
                                      $('#bad_bidder_reviews').DataTable().clear().destroy();
                                    }
                                                                        
                                    bidders.getBiddersComments(bidder_id);
                                    
                                
                            },
                            enabled: false 
                        },
                        {  
                            text: '<i class="fa fa-user-times"></i> Delete',
                            className: 'btn btn-danger btn-delete',
                            attr:{
                                title: 'Delete'
                            },
                            action: function ( e, dt, node, config ) {
                               var datas =  dt.row( { selected: true } ).data();
                               var bidder_id = datas['bidder_id'];

                              // alert('delete this bidder using this id->'+bidder_id);
                               bidders.deleteBadBidders(bidder_id);


                            },
                            enabled: false 
                        }           
                    ]

        } );

        tableBidders.on( 'select deselect', function () {
        var selectedRows = tableBidders.rows( { selected: true } ).count();
 
        tableBidders.buttons( ['.btn-comment', '.btn-delete'] ).enable(
        tableBidders.rows( { selected: true } ).indexes().length === 0 ? false: true );
       
        } );

        //add numbers
        tableBidders.on( 'order.dt search.dt', function () {
        tableBidders.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
        } ).draw();
               
   
            /* Post comments base on bidders' list */
                $('#post_comment').on('submit', function(e){

                                        
                    var post_content = $('#post_comment .Editor-editor').html();
                    var bidder_id = $('#bidder_id_comment').val();
                                        
                        if(post_content.trim() !== ''){

                            $.ajax({
                                type: 'POST',
                                url: base_url + 'dashboard/postBidderComments',
                                data:{post_content:post_content,bidder_id: bidder_id},
                                dataType: 'json',
                                beforeSend:function(){
                                                           
                                },
                                success:function(response){
                                                           
                                    if ( $.fn.DataTable.isDataTable('#bad_bidder_reviews') ) {
                                            $('#bad_bidder_reviews').DataTable().clear().destroy();
                                        }                                                           
                                        
                                    bidders.getBiddersComments(bidder_id);
                                    $('#post_comment .Editor-editor').html(''); 

                                }
                            });
                        }else{

                            $('#post_comment .Editor-editor').focus();
                                                
                        }
                                        
                        e.preventDefault();
                        e.stopPropagation();
                });



   /*Bidders Add / Comments / Delete */
   var bidders = {

        //Formatting function for row details - modify as you need
        addRowFormat:function(response){
          //console.log(response);
           
           var bidder_id = response['bidder_id'];
           var bidder_name = response['identity'];
           var bidder_issue = response['problem'];

           var ids = $.MD5(response['bidder_id']);
          
           var left_content = $('<div/>').html(response['details']).css({'white-space':'normal', 'line-height':'16px'});
           var right_content = $('<div/>').html( 
                    $('<button/>').attr({'title':'Comment on this','data-scroll-to':'#post_comment','data-scroll-focus':'#statusbar_commentsWrapper','data-scroll-offset':'700','data-scroll-speed':'500'}).addClass('btn btn-dark btn-sm').html('<i class="fa fa-comments"></i> Add Comment').click(function(){
                        $('#biddersCommentsWrapper').show();
                        
                        $('#bidders_name').html(bidder_name);
                        $('#bidders_issue').html(bidder_issue);

                        $('#post_comment .Editor-editor').focus();

                        if ( $.fn.DataTable.isDataTable('#bad_bidder_reviews') ) {
                                $('#bad_bidder_reviews').DataTable().clear().destroy();
                            }
                                                                        
                        bidders.getBiddersComments(bidder_id);

                    })
                   
                     
                );
              /*.append( $('<button/>').attr('title','Delete this').addClass('btn btn-danger btn-sm').html('<i class="fa fa-user-times"></i>').click(function(){
                    bidders.deleteBidders(bidder_id);
                })

                );*/

            return $( $('<div/>').addClass('row padd-top').html( $('<div/>').addClass('col-sm-9').html(left_content)).append( $('<div/>').addClass('col-sm-3 text-center').html(right_content) )  );
            //return $( $('<div/>').addClass('row padd-top').html( $('<div/>').addClass('col-sm-12').html(left_content)  ));                     

        },
        deleteBadBidders:function(bidder_id){

                      bootbox.confirm({
                            title: "DELETE BAD BIDDER",
                            message: "Are you sure you want to delete this bidder?",

                            buttons: {
                                cancel: {
                                    label: '<i class="fa fa-chevron-left"></i> Cancel'
                                },
                                confirm: {
                                    label: '<i class="fa fa-check"></i> Confirm'
                                }
                            },

                            callback: function (result) {
                                if(result == true){
                                    $.ajax({
                                        type: 'POST',
                                        url: base_url+'dashboard/deleteBadBidders',
                                        data: {bidder_id: bidder_id},
                                        dataType: 'json',
                                        success:function(data){

                                            if(data['msg'] == 'deleted'){

                                                $('#biddersCommentsWrapper').hide();

                                                $('#identityReports').DataTable().ajax.reload();
                                                $('.btn-comment').addClass('disabled');
                                                $('.btn-delete').addClass('disabled');
                                                
                                            }
                                        }   
                                    });
                                }
                                
                            }
                        });

        },
        getBiddersComments:function(bidder_id){
            
            $.ajax({
                type: 'POST',
                url: base_url + 'dashboard/getBiddersComments',
                data:{bidder_id: bidder_id},
                dataType: 'json', 
                beforeSend: function(){
                    $('#bad_bidder_reviews').append( $('<tr/>').addClass('loading_comments').html( $('<td/>').attr('colspan','3').html('<img src="images/fblike-loader.gif" /> Loading comments...') ) );
                },        
                success:function(response){
                $('.loading_comments').remove();
                   
                var tableComments = $('#bad_bidder_reviews').DataTable( {
                      "dom": 'rtip', 
                      data: response.data,
                       "columns": [
                        {
                          
                          "data": 'photo',
                          "className": 'comment_img',
                          "defaultContent": ''
                        },
                        {
                          "data": 'full_name'
                        },
                        { "data": 'content',
                          "className" : 'comment_content'  
                         },
                      
                        { "data": "date_added", 
                          "className": 'date_added',
                          "defaultContent": '' 
                        }
                    ],
                    "columnDefs": [ 
                        {targets:0, render:function(data, type, row){
                            var photos = (data == '') ? 'no-image.jpg' : data;
                            return '<img class="avatar-comment" src="'+base_url+'user_images/'+ photos+'" />';
                        }},
                        {targets:3, render:function(data){
                            return moment(data).fromNow();
                        }},
                        {targets:2, render:function(data, type, row){
                            return '<h5>'+row.full_name+'</h5><p>' + data+'</p>';
                        }},
                        {
                            targets: [1],
                            "orderable": false,
                            "visible": false,
                            "searchable": false
                        }

                        ],
                    "lengthMenu": [[5, 25, 50, -1], [5, 25, 50, "All"]],
                    "language": {
                        "info": "Showing _START_ to _END_ of _TOTAL_ Comments",
                        "emptyTable": "No Comment yet. Be the first to comment on this bidder",
                        "processing": "Loading comments...",
                        "paginate": {
                                  "previous": '<i class="fa fa fa-angle-left"></i>',
                                  next: '<i class="fa fa fa-angle-right"></i>',
                                }
                      },
                      "retrieve": true
                    } );

                     $('#bad_bidder_reviews thead').remove();
                 
                   
                   


                }
            });

            
        }
   }


        
   $('.btn-addtolist').attr({'data-toggle':'tooltip'});
   $('.btn-comment').attr({'data-toggle':'tooltip'});
   $('.btn-delete').attr({'data-toggle':'tooltip'});
   

    // Add event listener for opening and closing details td.details-control
    $('#identityReports tbody').on('click', 'tr.main-tr', function () {
            $('#biddersCommentsWrapper').hide();
             

            var tr = $(this).closest('tr');
            var row = tableBidders.row( tr );
            var datas = row.data();

         
     
            if ( row.child.isShown() ) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
             }
            else {
                // Open this row
                if( tableBidders.row('.shown').length ){
                     $('td.details-control', tableBidders.row( '.shown' ).node()).click();
                }
                
                row.child( bidders.addRowFormat(row.data()) ).show();
                tr.addClass('shown');
             
            }
    } );
        
   

    $(".nav-tabs a").click(function(){
        $(this).tab('show');
     });

    $('[data-toggle="tooltip"]').tooltip();

    $('#deepSearch input').click(function(){
        $('#deepMsg').fadeOut('slow');
        $('#deepSearch input').removeClass('errorz');
    });


   

/*-- Deep Search Functions --*/
var API_key = '6guxd1zrevr292nyskyvndqp';

var deepSearch ={

            getData:function(){
               var sEmail = $('.s-email').val();
               var sPhone = $('.s-phone').val();
               var sFname = $('.s-fname').val();
               var sLname = $('.s-lname').val();
               var sMname = $('.s-mname').val();
               var sCountryCode = $('.s-country-code').val();
               var sStateCode = $('.s-state-code').val();
               var sCity = $('.s-city').val();
               var sUsername = $('.s-username').val();
               var sAge = $('.s-age').val();
               var sSearchPointer = $('.s-search-pointer').val();

              
               if(sEmail == '' && sPhone == '' && sFname == '' && sLname == '' && sMname == '' && sCountryCode == '' && sStateCode == '' && sCity == '' && sUsername == '' && sAge == '' && sSearchPointer == ''){
                    this.submitSearchData(0,0);
               }else{

                var dataString1 = 'email='+sEmail
                                +'&phone='+sPhone
                                +'&first_name='+sFname
                                +'&last_name='+sLname
                                +'&middle_name='+sMname
                                +'&country='+sCountryCode
                                +'&state='+sStateCode
                                +'&city='+sCity
                                +'&username='+sUsername
                                +'&age='+sAge
                                +'&search_pointer='+sSearchPointer
                                +'&key='+API_key;

            
                var dataString2 = {'email':sEmail, 
                                    'phone':sPhone, 
                                    'first_name':sFname, 
                                    'last_name': sLname, 
                                    'middle_name': sMname,
                                    'country': sCountryCode,
                                    'state' : sStateCode,
                                    'city' : sCity,
                                    'username' : sUsername,
                                    'age' : sAge,
                                    'search_pointer' : sSearchPointer
                                    

                                 };              
                               
                               
                    this.submitSearchData(dataString1, dataString2);
               
               }

               
            },

            resetData:function(){
                $('#deepSearch input').removeClass('errorz');
                $('.s-email').val('');
                $('.s-phone').val('');
                $('.s-fname').val('');
                $('.s-lname').val('');
                $('.s-mname').val('');
                $('.s-country-code').val('');
                $('.s-state-code').val('');
                $('.s-city').val('');
                $('.s-username').val('');
                $('.s-age').val('');
                $('.s-search-pointer').val('');
                $('#back_btn').hide();

                $('.s-email').focus();
                $('#deepMsg').fadeOut('slow');
                $('#deepSearchResultsWrapper').html('');
            },
            renderSearchResults:function(data){
                for (var i = 0; i < data.length; i++){
                    this.drawTableRow(data[i]);
                }
            },
        
           submitSearchData:function(dataString1, dataString2){        
               
               console.log(dataString2);

               if(dataString2 === 0){

                    $('#deepMsg').html('<span class="text-danger"><i class="mdi mdi-alert-outline"></i> Sorry, required search parameters are missing.</span>').fadeIn('slow');
                    $('#deepSearch input').addClass('errorz');
               }else{

                  
                  $('#deepSearch input').removeClass('errorz');
                  $.ajax({ type: 'POST',
                    url: 'https://auctionintel.com/clients/dashboard/deepSearchGetJSON',
                    data: dataString2,
                    dataType: 'json',
                    beforeSend:function(){
                        //$('#deepSearchResultsWrapper').html('<center><img src="images/fblike-loader.gif" /> Loading search results...</center>');
                        $('#deepMsg').html('<img src="images/loader.gif" /> Searching the deep web. Please wait...').show();
                    },
                    success:function(data){
                        
                        console.log(data);
                        $.cookie.json = true;

                        var searchCount = data['@persons_count'];
                        var statusResponse = data['@http_status_code'];
                        var errorResponseMsg = data['error'];
                        var warningMsg = (data['warning'] == undefined)? '' : data['warnings'];

                        if(statusResponse !== 400){
                        var phoneQry = (data.query.phones == undefined) ? '': data.query.phones[0].number;
                        var emailsQry = (data.query.emails == undefined) ? '' : data.query.emails[0].address;
                        }

                        switch(statusResponse){ 
                            
                            case 400:
                                $('#deepMsg').html('<span class="text-danger"><i class="mdi mdi-alert-outline"></i>'+errorResponseMsg+'</span>').fadeIn('slow');
                                $('#deepSearchResultsWrapper').html('');
                                $('#deepSearch input').addClass('errorz');

                            break;

                            case 200:
                                    switch(searchCount){
                                        case 0:
                                                $('#deepMsg').html('<span class="text-danger"><i class="mdi mdi-alert-outline"></i> No Results Found for '+phoneQry+' '+emailsQry+' </span><br/><div class="suggest_msg">Suggestions: <br/> <ul><li>Make sure all words are spelled correctly.</li><li>Try searching with other parameters.</li></ul></div>').fadeIn('slow');
                                                $('#deepSearchResultsWrapper').html('');
                                                $('#deepSearch input').addClass('errorz');
                                        break;

                                        case 1:
                                                
                                            if(data.person != undefined){   

                                               

                                                deepSearch.getSingleSearchResults(data);   
                                                $.removeCookie('prev_qry'); 
                                                $.removeCookie('origin'); 

                                            }else{

                                                $.cookie('prev_qry', dataString2);
                                                $.cookie('origin','multiple');

                                                deepSearch.getMultipleSearchResults(data);
                                            }
                                        break;

                                        default:

                                                $.cookie('prev_qry', dataString2);
                                                $.cookie('origin','multiple');
                                                deepSearch.getMultipleSearchResults(data);                                                                                     

                                        break;
                                        }/*END switch search count*/
                   
                        break;
                    }/*End Switch status response*/



                    }


                });                                   
            }

           },          
          getSearchDetails:function(s_operator){
                 deepSearch.resetData();  
                 $('.s-search-pointer').focus();
                 $('.s-search-pointer').val(s_operator);

                 $('#goDeepSearch').trigger('click');
                 $('.s-search-pointer').val('');
                      
          },
          getSingleSearchResults:function(data){
                        /*--get Single Search Results--*/

                        var img_url = (data.person.images == undefined)? '' : data.person.images[0].url;
                        var img_thumbs = (data.person.images == undefined)? '' : data.person.images[0].thumbnail_token;
                        var get_name = (data.person.names == undefined)? '' : data.person.names[0].display;
                        var dob = (data.person.dob == undefined)? '' : data.person.dob.display; 
                        var gender = (data.person.gender == undefined)? '' : data.person.gender.content;
                        var home_address = (data.person.addresses == undefined)? '' : data.person.addresses;
                        var education= (data.person.educations == undefined)? '' : data.person.educations;
                        var career = (data.person.jobs == undefined)? '' : data.person.jobs;
                        var usernames = (data.person.usernames == undefined)? '' : data.person.usernames;
                        var phones = (data.person.phones == undefined)? '' : data.person.phones;
                        var relations = (data.person.relationships == undefined)? '' : data.person.relationships;
                        var emails = (data.person.emails == undefined)? '' : data.person.emails[0].address;
                        var urls = (data.person.urls == undefined) ? '' : data.person.urls;

                            gender = (gender == 'male')? 'Male' : 'Female';
                        var getNames = (get_name == '')? emails : get_name;
                                                
                        

                        var randomColor = "#"+((1<<24)*Math.random()|0).toString(16);
                        var thumbs = 'https://thumb.pipl.com/image?height=250&width=250&favicon=true&zoom_face=true&tokens='+img_thumbs;



                        var noPhotos = '<div class="no-img-single" style="opacity: .5;background-color:'+randomColor+'">'+getNames.charAt(0)+'</div>';
                                               
                        var hasPhotos = (img_thumbs == '')? noPhotos : '<img src=' + thumbs + ' style="width: 100% !important;margin-bottom:20px;"/>';                      
                                                
                        
                        var setImg = '';

                                $.ajax({
                                    url:thumbs,
                                    type:'GET',
                                    async: false,
                                    crossDomain: true,
                                    error:function(response){
                                         console.log(response.status);

                                        if(response.status == 404 || response.status == 403){
                                                setImg = noPhotos;
                                        }else{
                                                setImg = hasPhotos
                                            }
                                        }
                                });


                                               var getAddress = [];
                                                $(home_address).each(function(i, v){
                                                   
                                                    if(v.display != undefined){
                
                                                        getAddress[i] = v.display;

                                                        
                                                    }

                                                });


                                                var getEducation = [];

                                                $(education).each(function(i, v){

                                                    if(v.display != undefined){
                                                        getEducation[i] = v.display;
                                                    }
                                                });

                                                var getCareer = [];
                                                $(career).each(function(i, v){

                                                    if(v.display != undefined){
                                                        getCareer[i] = v.display; 
                                                    }
                                                    
                                                });


                                                var getUsername = [];

                                                $(usernames).each(function(i, v){

                                                    if(v.content != undefined){
                                                        getUsername[i] = v.content; 
                                                    }
                                                });

                                                var getPhone = [];

                                                $(phones).each(function(i, v){
                                                    var numberType = (v['@type'] === undefined)? '(International)' : '('+v['@type']+')';
                                                    if(v.display != undefined){
                                                        getPhone[i] = v.display_international + numberType; 
                                                    }
                                                });

                                                var getRelations = [];

                                                $(relations).each(function(i, v){
                                                   
                                                        getRelations[i] = v.names[0].display + '('+v['@type']+')';                                  
                                                    
                                                });
                                        
                                                
                                                $('#deepMsg').html('').hide();
                                               

                                                var setAddress = (getAddress == '') ? '' : 'From: '+getAddress[getAddress.length-1];
                                                var setGender = (get_name == '')? '' : gender;
                                                var prev_qrys =  $.cookie('prev_qry');
                                                
                                                if( $.cookie('origin') != undefined ){

                                                $('#back_btn').show().click(function(){ deepSearch.backSearch(prev_qrys); });

                                                }
                                                console.log($.cookie('origin'));
                                                $('#deepSearchResultsWrapper').html('<table id="personDataTable" width="100%" style="border:1px solid #efefef;"></table>');
                                                
                                                var row = $('<tr />');
                                                $("#personDataTable").append(row); 
                                                row.append($('<td><div class="row"><div class="col-lg-4">' + setImg + '</div><div class="col-lg-8"><h3 style="font-size:28px;"><b>' + getNames + '</b></h3><div>'+dob+'<br/>'+setGender+'<br/>'+setAddress+'</div></div></td>'));
                                                                    
                                                if(career !=''){
                                                    var row1 = $('<tr />');
                                                    $("#personDataTable").append(row1);
                                                    row1.append($('<td><div class="row"><div class="col-lg-4"><img src="https://auctionintel.com/clients/images/icons/icon_career_gray.png" style="width: 15px !important;"> CAREER: </div><div class="col-lg-8"> '+ getCareer.join(', ') +'</div></div></td>') );
                                                }

                                                if(education != ''){
                                                    var row2 = $('<tr />');
                                                    $("#personDataTable").append(row2);
                                                    row2.append($('<td><div class="row"><div class="col-lg-4"><img src="https://auctionintel.com/clients/images/icons/icon_education_gray.png" style="width: 15px !important;"> EDUCATION: </div><div class="col-lg-8"> '+ getEducation.join(', ') +'</div></div></td>') );
                                                }

                                                if(usernames != ''){
                                                    var row3 = $('<tr />');
                                                    $("#personDataTable").append(row3);
                                                    row3.append($('<td><div class="row"><div class="col-lg-4"><img src="https://auctionintel.com/clients/images/icons/icon_usernames_gray.png" style="width: 15px !important;"> USERNAMES: </div><div class="col-lg-8"> '+ getUsername.join(', ') +'</div></div></td>') );
                                                }

                                                if(phones != ''){
                                                    var row4 = $('<tr />');
                                                    $("#personDataTable").append(row4);
                                                    row4.append($('<td><div class="row"><div class="col-lg-4"><img src="https://auctionintel.com/clients/images/icons/icon_phone_gray.png" style="width: 15px !important;"> PHONE: </div><div class="col-lg-8"> '+ getPhone.join(', ') +'</div></div></td>') );
                                                }


                                                if(home_address != ''){                                               
                                                    var row5 = $('<tr />');
                                                    $("#personDataTable").append(row5);
                                                    row5.append($('<td><div class="row"><div class="col-lg-4"><img src="https://auctionintel.com/clients/images/icons/icon_address_gray.png" style="width: 15px !important;"> PLACES: </div><div class="col-lg-8"> '+ getAddress.join(', ') +'</div></div></td>') );
                                                }


                                                if(relations != ''){                 
                                                    var row6 = $('<tr />');
                                                    $("#personDataTable").append(row6);
                                                    row6.append($('<td><div class="row"><div class="col-lg-4"><img src="https://auctionintel.com/clients/images/icons/icon_associates_gray.png" style="width: 15px !important;"> ASSOCIATED WITH: </div><div class="col-lg-8"> '+ getRelations.join(', ') +'</div></div></td>') );
                                                
                                                }


                                                $(urls).each(function(k,v){                                            

                                                if(urls != ''){

                                                  var post_string = {'post_url':v['url']};
                                                  
                                                  $.ajax({
                                                    type: 'POST',
                                                    url: 'https://auctionintel.com/clients/dashboard/simpleHtmlDOM',
                                                    data: post_string,
                                                    dataType: 'json',                                             
                                                    success:function(data){
                                                        console.log(data);
                                                       var site_title = data.title;
                                                       var limitUrlString = v['url'].substr(0, 60)+'...';

                                                       var row7 = $('<tr />');
                                                                                                           
                                                       var favicon = '';
                                                       
                                                            if(v['@sponsored'] !=true){
                                                                $("#personDataTable").append(row7);
                                                                row7.append($('<td><table id="url_links" width="100%"><tr><td style="width:50px !important;padding: 10px 0px !important;border:0 !important">'+deepSearch.checkIcons(v["@category"])+'</td><td style="border:0 !important"><a href="'+v["url"]+'" target="_blank" rel="noreferrer" rel="nofollow" style="font-size:16px;"><b>'+getNames+'</b></a><br/><p style="color:green;font-size:11px;margin:5px 0px;">'+limitUrlString+'</p>'+favicon+' '+site_title+' - '+v["@domain"]+'</td></tr></table></td>') );
                                                            }
                                                    }
                                                  });                                           
                                              
                                                    
                                                }
                                            });//-->each urls

                                            $.removeCookie('origin');

          },
          checkIcons:function(dtypes){
            var ICON_PATH = 'https://auctionintel.com/clients/images/icons/';
                        switch(dtypes){
                            case 'professional_and_business':
                                return '<img src="'+ICON_PATH+'icon_career_gray.png" class="icon_single" style="width: 50px !important;"> ';    
                            break;
                            case 'background_reports':
                                return '<img src="'+ICON_PATH+'icon_address_gray.png" class="icon_single" style="width: 50px !important;">';    
                            break;
                            case 'public_records':
                                return '<img src="'+ICON_PATH+'icon_usernames_gray.png" class="icon_single" style="width: 50px !important;">';
                            break;
                            case 'contact_details':
                                return '<img src="'+ICON_PATH+'icon_phone_gray.png" class="icon_single" style="width: 50px !important;">';
                            break;
                            case 'personal_profiles':
                                return '<img src="'+ICON_PATH+'icon_name_gray.png" class="icon_single" style="width: 50px !important;">';
                            break;
                            default:
                                return '<img src="'+ICON_PATH+'icon_usernames_gray.png" class="icon_single" style="width: 50px !important;">';
                            break;
                        }
          },
          getMultipleSearchResults:function(data){

                        /*--get Multiple Search Results--*/

                        var query = (data.query === undefined) ? '' : data.query;
                        var possiblePersons = data.possible_persons;

                        var qnames = (data.query.names === undefined) ? '' : data.query.names;
                        var unames = (data.query.usernames === undefined) ? '' : data.query.usernames;
                        var qEmails = (data.query.emails === undefined) ? '' : data.query.emails;

                        var queryNames = [];

                                if(qnames != ''){
                                                    $(qnames).each(function(i, v){
                                                        queryNames[i] = v.display ;
                                                                           
                                                    });

                                                }

                                if(unames != ''){
                                                    $(unames).each(function(i, v){
                                                            
                                                        queryNames[i] = v.content ;
                                                                           
                                                    });

                                                }  
                                if(qEmails != ''){
                                                    $(qEmails).each(function(i, v){
                                                            
                                                        queryNames[i] = v.address ;
                                                         console.log(v);                  
                                                    });

                                                }


                                                var checkSourcesCount = data['@visible_sources'];
                                                                                               
                                                if(checkSourcesCount > 0){
                                                    
                                                    $('#deepSearchResultsWrapper').html('<h4 style="margin-top:35px;">Search Results for <span style="color: #308ee0 !important;">'+queryNames+'</span></h4><table id="personDataTable" style="width:100%;border:1px solid #efefef;"></table>');
                                                }else{

                                   
                                                    $('#deepSearchResultsWrapper').html('<h4 style="margin-top:35px;">Results for <span style="color: #308ee0 !important;">'+queryNames+'</span></h4><p style="font-size:15px;margin-bottom:35px;">Showing possibly related results.</p><table id="personDataTable" style="width:100%;border:1px solid #efefef;"></table>');
                                                }
                                             
                                                $(possiblePersons).each(function(index, value){
                                                    var iconAddress = '<img src="https://auctionintel.com/clients/images/icons/icon_address_gray.png" style="width: 12px !important;opacity:.6;">';
                                                    var iconCareer = '<img src="https://auctionintel.com/clients/images/icons/icon_career_gray.png" style="width: 12px !important;opacity:.6;">';
                                                    var iconEducation = '<img src="https://auctionintel.com/clients/images/icons/icon_education_gray.png" style="width: 12px !important;opacity:.6;">';
                                                    var iconGender = '<img src="https://auctionintel.com/clients/images/icons/icon_name_gray.png" style="width: 12px !important;opacity:.6;">'; 
                                                    var getNames = (value.names === undefined) ? '' : value.names[0].display;
                                                    var gender = (value.gender === undefined) ? '' :  value.gender.content;
                                                        gender = (gender == '')? '' : iconGender+' '+gender;
                                                    var address = (value.addresses === undefined) ? '' : iconAddress+' '+value.addresses[0].display;
                                                    var educations = (value.educations === undefined) ? '' : iconEducation+' '+value.educations[0].display;
                                                    var jobs = (value.jobs === undefined) ? '' : iconCareer+' '+value.jobs[0].display;
                                                    var imgs = (value.images === undefined) ? '' : value.images;

                                                    var rows = $('<tr/>').on('click', function(){ deepSearch.getSearchDetails(value['@search_pointer']); });

                                                    var randomColor = "#"+((1<<24)*Math.random()|0).toString(16);
                                                    
                                                   
                                                    var img = [];
                                                    $.each(imgs,function(i,v){
                                                         img[i] = v.url;
                                                    });

                                                    var img_thumb = [];
                                                    $.each(imgs,function(i,v){
                                                        img_thumb[i] = v.thumbnail_token;
                                                    });

                                                    var thumbs = 'https://thumb.pipl.com/image?height=100&width=100&favicon=true&zoom_face=true&tokens='+img_thumb;
                                                    var getImg = '';
                                                    
                                                    var noPhotos = '<div class="avatar-small" style="opacity: .5;background-color:'+randomColor+'">'+getNames.charAt(0)+'</div>';
                                                    var hasPhotos = '<div class="avatar-small"><img style="border-radius:3px !important;" src="'+thumbs+'"/></div>';
                                                    
                                                    

                                                    if(img[0] === undefined){
                                                        getImg = noPhotos;
                                                    }else{

                                                        
                                                         $.ajax({
                                                           url:img[0],
                                                           type:'GET',
                                                           async: false,
                                                           crossDomain: true,
                                                           error:function(response){
                                                           //console.log(response.status);

                                                           if(response.status == 404 || response.status == 403){
                                                                getImg = noPhotos;
                                                            }else{
                                                                getImg = hasPhotos
                                                            }
                                                           }
                                                        });

                                                        
                                                    
                                                    }

                                                    
                                                    $('#deepMsg').html('').hide();
                                              
                                                    

                                                    $("#personDataTable").append( rows );

                                                    rows.append($('<td/>').addClass('detailed-img').html(getImg).css({"width":"80px"}));
                                                    rows.append($('<td/>').addClass('detailed-information').html('<h4 class="p-name">'+getNames+'</h4><div class="p-gender">'+gender+'</div><div class="p-address"> '+address+'</div><div class="p-education">'+educations+'</div><div class="p-jobs">'+jobs+'</div>'));


                                                  

                                                   
                                                   
                                                    
                                                });                
          },
          backSearch:function(datas){
                                               
                $('.s-email').val(datas['email']);
                $('.s-phone').val(datas['phone']);
                $('.s-fname').val(datas['first_name']);
                $('.s-lname').val(datas['last_name']);
                $('.s-mname').val(datas['middle_name']);
                $('.s-country-code').val(datas['country']);
                $('.s-state-code').val(datas['state']);
                $('.s-city').val(datas['city']);
                $('.s-username').val(datas['username']);
                $('.s-age').val(datas['age']);

                $('#goDeepSearch').trigger('click');
                $('#back_btn').hide();
                $.removeCookie('origin');



          } 



        }

       
        /*-- Get Deep Search Data --*/
        $('#goDeepSearch').click(function(){

                deepSearch.getData();

        });

        /*-- Reset Deep Search Data --*/
        $('#resetSearch').click(function(){
                deepSearch.resetData();

        });


        /*-- Text Editor --*/
        


} );