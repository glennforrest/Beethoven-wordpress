// Looking at processing all forms to one ajax endpoint, and within this app variable
// will be setting up different cases depending on the type of request and handling them
// accordingly.

var app = (function($){
    // Define your processor object
    var ajax_data = {
          url: '/wp-admin/admin-ajax.php',
          dataType: 'json',
          success: function(response){
              $('.notifications').attr('class', 'notifications-success');
              if(response.message){
                  console.log(response.message);
                $('.notification-message').html(response.message);
              }else{
                console.log(response);
              
              $('.notification-message').html(response);  
              }
              
              
          },
          error: function(err){ console.log(err); },
          method: 'POST',
          data: { 
                action : 'processor',
                formData : {}
          }
    };
    
    function form_processor(form_name){
        var data = {};
        $('input[type="text"], input[type="hidden"], option:selected, input:checked, textarea', $(form_name) ).each(function(i, el){
            var value = $(el).val();
            
            // If element is an option
            if($(el).is('option')){
                // Grab the name from the select's name
                var name = $(el).closest('select').attr('name').replace('form[','') .replace(']','');
            }else{
                var name = $(el).attr('name').replace('form[','') .replace(']','');
                console.log(name);
            }
            // Get and store value
            data[name] = value;
        });
        return data;
    };

    var processor = {
             enrolment: function(e){
                // Prevent default submission
                e.preventDefault();
                // Copy the ajax_data
                var enrolment_data = ajax_data;
                // Define the processor specific data
                enrolment_data.data.formData = form_processor('.enrolment-form');
                enrolment_data.data.formData['type'] = 'enrolment';
                console.log(enrolment_data);
                // Process the data
                $.ajax(enrolment_data);
              },
              update_student: function(e){
                e.preventDefault();
                var update_student_data = ajax_data;
                update_student_data.data.formData = form_processor('.update-student-form');
                update_student_data.data.formData['type'] = 'update-student';
                console.log(update_student_data);
                $.ajax(update_student_data);
              },
              classroom: function(e){
                  e.preventDefault();
    
                  var classroom_data = ajax_data;
                  var formData = $(this).serializeArray();
                  var students = [];
                  
                  jQuery.each( formData, function( i, field ) {
                      var name = field.name.replace('form[','') .replace(']','');
                      var value = field.value;
                      if(name == 'student[]'){
                          students[i] = value;
                      }else{
                          classroom_data.data.formData[name] = value;
                      }
                     });
                  classroom_data.data.formData['students'] = students;
                  
                  // Checking whether this is for an update or create classroom request.
                  if(e.currentTarget.className == 'update'){
                      classroom_data.data.formData['type'] = 'update-classroom';
                      
                  }else if(e.currentTarget.className == 'create'){
                      classroom_data.data.formData['type'] = 'create-classroom';
                  }
                  
                  console.log(classroom_data);
                  $.ajax(classroom_data);
              },
              results: function(formData){
                var results_data = ajax_data;
                results_data.data.formData = formData;
                results_data.data.formData['type'] = 'results';
                $.ajax(results_data);
                
              },
              lesson: function(e){
                  e.preventDefault();
                  var lesson_data = ajax_data;
                  var formData = $(this).serializeArray();
                  var questions = [];
                  var answers = [];
                  console.log(formData);
                  jQuery.each( formData, function( i, field ) {
                      
                      var name = field.name.replace('form[','') .replace(']','');
                      var value = field.value;
                      switch(name){
                          case 'question[]':
                              questions[questions.length] = value;
                              break;
                          case 'answer[]':
                              answers[answers.length] = value;
                              break;
                          default:
                              lesson_data.data.formData[name] = value;
                              
                      }
                 });
                 
                 lesson_data.data.formData['questions'] = questions;
                 // For note identification, duplicating questions into answers.
              if(lesson_data.data.formData['exercise_type'] == 'note_identification'){
                  lesson_data.data.formData['answers'] = lesson_data.data.formData['questions'];
              }else{
                lesson_data.data.formData['answers'] = answers;
              }
                 
                 // Checking whether this is for an update or create classroom request.
                  if(e.currentTarget.className == 'update'){
                      lesson_data.data.formData['type'] = 'update-lesson';
                      
                  }else if(e.currentTarget.className == 'create'){
                      lesson_data.data.formData['type'] = 'create-lesson';
                  }
                  
                  
                  console.log(lesson_data);
                  $.ajax(lesson_data);
              }
        },
        dashboardFunctions = {
            setSideMenuHeight : function(){
                var height = window.outerHeight,
                sideMenu = $('#sidebar-wrapper');
                sideMenu.css('height', height);
              },
            studentActiveMenuItem: function(filePath){
              // Remove student from the
              var slug = filePath.substr(8);
              var page = slug.substr(0, slug.indexOf('/') );
              
              switch(page){
                case 'results':
                  $('a:contains(RESULTS)').closest('li').attr('class', 'active');
                  break;
                case 'eartrainer':
                  $('a:contains(EAR TRAINER)').closest('li').attr('class', 'active');
                  break;
                case 'lessons':
                  $('a:contains(LESSONS)').closest('li').attr('class', 'active');
                  break;
                default:
                 $('a:contains(DASHBOARD)').closest('li').attr('class', 'active');
                  break;
              }
            },
            teacherActiveMenuItem: function(filePath){
              // Remove student from the
              var slug = filePath.substr(8);
              var page = slug.substr(0, slug.indexOf('/') );
              
              switch(page){
                case 'classrooms':
                  $('a:contains(CLASSROOMS)').closest('li').attr('class', 'active');
                  break;
                case 'student':
                  $('a:contains(STUDENTS)').closest('li').attr('class', 'active');
                  break;
                case 'lesson':
                  $('a:contains(LESSONS)').closest('li').attr('class', 'active');
                  break;
                case 'results':
                  $('a:contains(RESULTS)').closest('li').attr('class', 'active');
                  break;
                default:
                 $('a:contains(DASHBOARD)').closest('li').attr('class', 'active');
                  break;
              }
            },
            initMenu: function(){
              jQuery('#menu ul').hide();
              jQuery('#menu ul').children('.current').parent().show();
              //jQuery('#menu ul:first').show();
              jQuery('#menu li a').click(function(){
                  var checkElement = jQuery(this).next();
                  if((checkElement.is('ul')) && (checkElement.is(':visible'))) {
                      return false;
                  }
                  if((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
                      jQuery('#menu ul:visible').slideUp('normal');
                      checkElement.slideDown('normal');
                      return false;
                  }
              });
            },
            validator: function(){
              jQuery(document).ready(function($){
                $('.lesson-select').perfectScrollbar();
                
                jQuery("#menu-toggle").click(function(e) {
                    e.preventDefault();
                    jQuery("#wrapper").toggleClass("toggled");
                });
                
                glennsFormValidator.init();
               
               
               $('input[type=submit]').attr('disabled', true);
               
               $('.required').on('blur', function(){
                  // Checking if there is an error class
                  if($('.validated').length === $('.required').length){
                     // Enabling the submit button.
                     $('input[type=submit]').attr('disabled', false);
                  }else{
                     $('input[type=submit]').attr('disabled', true);
                  }
               });
            });
              
            }
        }
            
        
    // Bind your processor object to form submit events, etc..
    $(document).on('submit','.enrolment-form', processor.enrolment);
    $(document).on('submit','.update-student-form', processor.update_student);
    $(document).on('submit','#classroom-form', processor.classroom);
    $(document).on('submit','#lesson-form', processor.lesson);
    

    return { 
      processor: processor,
      dashboardFunctions: dashboardFunctions
    };
})(jQuery);