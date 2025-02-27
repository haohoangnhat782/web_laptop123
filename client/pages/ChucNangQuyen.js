$(document).ready(function() {
    loadChucNangQuyen();
    clickPage(loadChucNangQuyen)
    $(document).on("keyup","#search",function(){
        var search = $(this).val();
        console.log(search+"AAAA");
        if(checkSpace(search)){
            loadChucNangQuyen();
            clickPage(loadChucNangQuyen)
        }else{
            searchChucNangQuyen(search)
            clickPage(searchChucNangQuyen)
        }
    })
    addChucNang()
    getChucNangQuyen()
    editChucNang()
})
function searchChucNangQuyen(text){
    var pageno;
    if($("#search").val()!==1){
        pageno = 1;
    }else{
        pageno = $("#currentpage").val();
    }
    $.ajax({
        url:"server/src/controller/PaginationController.php",
        data: {action:"search",search:text, page: pageno,table:"chucnangquyen"},
        method: "GET",
        dataType: "json",
        success:function(data){
            console.log(data);
            renderChucNangQuyen(data);
        }
    })
}
function loadChucNangQuyen(){
    var pageno = $("#currentpage").val();
    $.ajax({
        url:"server/src/controller/PaginationController.php",
        data: {action:"pagination", page: pageno,table:"chucnangquyen"},
        method: "GET",
        dataType: "json",
        success:function(data){
            renderChucNangQuyen(data);
        }
    })
}
function renderChucNangQuyen(data){
    var jsondata=data.pagination;
    console.log(data)
    var html="";
    jsondata.forEach((chucnangquyen,index) => {
        html+=`<tr>
        <td>
            <span class="custom-checkbox">
                <input type="checkbox" id="checkbox1" name="options[]" value="1">
                <label for="checkbox1"></label>
            </span>
        </td>
        <td>${chucnangquyen['ma_chuc_nang']}</td>
        <td>${chucnangquyen['ten_chuc_nang']}</td>
        <td><span class="status text-success">&bull;</span> Active</td>
        <td>
            <a  id="btnShowData" href="#editChucNang" data-id=${chucnangquyen['ma_chuc_nang']} class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
            <a href="#deleteEmployeeModal" class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
            <a href="#" class="view" title="View" data-toggle="tooltip"><i class="material-icons">&#xE417;</i></a>
        </td>
    </tr>`
    });
    $("#show-listChucNang").html(html);
    getSizeinTable("chucnangquyen","CN","#admin-MaChucNang");
    phanquyen_chucnang("Chức Năng");
    totalPage(data.count);
}
function addChucNang(){
    getSizeinTable("chucnangquyen","CN","#admin-MaChucNang");
    $(document).on("click","#admin-addChucNang",function(){
        var maChucNang = $("#admin-MaChucNang").val();
        var tenChucNang=$("#admin-TenChucNang").val();
        if(checkSpace(tenChucNang)){
            alert("Vui lòng nhập tên chức năng")
        }else{
            $.ajax({
                url:"server/src/controller/ChucNangQuyenController.php",
                method:"POST",
                data:{action:"add",maChucNang:maChucNang,tenChucNang:tenChucNang},
                dataType:"json",
                success:function(data){
                    $("form").trigger('reset');
                    $("#addChucNang").modal("hide");
                    loadChucNangQuyen()
                }
            })
        }
    })
}
function editChucNang(){
    $(document).on("click","#admin-btn-updateChucNang",function(){
        var maChucNang=$("#admin-edit-machucnang").val();
        var tenChucNang=$("#admin-edit-tenchucnang").val();
        $.ajax({
            url:"server/src/controller/ChucNangQuyenController.php",
            method:"POST",
            data:{action:"update",maChucNang:maChucNang,tenChucNang:tenChucNang},
            dataType:"json",
            success:function(data){
                $("form").trigger('reset');
                $("#editChucNang").modal("hide");
                loadChucNangQuyen()
            }
        })
    })
}
function getChucNangQuyen(){
    $(document).on("click","#btnShowData",function(){
        var id = $(this).attr("data-id");
        $.ajax({
            url:"server/src/controller/ChucNangQuyenController.php",
            method:"POST",
            data:{action:"getchucnang",id:id},
            dataType:"json",
            success:function(data){
               $("#admin-edit-machucnang").val(data.ma_chuc_nang)
               $("#admin-edit-tenchucnang").val(data.ten_chuc_nang)
            }
        })
    })
}