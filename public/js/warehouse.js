function addOptions(e, obj) {

    e.preventDefault()
    $(obj).parent().remove()
    let first = $("#first").html();
    $("#fullDiv").append(`<div class="form-group row" ><div class="form-group col-md-4">` + first +
          `</div> <div class="form-group col-md-4">
                <label for="address">Quantiy in warehouse</label>
                <input type="number" name="quantity_in_store[]" class="form-control" id="exampleInputEmail1" placeholder="Enter quantity in warehouse">
            </div>                             
 
      `+`
      <div class="form-group col-md-4">
        <br>
            <a class="btn btn-success" onclick="addOptions(event,this)" href="#">
            <i class="mdi mdi-plus-circle-outline"></i> 
            </a>
            <a class="btn btn-danger" onclick="removeOptions(event,this)"  href="#">
            <i class="mdi mdi-close-outline"></i> 
            </a>
     </div>
      `
)
}

function removeOptions(e, obj) {

e.preventDefault()
let prev = $($(obj).parent().parent().prev()).find("#first")

$(obj).parent().parent().remove()
if($("#fullDiv").children().length > 1) {
    let options = `   <div class="form-group col-md-4" id="current">
        <br>
        <a class="btn btn-success" onclick="addOptions(event,this)" href="#">
        <i class="mdi mdi-plus-circle-outline"></i> 
        </a>
        <a class="btn btn-danger" onclick="removeOptions(event,this)"  href="#">
        <i class="mdi mdi-close-outline"></i> 
        </a>
    </div>`;
   $("#fullDiv").children().last().append(options)
 }else{
    let options = `   <div class="form-group col-md-4" id="current">
    <br>
    <a class="btn btn-success" onclick="addOptions(event,this)" href="#">
    <i class="mdi mdi-plus-circle-outline"></i> 
    </a>
</div>`
                            $("#fullDiv").children().last().append(options)

 }
   
}
