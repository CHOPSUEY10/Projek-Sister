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

<div class="modal fade" id="hasilModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Hasil Voting</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" style="display : grid; grid-template-columns: 30% 50% 20% ;">
            <form action=""  >
                <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                    <div class="card-body mb-3">
                      <h5 class="card-title">Total Suara : </h5>
                      <p class="card-text" id="totalSuara">-</p>
                    </div>
                </div>
                <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                    <div class="card-body mb-3">
                      <h5 class="card-title">Total Kandidat : </h5>
                      <p class="card-text" id="totalKandidat">-</p>
                    </div>
                </div>
            </form>

            <div>
                <canvas id="hasilChart"></canvas>
            </div>
          
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
            <th>Hasil</th>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>
<script src="{{asset('js/jquery-3.7.1.js')}}"></script>
<script src="js/datatables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>

<script>
    let voteData = [];
    let table = null;
    function setData(id){
        $("#updateName")[0].value = voteData[id].voting_name;
        $("#updateStart")[0].value = voteData[id].voting_start;
        $("#updateEnd")[0].value = voteData[id].voting_end;
        $("#updateDesc")[0].value = voteData[id].description;
        $("#updateId")[0].value = voteData[id].id;
    }

    let chart = null;
    function setHasil(id){
        $("#totalSuara")[0].innerHTML = voteData[id].data.length;
        $("#totalKandidat")[0].innerHTML = voteData[id].candidate.length;
        
        let can = new Array(voteData[id].candidate.length).fill(0); // Inisialisasi array dengan panjang kandidat
        let labels = [];
        
        // Siapkan label dan hitung suara per kandidat
        voteData[id].candidate.forEach((e, index) => {
            labels.push(e.name); // Tambahkan nama kandidat ke label
            can[index] = 0; // Pastikan nilai awal 0
        });
        
        voteData[id].data.forEach((d) => {
            if (d.candidate < can.length) {
                can[d.candidate] += 1; // Tambahkan suara untuk kandidat terkait
            }
        });
        
        console.log(can);
        
        const data = {
            labels: labels,
            datasets: [{
                label: 'Data Votingan',
                data: can,
                backgroundColor: [
                    'rgba(255, 99, 132)',
                    'rgba(255, 159, 64)',
                    'rgba(255, 205, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(201, 203, 207, 0.2)'
                ],
                borderColor: [
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    'rgb(54, 162, 235)',
                    'rgb(153, 102, 255)',
                    'rgb(201, 203, 207)'
                ],
                borderWidth: 1
            }]
        };
        
        if (chart != null) chart.destroy();
        
        chart = new Chart($("#hasilChart")[0], {
            type: 'bar',
            data: data,
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        suggestedMin: 0,
                        suggestedMax: Math.max(...can) + 3 // Tambahkan sedikit margin
                    }
                }
            },
        });
        
   
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
                            `,
                            `<button  data-toggle="modal" data-target="#hasilModal" class="btn btn-primary" onClick="setHasil(${idx})">Lihat</button>`

                        ]);
                    });
                    if(table!=null)table.destroy();

                    table = new DataTable( "#voteTable",{
                        data : data,
                        column : [
                            {title : 'no'},
                            {title : 'name'},
                            {title : 'start'},
                            {title : 'end'},
                            {title : 'desc'},
                            {title : 'count'},
                            {title : 'hasil'},
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
