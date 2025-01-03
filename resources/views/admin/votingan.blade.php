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
                    <label for="exampleFormControlInput1" class="form-label">Nama Voting</label>
                    <input name="voting_name" type="text" class="form-control" id="exampleFormControlInput1" placeholder="Masukkan nama voting">
                </div>

                <div style="display:  grid; grid-template-columns: repeat(2, calc(50% - 1rem)); column-gap:1rem;">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Nama Voting</label>
                        <input name="voting_start" type="datetime-local" class="form-control" id="exampleFormControlInput1" placeholder="Tanggal Mulai">
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Nama Voting</label>
                        <input name="voting_end" type="datetime-local" class="form-control" id="exampleFormControlInput1" placeholder="Tanggal Selesai">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Deskrpsi</label>
                    <input name="description" type="text" class="form-control" id="exampleFormControlInput1" placeholder="Masukkan deskripsi voting">
                </div>

                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Masukkan kandidat</label>
                    <input name="candidate[][name]" type="text" class="form-control mb-2"  placeholder="Masukkan nama kandidat">
                    <input name="candidate[][name]" type="text" class="form-control mb-2"  placeholder="Masukkan nama kandidat">

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

  
<!-- Modal -->
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
                    <label for="exampleFormControlInput1" class="form-label">Nama Voting</label>
                    <input name="voting_name" type="text" class="form-control" id="updateName" placeholder="Masukkan nama voting">
                </div>

                <div style="display:  grid; grid-template-columns: repeat(2, calc(50% - 1rem)); column-gap:1rem;">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Mulai Voting</label>
                        <input name="voting_start" type="datetime-local" class="form-control" id="updateStart" placeholder="Tanggal Mulai">
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Voting Selesai</label>
                        <input name="voting_end" type="datetime-local" class="form-control" id="updateEnd" placeholder="Tanggal Selesai">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Deskrpsi</label>
                    <input name="description" type="text" class="form-control" id="updateDesc" placeholder="Masukkan deskripsi voting">
                </div>

                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Masukkan kandidat</label>
                    <input name="candidate[][name]" type="text" class="form-control mb-2"  placeholder="updateCan1" disabled>
                    <input name="candidate[][name]" type="text" class="form-control mb-2"  placeholder="updateCan2" disabled>

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
    <table id="voteTable" class="table">
        <thead>
            <th>No</th>
            <th>Nama</th>
            <th>Tgl.Mulai</th>
            <th>Tgl.Selesai</th>
            <th>Tgl.Deskripsi</th>
            <th>Kandidat</th>
            <th>Aksi</th>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>
<script src="{{asset('js/jquery-3.7.1.js')}}"></script>
<script>
    let voteData = [];

    function setData(id){
        $("#updateName")[0].value = voteData[id].voting_name;
        $("#updateStart")[0].value = voteData[id].voting_start;
        $("#updateEnd")[0].value = voteData[id].voting_end;
        $("#updateDesc")[0].value = voteData[id].description;
        $("#updateId")[0].value = voteData[id].id;
    }
    
    function fetchData(){
        $.ajax({
            url : "{{$apiRoute}}/voting",
            method : "GET",
            success : (res)=>{
                console.log(res);
                if(res.status == 200){
                    let data = [];
                    voteData = res.data;
                    res.data.forEach((e, idx)=>{
                        data.push([
                            idx+1,
                            e.voting_name,
                            e.voting_start,
                            e.voting_end,
                            e.description,
                            e.candidate.length,
                            `
                                <button  data-toggle="modal" data-target="#updateModal" class="btn btn-primary" onClick="setData(${idx})">Edit</button>
                                <button class="btn btn-danger" onClick="deleteData('${e.id}')">Hapus</button>
                            `
                        ]);
                    });

                    $('#voteTable').DataTable( {
                        data : data,
                        column : [
                            {title : 'no'},
                            {title : 'name'},
                            {title : 'start'},
                            {title : 'end'},
                            {title : 'desc'},
                            {title : 'count'},
                        ],
                        statSave : true,
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
                    url : '{{$apiRoute}}/voting',
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
            url : "{{$apiRoute}}/voting",
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
            url : "{{$apiRoute}}/voting",
            method : "PUT",
            data : {
                voting_name : $("#updateName")[0].value,
                voting_start : $("#updateStart")[0].value ,
                voting_end : $("#updateEnd")[0].value ,
                description : $("#updateDesc")[0].value,
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