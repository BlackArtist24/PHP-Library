let imageLoginDiv;
function fun_userData(){
    $.ajax({
        url: "olivrweb/information/Api.php",
        type: "POST",
        success: function (data) {
          obj = JSON.parse(data);
          if (obj.status === true) {
            var allImageDetails = obj.imagedata;
            imageLoginDiv = "";
            $("#image_details").html(" ");
            allImageDetails.forEach((element) => {
              imageLoginDiv += `<tr>
                                  <td>${element.S_No}</td>
                                  <td>${element.User_Id}</td>
                                  <td>${element.Name}</td>
                                  <td>
                                      <a href="${element.User_Image}" target="_blank" rel="noopener noreferrer">
                                          <img src="${element.User_Image}" alt="" width="100" height="100">
                                      </a>
                                  </td>
                                  <td>
                                      <a href="${element.Qr_Image}" target="_blank" rel="noopener noreferrer">
                                          <img src="${element.Qr_Image}" alt="" width="100" height="100">
                                      </a>
                                  </td>
                                  <td>${element.Insert_Time}</td>
                                  <td>${element.Update_Time}</td>
                              </tr>`;
            });
            $("#image_details").html(imageLoginDiv);
            fun_CallDataTb();

          } else {
            $("#image_details").html(" ");
            // $("#register_count").val("Total Image Details: " + obj.message);
          }
        },
      });
}
function fun_CallDataTb(){
    $("#UserDataTable").DataTable();
}

$(document).ready(function () {
    fun_userData()
});


