function internalServerError(){

}
function showLoader(){
    $(".loader").show();
}
function hideLoader(){
    $(".loader").hide();
}
function successMessage(message){
  toastr.success(message, 'Success');
}
function errorMessage(message){  
  toastr.error(message, 'Warning');
}
function redirect(url){
  window.location.href = url;
}