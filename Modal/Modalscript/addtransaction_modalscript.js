

  var saveproduct = 0;

  window.onload = loadDefaultOnload();

  $(".transactionDropDown").dropdown();

  $("#ap_type").change(function(){

    var type = $("#ap_type").dropdown("get value");

    if(type == 1){

      document.getElementById("ap_qntyperunit").value = 1;
      document.getElementById("ap_qntyperunit").readOnly = true;

    }
    else {

      document.getElementById("ap_qntyperunit").value = "";
      document.getElementById("ap_qntyperunit").readOnly = false;

    }

  });

  $("#ap_alerttype").change(function(){

    var type = $("#ap_alerttype").dropdown("get value");

    if(type == 1){

      document.getElementById("ap_alertqnty").value = 1 ;
      document.getElementById("ap_alertqnty").readOnly = false;

    }
    else {

      document.getElementById("ap_alertqnty").value = 0;
      document.getElementById("ap_alertqnty").readOnly = true;

    }

  });
  function Loaddata(ID,name,qnty,pic,category,prcperunit)
  {
    var photo = document.getElementById('picture');
    photo.setAttribute('src','../UploadedProductPhoto/'+pic);
    $('#proname').text(name);
    $('#procat').text(category);
    $('#proprice').text(prcperunit);
    $('#proqnty').text(qnty);
  }
  function check_type()
  {
    var type = $('#tran_type').dropdown('get value');
    var ind = document.getElementById('indi');
    var rep = document.getElementById('repack');
    if(type==1)
    {
        ind.setAttribute('style','visibility:visible');
        rep.setAttribute('style','display:none');
    }else {
        ind.setAttribute('style','display:none');
        rep.setAttribute('style','visibility:visible');
    }
  }
  function loadDefaultOnload(){


  }

  function saveNewProduct(){

    var name = document.getElementById('ap_name').value;

    if(name != ""){

      var formData = new FormData($('#addproductform')[0]);
      var alertType = $("#ap_alerttype").dropdown("get value");

      formData.append('func', 1);
      formData.append('saveproduct', saveproduct);
      formData.append('ap_alerttype', alertType);

      $.ajax({

          url: "../PHP/BackEndController/inventorycontroller.php",
          type: "POST",
          data: formData,
          success: function (resultdata) {

            if($.trim(resultdata) == 1){

              loadProductsToDropBox();
              loadProductsToCards();
              document.getElementById("addproductform").reset();
              loadDefaultOnload();
              saveproduct = 0;

              alert("Products Saved.");

            }

            else if($.trim(resultdata) == 2){

              if(confirm("Product name already exist. Do you still want to save this product?")){

                saveproduct = 1;
                saveNewProduct();

              }

            }

            else{

              alert("Error Occured!");

            }

          },
          cache: false,
          contentType: false,
          processData: false

      });

    }
    else {

      alert("Please enter product name.");

    }


  }
