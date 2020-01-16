function generatePathway(form){
  var selectedPosition = form.membershipType.value;

  if(selectedPosition == "student"){
    var selectedPositionConfirmation = confirm("Are you sure you want to continue: ");
    if(selectedPositionConfirmation == true){
      window.open("signupPage/signupStudentPage.html","_self")
    }
  }
  else if(selectedPosition == "professor"){
    var selectedPositionConfirmation = confirm("Are you sure you want to continue: ");
    if(selectedPositionConfirmation == true){
      window.open("signupPage/signupProfessorPage.html","_self")
    }
  }
  else if(selectedPosition == "librarian"){
    var selectedPositionConfirmation = confirm("Are you sure you want to continue: ");
    if(selectedPositionConfirmation == true){
      window.open("signupPage/signupLibrarianPage.html","_self")
    }
  }
  else{
    alert("Please select a Membership Type");
  }
}

function displayFillAllMandatoryFieldsMessage(){
  alert("Please fill all fields with asterisk mark (*)");
}
