function MedicalCertificatValidation(){

    let StartDate=document.getElementById("StartDate").value;
    let EndDate=document.getElementById("EndDate").value;
    let File=document.getElementById("certificate");

    const startDateObject = new Date(StartDate);
    const endDateObject = new Date(EndDate);

    if(StartDate.length==0||EndDate.length==0){
        alert("you have to enter the start date and the end date");
        
        return false;
    }
    if(endDateObject <= startDateObject){
      alert("The end date cannot be before the start date.");
 
      return false;
    }
    if (File.files.length === 0) {
        alert("Please select a certificate file.");
  
        return false;
      }
      return true;
}

function ValidateAddictation(){

    let Reason=document.getElementById("reason").value;
    Reason=Reason.trim();
    if(Reason.length <= 10){
        alert("You have to enter the reason (10 chars), please don't play around >:-(")
        return false;
    }
    return true;
}