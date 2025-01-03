<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Menu Votingan</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#exampleModalCenter"><i
            class="fas fa-download fa-sm text-white-50"></i> Tambah Data</a>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Tambahkan Data</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="" id="addForm" >
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Username</label>
                    <input name="username" type="text" class="form-control" id="exampleFormControlInput1" placeholder="Masukkan username">
                </div>

                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Password</label>
                    <input name="password" type="text" class="form-control" id="exampleFormControlInput1" placeholder="Masukkan password">
                </div>

                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Role</label>
                    <select name="role" type="text" class="form-control" placeholder="Masukkan password">
                        <option value="user">user</option>
                        <option value="admin">admin</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Email (opsional)</label>
                    <input name="email" type="text" class="form-control mb-2"  placeholder="Masukkan email">
                </div>

            </form>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" onClick="addData()">Save changes</button>
        </div>
      </div>
    </div>
  </div>

  
  <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Update Data</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="" id="updateForm" >
                <input type="text" id="updateId" name="id" hidden>

                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Username</label>
                    <input name="username" type="text" class="form-control" id="updateUsername" placeholder="Masukkan username">
                </div>

                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Password</label>
                    <input name="password" type="text" class="form-control" id="updatePass" placeholder="Masukkan password">
                </div>

                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Role</label>
                    <select name="password" type="text" class="form-control" id="updateRole" placeholder="Masukkan password">
                        <option value="user">user</option>
                        <option value="admin">admin</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Email</label>
                    <input name="email" type="text" class="form-control" id="updateMail" placeholder="Masukkan email">
                </div>
            </form>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" onClick="updateData()">Save changes</button>
        </div>
      </div>
    </div>
  </div>

<div>
    <table id="userTable" class="table">
        <thead>
            <tr>
                <td>ID</th>
                <td>Username</th>
                <td>Email</th>
                <td>Role</th>
                <td>Aksi</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>
<script src="{{asset('js/jquery-3.7.1.js')}}"></script>
<script src="js/datatables.min.js"></script>

<script>
    let userData = [];
    let table = null;

    function setData(id){
        $("#updateUsername")[0].value = userData[id].username;
        $("#updateMail")[0].value = userData[id].email;
        $("#updateRole")[0].value = userData[id].role;
        $("#updateId")[0].value = userData[id].id;
    }
    
    function fetchData(){
        $.ajaxSetup({
            headers : {
                'Authorization' : "Bearer " + window.localStorage.getItem('api-key')
            }
        });

        $.ajax({
            url : "{{$apiRoute}}/user",
            method : "GET",
            success : (res)=>{
                console.log(res);
                if(res.status == 200){
                    let data = [];
                    userData = res.data;
                    res.data.forEach((e, idx)=>{
                        data.push([
                            e.id,
                            e.username,
                            e.email,
                            e.role ?? "-",
                            `
                                <button  data-toggle="modal" data-target="#updateModal" class="btn btn-primary" onClick="setData(${idx})">Edit</button>
                                <button class="btn btn-danger" onClick="deleteData('${e.id}')">Hapus</button>
                            `
                        ]);
                    });
                    if(table!=null)table.destroy();
                    table = new DataTable("#userTable",{
                        data : data,
                        column : [
                            {title : 'id'},
                            {title : 'username'},
                            {title : 'email'},
                            {title : 'role'},
                            {title : 'action'},
                        ],
                        saveStat : true,
                        'bDestroy' : true
                    });

                }else{
                    Swal.fire({
                        icon : "error",
                        title : "Error",
                        text : err.statusText
                    });
                }
            },
            error : (err)=>{
                Swal.fire({
                    icon : "error",
                    title : "Error",
                    text : err.statusText
                });
            }
        });
    }

    
    function deleteData(id){
        Swal.fire({
            title: 'Yakin ingin menghapus data voting ' + id,
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: 'Ya',
            denyButtonText: 'Tidak',
            customClass: {
              actions: 'my-actions',
              cancelButton: 'order-1 right-gap',
              confirmButton: 'order-2',
              denyButton: 'order-3',
            },
          }).then((result) => {
            if (result.isConfirmed) {
                $.ajaxSetup({
                    headers : {
                        'Accept' : 'application/json',
                        'Authorization' : 'Bearer ' + window.localStorage.getItem('api-key')
                
                    }
                });

                $.ajax({
                    url : '{{$apiRoute}}/user',
                    method : "DELETE",
                    data : {
                        id : id
                    },
                    success : (res)=>{
                        Swal.fire({
                            icon : res.status == 200 ?"success" : "error",
                            text : res.message,
                            title : res.status == 200 ? "Berhasil" : "Gagal"
                        })

                        fetchData();

                    },
                    error : (err)=>{
                        Swal.fire({
                            icon : "error",
                            text : err.responseJSON.message,
                            title : "Error"
                        })

                    }
                });

            } else if (result.isDenied) {
              Swal.fire('Aksi dibatalkan', '', 'info')
            }
          })
    }


    function addData(){
        $.ajaxSetup({
            headers : {
                'Authorization' : "Bearer " + window.localStorage.getItem('api-key')
            }
        });

        $.ajax({
            url : "{{$apiRoute}}/user",
            method : "POST",
            data : new FormData($("#addForm")[0]),
            cache : false,
            processData : false,
            contentType : false,
            success : async (res)=>{
                await Swal.fire({
                    icon : res.status == 200 ? "success" : "error",
                    text : res.message,
                    title : res.status == 200 ? "Berhasil" : "Gagal"
                });

                fetchData();
            },
            error : async(err)=>{
                await Swal.fire({
                    icon : "error",
                    text : err.responseJSON.message,
                    title : "Error"
                });
            }
        });
    }

    function updateData(){
        $.ajaxSetup({
            headers : {
                'Accept' : 'application/json',
                'Authorization' : "Bearer " + window.localStorage.getItem('api-key')
            }
        });

        $.ajax({
            url : "{{$apiRoute}}/user",
            method : "PUT",
            data : {
                username : $("#updateUsername")[0].value,
                password : $("#updatePass")[0].value ,
                email : $("#updateMail")[0].value ,
                role : $("#updateRole")[0].value ,
                id : $("#updateId")[0].value,
            },
  
            success : async (res)=>{
                await Swal.fire({
                    icon : res.status == 200 ? "success" : "error",
                    text : res.message,
                    title : res.status == 200 ? "Berhasil" : "Gagal"
                });

                fetchData();
            },
            error : async(err)=>{
                await Swal.fire({
                    icon : "error",
                    text : err.responseJSON.message,
                    title : "Error"
                });
            }
        });
    }


    fetchData();
</script>
