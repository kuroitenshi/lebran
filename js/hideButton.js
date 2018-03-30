 $(document).ready(function () {
         $('#sidebarCollapse').on('click', function () {
             $('#sidebar').toggleClass('active');
             $('#hideme').toggleClass('glyphicon-chevron-left');
             $('#hideme').toggleClass('glyphicon-chevron-right');

             if($('#hideme').hasClass('glyphicon-chevron-left')){
              $('#hidemetext').text('Hide');
              $('#hideme').css('padding-left', '');
            }
            else{
              $('#hidemetext').text('Show');
              $('#hideme').css('padding-left', '20px');
            }
         });
	});