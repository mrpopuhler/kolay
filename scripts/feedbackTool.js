function insertFeedbackTool() {
  $('#feedbackTool').html('<style>#feedback{bottom: 3px; position: fixed; right: 3px;}#feedbackForm .form-control {margin-bottom: 10px;}</style><button id="feedback" class="btn btn-warning">Feedback</button><div class="modal fade" id="feedbackModal" tabindex="-1" role="dialog" arialabelledby="myModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content "><div class="modal-header azul-modal"> <button type="button" class="close" data-dismiss="modal"><span ariahidden="true">x</span><span class="sr-only">Close</span></button><h4 class="modal-title" id="feedbackModalLabel">Leave Feedback</h4></div><div class="modal-body"><form target="_self" id="feedbackForm" method="post"> <div class="form-group"><label for="replyemail">Reply Email:</label><input class="form-control" name="replyemail" id="replyEmail" placeholder="Enter Reply Email" type="email"></div><div class="form-group"><label for="replyemail">Feedback Type:</label><select name="subject" required="required" class="form-control" id="subject"><option class="disabled" value="choose">Choose a type</option><option value="question">I have a question about Kolay Accounts</option><option value="feedback">I have constructive feedback for you</option><option value="feature">I would like to suggest a new feature</option><option value="help">I need assistance managing my accounts</option></select></div><div class="form-group"><label for="replyemail">Feedback:</label><textarea class="form-control" name="feedback_text" id="feedbackText" required="required" placeholder="Enter Feedback" type="text"></textarea></div><div id="feedbackModalErrors"></div></form></div><div class="modal-footer"> <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button> <input class="btn btn-danger" id="send_feedback" data-loading-text="Sending..." value="Send Feedback" name="send_feedback" type="submit"> </div></div></div></div>');
}


$(document).ready(function(){
	 insertFeedbackTool();
	 function leaveFeedback() {
	   console.log("Leave Feedback");
      $('#feedbackModal').modal('show');
    }   
    $('#feedback').click(function(){
      leaveFeedback();
    });
    function validateEmail(re) {
      var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
      if (filter.test(re)) {
          return true;
      }
      else {
          return false;
      }
    }
    function checkForValidData() {
      var ta = $('#feedbackText').val();
      var se = $('#subject').val();
      var re = $('#replyEmail').val();
      console.log(ta + se + re);
      if(ta==""){$("#feedbackModalErrors").html("Please enter your feedback."); return false;}
      else if (se=="choose"){$("#feedbackModalErrors").html("Please choose a feedback type."); return false;}
      else if ((se=="help") || (se=="question")){
        if (re==""){$("#feedbackModalErrors").html("Please enter a reply email."); return false;}
        else if (!validateEmail(re)){$("#feedbackModalErrors").html("Please enter a valid reply email."); return false;}
        else{console.log(ta + se + re); return true; }
      }
      else {console.log(ta + se + re); return true; }
    }
    function clearForm(){
      $('#feedbackText').val("");
      $('#subject').val("choose");
      $('#replyEmail').val("");
    }
    $('#send_feedback').click(function(e){
      e.preventDefault();
      if (checkForValidData()==true){
        $.post("/php/send_feedback.php",{send_feedback:$("#send_feedback").val(),subject:$("#subject").val(),replyemail:$("#replyEmail").val(),feedback_text:$("#feedbackText").val()}).success(function(data){
          $("#response").html(data);
          clearForm();
          $('#feedbackModal').modal('hide');
          $('#signup').click();
          
        });
      } else {console.log(checkForValidData() + "Ajax should not have gone...");}
    });
    $('#feedbackModal').on('shown.bs.modal', function () {
      $('#replyEmail').focus();
    });
});
