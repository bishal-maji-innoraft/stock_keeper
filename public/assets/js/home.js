$(document).ready(function () {
  /**
   * Add new Item in Stock Table
   *
   * */
  $("#action_add_stock").click(function (event) {
    event.preventDefault();
    var form = $("form").serializeArray();
    var isAnyEmptyField = false;
    var formDataArr = {};
    form.forEach((element) => {
      if (!element.value) {
        isAnyEmptyField = true;
        return;
      }
      formDataArr[element.name] = element.value;
    });

    $.ajax({
      url: "/add_stock",
      type: "post",
      data: formDataArr,
      success: function (response) {
        console.log(json_decode(response));
      },
    });
  });

  /**
   * Update the stock in tabe
   */
  $("#action_update_stock").click(function (event) {
    event.preventDefault();
    var form = $("form").serializeArray();
    var isAnyEmptyField = false;
    var formDataArr = {};
    form.forEach((element) => {
      if (!element.value) {
        isAnyEmptyField = true;
        return;
      }
      formDataArr[element.name] = element.value;
    });

    $.ajax({
      url: "/update_stock",
      type: "post",
      data: formDataArr,
      success: function (response) {},
    });
  });
});
