/* Code Developed and Maintained by Hewa Vidanage Lahiru Hasanka */

function generatePathway(form){
  var selectedPosition = form.membershipType.value;

  if(selectedPosition == "65350001"){
    var selectedPositionConfirmation = confirm("Are you sure you want to continue: ");
    if(selectedPositionConfirmation == true){
      window.open("signupPage/signupStudentPage.html","_self")
    }
  }
  else if(selectedPosition == "65350002"){
    var selectedPositionConfirmation = confirm("Are you sure you want to continue: ");
    if(selectedPositionConfirmation == true){
      window.open("signupPage/signupProfessorPage.html","_self")
    }
  }
  else if(selectedPosition == "65350003"){
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
