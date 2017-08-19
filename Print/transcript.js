  window.onload = loadDataOnload();


  function loadDataOnload(){
    //alert("asdfsdf");

  }

function open_report_win()
{
  var store = new Array();
  store[0] = $.trim(document.getElementById('tbl_body').innerHTML);
  alert(store[0]);
  sessionStorage.setItem("sent", store);

  window.open('../Print/TransactionDetails.php','_blank');
}
  $(".purchaseproductDropDown").dropdown({ fullTextSearch: true });
