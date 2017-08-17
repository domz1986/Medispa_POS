window.onload = loadDefaultOnload();

$(".transactionDropDown").dropdown();

function loadDefaultOnload(){


}
function addFee()
{

  var ptable = document.getElementById('tbl_body');
  var productname = document.getElementById('fee_name');
  var pamnt = document.getElementById('fee_amnt');
  var row = ptable.insertRow(ptable.rows.length);

  var x = row.insertCell();
  x.setAttribute("style","display:none");
  x.innerHTML="fees";

  var y = row.insertCell();
  y.setAttribute("style","display:none");
  y.innerHTML=productname.value+pamnt.value;

  var z = row.insertCell();
  z.innerHTML=productname.value;
  z.setAttribute("style","cursor:pointer;");
  z.setAttribute("onclick","remove_row('"+x.innerHTML+"','"+y.innerHTML+"')");

  row.insertCell().innerHTML="";
  row.insertCell().innerHTML=pamnt.value;


  $('#addfeeModal').modal('hide');
}
