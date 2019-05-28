
// var logform = GetByID('log_form');
//
// logform.onsubmit = function () {
//
//     var message = {
//         login : logform.elements.login.value,
//         pass  : logform.elements.pass.value,
//     };
//
//     AjaxRequest('POST','/auth/login/',JSON.stringify(message),function (response) {
//         alert(response);
//         let input = JSON.parse(response);
//         if (input.errCode === 200) alert("Yay!");
//     },function () {alert('Time out');}, 7000);
//
//     return false;
// };